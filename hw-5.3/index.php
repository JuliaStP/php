<?php

require_once 'vendor/autoload.php';

// import the Intervention Image Manager Class
use Intervention\Image\ImageManagerStatic as Image;

// and you are ready to go ...
$image = Image::make(
    'images/eleph.jpg')->resize(200, null,
    function (\Intervention\Image\Constraint $const) {
    $const->aspectRatio();
});

$image->text(
    'Hello world',
    $image->getWidth() / 2,
    $image->getHeight() / 1.3 ,
    function (\Intervention\Image\AbstractFont $font) {
    $font->size(30);
    $font->color([0,0,128]);
    $font->align('right');
    $font->valign('bottom');
});

$image->save('images/elephant_new.jpg');

echo $image->response('jpg');