<?php

namespace Libraries;

require './vendor/autoload.php';

// use Linode\LinodeApi;
// use Linode\LinodeException;
use Dotenv\Dotenv;
use Linode\Entity\Domains\Domain;
use Linode\Internal\Domains\DomainRecordRepository;
use Linode\LinodeClient;

//load up our .env file with token=MYTOKEN in it.
$dotenv = Dotenv::create(__DIR__);
$dotenv->load();
$token = getenv('token');

$client = new LinodeClient($token);
$domain = $client->domains->findOneBy([
    Domain::FIELD_DOMAIN => getenv('domain'),
]);

$records = $domain->records->findAll();
$currentIp = file_get_contents("https://advancedonsite.com/homeipaddress.php");

foreach ($records as $record) {

    if ($record->type == "A" && $record->name == "home") {
        if ($record->target != $currentIp) {
            echo "$currentIp needs updating \n";
            $repository = new DomainRecordRepository($client, $domain->id);
            $repository->update($record->id, ["target" => $currentIp]);
        }else{
            echo "$currentIp is up to date \n";
        }
    }

}
