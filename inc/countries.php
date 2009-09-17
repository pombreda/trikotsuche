<?php
/**
 * FIXME inappropriate class name
 */
class Countries extends Page {
  public function __construct($path) {
    parent::__construct();
    $this->path($path);
  }
  
  public function index() {
    $this->topic('retro');
    #$right = $this->menu('shirts', $this->indexList(), $this->path);
    #$this->region('right', $right);
  }
  
  public function item() {
    
  }
  
  public function country($country = null) {
    if ($country) $this->country = $country;
    return $this->country;
  }
  
  public function region($name, $content = '') {
    if (!isset($this->region->$name)) {
      $this->region->$name = '';
    }
    if ($content) $this->region->$name = $content;
    return $this->region->$name;
  }
  
  public function regions() {
    $left = $this->menu('nav', $this->countryList(), $this->path . 'land/');
    $this->region('left', $left);
    
    $right = '';
    $parent = $this->padre();
    $teams = $this->teamList();
    if (isset($teams[$parent])) {
      $list = $this->menu_items($teams[$parent], 'Vereine', $this->path . $parent . '/verein/');
      $right .= $list;
    }
    $players = $this->playerList();
    if (isset($players[$parent])) {
      $list = $this->menu_items($players[$parent], 'Spieler', $this->path . $parent . '/spieler/');
      $right .= $list;
    }
    $this->region('right', $right);
  }

  public function countries() {
    $this->topic($this->args(1));
    $this->padre($this->args(1));
  }
  
  public function countryList() {
    return array (
      'europa' => array (
        'deutschland',
        'england',
        'spanien',
        'italien',
        'portugal',
        'türkei',
        'frankreich',
        'holland',
        'schweden',
        'schweiz',
        'dänemark',
        'russland',
      ),
      'amerika' => array (
        'brasilien',
        'argentinien',
        'mexiko',
        'chile',
        'usa',
      ),
      'afrika' => array (
        'elfenbeinküste',
        'südafrika',
        'nigeria',
        'ägypten',
      ),
      'asien' => array (
        'japan',
        'südkorea'
      ),
      'ozeanien' => array (
        'australien'
      )
    );
  }

  public function players() {
    $this->topic($this->args(2));
    $this->padre($this->args(0));
  }
  
  public function playerList() {
    return array (
      'argentinien' => array(
        'maradona',
        'messi',
        'aguero',
        'tevez'
      ),
      'brasilien' => array(
        'pele',
        'ronaldinho',
        'ronaldo',
        'robinho'
      ),
      'deutschland' => array (
        'ballack',
        'podolski',
        'gomez',
        'lahm',
        'schweinsteiger'
      ),
      'england' => array(
        'beckham',
        'rooney',
        'gerrard',
        'lampard',
        'owen'
      ),
      'italien' => array (
        'toni',
        'gattuso'
      ),
      'portugal' => array(
        'deco',
        'ronaldo'
      ),
      'spanien' => array (
        'torres',
        'david villa',
        'xavi'
      ),
      'russland' => array(
        'arschawin'
      )
      
    );
  }

  public function teams() {
    $this->topic($this->args(2));
    $this->padre($this->args(0));
  }
  
  public function teamList() {
    return array (
      'argentinien' => array(
        'boca juniors'
      ),
      'deutschland' => array (
        'bayern münchen',
        'borussia dortmund',
        'schalke 04',
        'hertha bsc',
        'werder bremen',
        'vfb stuttgart',
        '1860 münchen',
        '1. fc köln',
        'hannover 96',
      ),
      'england' => array(
        'arsenal',
        'chelsea',
        'manchester united',
        'manchester city',
        'aston villa',
        'tottenham'
      ),
      'italien' => array (
        'ac mailand',
        'as rom'
      ),
      'spanien' => array (
        'real Madrid',
        'fc barcelona'
      ),
      'türkei' => array(
        'besiktas',
        'galatasaray',
        'trabzonspor',
        'ankaraspor',
        'denizlispor'
      )
    );
  }
  
  public function indexList() {
    return array(
      'fussballtrikots' => array(
        'retro'
      )
    );
  }
}