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
            <a class="btn btn-primary" href="/user/register">Register</a>
            <a class="btn btn-primary" href="/user/login">Login in</a>
        </div>
    </div>
    <div class="content">
        <form method="POST" enctype="multipart/form-data">
            <input type="file" name="upfile" accept="image/*"/>
            <input type="text" name="title"/>
            <!--            TO DO TITLE OF IMAGE-->
            <input type="text" name="watermarkText"/>
            <button type="submit" name="save" class="btn">WYSLIJ</button>
        </form>
    </div>
</div>
</body>
</html>