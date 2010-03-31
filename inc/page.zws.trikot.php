<?php
/**
 * Main PageZws subclass for www.trikotsuche.de
 */
class Trikot extends PageZws {
  public function __construct($path, $client) {
    parent::__construct($client);
    $this->path($path);
    
    # ugly
    $path = $this->path() . 'land/';
    $left = $this->menu($this->countryList(), $path, 'nav');
    $this->box('left', $left);
  }
  
  /**
   * Display index page.
   */
  public function index() {
    $path = $this->path() . 'tags/';
    $list = $this->searchList();
    $this->topic('fußball trikots');
    $result = $this->item_search();
    $this->content($result);
    
    $tags = $this->menu_tags(
      $list,
      $path,
      'tags',
      'Tags',
      30
    );
    $this->box('right', $tags);
  }
  
  /**
   * Display search results.
   */
  public function search() {
    if (isset($_POST['search'])) {
      $topic = $this->urify($_POST['search']);
      $redirect = $this->path() . 's/' . $topic;
      header('Location: ' . $redirect);
      exit();
    }
    $this->topic($this->args(1));
    $result = $this->item_search();
    $this->content($result);
  }
  
  /**
   * Perform a search.
   */
  public function item_search() {
    return $this->client()->search(
      $this->topic(), $this->num(), 10);
  }

  /**
   * Display tags page.
   */
  public function tags() {
    $topic = $this->args(1);
    $path = $this->path() . 'tags/';
    if ($topic) {
      $this->topic($topic);
      $result = $this->item_search();
      $this->box('right', $this->menu_tags(
        $this->searchList(),
        $path,
        'tags',
        'Tags',
        30
      ));
    }
    else {
      $topic = $this->topic('Tags');
      $result = $this->menu_tags(
        $this->searchList(),
        $path,
        'tags'
     );
    }
    $this->content($result);
  }
  
  /**
   * Display a single item.
   */
  public function item() {
    $this->padre($this->args(3));
    $this->topic($this->unurify($this->args(1)));
    $id = $this->args(2);
    $result = $this->client()->getProduct($id);
    $this->content($result);
    $this->boxes();
  }
  
  /**
   * Country getter/setter.
   */
  public function country($country = null) {
    if ($country) $this->country = $country;
    return $this->country;
  }

  /**
   * Add content to the boxes of a page, i.e. left and right sidebars.
   */
  public function boxes() {
    $right = '';
    $parent = $this->padre();
    $teams = $this->teamList();
    if (isset($teams[$parent])) {
      $path = $this->path() . $parent . '/verein/';
      $list = $this->menu_sub($teams[$parent], $path, 'teams', 'Vereine');
      $this->tab($parent, 'Vereine', $list);
    }
    $players = $this->playerList();
    if (isset($players[$parent])) {
      $path = $this->path() . $parent . '/spieler/';
      $list = $this->menu_sub($players[$parent], $path, 'players', 'Spieler');
      $this->tab($parent, 'Spieler', $list);
    }
    $tabs = $this->tab_menu($parent);
    $this->box('right', $tabs);
  }
  
  /**
   * Create link array for sitemap generation.
   */
  public function xml_sitemap() {
    $items = array();
    $countries = $this->countryList();
    $players = $this->playerList();
    $teams = $this->teamList();
    $search = $this->searchList();
    
    foreach ($countries as $continent => $cs) {
      foreach ($cs as $c) {
        $path = $this->path();
        $c = $this->urify($c);
        $items[] = $path . 'land/' . $c;
        
        if (isset($players[$c])) {
          foreach ($players[$c] as $i) {
            $items[] = $path . $c . '/spieler/' . $this->urify($i);
          }
        }
        
        if (isset($teams[$c])) {
          foreach ($teams[$c] as $i) {
            $items[] = $path . $c . '/verein/' . $this->urify($i);
          }
        }
      }
    }
    
    foreach ($search as $term => $value) {
      $items[] = $path . 'tags/' . $this->urify($term);
    }
    
    parent::xml_sitemap($items);
  }

