<?php

print_r($_POST);

file_put_contents('saved.xml',$_POST['xml']);


