<?php
declare(strict_types=1);

namespace Controllers;

use Core\Response;

class ImagesController extends AbstractController
{

    private $viewPath = "Images/";

    public function upload(): void
    {
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $this->view($this->viewPath . "upload", new Response(200, []));
            return;
        }
        // dir to save images to
        $targetDir = dirname(__DIR__, 2) . "/public/images";
        try {
            //checks if any errors occured or if file is empty or variables are not set
            if (
                !isset($_FILES["upfile"]["error"]) ||
                is_array($_FILES["upfile"]["error"]) ||
                empty($this->data["title"]) ||
                empty($this->data["watermarkText"]) ||
                empty($this->data["author"])
            ) {
                throw new \RuntimeException("Invalid parameters");
            }

            if (empty($this->data["private"]) || $this->data["private"] == "false") {
                $this->data["private"] = false;
            } else {
                $this->data["private"] = true;
            }

            if ($this->check_file_uploaded_name($this->data["title"])) {
                $name = $this->data["title"];
            } else {
                throw new \RuntimeException("Invalid characters in title");
            }
            //checks if any errors occured during uploading
            switch ($_FILES['upfile']['error']) {
                case UPLOAD_ERR_OK:
                    break;
                case UPLOAD_ERR_NO_FILE:
                    throw new \RuntimeException('No file sent.');
                case UPLOAD_ERR_INI_SIZE:
                case UPLOAD_ERR_FORM_SIZE:
                    throw new \RuntimeException('Exceeded filesize limit.');
                default:
                    throw new \RuntimeException('Unknown errors.');
            }
            //checks if the file does not exceed 1M
            if ($_FILES['upfile']['size'] > 1048576) {
                throw new \RuntimeException('Exceeded filesize limit.');
            }
            //checking MIME type
            $finfo = new \finfo(FILEINFO_MIME_TYPE);
            if (false === $ext = array_search(
                    $finfo->file($_FILES['upfile']['tmp_name']),
                    array(
                        'jpg' => 'image/jpeg',
                        'png' => 'image/png',
                    ),
                    true
                )) {
                throw new \RuntimeException('Invalid file format.');
            }
            //file name on server gets randomized using random and sha encoding
            $filename = sha1_file($_FILES['upfile']['tmp_name']) . rand(0, 100000);
            if (!move_uploaded_file($_FILES['upfile']['tmp_name'], sprintf('%s/%s.%s', $targetDir, $filename, $ext)
            )) {
                throw new \RuntimeException('Failed to move uploaded file.');
            }

        } catch (\RuntimeException $e) {
            $this->view($this->viewPath . "upload", new Response(400, ["error" => $e->getMessage()]));
            return;
        }
        $image = parent::model("Image");
        $image->setName($name)
            ->setFilename($filename . "." . $ext)
            ->setAuthor($this->data["author"])
            ->setPrivacy($this->data["private"])
            ->setExt($ext);
        try {
            if (!$this->repository->uploadImage($image)) {
                throw new \RuntimeException('Failed to upload image');
            }
        } catch (\Exception $e) {
            $this->view($this->viewPath . "upload", new Response(400, ["error" => $e->getMessage()]));
            return;
        }
        $this->addMinature($filename, $ext);
        $watermarkText = $this->data["watermarkText"];
        if (empty($watermarkText)) {
            $this->addWatermark($filename, $ext);
        } else {
            $this->addWatermark($filename, $ext, $watermarkText);
        }
        $this->view($this->viewPath . "upload", new Response(201, []));
    }

    public function saved(): void
    {
        if (empty($_SESSION["savedImages"])) {
            $this->view($this->viewPath . "saved", new Response(200, []));
            return;
        }
        if ($_SERVER["REQUEST_METHOD"] == "POST" & !empty($this->data)) {
            if (is_array($this->data)) {
                $_SESSION["savedImages"] = array_diff($_SESSION["savedImages"], $this->data);

            } else {
                foreach ($_SESSION["savedImages"] as $savedImage) {
                    if ($key = array_search($savedImage, $this->data) !== false) {
                        unset($_SESSION["savedImages"][$key]);
                    }
                }
            }
        }
        $imagesArray = [];
        $pageInfo = 0;
        foreach ($_SESSION["savedImages"] as $filename) {
            array_push($imagesArray, $this->repository->getImageByFilename($filename));
        }
        $this->view($this->viewPath . "saved", new Response(200, ["imageData" => $imagesArray, "pageInfo" => $pageInfo]));
    }

    public function searchByTitle(): void
    {
        $this->view($this->viewPath . "searchByTitle", new Response(200, []));
    }

    public function search(): void
    {
        if ($_SERVER["REQUEST_METHOD"] != "GET") {
            return;
        }
        $title = $_GET["title"];
        $imageArray = $this->repository->downloadAllImages();
        if (empty($imageArray)) {
            echo "a";
            return;
        }
        $imageFilenameArray = [];
        foreach ($imageArray as $image) {
            if (preg_match("/.*" . $title . ".*/i", $image["name"])) {
                if ($image["privacy"] == false) {
                    array_push($imageFilenameArray, $image);
                } elseif ($image["privacy"] == true & !empty($_SESSION["logged"])) {
                    if ($_SESSION["user"]->getUsername() == $image["author"]) {
                        array_push($imageFilenameArray, $image);
                    }
                }
            }
        }
        echo json_encode($imageFilenameArray);
    }

    private function check_file_uploaded_name(string $filename): bool
    {
        return ((preg_match("`^[-0-9A-Z_\.]+$`i", $filename)) ? true : false);
    }

    private function addMinature($srcName, $ext)
    {
        $srcDir = dirname(__DIR__, 2) . "/public/images";
        $targetDir = dirname(__DIR__, 2) . "/public/images/miniatures";
        $targetImagePath = sprintf("%s/miniature%s.%s", $targetDir, $srcName, $ext);
        $srcImagePath = sprintf("%s/%s.%s", $srcDir, $srcName, $ext);
        switch ($ext) {
            case("png"):
                $srcImage = imagecreatefrompng($srcImagePath);
                break;
            case("jpg"):
                $srcImage = imagecreatefromjpeg($srcImagePath);
                break;
        }
        $targetImage = imagecreatetruecolor(200, 125);
        $srcWidth = imagesx($srcImage);
        $srcHeight = imagesy($srcImage);
        imagecopyresized($targetImage, $srcImage, 0, 0, 0, 0, 200, 125, $srcWidth, $srcHeight);
        switch ($ext) {
            case("png"):
                imagepng($targetImage, $targetImagePath);
                break;
            case("jpg"):
                imagejpeg($targetImage, $targetImagePath);
                break;
        }

    }

    private function addWatermark($srcName, $ext, $text = "")
    {
        $srcDir = dirname(__DIR__, 2) . "/public/images";
        $targetDir = dirname(__DIR__, 2) . "/public/images/watermarks";
        $targetImagePath = sprintf("%s/watermarked%s.%s", $targetDir, $srcName, $ext);
        $srcImagePath = sprintf("%s/%s.%s", $srcDir, $srcName, $ext);
        $fontFile = dirname(__DIR__, 2) . "/public/assets/fonts/OpenSansRegular.ttf";
        $fontSize = 24;
        switch ($ext) {
            case("png"):
                $targetImage = imagecreatefrompng($srcImagePath);
                break;
            case("jpg"):
                $targetImage = imagecreatefromjpeg($srcImagePath);
                break;
        }
        $fontColor = imagecolorallocate($targetImage, 125, 125, 125);
        $posX = 0;
        $posY = $fontSize;
        $angle = 0;
        imagettftext($targetImage, $fontSize, $angle, $posX, $posY, $fontColor, $fontFile, $text);
        switch ($ext) {
            case("png"):
                imagepng($targetImage, $targetImagePath);
                break;
            case("jpg"):
                imagejpeg($targetImage, $targetImagePath);
                break;
        }

    }
}