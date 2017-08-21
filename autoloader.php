<?php

 spl_autoload_register(function ($className) {
     $path = preg_replace('/\\\/', '/', $className);

     require_once(__DIR__.'/'.$path.'.php');
 });