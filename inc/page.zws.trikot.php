<?php
/**
 *
 */
class Trikot extends PageZws {
  public function __construct($path, $client) {
    parent::__construct($client);
    $this->path($path);
  }
  
  public function index() {
    $this->topic('retro');
    $this->search();
  }
  
  public function search() {
    $topic = $this->topic() . ' trikot';
    $result = $this->client()->searchProducts($topic, $this->params(), $this->num(), 10);
    $this->content($result);
  }
  
  public function item() {
    $this->padre($this->args(3));
    $this->topic($this->unurify($this->args(1)));
    $id = $this->args(2);
    $result = $this->client()->getProduct($id);
    $this->content($result);
  }
  
  public function country($country = null) {
    if ($country) $this->country = $country;
    return $this->country;
  }
  

  public function boxes() {
    $path = $this->path() . 'land/';
    $left = $this->menu($this->countryList(), $path, 'nav');
    $this->box('left', $left);
    
    $right = '';
    $parent = $this->padre();
    $teams = $this->teamList();
    if (isset($teams[$parent])) {
      $path = $this->path() . $parent . '/verein/';
      $list = $this->menu_sub($teams[$parent], $path, 'teams', 'Vereine');
      $right .= $list;
    }
    $players = $this->playerList();
    if (isset($players[$parent])) {
      $path = $this->path() . $parent . '/spieler/';
      $list = $this->menu_sub($players[$parent], $path, 'teams', 'Spieler');
      $right .= $list;
    }
    $this->box('right', $right);
  }

  public function countries() {
    $this->topic($this->args(1));
    $this->padre($this->args(1));
    $this->search();
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
        'kamerun',
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
    $this->search();
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
    $this->search();
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