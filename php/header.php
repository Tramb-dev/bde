<?php
header ("Content-type: image/png");
$image = imagecreate(200,50);

$noir = imagecolorallocate($image, 0, 0, 0);
$blanc = imagecolorallocate($image, 255, 255, 255);

imagestring($image, 4, 35, 15, "Adrénaline", $blanc);
imagecolortransparent($image, $noir); // On rend le fond transparent
imagepng($image);
?>
