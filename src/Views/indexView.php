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

        <a class="gallery-name" href="http://192.168.56.10:8080/">
            Image Gallery
        </a>

        <div class="btn-wrapper">
            <a class="btn btn-primary" href="http://192.168.56.10:8080/images/upload">Upload File</a>
            <a class="btn btn-primary" href="http://192.168.56.10:8080/user/register">Register</a>
            <a class="btn btn-primary" href="http://192.168.56.10:8080/user/login">Login in</a>
        </div>
    </div>
    <div class="content">
        <div class="searchbar"></div>
        <div class="image-wrapper">
            <?php
            for ($i = 0; $i < 10; $i++) {
                echo '<img class="image" src="/assets/img/image.png" alt="image">';
            }
            ?>
        </div>
    </div>
</div>
</body>
</html>