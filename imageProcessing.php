<?php
include 'createImage.php';

function getTopRGBColors($imgLocation)
{
        $image = imageCreateFromAny($imgLocation); // Create a new image from file or URL

        $imgWidth = imagesx($image);
        $imgHeight = imagesy($image);

        $pixels = $imgWidth * $imgHeight;

        $rgbArray = array();

        for ($i = 0; $i < $imgWidth; $i++) { // Get RGB value of every pexel and assign it to associative array, increment value on every occurrence
                for ($j = 0; $j < $imgHeight; $j++) {

                        $rgb = ImageColorAt($image, $i, $j); // this function returns the RGB value of that pixel as integer
                        if (!array_key_exists($rgb, $rgbArray)) {
                                $rgbArray[$rgb] = 1;
                        } else {
                                $rgbArray[$rgb] += 1;
                        }
                }
        }

        arsort($rgbArray);
        $rgbArray = (array_slice($rgbArray, 0, 5, true));
        foreach ($rgbArray as $key => $value) {
                $rgbArray[$key] = round(($value / $pixels) * 100, 2); // Percentage
        }
        return $rgbArray;
}