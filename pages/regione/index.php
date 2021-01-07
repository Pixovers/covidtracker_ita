<?php
include '/home/covid/it.resources/config.php';
include '/home/covid/it.resources/classes/info_card.php';



if (isset($_GET['regione'])) {
    $result = $GLOBALS['COVID_IT_DB_CONN']->query("SELECT * FROM regioni WHERE url_encoded = \"" . $_GET['regione'] . "\"");
    $regione_attuale = array();
    while ($temp = $result->fetch_assoc()) {
        $regione_attuale += $temp;
    }
}

?>


<!DOCTYPE html>


<html lang="it">

<head>

<?php include "/home/covid/resources/templates/head.php"; ?>

  <meta name="mobile-web-app-capable" content="yes">
  <link rel='manifest' href='/manifest.json'>
  <link rel='apple-touch-icon' href='https://it.covidtracker2020.live/pwa/img/150x150.png'>
  <meta name="theme-color" content="#009578">




    <script type="text/javascript" src="https://www.covidtracker2020.live/js/jqvmap/jquery.vmap.min.js"></script>
    <link href="https://www.covidtracker2020.live/stylesheet/jqvmap/jqvmap.min.css" media="screen" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="https://it.covidtracker2020.live/js/map/jquery.vmap.<?php echo $regione_attuale['url_encoded'] ?>.js" charset="utf-8"></script>





    <script>
        var sample = {
            <?php

            $result = $GLOBALS['COVID_IT_DB_CONN']->query("SELECT totale_casi, codice_provincia FROM dati_province WHERE data = '$DATE' AND codice_Regione = \"" . $regione_attuale['codice'] . "\" and codice_provincia < 150");

            while ($row = $result->fetch_assoc()) {
                echo $row['codice_provincia'] . ':"' . $row['totale_casi'] . '",';
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
                map: '<?php echo $regione_attuale['url_encoded'] ?>',
                backgroundColor: 'rgba(0,0,0,0)',
                color: '#353a40',
                hoverOpacity: 0.7,
                selectedColor: '#666666',
                enableZoom: true,
                showTooltip: true,
                scaleColors: ['#ffff4d', '#b30000'],
                values: sample,
                normalizeFunction: 'polynomial'
            });
        });
    </script>


</head>


<body>
    <?php
    include '/home/covid/it.resources/templates/navbar.php';
    ?>

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


    <div class="container-fluid">
        <div class="row mt-2">

            <?php
            $cards = new InfoCard($regione_attuale["url_encoded"], $DATE);
            $cards->GenerateCode();
            $cards->GenerateModals();
            ?>



        </div>


        <div class="row">

            <div class="col-md-12">

                <div class="card text-white dark_mode_object shadow-lg mb-3">
                    <div class="card-header">Mappa</div>
                    <div class="card-body">

                        <div id="vmap" style="height:calc(50vh - 40px);"> </div>

                    </div>
                </div>

            </div>
        </div>


        <div class="row">
            <div class="col-md-12">
                <div class="card text-white dark_mode_object shadow-lg h-100 zoom">
                    <div class="card-header card-header d-flex flex-row align-items-center justify-content-between py-2">
                        <h5 class="m-0 font-weight-bold text-primary text-truncate"><?php ?></h5>

                        <div class="">

                            <button type="button" class="btn btn-success btn-sm py-0" data-toggle="tooltip" data-placement="bottom" title="Tabella delle regioni d'Italia">
                                <i class="fas fa-info fa-sm"></i></button>
                        </div>

                    </div>
                    <div class="card-body">


                        <table class="table table-striped " data-toggle="table" data-height="300" data-detail-view="true" data-detail-view-icon="false" data-detail-formatter="detailFormatter" data-header-style="headerStyle" data-show-export="true" id="table" data-click-to-select="true" data-show-toggle="true" sdata-show-columns="true" data-footer-style="footerStyle" data-mobile-responsive="true" data-search="true" data-search-align="left" data-sort-class="table-active" data-show-print="true" 
                        data-url="https://it.covidtracker2020.live/table_json_data.php?tipo=div&data=2020-10-25&location=<?php echo $_GET['regione'] ?>">



                            <thead class="thead dark_mode_object">
                                <tr>


                                    <th data-field="provincia" scope="col" data-sortable="true">PROVINCIA</th>
                                    <th data-field="Casi_Totali" scope="col" data-sortable="true">CASI TOTALI</th>
                                    <th data-field="sigla" scope="col" data-sortable="true">SIGLA</th>





                                </tr>

                            </thead>


                        </table>

                    </div>
                </div>

            </div>

        </div>

        <br><br>


        <div class="modal" id="myModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <canvas id="barChart"></canvas>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                    </div>
                </div>
            </div>
        </div>



    </div>

    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>

    <script src="/index.js"></script>


    <?php
    include '/home/covid/resources/templates/footer.php';
    include '/home/covid/resources/templates/cookie-popup.php';
    ?>

    <?php $cards->GenerateCharts(); ?>
    
</body>

</html>