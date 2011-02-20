<?php
// Get and Display merge vars, allow user to insert them through menu?
$UI = new UI(getenv('DIALOG'));

$mergevars = $api->listMergeVars($config->list_id);
$oopsy->go($api->errorCode, $api->errorMessage, 'Unable to get list merge vars!');

$collector = array();
foreach ($mergevars as $mvar) {
    $temp = '{title="%s";tag="%s";}';
    $collector[] = sprintf($temp, $mvar['name'], $mvar['tag']);
}

$response = $UI->menu($collector);

if(empty($response)) {
    exit('');
}

$xml = new SimpleXMLElement($response);

for ($i=0; $i < count($xml->dict->key); $i++) { 
    if('tag' == $xml->dict->key[$i]) {
        $tag = $xml->dict->string[$i];
    }
}

echo "*|{$tag}|*";