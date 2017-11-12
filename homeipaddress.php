<?php 

namespace Linode;
use Dotenv;

spl_autoload_register(function ($class_name) {
    //echo $class_name;
    require_once str_replace("\\","/", $class_name) . '.php';
});

//load up our .env file with token=MYTOKEN in it.
$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();
$token = getenv('token');

$api = new LinodeClient($token);

$data = $api->apiGet("/domains/27171/records/2601848");
if($data['name'] == "jasonbronson"){
    $myip = $_SERVER['REMOTE_ADDR'];
    if(!empty($myip)){
        $ip = array("name" => 'jasonbronson', "target" => $myip);
        $response = $api->apiPut("/domains/27171/records/2601848", $ip);
    }
    
}
print_r($response);


