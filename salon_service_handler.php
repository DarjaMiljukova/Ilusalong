<?php

$xml = simplexml_load_file('broneeringud.xml');

echo "<h2>Salongiteenused</h2>";
echo "<ul>";
foreach ($xml->broneering->teenus as $service) {
    echo "<li>";
    echo "<strong>Protseduur:</strong> " . htmlspecialchars($service->protseduur) . "<br>";
    echo "<strong>Spetsialist:</strong> " . htmlspecialchars($service->spetsialist) . "<br>";
    echo "<strong>Aeg:</strong> " . htmlspecialchars($service->aeg) . "<br>";
    echo "<strong>Hind:</strong> " . htmlspecialchars($service->hind) . "<br>";
    echo "</li>";
    echo "<br>";
}
echo "</ul>";

// Функция 1: Фильтрация по времени
function filterByTime($xmlFile, $time) {
    $xml = simplexml_load_file($xmlFile);
    $results = [];
    foreach ($xml->broneering->teenus as $service) {
        if ((string) $service->aeg === $time) {
            $results[] = $service;
        }
    }
    return $results;
}

// Функция 2: Поиск по специалисту
function searchBySpecialist($xmlFile, $specialist) {
    $xml = simplexml_load_file($xmlFile);
    $results = [];
    foreach ($xml->broneering->teenus as $service) {
        if (stripos($service->spetsialist, $specialist) !== false) {
            $results[] = $service;
        }
    }
    return $results;
}

// Функция 3: Фильтрация по диапазону цен
function filterByPriceRange($xmlFile, $minPrice, $maxPrice) {
    $xml = simplexml_load_file($xmlFile);
    $results = [];
    foreach ($xml->broneering->teenus as $service) {
        $price = (int) filter_var($service->hind, FILTER_SANITIZE_NUMBER_INT);
        if ($price >= $minPrice && $price <= $maxPrice) {
            $results[] = $service;
        }
    }
    return $results;
}

// Фильтрация и поиск
$timeResults = filterByTime('broneeringud.xml', '10:00');
$specialistResults = searchBySpecialist('broneeringud.xml', 'Triinu Mitt');
$priceRangeResults = filterByPriceRange('broneeringud.xml', 30, 50); //min 30€ ja msx 50€

// Функция для отображения результатов
function displayResults($title, $results) {
    echo "<h3>$title</h3>";
    echo "<ul>";
    foreach ($results as $service) {
        echo "<li>";
        echo "<strong>Protseduur:</strong> " . htmlspecialchars($service->protseduur) . "<br>";
        echo "<strong>Spetsialist:</strong> " . htmlspecialchars($service->spetsialist) . "<br>";
        echo "<strong>Aeg:</strong> " . htmlspecialchars($service->aeg) . "<br>";
        echo "<strong>Hind:</strong> " . htmlspecialchars($service->hind) . "<br>";
        echo "</li>";
        echo "<br>";
    }
    echo "</ul>";
}

// Вывод результатов
displayResults("Filtreeritud tulemused aja järgi (10:00)", $timeResults);
displayResults("Filtreeritud tulemused spetsialisti järgi (Triinu Mitt)", $specialistResults);
displayResults("Filtreeritud tulemused hinnavahemiku järgi (30€ - 50€)", $priceRangeResults);

?>