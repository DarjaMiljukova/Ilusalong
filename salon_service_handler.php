<?php
$xmlFile = 'broneeringud.xml';
$jsonFile = 'salong.json';

function loadXmlToArray($xmlFile) {
    $xml = simplexml_load_file($xmlFile);
    $data = [];
    foreach ($xml->broneering->teenus as $service) {
        $data[] = [
            "protseduur" => (string)$service->protseduur,
            "kliendinimi" => (string)$service->kliendinimi,
            "telefoninr" => (string)$service->telefoninr,
            "aeg" => (string)$service->aeg,
            "spetsialist" => (string)$service->spetsialist,
            "hind" => (int)$service->hind,
        ];
    }
    return $data;
}


function addServiceToJson($jsonFile, $newService) {
    $data = json_decode(file_get_contents($jsonFile), true);
    $newService['hind'] .= ' €';
    $data[] = $newService;
    file_put_contents($jsonFile, json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['addService'])) {
        $newService = [
            "protseduur" => $_POST['protseduur'],
            "kliendinimi" => $_POST['kliendinimi'],
            "telefoninr" => $_POST['telefoninr'],
            "aeg" => $_POST['aeg'],
            "spetsialist" => $_POST['spetsialist'],
            "hind" => (int)$_POST['hind']
        ];
        addServiceToJson($jsonFile, $newService);
        header("Location: salon_service_handler.php");
        exit;
    }
}

// otsime spetsialist
$searchSpecialist = $_GET['searchSpecialist'] ?? '';

$data = json_decode(file_get_contents($jsonFile), true);

if ($searchSpecialist) {
    $data = array_filter($data, function ($service) use ($searchSpecialist) {
        return stripos($service['spetsialist'], $searchSpecialist) !== false;
    });
}

$order = $_GET['order'] ?? 'asc';
if (isset($_GET['sort']) && $_GET['sort'] === 'hind') {
    usort($data, function ($a, $b) use ($order) {
        return $order === 'asc' ? $a['hind'] <=> $b['hind'] : $b['hind'] <=> $a['hind'];
    });
    $order = $order === 'asc' ? 'desc' : 'asc';
}
?>

<!DOCTYPE html>
<html lang="est">
<head>
    <meta charset="UTF-8">
    <title>Salongiteenused</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h2>Teenuste loend</h2>

<form method="get">
    <label for="searchSpecialist">Otsi spetsialisti järgi:</label>
    <input type="text" id="searchSpecialist" name="searchSpecialist" value="<?= htmlspecialchars($searchSpecialist) ?>" />
    <button type="submit">Otsi</button>
</form>
<br>
<table border="1">
    <tr>
        <th>Protseduur</th>
        <th>Kliendi nimi</th>
        <th>Telefoni number</th>
        <th>Aeg</th>
        <th>Spetsialist</th>
        <th><a href="?sort=hind&order=<?= $order ?>" class="text-none">Hind</a></th>
    </tr>
    <?php foreach ($data as $service): ?>
        <tr>
            <td><?= htmlspecialchars($service['protseduur']) ?></td>
            <td><?= htmlspecialchars($service['kliendinimi']) ?></td>
            <td><?= htmlspecialchars($service['telefoninr']) ?></td>
            <td><?= htmlspecialchars($service['aeg']) ?></td>
            <td><?= htmlspecialchars($service['spetsialist']) ?></td>
            <td><?= htmlspecialchars($service['hind']) ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<h2>Lisage uus teenus</h2>
<form method="post">
    <label>Protseduur: <input type="text" name="protseduur" required placeholder="Maniküür"></label><br>
    <label>Kliendi nimi: <input type="text" name="kliendinimi" required placeholder="Anna Filkit"></label><br>
    <label>Telefoni number: <input type="text" name="telefoninr" required placeholder="+37258456721"></label><br>
    <label>Aeg: <input type="text" name="aeg" required placeholder="10:15"></label><br>
    <label>Spetsialist: <input type="text" name="spetsialist" required placeholder="Miiu Killo"></label><br>
    <label>Hind: <input type="text" name="hind" required placeholder="34"></label><br>
    <button type="submit" name="addService">Lisage teenus</button>
</form>

<h2>Vaata JSON ja XML failid</h2>
<p class="links"><a href="<?= $jsonFile ?>" target="_blank">JSON fail</a></p>
<p class="links"><a href="<?= $xmlFile ?>" target="_blank">XML <fail></fail></a></p>
</body>
</html>
