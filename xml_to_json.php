<?php

$xml = simplexml_load_file('broneeringud.xml');
$data = [];

foreach ($xml->broneering->teenus as $service) {
    $data[] = [
        "protseduur" => (string)$service->protseduur,
        "kliendinimi" => (string)$service->kliendinimi,
        "telefoninr" => (string)$service->telefoninr,
        "aeg" => (string)$service->aeg,
        "spetsialist" => (string)$service->spetsialist,
        "hind" => (string)$service->hind,
    ];
}

$jsonData = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

// Сохраняем JSON в файл
file_put_contents('salong.json', $jsonData);

echo "JSON успешно сохранен в файл salong.json";

?>
