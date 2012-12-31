<?php

require 'SplClassLoader.php';

$classLoader = new SplClassLoader('Autocode', __DIR__ . '/../');
$classLoader->register();