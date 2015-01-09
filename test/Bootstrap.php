<?php
/** @var Composer\Autoload\ClassLoader $loader */
$loader = require_once('./vendor/autoload.php');

$loader->add('EyeSpyTestAsset', './test');

$spoof = new \EyeSpyTestAsset\Spoof();