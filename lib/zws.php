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
var_dump($item);
      $i = $this->item_prepare($item);
var_dump($i);die;
    }
  }
  
  private function item_prepare($item) {
    if (!isset ($item->{'@id'})) {
      return false;
    }
    $i['id'] = $item->{'@id'};

    if (!isset ($item->name)) {
      return false;
    } else {
      $i['name'] = check_plain($item->name);
    }

    if (!isset ($item->program->{'$'})) {
      return false;
    } else {
      $i['program'] = check_plain($item->program->{'$'});
    }

    if (!isset ($item->currency)) {
      return false;
    } else {
      $i['currency'] = check_plain($item->currency);
    }

    if (!isset ($item->price)) {
      return false;
    } else {
      $i['price'] = check_plain($item->price);
    }
    
    if (!isset ($item->image->small)) {
      return false;
    } else {
      $i['image_small'] = check_uri($item->image->small);
    }

    if (!isset ($item->image->medium)) {
      return false;
    } else {
      $i['image_medium'] = check_uri($item->image->medium);
    }

    if (!isset ($item->image->large)) {
      return false;
    } else {
      $i['image_large'] = check_uri($item->image->large);
    }

    $i['url'] = '';
    $adspace_id = $this->adspace_id;
    if (isset ($item->trackingLinks->trackingLink->{'@adspaceId'})
      && $adspace_id == $item->trackingLinks->trackingLink->{'@adspaceId'}
    ) {
      $i['url'] = check_uri($item->trackingLinks->trackingLink->ppc);
    }
    else {
      foreach ($item->trackingLinks->trackingLink as $l) {
        if (isset ($l->{'@adspaceId'}) && $adspace_id == $l->{'@adspaceId'}) {
          $i['url'] = check_uri($l->ppc);
        }
      }
    }

    if (!isset ($item->manufacturer)) {
      $i['manufacturer'] = '';
    } else {
      $i['manufacturer'] = check_plain($item->manufacturer);
    }

    return $i;
  }
}