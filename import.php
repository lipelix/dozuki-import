<?php

require_once 'vendor/autoload.php';
require_once 'vendor/shuber/curl/curl.php';

class Import {

    private $config;
    private $request;
    private $apiBaseUrl;
    
    public $guides;

    public function __construct() {
        $this->config = $this->getConfig();
        $this->request = new Curl;
        $this->request->options['CURLOPT_SSL_VERIFYPEER'] = false;
        $this->apiBaseUrl = "https://" . $this->config->domain . "/api/2.0";
        $this->request->headers = [
            "Authorization" => "api " . $this->config->token
        ];
    }
    
    public function init() {
        $this->guides = $this->getGuides();
    }

    private function getConfig() {
        return (json_decode(file_get_contents("config.json")));
    }

    function getResponse($response) {
        return json_decode($response->body);
    }

    public function getGuides() {
        return $this->getResponse($this->request->get("{$this->apiBaseUrl}/guides"));
    }
    
    public function createGuide() {
        return 
            $this->getResponse(
                $this->request->post("{$this->apiBaseUrl}/guides", '{"category":"libor-category-test","type": "how-to","subject": "test subject2","title": "test title2"}')
            );
    }
}

$import = new Import();
$import->init();
$import->createGuide();
var_dump($import->createGuide());
