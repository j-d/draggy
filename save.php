<?php

print_r($_POST);

if (empty($_GET['f']))
    die('Wrong file');

$file = $_GET['f'];

file_put_contents($file,$_POST['xml']);
file_put_contents(str_replace('saves/','saves/backups/',str_replace('.xml','.' . time() . '.xml',$file)),$_POST['xml']);