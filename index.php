<?php
include 'imageProcessing.php';

session_start();


if (!isset($_SESSION["rgb_colors"])) {
    $files = glob('uploads/*'); //get all file names
    foreach ($files as $file) {
        if (is_file($file))
            unlink($file); //delete file
    }
    $colors = getTopRGBColors('assets/smile.jpg'); // initial display of image and RGB colors as example
    $_SESSION['img_location'] = 'assets/smile.jpg';
} else {
    $colors = $_SESSION["rgb_colors"];
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous" />
    <title>Extract RGB values from image</title>
</head>

<body>
    <div class="d-flex justify-content-center bg-black vh-100">
        <div class="p-5">
            <form action="upload.php" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="formFile" class="form-label text-white">Upload image</label>
                    <input class="form-control" type="file" id="formFile" name="file" />
                </div>
                <input class="btn btn-dark" type="submit" name="submit" value="Process" />
            </form>
            <div class="pt-3">
                <div class="row">
                    <div class="col-sm-6 mb-2">
                        <img src="<?= $_SESSION['img_location'] ?>" class="img-fluid" alt="...">
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex flex-column text-white">
                            <?php
                            $textColor;
                            foreach ($colors as $key => $value) { // Dark or light text to use
                                $r = ($key >> 16) & 0xFF;
                                $g = ($key >> 8) & 0xFF;
                                $b = $key & 0xFF;
                                if (($r * 0.299 + $g * 0.587 + $b * 0.114) > 186) {
                                    $textColor = 'text-dark';
                                } else {
                                    $textColor = 'text-light';
                                }
                                echo '<div class="p-2 ' . $textColor . '" style="background-color: rgb(' . $r . ',' . $g . ',' . $b . ');">' . $value . '%' . '</div>
                                <span>' . 'R:' . $r . ' G:' . $g . ' B:' . $b . ' ' . ' </span>
                                ';
                            }
                            session_destroy();

                            ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous">
    </script>
</body>

</html>