<?php
require 'vendor/autoload.php';
use Loliko\MtaApi;
$mmd = new MtaApi(500028297 , '9c8db5792f750ae4aace861b85507415');
print_r($mmd->getUserPortrait('2017-11-06' , '2017-11-07' , 'grade'));