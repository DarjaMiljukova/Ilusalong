<?php
$jsonData = file_get_contents('salong.json');
$dataArray = json_decode($jsonData, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    echo 'JSON Error: ' . json_last_error_msg();
    exit;
}
echo  "<pre>";
print_r($dataArray);
echo "</pre>";
?>