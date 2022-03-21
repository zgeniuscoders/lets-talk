<?php

namespace Zgeniuscoders\Zgeniuscoders\Helpers;

function store(array $file)
{
    if (!empty($file["profil"])) {
        $maxSize = 10240000;
        $fileName = $file["profil"]["name"];
        $fileSize = $file["profil"]["size"];
        $fileExt = "." . strtolower(substr(strrchr($fileName, "."), 1));
        $tmpName = $file["profil"]["tmp_name"];
        $uniqueName = md5(uniqid(rand(), true));
        $extension = ['.jpg', '.png', '.svg', '.PNG', '.JPG'];
        if ($file["profil"]["error"] > 0) {
            $errors["profil"] = "na pas pu être upload";
        }
        if ($fileSize > $maxSize) {
            $errors["profil"] = "La photo de profil ne doit pas depasser  10Mega Byte";
        }
        if (!in_array($fileExt, $extension)) {
            $errors["profil"] = "Extension de cette fichier n'est pas autorisé";
        }
    }

    $filename = IMAGES . DIRECTORY_SEPARATOR . $uniqueName . $fileExt;

    move_uploaded_file($tmpName, $filename);
    return $uniqueName . $fileExt;
}
