<?php

require_once '../vendor/autoload.php';

$conf = json_decode(file_get_contents('../config/config.json'), true);

$method = $_SERVER['REQUEST_METHOD'];
if ($method != 'PURGE') {
    die();
}

$uri = $_SERVER['REQUEST_URI'];
$host = $_SERVER['HTTP_HOST'];

$key = new Cloudflare\API\Auth\APIKey($conf['apiEmail'], $conf['apiKey']);
$adapter = new Cloudflare\API\Adapter\Guzzle($key);
$zones = new Cloudflare\API\Endpoints\Zones($adapter);

if (!in_array($host, $conf['hosts'])) {
    throw new Exception("no host: ${host}");
}

$hostConfig = $conf['hosts'][$host];

$result = $zones->cachePurge($hostConfig['zoneId'], [
    $hostConfig['prefix'] . $uri
]);

if ($conf['dev']) {
    file_put_contents('../logs/tmplog', "host: {$host}, uri: {$uri}, result: {$result}\n", FILE_APPEND);
}
