<?php
include 'imageProcessing.php';
session_start();

// Uploads an image and saves it to directory, type of ext allowed and size of folder
if (isset($_POST['submit'])) {
    $file = $_FILES['file'];
    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];
    $fileType = $_FILES['file']['type'];

    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    $allowed = array('jpg', 'jpeg', 'png', 'bmp', 'gif');

    if (in_array($fileActualExt, $allowed)) {
        if ($fileError === 0) {
            if ($fileSize < 100000000) {
                $fileNameNew = uniqid('', true) . "." . $fileActualExt;
                $fileDestination = 'uploads/' . $fileNameNew;
                move_uploaded_file($fileTmpName, $fileDestination);

                $rgbColors = getTopRGBColors($fileDestination);

                $_SESSION["img_location"] = $fileDestination;
                $_SESSION["rgb_colors"] = $rgbColors;

                header("Location: index.php?uploadsuccess");
            } else {
                echo 'Your file is too big!';
            }
        } else {
            echo 'There was an error uploading your file!';
        }
    } else {
        echo 'You cannot upload files of this type!';
    }
}