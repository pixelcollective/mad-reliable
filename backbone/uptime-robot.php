<?php

namespace TPC\MAD;

class Uptime {

  private $api_key;
  public $uptime;

  function __construct() {
    $this->get_cache();
    
    if(!$this->uptime)
      $this->get_uptime(); 
  }
  
  public function get_cache() {
    $cache = get_option( 'tpc-mad-cache' );
    
    if ($cache != '' && time() < $cache['timestamp'] + 600)
      $this->uptime = $cache['data'];
    else
      $this->uptime = null;
  }

  public function set_cache($data) {
    if ($data !== NULL && $data->stat != 'fail') {
      update_option('tpc-mad-cache', array ( 'data' => $data, 'timestamp' => time()));
      $this->uptime = $data;
    }
  }

  public function get_uptime() {
    $request = curl_init();

    curl_setopt_array($request, array(
        CURLOPT_URL => "https://api.uptimerobot.com/v2/getMonitors",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "api_key=". UPTIME_ROBOT_API_KEY ."&format=json&logs=0&all_time_uptime_ratio=1",
        CURLOPT_HTTPHEADER => array(
          "cache-control: no-cache",
          "content-type: application/x-www-form-urlencoded"
        ),
    ));

    $response = json_decode(curl_exec($request));
    curl_close($request);

    $this->set_cache($response);
  }
}