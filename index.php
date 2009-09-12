<?php
error_reporting(E_ERROR|E_WARNING|E_NOTICE);

// Bootstrap
$path_root_fs = getcwd() . DIRECTORY_SEPARATOR;
$path_conf = $path_root_fs . 'conf' . DIRECTORY_SEPARATOR;
$path_inc = $path_root_fs . 'inc' . DIRECTORY_SEPARATOR;
$path_lib = $path_root_fs . 'lib' . DIRECTORY_SEPARATOR;
$path_lib3rd = $path_lib . '3rd' . DIRECTORY_SEPARATOR;
$path_cache = $path_root_fs . 'cache' . DIRECTORY_SEPARATOR;
$path_templates = $path_root_fs . 'templates' . DIRECTORY_SEPARATOR;
$template_page = $path_templates . 'page.php';

// Includes
include_once($path_conf . 'settings.php');
include_once($path_inc . 'common.php');
include_once($path_inc . 'template.php');
include_once($path_inc . 'zws.php');

// Libraries
include_once($path_lib . 'cache.php');
include_once($path_lib3rd . 'zx_php_client_2009-02-01/zanox-api.class.php');

$path_root_www = 'http://' . $_SERVER['HTTP_HOST'] . base_path();
$path_static = $path_root_www . 'static/';

// Static files and paths
$page = array();
$page['path_img'] = $path_static . 'img/';
$page['file_js'] = $path_static . 'js/script.js';
$page['path_css'] = $path_static . 'css/';

// Query parameters
$search = $site_default_search;
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

$item_total_count = 0;
$params = array('region' => $zws_region, 'adspace' => $zws_adspace_id);
$search = trim($search . ' ' . $site_topic);
$search_display = ucwords(check_plain($search));

$page['base_url'] = $path_root_www;
$page['site_name'] = $site_name;
$page['site_slogan'] = $site_slogan;
$page['title'] = $search_display . ' suchen und kaufen';
$page['search_display'] = $search_display;
$page['search_info'] = '';
$page['content'] = 'Keine Ergebnisse';
$page['pager'] = '';
$page['left'] = renderCountries();
$page['footer'] = $site_footer;

$cache_id = md5($search . $page_num);
$cache = new Cache($path_cache, 86400, true);
if (false === ($result = $cache->get($cache_id))) {
  $zx = ZanoxAPI::factory('soap');
  $zx->setMessageCredentials($zws_application_id, $zws_shared_key);
  $result = $zx->searchProducts($search, $params, $page_num, $zws_item_count);
  if (isset($result->total) && isset($result->productsResult->productItem)) {
    $cache->set($cache_id, $result);
  }
  else {
    $result = false;
  }
}

if ($result) {
  $page['search_info'] = 'Suchergebnisse: ' . $result->total;
  $page['content'] = zwsItemsHtml($result->productsResult->productItem);
  $page['pager'] .= pager($result->total, $zws_item_count, $result->page);
}

renderPage($page, $template_page);