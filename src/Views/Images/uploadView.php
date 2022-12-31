<?php header('X-PHP-Response-Code: 404', true, $response->getStatusCode()); ?>
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
            <a class="btn btn-primary" href="/images/upload">Upload File</a>
            <?php
            if (empty($_SESSION["logged"]) || $_SESSION["logged"] == false) {
                echo "<a class=\"btn btn-primary\" href=\"/user/register\">Register</a>
                      <a class=\"btn btn-primary\" href=\"/user/login\">Login in</a>";
            } else {
                echo "<a class=\"btn btn-primary\" href=\"/user/logout\">Logout</a>";
            }
            ?>
        </div>
    </div>
    <div class="content">
        <form method="POST" enctype="multipart/form-data">
            <span>image file</span>
            <input type="file" name="upfile" accept="image/*"/>
            <span>title</span>
            <input type="text" name="title"/>
            <span>author</span>
            <input type="text" name="author"/>
            <span>Watermark Text</span>
            <input type="text" name="watermarkText"/>
            <?php
            if (!empty($_SESSION["logged"]) && $_SESSION["logged"] == true) {
                echo "<span>Set image as private</span>
                      <input type=\"checkbox\" name=\"private\" value='true'/>";
            }
            ?>
            <button type="submit" name="save" class="btn">WYSLIJ</button>
        </form>
    </div>
</div>
</body>
</html>