<!DOCTYPE html>

<?php
include "/home/covid/it.resources/config.php"; ?>

<html lang="it">

<head>

<?php include "/home/covid/resources/templates/head.php"; ?>


    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale = 1.0, user-scalable = no">
    <meta name="mobile-web-app-capable" content="yes">
    <link rel='manifest' href='/manifest.json'>
    <link rel='apple-touch-icon' href='https://it.covidtracker2020.live/pwa/img/150x150.png'>
    <meta name="theme-color" content="#009578">

    <script>
        var sample = {
            <?php

            $result = $GLOBALS['COVID_IT_DB_CONN']->query("SELECT totale_positivi, codice_regione FROM dati_regioni WHERE data = '$DATE'");

            while ($row = $result->fetch_assoc()) {
                echo $row['codice_regione'] . ':"' . $row['totale_positivi'] . '",';
            }
            ?>

        };

        var data = [
            <?php

            $result = $GLOBALS['COVID_IT_DB_CONN']->query("SELECT 
                                                          dimessi_guariti, 
                                                          totale_casi, 
                                                          deceduti, 
                                                          nuovi_positivi,
                                                          tamponi,
                                                          codice_regione, 
                                                          url_encoded 
                                                        FROM 
                                                          dati_regioni dati
                                                        INNER JOIN regioni reg ON dati.codice_regione = reg.codice
                                                        WHERE data = '$DATE'");

            while ($row = $result->fetch_assoc()) {
                echo '[' . $row['codice_regione'] . ',' . $row['totale_casi'] . ',' . $row['nuovi_positivi'] . ',' . $row['deceduti'] . ',' . $row['tamponi'] . ',' . $row['dimessi_guariti'] . ',"' . $row['url_encoded'] . '"],';
            }

            ?>
        ]
    </script>



    <script>
        jQuery(document).ready(function() {
            jQuery('#vmap').vectorMap({
                map: 'italia',
                backgroundColor: 'rgba(0,0,0,0)',
                color: '#353a40',
                hoverOpacity: 0.7,
                selectedColor: '#666666',
                enableZoom: true,
                showTooltip: true,
                scaleColors: ['#ffff4d', '#b30000'],
                values: sample,
                normalizeFunction: 'polynomial',

                onLabelShow: function(event, label, code) {
                    function checkCode(code_value) {
                        return code == code_value[0];
                    }
                    //console.log( data.find(checkCode));

                    if (typeof window.orientation === 'undefined') {

                        country = data.find(checkCode);
                        if (typeof country !== 'undefined') {
                            // HTML Based Labels. You can use any HTML you want, this is just an example
                            label.html(`<div class="card bg-dark">
<img src="https://it.covidtracker2020.live/images/previews/` + country[6] + `-it-covidtracker2020.png" class="card-img-top" style="width: 12rem;" title"CovidTracker2020 - dati sempre aggiornati -` + country[6] + ` " alt="` + country[6] + `">
<div class="card-body py-2 text-center text-truncate ">


<p> <span class="h5  font-weight-bold  text-white">` + country[1] + `</span> <i style="font-size:25px" class="fas fa-calendar-plus  text-success"></i> </p>

<p> <span class="h5  font-weight-bold  text-white">` + country[2] + `</span> <i style="font-size:25px" class="fas fa-user-plus text-danger"></i> </p>

<p> <span class="h5  font-weight-bold  text-white">` + country[3] + `</span> <i style="font-size:25px" class="fas fa-skull-crossbones text-danger"></i> </p>

<p> <span class="h5  font-weight-bold  text-white">` + country[4] + `</span> <i style="font-size:25px" class="fas fas fa-vial text-danger"></i> </p>


</div>

</div>`);
                        }
                    }
                },

                onRegionClick: function(event, code, region) {
                    window.location.href = "https://it.covidtracker2020.live/pages/regione/?regione=" + region;
                    //alert( region );
                }
            });
        });
    </script>


</head>


<body>

    <style>
        html,
        body {
            padding: 0;
            margin: 0;
            width: 100%;
            height: 100%;
        }

        #vmap {
            width: 100%;
            height: 100%;
            -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
        }

        .jqvmap-zoomin {
            width: 30px;
            height: 30px;
            line-height: 30px;
        }

        .jqvmap-zoomout {
            width: 30px;
            height: 30px;
            top: 55px;
            line-height: 30px;
        }
    </style>


    <style>
        @keyframes transition {

            from {
                opacity: 0;
                transform: rotateX(-10deg);

            }

            to {
                opacity: 3;
                transform: rotateX(0);

            }

        }

        .container-fluid {
            animation: transition 0.75s;

        }
    </style>

    <?php
    include '/home/covid/it.resources/templates/navbar.php';
    ?>



    <div class="container-fluid py-0 mt-3 ">


        <div class="row">
            <div class="col-1"> </div>
            <div class="col-2 d-flex flex-row  justify-content-between py-0">

                <span data-toggle="tooltip" data-placement="bottom" title="contagi"> <i style="font-size:25px" class="fas fa-calendar-plus zoom text-success"></i></span>
                <span class="ml-6"> <i style="font-size:25px" class="fas fa-user-plus  text-success"></i></span>
                <span> <i style="font-size:25px" class="fas fa-skull-crossbones text-success"></i></span>
                <span> <i style="font-size:25px" class="fas fa-vial  text-success"></i></span>

            </div>

            <div class="col-9  py-0  text-right">
                <a href="#" class="badge badge-danger" data-toggle="tooltip" data-placement="bottom" title="contagi"> Contagi alti</a>
                <a href="#" class="badge badge-warning" data-toggle="tooltip" data-placement="bottom" title="contagi"> Contagi bassi</a>
            </div>

            <div id="vmap" style="height:calc(100vh - 40px);">

            </div>

        </div>


    </div>


    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>

    <?php
    include '/home/covid/resources/templates/footer.php';
    include '/home/covid/resources/templates/cookie-popup.php';
    ?>
</body>

</html>