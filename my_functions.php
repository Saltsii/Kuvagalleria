
<?php
session_start();
//XML-tiedostoon tallennus
function saveDataToXML($data, $file_name){

    $author = $_SESSION['username'];
    $xml = simplexml_load_file('data/galleria.xml');

    $new_pic = $xml->addChild('picture');
    $new_pic->addAttribute('accept','false');
    $new_pic->addChild('author', $author);
    $new_pic->addChild('file', $file_name);
    $new_pic->addChild('date', date("Y-m-d"));

    // Muotoilu ja tallennus
    $dom = new DOMDocument("1.0");
    $dom->preserveWhiteSpace = false;
    $dom->formatOutput = true;
    $dom->loadXML($xml->asXML());
    $dom->save('data/galleria.xml');

}