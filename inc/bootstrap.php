<?php
$path_root = dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR;
$path_conf = $path_root . 'conf' . DIRECTORY_SEPARATOR;
$path_inc = $path_root . 'inc' . DIRECTORY_SEPARATOR;
$path_lib = $path_root . 'lib' . DIRECTORY_SEPARATOR;

include $path_conf . 'settings.php';

include $path_inc . 'common.php';

include $path_lib . 'cache.php';
include $path_lib . 'webservice.php';
include $path_lib . 'datasource.php';