<?php
declare(strict_types=1);

namespace Controllers;

class ImagesController extends AbstractController
{

    private $viewPath = "Images/";

    public function upload()
    {
        $targetDir = dirname(__DIR__, 2) . "/public/images";
        try {
            if (
                !isset($_FILES["upfile"]["error"]) ||
                is_array($_FILES["upfile"]["error"])
            ) {
                throw new \RuntimeException("Invalid parameters");
            }
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
            if ($_FILES['upfile']['size'] > 1048576) {
                throw new \RuntimeException('Exceeded filesize limit.');
            }
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
            $filename = sha1_file($_FILES['upfile']['tmp_name']);
            if (!move_uploaded_file($_FILES['upfile']['tmp_name'], sprintf('%s/%s.%s', $targetDir, $filename, $ext)
            )) {
                throw new \RuntimeException('Failed to move uploaded file.');
            }

        } catch (\RuntimeException $e) {
            $this->view($this->viewPath . "upload", $e->getMessage());
            return;
        }
        if ($this->check_file_uploaded_name($_FILES["upfile"]["name"])) {
            $name = substr($_FILES["upfile"]["name"], 0, -4);
        } else {
            $name = substr($_FILES["upfile"]["tmp_name"], 5);
        }
        $privacy = false;
        $author = "anonymous";
        $image = parent::model("Image");
        $image->setName($name)
            ->setFilename($filename . "." . $ext)
            ->setAuthor($author)
            ->setPrivacy($privacy)
            ->setExt($ext);
        try {
            if (!$this->repository->uploadImage($image)) {
                $this->view($this->viewPath . "upload", ["error" => "something went wrong"]);
                return;
            }
        } catch (\Exception $e) {
            $this->view($this->viewPath . "upload", ["error" => "something went wrong"]);
            return;
        }
        $this->addMinature($filename, $ext);
        $watermarkText = $_POST["watermarkText"];
        if (empty($watermarkText)) {
            $this->addWatermark($filename, $ext);
        } else {
            $this->addWatermark($filename, $ext, $watermarkText);
        }
        $this->view($this->viewPath . "upload", ["message" => "file uploaded correctly"]);


    }

    private function check_file_uploaded_name(string $filename): bool
    {
        return ((preg_match("`^[-0-9A-Z_\.]+$`i", $filename)) ? true : false);
    }

    private function addMinature($srcName, $ext)
    {
        $srcDir = dirname(__DIR__, 2) . "/public/images";
        $targetDir = dirname(__DIR__, 2) . "/public/images/miniatures";
        $targetImagePath = sprintf("%s/%s.miniature.%s", $targetDir, $srcName, $ext);
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
        $targetImagePath = sprintf("%s/%s.miniature.%s", $targetDir, $srcName, $ext);
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