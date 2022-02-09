<?php
include "simple_html_dom.php";
include "functions.php";
include "extern.php";

$fileLatest = fopen("json/latest.json", "w");
fwrite($fileLatest, json_encode($textArray));

usort($textArray, "sortByCases");
$fileCases = fopen("json/cases.json", "w");
fwrite($fileCases, json_encode($textArray));

usort($textArray, "sortByCountry");
$fileCountry = fopen("json/country.json", "w");
fwrite($fileCountry, json_encode($textArray));

if(fclose($fileLatest) && fclose($fileCases) && fclose($fileCountry)){
    echo true;
}else{
    echo false;
}
?>