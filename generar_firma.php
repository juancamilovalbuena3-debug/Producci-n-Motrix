<?php
$ancho = 400;
$alto  = 120;
$img   = imagecreatetruecolor($ancho, $alto);

$blanco = imagecolorallocate($img, 255, 255, 255);
$negro  = imagecolorallocate($img, 26, 26, 46);
$gris   = imagecolorallocate($img, 100, 100, 100);

imagefill($img, 0, 0, $blanco);

// Texto Motrix como firma
imagesetthickness($img, 2);

// M
imageline($img, 30, 90, 30, 30, $negro);
imageline($img, 30, 30, 55, 65, $negro);
imageline($img, 55, 65, 80, 30, $negro);
imageline($img, 80, 30, 80, 90, $negro);

// o
imageellipse($img, 105, 72, 35, 35, $negro);

// t
imageline($img, 130, 45, 130, 95, $negro);
imageline($img, 118, 65, 142, 65, $negro);

// r
imageline($img, 152, 95, 152, 60, $negro);
imagearc($img, 170, 60, 30, 20, 270, 90, $negro);

// i
imageline($img, 190, 60, 190, 95, $negro);
imagefilledellipse($img, 190, 48, 5, 5, $negro);

// x
imageline($img, 205, 60, 225, 95, $negro);
imageline($img, 225, 60, 205, 95, $negro);

// Línea decorativa
imageline($img, 20, 105, 380, 105, $gris);

// Texto pequeño
imagestring($img, 2, 130, 108, 'MOTRIX S.A.S.', $gris);

imagepng($img, 'public/images/firma_motrix.png');
imagedestroy($img);
echo "Firma creada correctamente!\n";