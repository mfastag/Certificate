<?php

$url ="https://xmldata.qrz.com/xml/current/?username=ac2mi;password=01076137";

//$x = file_get_contents($url);
$x = file_get_contents('xml.xml');

$xx = simplexml_load_string($x);

echo $x;

$key = $xx->Session->Key;
print_r($xx);

echo $key;

$url = "https://xmldata.qrz.com/xml/current/?s={$key};callsign=AC2MI";
$x = file_get_contents($url);


echo $x;

$xx = simplexml_load_string($x);

print_r($xx);

?>
