<?php
/* @var string $content */

use app\assets\AssetBase;

$asset = new AssetBase();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Framework</title>
    <?= $asset->getCss() ?>
</head>
<body>
    <header><h1>Header</h1></header>
    <?= $content ?>
    <footer><h1>Footer</h1></footer>
    <?= $asset->getJs() ?>
</body>
</html>