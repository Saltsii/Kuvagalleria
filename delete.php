<?php


$xml = simplexml_load_file('data/galleria.xml');

$target = $xml->xpath("//picture");


if(!$target)
return; 


$domRef = dom_import_simplexml($target[0]);
$domRef->parentNode->removeChild($domRef);


$dom = new DOMDocument('1.0');
$dom->preserveWhiteSpace = false;
$dom->formatOutput = true;
$dom->loadXML($xml->asXML());
$dom->save('data/galleria.xml');

header('Location: index.php');
?>