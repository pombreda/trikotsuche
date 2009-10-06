<?php
/**
 * Datasource class acts as an adapter for data requests.
 */
class Datasource {
  
  /**
   * @var WebService
   */
  protected $web_service;
  
  /**
   * @var Cache
   */
  protected $cache;
  
  public function __construct($web_service, $cache = null) {
    $this->web_service = $web_service;
    if ($cache) {
      $this->cache = $cache;
    }
  }
  
  public function search() {
    switch ($this->web_service) {
      case 'Zws':
        break;
    }
    $request = $this->web_service->build_request();
    $result = null;
    if ($this->cache) {
      if (!($result = $this->cache->get($request))) {
        $result = $this->web_service->request($request);
      }
    }
    return $result;
  }
}