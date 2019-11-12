<?php

namespace Guzzle;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Client;

class Guzzle { 

    protected $baseUri;
    protected $token;
    protected $client;

    use \Logger\Logging;

    public function __construct($baseUri, $token)
    {
        $this->baseUri = $baseUri;
        $this->token = $token;
        $this->client = new Client([
            // Base URI is used with relative requests
            'base_uri' => $baseUri,
            // You can set any number of default request options.
            'timeout'  => 20.0,
            'verify' => false
        ]);

    }

    public function request($uri, $json, $method = "GET", $params = "", $debug = false){ 


        $this->log("DEBUG Guzzle request: {$this->baseUri}{$uri} $method");
        $err = "";
        $data = "";
        $reason = "";
        $unknown = false;

        try {
            //Authorization 
            $headers = [
                'Authorization' => "Bearer {$this->token}",        
                'Accept'        => 'application/json',
                'accept-encoding' => 'gzip, deflate'
            ];
            
            $response = $this->client->request($method, $uri, [
                'headers' => $headers,
                'allow_redirects' => false,
                'query' => $params,
                'debug' => $debug,
                'exceptions' => true,
                'json' => $json
                ] );

            $code = $response->getStatusCode(); // 200
            $reason = $response->getReasonPhrase(); // OK
            $header = $response->getHeader('Content-Length');
            $body = $response->getBody();
            $contents = $body->getContents();
            
            $this->log("Status Code: $code");
            
            if(!empty($contents)){
                $data = json_decode($contents);
                //$this->log("Data: {$contents}");
            }elseif(!empty($body)){
                $data = json_decode($body);
                //$this->log("Body: ".print_r($body));
            }
            
        } catch (\Exception $e) {
            
            $this->log($e->getMessage());
            $header = Psr7\str($e->getRequest());
            $code = 500;
            if ($e->hasResponse()) {
                $response = $e->getResponse();
                $reasonPhrase = $response->getReasonPhrase();
                $code = $response->getStatusCode();
                $reason = (string) $response->getBody();
                $reason = json_decode($reason);
                // $contents = $body->getContents();
                $err = $reasonPhrase; 
            }else{
                $err = "unknown error";
                $code = 500;
                $unknown = true;
            }
            
        }

        if($err){
            if($unknown){
                return (object) array( 'detail' => $reason, 'title' => $err, 'code' => $code );
            }else{
                return $reason;
            }
            
        } else {
            return (object) $data;
        }

    }

}