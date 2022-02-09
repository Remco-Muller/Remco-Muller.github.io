<?php
function decodeCountry($country){
    if(strpos($country, "China") !== false){
        $country = "China";
    }elseif(strpos($country, "the ") !== false){
        $country = substr($country, 4, strlen($country) - 4);
    }
    switch ($country) {
        case "Congo":
            $country = "Republic of the Congo";
            break;
        case "R&eacute;union":
            $country = "Reunion";
            break;
        case "Cura&ccedil;ao":
            $country = "Curacao";
            break;
        case "Eswatini":
            $country = "Swaziland";
            break;
        case "Republic of North Macedonia":
            $country = "Macedonia";
            break;
        case "Faeroe Islands":
            $country = "Faroe Islands";
            break;
        case "Czechia":
            $country = "Czech Republic";
            break;
        case "Channel Islands":
            $country = "Jersey";
            break;
        case "C&ocirc;te d'Ivoire":
            $country = "Ivory Coast";
            break;
        case "State of Palestine":
            $country = "Palestinian Territory";
            break;
        case "DR Congo":
            $country = "Democratic Republic of the Congo";
            break;
        case "Brunei Darussalam":
            $country = "Brunei";
            break;
        case "Timor-Leste":
            $country = "East Timor";
            break;
        case "Cabo Verde":
            $country = "Cape Verde";
            break;
        case "Caribbean Netherlands":
            $country = "Netherlands";
            break;
    }
    return array_search($country,$GLOBALS["jsonDecode"]);
}

function convertSomething($something){
    foreach ($something->find("a") as $a){
        return $a->plaintext;
    }
}
function sortByCases($a,$b)
{
    return ($a["cases"] >= $b["cases"]) ? -1 : 1;
}
function sortByCountry($a,$b)
{
    $a["country"] = ucfirst($a["country"]);
    $b["country"] = ucfirst($b["country"]);
    return strcmp($a["country"], $b["country"]);
}
function validateDeath($index){
    if(strpos($index, "new deaths</strong>") || strpos($index, "new death</strong>")){
        return true;
    }else{
        return false;
    }
}
?>