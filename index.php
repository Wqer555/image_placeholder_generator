<?php
if(!empty($_GET)) {
  function hex_to_array(string $hex): array {
    $hex = hexdec($hex);
    return ['red' => 0xFF & ($hex >> 0x10),
            'green' => 0xFF & ($hex >> 0x8),
            'blue' => 0xFF & $hex];
  }
  header('Content-type: image/png');
  $font = './inconsolata.ttf';
  $x = $_GET['x'];
  $y = $_GET['y'];
  $t = $_GET['text'];
  $fs = $_GET['fs'];
  $bc = hex_to_array($_GET['bc']);
  $tc = hex_to_array($_GET['tc']);
  $img = imagecreatetruecolor($x, $y);
  imagefill($img, 0, 0, imagecolorallocate($img, $bc['red'], $bc['green'], $bc['blue']));
  [$left, $bottom, $right, , , $top] = imageftbbox($fs, 0, $font, $t);
  $x = ($x - ($right - $left)) / 2;
  $y = ($y - ($top - $bottom)) / 2;
  imagettftext($img, $fs, 0, $x, $y, imagecolorallocate($img, $tc['red'], $tc['green'], $tc['blue']), $font, $t);
  imagepng($img);
  imagedestroy($img);
  die;
}
?>
<!doctype html>
<html>
  <head>
    <title>Image Placeholder Generator</title>
  </head>
  <body>
    <form action="?" method="get">
      <table>
        <tr><td>Width</td><td><input type="number" min="0" name="x" value="400" required></td></tr>
        <tr><td>Height</td><td><input type="number" min="0" name="y" value="300" required></td></tr>
        <tr><td>Font Size</td><td><input type="number" min="0" name="fs" value="24" required></td></tr>
        <tr><td>Text</td><td><input type="text" name="text" value="Hello World" required></td></tr>
        <tr><td>Background Color</td><td><input type="color" name="bc" value="#000000" required></td></tr>
        <tr><td>Text Color</td><td><input type="color" name="tc" value="#ffffff" required></td></tr>
      </table>
      <input type="submit" value="Submit">
    </form>
  </body>
</html>
