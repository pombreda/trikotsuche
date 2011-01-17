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
$template_rss = $path_templates . 'rss.php';

// Includes
include($path_conf . 'settings.php');
include($path_conf . 'urls.php');
include($path_inc . 'common.php');
include($path_inc . 'page.php');
include($path_inc . 'page.zws.php');
include($path_inc . 'page.zws.trikot.php');

// Libraries
include($path_lib . 'cache.php');
include($path_lib . 'wsclient.php');
include($path_lib . 'zws.php');

$path_root_www = 'http://' . $_SERVER['HTTP_HOST'] . base_path();
$path_static = $path_root_www . 'static/';

// Static files and paths
$page = array();
$page['path_img'] = $path_static . 'img/';
$page['file_js'] = $path_static . 'js/script.js';
$page['path_css'] = $path_static . 'css/';

$p = null;
$class = '';
$method = '';
$q = '';

if (isset($_REQUEST['q'])) {
  $q = $_REQUEST['q'];
}

$zws = new Zws($zws_connect_id, $zws_public_key, $zws_secret_key, $zws_adspace_id);

foreach ($urls as $pattern => $action) {
  $re = '!' . $pattern . '!u';
  if (preg_match($re, $q)) {
    $a = explode('.', $action);
    $class = $a[0];
    $method = $a[1];
    $p = new $class($path_root_www, $zws);
    $p->$method();
    break;
  }
}

if (!$p) {
  header('Location: ' . $path_root_www, TRUE, 302);
  exit();
}

$page_url = $path_root_www . $q;
$rss_url = $page_url . '?format=rss';

$title = ucwords(check_plain($p->topic()));
$page['base_url'] = $path_root_www;
$page['site_name'] = $site_name;
$page['site_slogan'] = $site_slogan;
$page['title'] = $title . ' - Trikots suchen und kaufen';
$page['description'] = $page['title'] . ' - ' . $site_description;
$page['url'] = $page_url;
$page['search_display'] = $page['title'];
$page['search_info'] = '';
$page['content'] = 'Keine Ergebnisse';
$page['pager'] = '';
$page['right'] = $p->box('right');
$page['footer'] = $site_footer;
$page['rss_url'] = $rss_url;
$page['rss_date'] = date('D, d M Y H:i:s T');

$cache_id = md5($title . $q . $p->num());
$cache = new Cache($path_cache, 86400, true);
$result = null;

if (false === ($result = $cache->get($cache_id))) {
  $result = $p->content();
  if (is_array($result)) {
    # remove false values from result array
    $result = array_filter($result, 'not_false');
    if (!empty($result)) {
      $cache->set($cache_id, $result);
    }
  }
}

$path = 'fanartikel';
$meta = $zws->result_meta();
if($result) {
  if (empty($meta)) {
    $page['content'] = $p->item_page($result, $path);
  }
  else {
    if ('rss' == $p->format()) {
      $page['content'] = $p->items_feed($result, $path);
      $p->render($page, $template_rss, 'Content-Type: text/xml; charset=utf-8');
      exit();
    }
    $total = $meta['total'];
    $page['search_info'] = 'Suchergebnisse: ' . $total;
    $page['content'] = $p->items_html($result);
    $page['pager'] = $p->pager($total, Trikot::ITEM_LIMIT);
  }
}

$p->render($page, $template_page);