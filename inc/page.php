<?php
/**
 * 
 */
abstract class Page {
  protected $title = '';
  protected $topic = '';
  protected $padre = '';
  protected $path = '';

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
    $this->args = explode('/', $q);
  }
  
  protected function urify($uri) {
    $uri = str_replace(' ', '-', $uri);
    return urlencode(strtolower($uri));
  }

  protected function args($idx) {
    if (isset($this->args[$idx])) {
      return str_replace('-', ' ', $this->args[$idx]);
    }
    return false;
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

  function pager($total, $limit, $page) {
    $html = '';
    if ($total > $limit && $limit != 0) {
      $max_page = ceil($total / $limit) - 1;
      $html .= '<div id="pagination">';
      # previous link
      if ($page > 0) {
        $html .= sprintf('<a onclick="pager(%d)">&lt;&lt;</a>', 0);
        $html .= '&nbsp;&nbsp;';
        $html .= sprintf('<a onclick="pager(%d)">&lt;</a>', $page -1);
      }
      $html .= sprintf('<span class="pager-info">%d von %d</span>', $page +1, $max_page +1);
      # next link
      if ($max_page > $page) {
        $html .= sprintf('<a onclick="pager(%d)">&gt;</a>', $page +1);
        $html .= '&nbsp;&nbsp;';
        $html .= sprintf('<a onclick="pager(%d)">&gt;&gt;</a>', $max_page);
      }
      $html .= '</div>';
    }
    return $html;
  }
}