<?php header('X-PHP-Response-Code: ', true, $response->getStatusCode()); ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/assets/css/style.css">
    <title>Image Gallery</title>
</head>
<body>
<div class="wrapper">
    <div class="header">

        <a class="gallery-name" href="/">
            Image Gallery
        </a>

        <div class="btn-wrapper">
            <a class="btn btn-primary" href="/images/searchByTitle">Search By Title</a>
            <a class="btn btn-primary" href="/images/saved">Saved Images</a>
            <a class="btn btn-primary" href="/images/upload">Upload File</a>
            <?php
            if (empty($_SESSION["logged"]) || $_SESSION["logged"] == false) {
                echo " 
                        <a class=\"btn btn-primary\" href=\"/user/register\">Register</a>
                        <a class=\"btn btn-primary\" href=\"/user/login\">Login in</a>";
            } else {
                echo "<a class=\"btn btn-primary\" href=\"/user/logout\">Logout</a>";
            } ?></div>
    </div>
    <div class="content">
        <form class="form-content" method="POST">
            <div class="image-wrapper">
                <?php
                if (!empty($response->getData()["imageData"])) {
                    foreach ($response->getData()["imageData"] as $index => $image) {
                        $filename = $image["filename"];
                        $watermarkedFilename = "watermarked" . $image["filename"];
                        $miniaturedFilename = "miniature" . $image["filename"];
                        $imageTitle = $image["title"];
                        $imageAuthor = $image["author"];
                        $imagePrivacy = "";
                        if ($image["privacy"] == true) {
                            $imagePrivacy = "<span>This image is private</span>";
                        }
                        echo "<div class='image-div'>
                            <a class='imagelink' href='/images/watermarks/$watermarkedFilename'>
                                <img class='image' src=\"/images/miniatures/$miniaturedFilename\" alt=\"$imageTitle\">
                            </a>
                            <div class='image-text'>
                                <span>Title: $imageTitle</span><br/>
                                <span>Author: $imageAuthor</span><br/>
                                <label>
                                    <input type=\"checkbox\" name=\"$index\" value=\"$filename\">Click to forget image
                                </label><br/>
                                $imagePrivacy
                            </div>
                          </div>";
                    }
                }
                ?>
            </div>
            <button type="submit" class="btn btn-secondary btn-pages">Forget Images</button>
        </form>
    </div>
</div>
</body>
</html>