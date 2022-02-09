<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Jquery -->
    <script src="js/jquery.js"></script>
    <script src="js/jquery-ui.js"></script>

    <!-- Bootstrap JS -->
    <script src="js/bootstrap.bundle.js" type="text/javascript"></script>
    <script src="js/bootstrap.js" type="text/javascript"></script>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/bootstrap-grid.css">
    <link href="css/bootstrap-reboot.css" rel="stylesheet">
    <style>
        .countrycard{
            min-height: 125px;
            width: 98%;
            background-color: #6d7080;
            color: #26262c !important;
            overflow: hidden;
        }
        .main-body{
            overflow: auto;
        }
        .btn-secondary{
            background-color: #4C515D !important;
            border-color: #4C515D !important;;
        }
    </style>
    <script>
        function order(button){
            var classn = $(button).html();
            $(".sortRow").css("display", "none");
            $("." + classn).css("display", "flex");
            $("button").removeClass("btn-primary").addClass("btn-secondary");
            $(button).removeClass("btn-secondary").addClass("btn-primary");
        }
        function flow(tag){
            var mHeight = $(tag).css("max-height");
            if(mHeight == "125px"){
                $(tag).css("max-height", "100%").css("box-shadow", "");
            }else{
                $(tag).css("max-height", "125px").css("box-shadow", "rgba(0,0,0,0.3) 0px -20px 20px 0px inset");
            }
        }
        function replaceText(value){
            return value.replace(/,/g, "")
        }
        function commaSeparateNumber(val){
            while (/(\d+)(\d{3})/.test(val.toString())){
                val = val.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
            }
            return val;
        }
        setInterval("update()", 60000);
        function update(){
            var cases = 0;
            var death = 0;
            var currentCases = replaceText($('.todaycases').text());
            var currentDeaths = replaceText($('.todaydeaths').text());
            var totalCases = replaceText($('.totalcases').text());
            var totalDeaths = replaceText($('.totaldeath').text());

            $.ajax({
                url: "json.php",
                success: function(context){
                    if(context){
                        $.getJSON("json/latest.json", function(data){
                            $('.Latest').html("");
                            $.each(data, function(key){
                                $(data[key].body).appendTo(".Latest");
                                cases += data[key].cases;
                                death += data[key].deaths;
                            })
                        }).done(function() {
                            if (cases > currentCases) {
                                $('.todaycases').css("color", "green")
                                $('.totalcases').css("color", "green")
                                $({casesToday: currentCases}).animate({casesToday: cases}, { //todayCases
                                    duration: 3000,
                                    easing: 'swing',
                                    complete: function () {
                                        $('.todaycases').css("color", "")
                                    },
                                    step: function () {
                                        $('.todaycases').text(commaSeparateNumber(Math.round(this.casesToday)))
                                    }
                                });
                                $({casesTotal: totalCases}).animate({casesTotal: parseInt(totalCases) + (cases - parseInt(currentCases))}, { //totalCases
                                    duration: 3000,
                                    easing: 'swing',
                                    complete: function () {
                                        $('.totalcases').css("color", "")
                                    },
                                    step: function () {
                                        $('.totalcases').text(commaSeparateNumber(Math.round(this.casesTotal)))
                                    }
                                })
                            }
                            if (death > currentDeaths) {
                                $('.todaydeaths').css("color", "green");
                                $('.totaldeath').css("color", "green");
                                $({deathToday: currentDeaths}).animate({deathToday: death}, { //todayDeaths
                                    duration: 3000,
                                    easing: 'swing',
                                    complete: function () {
                                        $('.todaydeaths').css("color", "")
                                    },
                                    step: function () {
                                        $('.todaydeaths').text(commaSeparateNumber(Math.round(this.deathToday)))
                                    }
                                })

                                $({deathToday: totalDeaths}).animate({deathToday: (parseInt(totalDeaths) + (death - parseInt(currentDeaths)))}, { //totalDeaths
                                    duration: 3000,
                                    easing: 'swing',
                                    complete: function () {
                                        $('.totaldeath').css("color", "")
                                    },
                                    step: function () {
                                        $('.totaldeath').text(commaSeparateNumber(Math.round(this.deathToday)))
                                    }
                                })
                            }
                        })
                        $.getJSON("json/cases.json", function(data){
                            $('.Highest').html("");
                            $.each(data, function(key){
                                $(data[key].body).appendTo(".Highest");
                            })
                        });

                        $.getJSON("json/country.json", function(data){
                            $('.A-B-C').html("");
                            $.each(data, function(key){
                                $(data[key].body).appendTo(".A-B-C");
                            })
                        });
                    }
                }
            })
        }
    </script>
