<?php
include PATH_LIB . '3rd' . DIRECTORY_SEPARATOR . 'zxapiclient_2009_07_01' . DIRECTORY_SEPARATOR . 'ApiClient.php';

class Zws extends WebService {
  /**
   * var ApiClient
   */
  private $client;
  
  /**
   * var string
   */
  private $adspace_id;
  
  public function build_request() {}
  
  public function __construct($connect_id, $public_key, $secret_key, $adspace_id = NULL) {
    $this->client = ApiClient::factory(PROTOCOL_JSON, VERSION_2009_07_01);
    $this->client->setConnectId($connect_id);
    $this->client->setSecretKey($secret_key);
    $this->client->setPublicKey($public_key);
    $this->adspace_id = $adspace_id;
  }
  
  public function search($search, $page = 0, $limit = 10) {
    # how awful
    $result = $this->client->searchProducts(
      $search,
      'phrase',
      null,
      null,
      null,
      array(),
      true,
      0,
      null,
      $this->adspace_id,
      $page,
      $limit
      
    );
    $items = json_decode($result)->productItems->productItem;
var_dump($result);
    foreach ($items as $item) {
      $id = $item->{'@id'};
var_dump($item, $id);
    }
  }
  
//  private function item_prepare($item) {
//    if (!isset ($item->id)) {
//      return false;
//    }
//    $i['id'] = $item->id;
//    
//    if (!isset ($item->name)) {
//      $i['name'] = ZWS_NO_DATA;
//    } else {
//      $i['name'] = check_plain($item->name);
//    }
//
//    if (!isset ($item->program->_)) {
//      $i['program'] = ZWS_NO_DATA;
//    } else {
//      $i['program'] = check_plain($item->program->_);
//    }
//
//    if (!isset ($item->currency)) {
//      $i['currency'] = ZWS_NO_DATA;
//    } else {
//      $i['currency'] = check_plain($item->currency);
//    }
//
//    if (!isset ($item->price)) {
//      $i['price'] = ZWS_NO_DATA;
//    } else {
//      $i['price'] = check_plain($item->price);
//    }
//
//    $i['url'] = '';
//    $params = $this->params();
//    $adspace_id = $params['adspace'];
//    if (!isset ($item->url->adspace->_)) {
//      if (isset($item->url->adspace)) {
//        foreach ($item->url->adspace as $a) {
//          if ($a->id == $adspace_id) {
//            $i['url'] = check_uri($a->_);
//            break;
//          }
//        }
//      }
//    } else {
//      $i['url'] = check_uri($item->url->adspace->_);
//    }
//
//    if (!isset ($item->manufacturer)) {
//      $i['manufacturer'] = ZWS_MANUFACTURER;
//    } else {
//      $i['manufacturer'] = check_plain($item->manufacturer);
//    }
//
//    if (!isset ($item->image->small)) {
//      $i['image_small'] = ZWS_IMAGE_SMALL_URL;
//    } else {
//      $i['image_small'] = check_uri($item->image->small);
//    }
//
//    if (!isset ($item->image->medium)) {
//      $i['image_medium'] = ZWS_IMAGE_MEDIUM_URL;
//    } else {
//      $i['image_medium'] = check_uri($item->image->medium);
//    }
//
//    if (!isset ($item->image->large)) {
//      $i['image_large'] = ZWS_IMAGE_LARGE_URL;
//    } else {
//      $i['image_large'] = check_uri($item->image->large);
//    }
//
//    return $i;
//  }
}