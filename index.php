<?php
error_reporting(E_ERROR|E_WARNING|E_NOTICE);

// Bootstrap
$path_root_fs = getcwd() . DIRECTORY_SEPARATOR;
$path_conf = $path_root_fs . 'conf' . DIRECTORY_SEPARATOR;
$path_inc = $path_root_fs . 'inc' . DIRECTORY_SEPARATOR;
$path_templates = $path_root_fs . 'templates' . DIRECTORY_SEPARATOR;
// Static files and paths
$template_page = $path_templates . 'page.php';

// Includes
include_once($path_conf . 'settings.php');
include_once($path_inc . 'helper.php');
include_once($path_inc . 'validate.php');
include_once($path_inc . 'template.php');
include_once($path_inc . 'zws.php');
// include zanox API client library
include_once('/usr/local/lib/php/zx_php_client_2009-02-01/zanox-api.class.php');

$path_root_www = 'http://' . $_SERVER['HTTP_HOST'] . basePath();
$path_static = $path_root_www . 'static/';
// Static files and paths
$page = array();
$page['path_img'] = $path_static . 'img/';
$page['file_js'] = $path_static . 'js/script.js';
$page['path_css'] = $path_static . 'css/';

// Query parameters
$search = $zws_default_search;
if (isset($_REQUEST['q'])) {
  $q = $_REQUEST['q'];
  $params = split('/', $q);
  if (isset($params[1])) {
    $search = $params[1];
  }
}
$page_num = $zws_page;
if (isset($_REQUEST['page'])) {
  $page_num = $_REQUEST['page'];
}

$zx = ZanoxAPI::factory('soap');
$zx->setMessageCredentials($zws_application_id, $zws_shared_key);
#var_dump($zx->getProgramsByAdspace($adspace_id));die;

$params = array('region' => $zws_region, 'adspace' => $zws_adspace_id);
$search .= ' ' . $zws_topic;
$result = $zx->searchProducts($search, $params, $page_num, $zws_item_count);

$page_num = $result->page;
$item_total_count = $result->total;
#$item_count = $result->items;

$page['title'] = 'Trikotsuche - Fußballtrikots und Fanartikel';
$page['header'] = '<h1>' . $page['title'] . '</h1>';
$page['content'] = '';
$page['pager'] = '';
$page['left'] = renderCountries();
$page['footer'] = '<p>' . $page['title'] . '</p>';
if ($item_total_count > 0 && isset($result->productsResult->productItem)) {
  $page['content'] = zwsItemsHtml($result->productsResult->productItem);
  $page['pager'] .= pager($item_total_count, $zws_item_count, $page_num);
}

renderPage($page, $template_page);