  public function countries() {
    $topic = $this->args(1);
    $this->topic($topic . ' trikot');
    $this->padre($topic);
    $result = $this->item_search();
    if (!$result) {
      $this->topic($topic);
      $result = $this->item_search();
    }
    $this->content($result);
    $this->boxes();
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
        'griechenland',
        'kroatien',
        'schweden',
        'schweiz',
        'dänemark',
        'russland',
        'belgien',
        'albanien',
        'bosnien',
        'bulgarien',
        'estland',
        'finnland',
        'irland',
        'island',
        'lettland',
        'litauen',
        'mazedonien',
        'moldawien',
        'montenegro',
        'österreich',
        'polen',
        'rumänien',
        'schottland',
        'serbien',
        'slowakei',
        'slowenien',
        'tschechien',
        'ukraine',
        'ungarn',
        'wales',
        'weißrussland',
        'zypern'
      ),
      'amerika' => array (
        'brasilien',
        'argentinien',
        'mexiko',
        'chile',
        'usa',
        'kanada',
        'bolivien',
        'kolumbien',
        'ecuador',
        'guyana',
        'paraguay',
        'bermuda',
        'belize',
        'costa rica',
        'el salvador',
        'guatemala',
        'honduras',
        'nicaragua',
        'panama',
        'peru',
        'surinam',
        'trinidad',
        'uruguay',
        'venzuela'
      ),
      'afrika' => array (
        'elfenbeinküste',
        'südafrika',
        'kamerun',
        'nigeria',
        'marokko',
        'ägypten',
        'algerien',
        'angola',
        'äquatorialguinea',
        'äthiopien',
        'benin',
        'botsuana',
        'burkina faso',
        'burundi',
        'dschibuti',
        'eritrea',
        'gabun',
        'gambia',
        'ghana',
        'guinea',
        'kamerun',
        'kap verde',
        'kenia',
        'komoren',
        'kongo',
        'lesotho',
        'liberia',
        'libyen',
        'madakaskar',
        'malawi',
        'mali',
        'mauretanien',
        'mauritius',
        'mosambik',
        'namibia',
        'niger',
        'ruanda',
        'sambia',
        'senegal',
        'seychellen',
        'sierra leone',
        'simbabwe',
        'somalia',
        'sudan',
        'swasiland',
        'tansania',
        'togo',
        'tschad',
        'tunesien',
        'uganda'
      ),
      'asien' => array (
        'japan',
        'südkorea',
        'mongolei',
        'china',
        'norkorea',
        'bangladesch',
        'buthan',
        'indien',
        'malediven',
        'nepal',
        'pakistan',
        'sri lanka',
        'brunei',
        'indonesien',
        'kambodscha',
        'laos',
        'malaysia',
        'myanmar',
        'philippinen',
        'singapur',
        'thailand',
        'osttimor',
        'vietnam',
      ),
      'ozeanien' => array (
        'australien'
      )
    );
  }

  public function players() {
    $topic = $this->args(2);
    $this->topic($topic . ' trikot');
    $this->padre($this->args(0));
    $result = $this->item_search();
    if (!$result) {
      $this->topic($topic);
      $result = $this->item_search();
    }
    $this->content($result);
    $this->boxes();
  }

  public function playerList() {
    return array (
      'argentinien' => array(
        'maradona',
        'messi',
        'aguero',
        'saviola',
        'tevez'
      ),
      'brasilien' => array(
        'pele',
        'kaka',
        'ronaldinho',
        'ronaldo',
        'robinho'
      ),
      'dänemark' => array (
        'bendtner'
      ),
      'deutschland' => array (
        'asamoah',
        'ballack',
        'cacau',
        'friedrich',
        'frings',
        'gentner',
        'gomez',
        'hitzlsperger',
        'klose',
        'kuranyi',
        'lahm',
        'lehmann',
        'marin',
        'mertesacker',
        'odonkor',
        'özil',
        'podolski',
        'schäfer',
        'schweinsteiger',
        'trochowski',
        'westermann'
      ),
      'england' => array(
        'beckham',
        'ferdinand',
        'rooney',
        'gerrard',
        'lampard',
        'owen',
        'shearer',
        'gascoigne',
        'sheringham',
        'fowler',
      ),
      'frankreich' => array(
        'ribery',
        'henry',
        'zidane',
        'cantona',
        'platini'
      ),
      'holland' => array(
        'van nistelrooy',
        'Sneijder'
      ),
      'italien' => array (
        'toni',
        'gattuso',
        'cannavaro',
        'maldini',
        'del piero',
        'nesta',
        'baggio',
        'gilardino',
        'materazzi',
        'rossi',
        'gentile',
        'altobelli',
        'conti',
        'bergomi'
      ),
      'kroatien' => array(
        'boksic',
        'klasnic',
        'prso',
        'suker'
      ),
      'portugal' => array(
        'deco',
        'ronaldo',
        'simao',
        'eusebio'
      ),
      'russland' => array(
        'arshavin',
        'pavlyuchenko'
      ),
      'spanien' => array (
        'torres',
        'david villa',
        'xavi',
        'fabregas',
        'sergio ramos',
        'raul'
      ),
      'ukraine' => array(
        'shevchenko'
      )
    );
  }

  public function teams() {
    $this->topic($this->args(2) . ' trikot');
    $this->padre($this->args(0));
    $result = $this->item_search();
    $this->content($result);
    $this->boxes();
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
        'fc barcelona',
        'valencia',
        'deportivo',
        'villareal',
        'sevilla'
      ),
      'türkei' => array(
        'besiktas',
        'galatasaray',
        'trabzonspor',
        'ankaraspor',
        'denizlispor'
      ),
      'holland' => array(
        'ajax'
      )
    );
  }
  
  public function indexList() {
    return array(
      'fussballtrikots' => array(
        'retro',
        'nationalmannschaft',
        'dfb',
        ''
      )
    );
  }
  
  function searchList() {
    return array(
      'trikot' => 14.9290114591,
      'fanshop' => 14.347255832,
      'fanartikel' => 14.2209756661,
      'werder bremen' => 13.6207114797,
      'schal' => 13.3236702341,
      'trikots' => 13.1451028644,
      'schalke 04' => 12.8488997422,
      'fahne' => 12.8488997422,
      'fussballschuhe' => 12.8488997422,
      'trainingsanzug' => 12.5620323337,
      'sportbekleidung' => 12.317166693,
      'nationalmannschaft' => 12.0823784232,
      'sportartikel' => 12.0332062475,
      'nalini' => 11.4320949471,
      'erima' => 11.2922787939,
      'stutzen' => 11.1899615784,
      'deutschland trikot' => 11.1358291309,
      'trainingsanzüge' => 10.9653494077,
      'dfb trikot' => 10.5365662066,
      'fussball trikot' => 10.5132531242,
      'trikotsatz' => 10.4912742174,
      'werder bremen trikot' => 10.4912742174,
      'trikotsätze' => 10.3997070239,
      'schalke trikot' => 10.3859137018,
      'fußballtrikot' => 10.2564656716,
      'teamsport' => 10.2564656716,
      'fussballtrikot' => 9.96170928974,
      'fußball trikot' => 9.95313449243,
      'fan artikel' => 9.71099444042,
      'fussballspieler' => 9.59624882254,
      'torwart trikot' => 9.58052366594,
      'fahrrad trikot' => 9.46032057724,
      'vfb stuttgart trikot' => 9.39337001135,
      'trikos' => 9.39337001135,
      'trikot home' => 9.33600338997,
      'fussball trikots' => 9.32839003875,
      'vfb trikot' => 9.19202364019,
      'fußballtrikots' => 9.17781718027,
      'fußball trikots' => 9.15482766205,
      'italien trikot' => 9.12260145767,
      'rad trikot' => 9.10670059722,
      'hertha trikot' => 9.08250700047,
      'retro trikot' => 8.99093980694,
      'trickot' => 8.98544528762,
      'trikot hose' => 8.91058571829,
      'em trikot' => 8.89913989728,
      'deutschland trikots' => 8.79026911148,
      'kinder trikot' => 8.78477459216,
      'trikot s' => 8.70946507906,
      'football trikot' => 8.68946441236,
      'wm trikot' => 8.67931204089,
      'hannover 96 trikot' => 8.60245303537,
      'trikot set' => 8.60245303537,
      '1860 trikot' => 8.58774484737,
      'kappa trikot' => 8.58774484737,
      'schiedsrichter trikot' => 8.48011418317,
      'frankreich trikot' => 8.48011418317,
      'trikot hsv' => 8.28399930425,
      'bundesliga trikot' => 8.09712193092,
      'argentinien trikot' => 8.07464907507,
      'fußball fanartikel' => 8.05165955684,
      'trikot kaufen' => 7.97933889526,
      'podolski trikot' => 7.97933889526,
      'as rom trikot' => 7.97384437594,
      'ballack trikot' => 7.88777170174,
      'trikot shop' => 7.88777170174,
      'fussball fanartikel' => 7.84678549783,
      'trikot beflockung' => 7.78696700261,
      'borussia mönchengladbach trikot' => 7.78681547598,
      'original trikot' => 7.78322401634,
      'jordan trikot' => 7.67786350068,
      'trikot nationalmannschaft' => 7.65775527113,
      'fantrikot' => 7.56760417414,
      'trikot langarm' => 7.46664794839,
      'dfb trikots' => 7.38832785958,
      'trikot wm 2006' => 7.29871570089,
      'manu trikot' => 7.27239839257,
      'real trikot' => 7.20823017323,
      'national trikot' => 7.16239749736,
      'fan trikot' => 7.10742547411,
      'mini trikot' => 7.09007683578,
      'sporttrikot' => 7.05185562296,
      'michael jordan trikot' => 7.03878354139,
      'lakers trikot' => 6.95654544315,
      'trikot shirt' => 6.95654544315,
      'trikot schweinsteiger' => 6.92755790628,
      'damen trikot' => 6.91945655129,
      'trikot 09 10' => 6.79215922514,
      'usa trikot' => 6.76849321165,
      'fc trikot' => 6.7681483246,
      'trikot brasilien' => 6.75460409949,
      'kamerun trikot' => 6.75460409949,
      'trikots kaufen' => 6.75460409949,
      'lahm trikot' => 6.74288063579,
      'vereinstrikots' => 6.70735121464,
      'japan trikot' => 6.49223983502,
      'trikot schweden' => 6.48768401848,
      'wm trikots' => 6.4303644313,
      'trikot bestellen' => 6.36440646351,
      'baseball trikot' => 6.34510990649,
      'trikot discount' => 6.22105725782,
      'trikot satz' => 6.17316090851,
      'baby trikot' => 6.17316090851,
      'sporttrikots' => 6.16373576805,
      'arshavin trikot' => 6.07940674075,
      'italien trikots' => 6.06911979167,
      'lehmann trikot' => 6.04910825984,
      'trikot 2010' => 5.9319003004,
      'iverson trikot' => 5.8497569632,
      'buffon trikot' => 5.69967404661,
      'trikot t shirt' => 5.68357976734,
      'vereinstrikot' => 5.67012227316,
      'neue trikot' => 5.57872932565,
      'trikot de' => 5.57872932565,
      'trikot weiß' => 5.57532390775,
      'umbro trikot' => 5.57481209336,
      'gomez trikot' => 5.57481209336,
      'nalini trikot' => 5.57481209336,
      'trikot deutsche nationalmannschaft' => 5.48541914651,
      'tw trikot' => 5.43707880859,
      'boca juniors trikot' => 5.3738885534,
      'trikot verkauf' => 5.36129216571,
      'fox trikot' => 5.30910892763,
      'trikot nummer' => 5.29731686621,
      'trabzonspor trikot' => 5.16934698525,
      'kobe bryant trikot' => 5.10818538766,
      'trikot orange' => 5.10494497357,
      'trikot erstellen' => 5.05040073066,
      'lotto trikot' => 5.05040073066,
      'trikot versand' => 5.04985600725,
      'trikot 2009 2010' => 5.04943925375,
      'celtics trikot' => 4.96842344529,
      'nostalgie trikot' => 4.96772779308,
      'trikot fanshop' => 4.96772779308,
      'trikot online' => 4.96772779308,
      'trikot jacke' => 4.9558270576,
      'mighty ducks trikot' => 4.90875021359,
      'trikot sponsor' => 4.84367514442,
      'trikot design' => 4.84367514442,
      'mein trikot' => 4.77605155264,
      'deutschland dein trikot' => 4.77605155264,
      'trikot beflocken' => 4.75960653929,
      'trikot sets' => 4.70202462735,
      'all blacks trikot' => 4.70202462735,
      'trikot flock' => 4.70202462735,
      'trikot scholl' => 4.63555389062,
      'fanartikel trikot' => 4.61214579972,
      'trikot 99' => 4.57661637857,
      'trikot sammlung' => 4.56226268498,
      'benzema trikot' => 4.56226268498,
      'club trikot' => 4.43716564979,
      'rosa trikot' => 4.43716564979,
      'trikot 15' => 4.36989079233,
      'das trikot' => 4.35414143118,
      'boston celtics trikot' => 4.35414143118,
      'trikot express' => 4.35414143118,
      'ghost trikot' => 4.16176953854,
      'trikot designer' => 4.15575319035,
      'deutschland trikot 2010' => 4.15575319035,
      'trikot sätze' => 4.08715209164,
      'trikot kauf' => 4.01430879897,
      'trikot aktion' => 3.9633812977,
      'trikot nr 15' => 3.92335851509,
      'tsubasa trikot' => 3.54052444688,
      'trikot discounter' => 3.54052444688,
      'trikot tausch' => 3.46260600979,
      'trikot nummer 15' => 2.8942531046,
      'dfb trikot 2010' => 2.82346005261,
      'trikot online kaufen' => 2.71502581484,
      'fm trikot' => 2.6511270537,
      'trikot lucio' => 2.47863703677,
      'trikot drogenabhängig' => 1,
      'lahm trikot 2006' => 1,
      'schweinsteiger trikot 2006' => 1,
      'trikot hargreaves' => 1,
      'alle trikot' => 1,
      'deutsche post trikot' => 1,
      'trikot editor' => 1,
      'post trikot' => 1,
      'wm trikot 2010' => 1,
      'trikot 2009 10' => 1,
    );
  }
}