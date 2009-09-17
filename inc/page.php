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

  # Page regions
  protected $left = '';
  protected $right = '';
  protected $footer = '';
  
  private $args = array();
  
  abstract protected function index();
  abstract protected function item();
  abstract protected function region($name, $content = '');
  abstract protected function regions();
  
  public function __construct() {
    $q = '';
    if (isset($_REQUEST['q'])) {
      $q = $_REQUEST['q'];
    }

    if (isset($_REQUEST['page'])) {
      $this->num = $_REQUEST['page'];
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
    $uri = preg_replace('/[^\w\pL]/u', '-', trim($uri));
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
  
  public function params($params = null) {
    if ($params)
      $this->params = $params;
    return $this->params;
  }

  public function content($content = null) {
    if ($content)
      $this->content = $content;
    return $this->content;
  }
  
  public function left($left = null) {
    if ($left)
      $this->left = $left;
    return $this->left;
  }

  public function right($right = null) {
    if ($right)
      $this->right = $right;
    return $this->right;
  }

  public function footer($footer = null) {
    if ($footer)
      $this->footer = $footer;
    return $this->footer;
  }

  function render($page, $template) {
    header('Content-Type: text/html');
    include ($template);
  }

  function menu($id, $items, $path) {
    $html = sprintf('<div id="%s">', $id);
    foreach ($items as $header => $item) {
      $html .= $this->menu_items($item, $header, $path);
    }
    $html .= '</div>';
    return $html;
  }

  function menu_items($items, $header, $path) {
    $template = '<li><a href="%s">%s</a></li>';
    $html = '';
    $html .= sprintf('<h3 class="subnav-header">%s</h3>', ucwords($header));
    $html .= sprintf('<ul class="subnav" id="%s">', strtolower($header));
    foreach ($items as $i) {
      $href = $path . $this->urify($i);
      $html .= sprintf($template, $href, ucwords($i));
    }
    $html .= '</ul>';
    return $html;
  }

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
}