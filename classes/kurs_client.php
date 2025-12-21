<?php

class ApiClientKurs {
    private $apiKey;
    private $baseUrl;

    public function __construct() {
        $this->apiKey  = $_ENV['API_KURS_KEY'];
        $this->baseUrl = rtrim($_ENV['API_KURS_URL'], '/'); 
    }
    
    public function getRate($fromCurrency = "USD", $toCurrency = "IDR") {

        $url = $this->baseUrl . "/" . $this->apiKey . "/latest/" . $fromCurrency;

        $response = @file_get_contents($url);

        if (!$response) {
            return false;
        }

        $data = json_decode($response, true);

        if (!isset($data["conversion_rates"])) {
            return false;
        }

        if (!isset($data["conversion_rates"][$toCurrency])) {
            return false;
        }

        return floatval($data["conversion_rates"][$toCurrency]);
    }
}
