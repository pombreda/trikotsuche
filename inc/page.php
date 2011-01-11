<?php
/**
 * 
 */
abstract class Page {
  protected $title = '';
  protected $topic = '';
  protected $padre = '';
  protected $path = '';
  protected $num = 0;
  protected $content = '';
  protected $tab = '';

  private $args = array();
  
//  abstract protected function index();
//  abstract protected function item();
//  abstract protected function boxes();
  
  public function __construct() {
    $q = '';
    if (isset($_REQUEST['q'])) {
      $q = $_REQUEST['q'];
    }
    if (isset($_REQUEST['page'])) {
      $this->num = $_REQUEST['page'];
    }
    
    $this->format('html');
    if (isset($_REQUEST['format'])) {
      $this->format($_REQUEST['format']);
    }
    
    $this->args = explode('/', $q);
  }
  
  protected function args($idx) {
    if (isset($this->args[$idx])) {
      return str_replace('-', ' ', $this->args[$idx]);
    }
    return false;
  }
  
  public function num() {
    return $this->num;
  }
  
  public function urify($uri) {
    $uri = preg_replace('/[^\w\pL]+/u', '-', trim($uri));
    return urlencode(strtolower($uri));
  }
  
  public function unurify($uri) {
    $uri = str_replace('-', ' ', $uri);
    return urldecode($uri);
  }
  
  public function padre($padre = null) {
    if ($padre) $this->padre = $padre;
    return $this->padre;
  }
  
  public function path($path = null) {
    if ($path)
      $this->path = $path;
    return $this->path;
  }
  
  public function title($title = null) {
    if ($title)
      $this->title = $title;
    return $this->title;
  }

  public function topic($topic = null) {
    if ($topic)
      $this->topic = $topic;
    return $this->topic;
  }
  
  public function format($format = null) {
    if ($format)
      $this->format = $format;
    return $this->format;
  }
  
  public function params($params = null) {
    if ($params)
      $this->params = $params;
    return $this->params;
  }

  public function box($name, $content = '') {
    if (!isset($this->box->$name)) {
      $this->box->$name = '';
    }
    if ($content) $this->box->$name = $content;
    return $this->box->$name;
  }
  
  public function content($content = null) {
    if ($content)
      $this->content = $content;
    return $this->content;
  }

  function render($page, $template, $format = 'Content-Type: text/html') {
    header($format);
    ob_start('ob_gzhandler');
    include $template;
  }

  function menu($items, $path, $id) {
    if (!check_array($items)) return false;  
    $html = sprintf('<div id="%s">', $id);
    foreach ($items as $header => $item) {
      $html .= $this->menu_items($item, $path, $header);
    }
    $html .= '</div>';
    return $html;
  }
  
  function menu_sub($items, $path, $id, $header) {
    if (!check_array($items)) return false;  
    $html = sprintf('<div id="%s" class="submenu">', $id);
    $html .= $this->menu_items($items, $path, $header);
    $html .= '</div>';
    return $html;
  }

  function menu_items($items, $path, $header) {
    if (!check_array($items)) return false;  
    $html = '';
    $template = '<li><a href="%s">%s</a></li>';
    $html .= sprintf('<h3 class="subnav-header">%s</h3>', ucwords($header));
    $html .= sprintf('<ul class="subnav" id="%s">', strtolower($header));
    foreach ($items as $i) {
      $href = $path . $this->urify($i);
      $html .= sprintf($template, $href, ucwords($i));
    }
    $html .= '</ul>';
    return $html;
  }
  
  function menu_tags($items, $path, $id, $header = '', $limit = 100) {
    if (!check_array($items)) return false;
    $html = '';
    if (!empty($header)) {
      $html .= sprintf('<h3>Tags</h3>', $path);
    }
    $template = '<li style="font-size:%dpx;"><a href="%s">%s</a></li>';
    $html .= sprintf('<ul class="tags" id="%s">', $id);
    $count = 0;
    $items = array_slice($items, 0, $limit);
    ksort($items);
    foreach ($items as $tag => $value) {
      $href = $path . $this->urify($tag);
      $html .= sprintf($template, ceil($value) * 1.4, $href, $tag);
    }
    $html .= '</ul>';
    return $html;
  }
  
  function tab($id, $header, $content) {
    $this->tab[$id]['header'][] = $header;
    $this->tab[$id]['content'][] = $content;
  }
  
  function tab_menu($id) {
    $html = '';
    if (isset($this->tab[$id])) {
      $header = $this->tab[$id]['header'];
      $content = $this->tab[$id]['content'];
      
      $html .= sprintf('<ul id="%s" class="tab-menu">', $id);
      $template = '<li id="tab-header-%s-%d" class="tab-header">%s</li>';
      foreach ($header as $idx => $h) {
        $html .= sprintf($template, $id, $idx, $h);
      }
      $html .= '</ul>';
      
      $template = '<div id="tab-content-%s-%d" class="tab-content">%s</div>';
      foreach ($content as $idx => $c) {
        $html .= sprintf($template, $id, $idx, $c);
      }
    }
    return $html;
  }

  # FIXME does not work on index page
  public function pager($total, $limit) {
    $html = '';
    $total = intval($total);
    $limit = intval($limit);
    $num = intval($this->num());
    if ($total > $limit && $limit != 0) {
      $max_page = ceil($total / $limit) - 1;
      $html .= '<div id="pagination">';
      # previous link
      if ($num > 0) {
        $html .= sprintf('<a onclick="pager(%d)">&lt;&lt;</a>', 0);
        $html .= '&nbsp;&nbsp;';
        $html .= sprintf('<a onclick="pager(%d)">&lt;</a>', $num -1);
      }
      $html .= sprintf('<span class="pager-info">%d von %d</span>', $num +1, $max_page +1);
      # next link
      if ($max_page > $num) {
        $html .= sprintf('<a onclick="pager(%d)">&gt;</a>', $num +1);
        $html .= '&nbsp;&nbsp;';
        $html .= sprintf('<a onclick="pager(%d)">&gt;&gt;</a>', $max_page);
      }
      $html .= '</div>';
    }
    return $html;
  }
  
  public function xml_sitemap($items) {
    $xml = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
    $item_template = '<url><loc>%s</loc></url>';
    foreach ($items as $item) {
      $xml .= sprintf($item_template, $item);
    }
    $xml .= '</urlset>';
    header('Content-Type: text/xml; charset=utf-8');
    echo $xml;
    exit();
  }
}
