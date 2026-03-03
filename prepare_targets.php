<?php
// prepare_targets.php

$srcDir = __DIR__ . '/public/assets/country-teams-shields';
$destDir = __DIR__ . '/public/assets/ar-compiler-targets';

if (!is_dir($destDir)) {
    mkdir($destDir, 0777, true);
}

$files = scandir($srcDir);
$count = 0;

foreach ($files as $file) {
    if (pathinfo($file, PATHINFO_EXTENSION) === 'png') {
        $srcPath = $srcDir . '/' . $file;
        $destPath = $destDir . '/' . str_replace('.png', '.jpg', $file);

        $srcImg = @imagecreatefrompng($srcPath);
        if (!$srcImg) {
            echo "Failed to load: $file\n";
            continue;
        }

        $width = imagesx($srcImg);
        $height = imagesy($srcImg);

        // Add 50px white padding on all sides for tracking contrast
        $pad = 50;
        $newWidth = $width + ($pad * 2);
        $newHeight = $height + ($pad * 2);

        $destImg = imagecreatetruecolor($newWidth, $newHeight);
        $white = imagecolorallocate($destImg, 255, 255, 255);
        imagefill($destImg, 0, 0, $white);

        // Enable alpha blending for the destination, so the transparent PNG composites on top of white
        imagealphablending($destImg, true);

        imagecopy($destImg, $srcImg, $pad, $pad, 0, 0, $width, $height);

        // Save as max quality JPEG
        imagejpeg($destImg, $destPath, 100);

        imagedestroy($srcImg);
        imagedestroy($destImg);

        $count++;
    }
}

echo "Successfully processed $count shields into $destDir for compilation.\n";
