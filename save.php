<?php

print_r($_POST);

file_put_contents('saved.txt',$_POST['xml']);