</head>
<body class="bg-dark">
<main>
<div class="container-fluid bg-light">
    <div class="row bg-dark">
        <div class="col-12 col-xl-2 offset-0 offset-xl-1 mt-3 pb-0">
            <div class="alert alert-danger" role="alert" style="text-align: center;">
                New cases today <strong><span class="todaycases">0</span></strong>
            </div>
        </div>
        <div class="col-12 col-xl-2 mt-0 mt-xl-3 pb-0">
            <div class="alert alert-info" role="alert" style="text-align: center;">
                New deaths today <strong><span class="todaydeaths">0</span></strong>
            </div>
        </div>
        <div class="col-12 col-xl-2 mt-0 mt-xl-3 pb-0">
            <div class="alert alert-warning" role="alert" style="text-align: center;">
                Total cases <strong><span class="totalcases">0</span></strong>
            </div>
        </div>
        <div class="col-12 col-xl-2 mt-0 mt-xl-3 pb-0">
            <div class="alert alert-primary" role="alert" style="text-align: center;">
                Total deaths <strong><span class="totaldeath">0</span></strong>
            </div>
        </div>
        <div class="col-12 col-xl-2 mt-0 mt-xl-3 mb-2 pb-0">
            <div class="alert alert-success" role="alert" style="text-align: center;">
                Total recovered <strong><span class="recovered">0</span></strong>
            </div>
        </div>
        <div class="col-12 col-md-10 mt-1 mt-xl-4 mb-2 offset-0 offset-xl-1">
            <div class="btn-group btn-group-lg" role="group" aria-label="Basic example">
                <button type="button" class="btn btn-primary" onclick="order(this)">Latest</button>
                <button type="button" class="btn btn-secondary" onclick="order(this)">Highest</button>
                <button type="button" class="btn btn-secondary" onclick="order(this)">A-B-C</button>
            </div>
        </div>
    </div>
    <div class="row bg-dark">
        <div class="col-12 col-xl-10 offset-0 offset-xl-1">
            <div class="container-fluid p-3 rounded-lg shadow-lg" style="background-color: #4C515D !important;">
                <div class="row Latest sortRow">
                    <?php
                    $textArray = null;
                    $todaycases = null;
                    $todayDeaths = null;
                    $totalCases = null;
                    $totalRecovered = null;
                    $totalDeaths = null;
                    include "simple_html_dom.php";
                    include "functions.php";
                    include "extern.php";
                    foreach ($textArray as $value){
                        echo $value["body"];
                    }
                    echo '<script>$(".todaycases").html("' . number_format($todaycases) .'")</script>' . "\n";
                    echo '<script>$(".todaydeaths").html("' . number_format($todayDeaths) . '")</script>' . "\n";
                    echo '<script>$(".totalcases").html("' . $totalCases . '")</script>' . "\n";
                    echo '<script>$(".totaldeath").html("' . $totalDeaths . '")</script>' . "\n";
                    echo '<script>$(".recovered").html("' . $totalRecovered . '")</script>' . "\n";
                    ?>
                </div>
                <div class="row Highest sortRow" style="display: none;">
                    <?php
                    usort($textArray, "sortByCases");
                    foreach ($textArray as $value){
                        echo $value["body"];
                    }

                    ?>
                </div>
                <div class="row A-B-C sortRow" style="display: none;">
                    <?php
                    usort($textArray, "sortByCountry");
                    foreach ($textArray as $value){
                        echo $value["body"];
                    }

                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
</main>
</body>
</html>
<?php
include "online.php";
?>