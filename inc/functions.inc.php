<?php

function e($value){
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function uploadAndResizeImage(array $file, string $uploadDir, int $maxDim = 400): ?string {
    if(empty($file) || $file['error'] !== 0 || $file['size'] === 0) return null;

    $nameWithoutExtension = pathinfo($file['name'], PATHINFO_FILENAME);
    $name = preg_replace('/[^a-zA-Z0-9]/', '', $nameWithoutExtension);
    $originalImage = $file['tmp_name'];

    $imageSize = getimagesize($originalImage);
    if(empty($imageSize)) die("Not a valid image.");

    switch($imageSize[2]){
        case IMAGETYPE_JPEG:
            $im = imagecreatefromjpeg($originalImage);
            $ext = '.jpg';
            break;
        case IMAGETYPE_PNG:
            $im = imagecreatefrompng($originalImage);
            $ext = '.png';
            break;
        default:
            die("Unsupported image type");
    }

    $imageName = $name . '-' . time() . $ext;

    $width = $imageSize[0];
    $height = $imageSize[1];
    $scaleFactor = $maxDim / max($width, $height);
    $newWidth = (int)($width * $scaleFactor);
    $newHeight = (int)($height * $scaleFactor);

    $destImage = rtrim($uploadDir, '/') . '/' . $imageName;

    $newImg = imagecreatetruecolor($newWidth, $newHeight);
    imagecopyresampled($newImg, $im, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

    if($imageSize[2] == IMAGETYPE_PNG) imagepng($newImg, $destImage);
    else imagejpeg($newImg, $destImage);

    return $imageName;
}