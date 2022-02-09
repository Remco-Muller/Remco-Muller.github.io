<?php
$today = date_create("now");
$todayFormat = date_format($today, "Y-m-d");
$base = 'https://www.worldometers.info/coronavirus/';
$curl = curl_init();
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($curl, CURLOPT_HEADER, false);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($curl, CURLOPT_URL, $base);
curl_setopt($curl, CURLOPT_REFERER, $base);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
$str = curl_exec($curl);
curl_close($curl);
// Create a DOM object
$html = new simple_html_dom();
// Load HTML from a string
$html->load($str);
$json = file_get_contents("json/flag.json");
$jsonDecode = json_decode($json, true);
$todaycases = 0;
$todayDeaths = 0;
$totalCasesString = '<div class="maincounter-number"> <span style="color:#aaa">';
$totalCases = substr($html, strpos($html, $totalCasesString) + strlen($totalCasesString),strpos($html, ' </span> </div> </div> <div style="text-align:center "><a href="#countries">view by country') - (strpos($html, $totalCasesString) + strlen($totalCasesString)));
$totalDeathString = '<div id="maincounter-wrap" style="margin-top:15px"> <h1>Deaths:</h1> <div class="maincounter-number"> <span>';
$totalDeaths = substr($html, strpos($html, $totalDeathString) + strlen($totalDeathString), strpos($html, '</span> </div> </div> <div id="maincounter-wrap" style="margin-top:15px;">') - (strpos($html, $totalDeathString) + strlen($totalDeathString)));
//$totalRecoveredString = '<h1>Recovered:</h1> <div class="maincounter-number" style="color:#8ACA2B "> <span>';
//$totalRecovered = substr($html, strpos($html, $totalRecoveredString) + strlen($totalRecoveredString), strpos($html, '</span> </div> </div> <div style="margin-top:50px;"></div>  <style>') - (strpos($html, $totalRecoveredString) + strlen($totalRecoveredString)));
$filen = fopen("fullData.txt", "w");
fwrite($filen, $html, strlen($html));
fclose($filen);
global $htmlLight;
$textArray = array();

foreach ($html->find("div#newsdate" . $todayFormat) as $k){ //load today
    $htmlLight = $k;
}
if(strlen($htmlLight) == 0){ //if new day not found load last day
    $today= new DateTime('- 24 hours');
    $todayFormat = date_format($today, "Y-m-d");
    foreach ($html->find("div#newsdate" . $todayFormat) as $k){
        $htmlLight = $k;
    }
}
foreach ($htmlLight->find("li.news_li") as $e){ //load main
    $country = convertSomething($e);
    $cardDeaths = 0;
    $trimPart1 = strpos($e->innertext, 'href="/coronavirus/country/') + strlen('href="/coronavirus/country/');
    $trimPart2 = strpos($e->innertext, '/">');
    $replaceArray = array("","","</strong>");
    $searchArray = array('<img alt="alert" src="/images/alert.png" style="width: 16px;" />&nbsp;', '<a style="text-decoration: underline;" href="/coronavirus/country/' . substr($e->innertext, $trimPart1, $trimPart2 - $trimPart1) . '/">', '</a></strong>');
    $bodyTrim = str_replace($searchArray,$replaceArray, $e->innertext);

    if(strpos($bodyTrim, "new cases")){
        $cases = intval(substr($bodyTrim,8, strpos($bodyTrim, "new cases") - 9));
    }elseif(strpos($bodyTrim, "new case")){
        $cases = intval(substr($bodyTrim,8, strpos($bodyTrim, "new case") - 9));
    }else{
        $cases = 0;
    }
    $todaycases = intval($todaycases) + intval($cases);
    $bgcolor = $cases > 999 ? "bg-warning": "";
    $text = "<div class='col-12 col-sm-12 col-md-6 col-lg-4 mt-2 mb-2'>
    <div class='countrycard card $bgcolor' onclick='flow(this)'>
    <div class='card-body'>
    <div class='media'>
    <img class='d-flex align-self-start mr-3' src='https://www.countryflags.io/" . decodeCountry($country) . "/shiny/64.png'>
    <div class='main-body'>
    <h5 class='mt-0'>$country</h5>
    " . $bodyTrim . "
    </div>   
    </div>
    </div>
    </div>
</div>";

    if(validateDeath($bodyTrim)){ //check death
        if(strpos($bodyTrim, "new deaths</strong>")){
            if(strpos($bodyTrim, "and <strong>")){
                $cardDeaths = substr($bodyTrim, strpos($bodyTrim, "and <strong>") + strlen("and <strong>"), strpos($bodyTrim, "new deaths</strong>") - (strpos($bodyTrim, "and <strong>") + strlen("and <strong>")));
            }else{
                $cardDeaths = substr($bodyTrim, strpos($bodyTrim, "<strong>") + strlen("<strong>"), strpos($bodyTrim, "new deaths</strong>") - (strpos($bodyTrim, "<strong>") + strlen("<strong>")));
            }
        }else{
            if(strpos($bodyTrim, "and <strong>")){
                $cardDeaths = substr($bodyTrim, strpos($bodyTrim, "and <strong>") + strlen("and <strong>"), strpos($bodyTrim, "new death</strong>") - (strpos($bodyTrim, "and <strong>") + strlen("and <strong>")));
            }else{
                $cardDeaths = substr($bodyTrim, strpos($bodyTrim, "<strong>") + strlen("<strong>"), strpos($bodyTrim, "new death</strong>") - (strpos($bodyTrim, "<strong>") + strlen("<strong>")));
            }
        }
        $cardDeaths = intval(intval($cardDeaths));
        $todayDeaths = intval($todayDeaths) + $cardDeaths;
    }
    array_push($textArray, array("body"=>$text, "cases"=>$cases, "country"=>$country, "deaths"=>$cardDeaths));
}
?>