<?php

namespace App\Http\Classes\CoinMarketCap;

class Api
{
    private $url = 'https://pro-api.coinmarketcap.com';
    private $currency;
    private $convert;
    public function __construct($currency, $convert = 'USD')
    {
        $this->currency = $currency;
        $this->convert = $convert;
    }

    private function query($endpoint) : array
    {
        $url = $this->url . $endpoint;
        $parameters = [
            'convert' => $this->convert,
            'symbol' => $this->currency,
        ];

        $headers = [
            'Accepts: application/json',
            'X-CMC_PRO_API_KEY: 8044a624-ca02-4f87-bdc6-5a1731b27750'
        ];
        $qs = http_build_query($parameters);
        $request = "{$url}?{$qs}";
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $request,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_RETURNTRANSFER => 1
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response, true);
    }

    public function getPrice(){
        return $this->query('/v2/cryptocurrency/quotes/latest')['data'][$this->currency][0]['quote'][$this->convert]['price'];
    }

}
