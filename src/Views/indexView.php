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
        <div class="searchbarwrapper"><input class="searchbar" type="text"/></div>
        <?php
        $nextPage = $data["pageInfo"]["page"] + 1;
        $previousPage = $data["pageInfo"]["page"] - 1;
        if ($data["pageInfo"]["maxPages"] != $data["pageInfo"]["page"]) {
            echo "<a class=\"btn btn-secondary\" href=\"??page=$nextPage\">Next Page</a>";
        }
        if ($previousPage > 0) {
            echo "<a class=\"btn btn-secondary\" href=\"??page=$previousPage\">Previous Page</a>";
        }
        ?>
        <div class="image-wrapper">
            <?php
            if (!empty($data["imageData"])) {
                foreach ($data["imageData"] as $image) {
                    $watermarkedFilename = "watermarked" . $image["filename"];
                    $miniaturedFilename = "miniature" . $image["filename"];
                    $imageName = $image["name"];
                    echo "<a class='imagelink' href='/images/watermarks/$watermarkedFilename'><img class='image' src=\"/images/miniatures/$miniaturedFilename\" alt=\"$imageName\"></a>";
                }
            }
            ?>
        </div>
    </div>
</div>
</body>
</html>