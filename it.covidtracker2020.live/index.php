<!DOCTYPE html>

<?php
include '/home/covid/it.resources/config.php';
include '/home/covid/it.resources/classes/info_card.php';
include '/home/covid/it.resources/classes/it_table.php';
include '/home/covid/resources/classes/counter.php';


?>

<html prefix="og: http://ogp.me/ns#">

<head>

    <?php include "/home/covid/resources/templates/head.php"; ?>

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

    <link rel='manifest' href='/manifest.json'>
</head>


<body>

<!-- add navbar -->
    <?php
    include '/home/covid/it.resources/templates/navbar.php';
    ?>


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


        .form-control {
            display: block;
            width: 70%;
            height: calc(1.5em + .75rem + 2px);
            padding: .375rem .75rem;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #e0cc39;
            background-color: #32383e;
            background-clip: padding-box;
            border: 1px solid #3079c1;
            border-radius: .25rem;
            transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;


        }

        .btn-secondary {
            color: #fff;
            background-color: #00549e;
            border-color: #00498a;
        }
    </style>

    <!-- main container -->
    <div class="container-fluid ">

        <div class="row mt-2">
    <!-- info card creation -->

            <?php
            $cards = new InfoCard("Italia", $DATE);
            $cards->GenerateCode();
            $cards->GenerateModals();
            ?>

        </div>


        <div class="row mt-2 mb-2">
            <div class="col-md-12 col-xl-9  py-2">
            <!-- Italy table card -->
                <div class="card text-white dark_mode_object shadow-lg  h-100 zoom">
                    <div class="card-header card-header d-flex flex-row align-items-center justify-content-between py-2">
                        <h5 class="m-0 font-weight-bold text-primary text-truncate">Italia</h5>

                        <div class="">
                            <a class="btn btn-danger btn-sm py-0" href="https://it.covidtracker2020.live/pages/archivio/" role="button"><i class="fas fa-plus-square"></i></a>



                            <button type="button" class="btn btn-secondary btn-sm py-0" data-toggle="tooltip" data-placement="bottom" title="Tabella delle regioni d'Italia">
                                <i class="fas fa-info fa-sm"></i></button>
                        </div>

                    </div>
                    <div class="card-body">


                        <table class="table table-striped " data-toggle="table" data-height="520" data-detail-view="true" data-detail-view-icon="false" data-detail-formatter="detailFormatter" data-header-style="headerStyle" data-show-footer="true" data-show-export="true" id="table" data-click-to-select="true" data-show-toggle="true" sdata-show-columns="true" data-footer-style="footerStyle" data-mobile-responsive="true" data-search="true" data-search-align="left" data-sort-class="table-active" data-show-print="true" data-url="https://it.covidtracker2020.live/table_json_data.php?data=2020-11-15&location=italia&tipo=div">



                            <thead class="thead dark_mode_object">
                                <tr>
                                    <th data-field="regione" scope="col" data-footer-formatter="REGIONE" data-sortable="true">REGIONE</th>
                                    <th data-field="Casi_Totali" scope="col" data-footer-formatter="CASI_TOTALI" data-sortable="true">CASI TOTALI</th>
                                    <th data-field="Positivi_Attuali" scope="col" data-footer-formatter="POSITIVI_ATTUALI" data-sortable="true">POSITIVI ATTUALI</th>
                                    <th data-field="Deceduti" scope="col" data-footer-formatter="DECEDUTI" data-sortable="true">DECEDUTI</th>
                                    <th data-field="Casi_Testati" scope="col" data-footer-formatter="CASI_TESTATI" data-sortable="true">CASI TESTATI</th>
                                    <th data-field="Tamponi" scope="col" data-footer-formatter="TAMPONI" data-sortable="true">TAMPONI</th>
                                    <th data-field="Terapia_Intensiva" data-footer-formatter="TERAPIA_INTENSIVA" scope="col" data-sortable="true">TERAPIA INTENSIVA</th>
                                    <th data-field="Guariti" scope="col" data-footer-formatter="GUARITI" data-sortable="true">GUARITI</th>
                                </tr>

                            </thead>


                        </table>

                    </div>
                </div>
            </div>

            <div class="col-md-12 col-xl-3 py-2">
                <?php
                $italia_counter = new CounterItalia();
                ?>

                <!-- Italy live card -->
                <div class="card dark_mode_object shadow-lg  zoom h-100">
                    <img src="https://it.covidtracker2020.live/images/previews/italia-it-covidtracker2020.png" class="card-img-top" alt="...">
                    <div class="card-body">
                        <div class="card-body py-2 text-center text-truncate">

                            <p> <span style="font-size:35px" class="  font-weight-bold  dark_mode_div"> <?php echo $italia_counter->GetDOM("totale_casi"); ?></span> <i style="font-size:25px" class="fas fa-viruses  text-success" data-toggle="tooltip" data-html="true" title="Casi totali"></i> </p>

                            <p> <span style="font-size:35px" class="font-weight-bold  dark_mode_div"> <?php echo $italia_counter->GetDOM("totale_positivi"); ?> </span> <i style="font-size:25px" class="fas fa-calendar-plus text-warning" data-toggle="tooltip" data-html="true" title="Positivi attuali"></i> </p>


                            <p> <span style="font-size:35px" class="font-weight-bold  dark_mode_div"> <?php echo $italia_counter->GetDOM("deceduti"); ?> </span> <i style="font-size:25px" class="fas fa-skull-crossbones text-danger" data-toggle="tooltip" data-html="true" title="Deceduti"></i> </p>

                            <p> <span style="font-size:35px" class=" font-weight-bold  dark_mode_div"> <?php echo $italia_counter->GetDOM("tamponi"); ?> </span> <i style="font-size:25px" class="fas fa-vial text-info" data-toggle="tooltip" data-html="true" title="Tamponi"></i> </p>


                        </div>
                    </div>

                    <div class="card-footer d-flex flex-row align-items-center justify-content-between py-2">
                        <h5 class="m-0 font-weight-bold text-primary text-truncate ">Live</h5>
                        <div class="">
                            <a class="btn btn-danger btn-sm py-0" href="https://it.covidtracker2020.live/pages/live/" role="button"><i class="fas fa-plus-square"></i></a>



                            <button type="button" class="btn btn-secondary btn-sm py-0" data-toggle="tooltip" data-placement="bottom" title="Dati generati tramite calcoli statistici">
                                <i class="fas fa-info fa-sm"></i></button>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-md-12 py-2">

            <!-- Italy Map Card -->
                <div class="card text-white dark_mode_object shadow-lg mb-3 zoom">
                    <div class="card-header card-header d-flex flex-row align-items-center justify-content-between py-2">
                        <h5 class="m-0 font-weight-bold text-primary text-truncate">Mappa</h5>

                        <div class="">

                            <a class="badge badge-danger" data-toggle="tooltip" data-placement="bottom" title="contagi"> Contagi alti</a>
                            <a class="badge badge-warning mr-2" data-toggle="tooltip" data-placement="bottom" title="contagi"> Contagi bassi</a>

                            <a class="btn btn-danger btn-sm py-0" href="https://it.covidtracker2020.live/pages/mappa/" role="button"><i class="fas fa-plus-square"></i></a>



                            <button type="button" class="btn btn-secondary btn-sm py-0" data-toggle="tooltip" data-placement="bottom" title="Mappa con le regioni d'Italia">
                                <i class="fas fa-info fa-sm"></i></button>
                        </div>

                    </div>
                    <div class="card-body">

                        <div id="vmap" style="height:calc(50vh - 40px);"> </div>

                    </div>
                </div>

            </div>

        </div>



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
        var $table = $('#table')

        $(function() {
            $('#toolbar').find('select').change(function() {
                $table.bootstrapTable('destroy').bootstrapTable({
                    exportDataType: $(this).val(),
                    exportTypes: ['json', 'xml', 'csv', 'txt', 'sql', 'excel', 'pdf'],

                })
            }).trigger('change')
        })
    </script>

    <script>
        function REGIONE() {
            return 'Totale:'


        }

        function CASI_TOTALI(data) {
            var field = this.field
            return data.map(function(row) {
                return +row[field]
            }).reduce(function(sum, i) {
                return sum + i
            }, 0)
        }

        function POSITIVI_ATTUALI(data) {
            var field = this.field
            return data.map(function(row) {
                return +row[field]
            }).reduce(function(sum, i) {
                return sum + i
            }, 0)
        }

        function DECEDUTI(data) {
            var field = this.field
            return data.map(function(row) {
                return +row[field]
            }).reduce(function(sum, i) {
                return sum + i
            }, 0)
        }


        function CASI_TESTATI(data) {
            var field = this.field
            return data.map(function(row) {
                return +row[field]
            }).reduce(function(sum, i) {
                return sum + i
            }, 0)
        }

        function TAMPONI(data) {
            var field = this.field
            return data.map(function(row) {
                return +row[field]
            }).reduce(function(sum, i) {
                return sum + i
            }, 0)
        }


        function TERAPIA_INTENSIVA(data) {
            var field = this.field
            return data.map(function(row) {
                return +row[field]
            }).reduce(function(sum, i) {
                return sum + i
            }, 0)
        }


        function GUARITI(data) {
            var field = this.field
            return data.map(function(row) {
                return +row[field]
            }).reduce(function(sum, i) {
                return sum + i
            }, 0)
        }
    </script>







    <script src="/index.js"></script>

    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>



    <?php
    include '/home/covid/resources/templates/footer.php';
    include '/home/covid/resources/templates/cookie-popup.php';
    ?>



    <script>
        //bar
        var ctxB = document.getElementById("barChart").getContext('2d');
        var myBarChart = new Chart(ctxB, {
            type: 'bar',
            data: {
                labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
                datasets: [{
                    label: '# of Votes',
                    data: [12, 19, 3, 5, 2, 3],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script>
    <script>
        <?php

        echo $italia_counter->GetAllJS();

        /*
        foreach ($counters as $counter) {
            echo $counter->GetJS("totale_casi");
            echo $counter->GetJS("deceduti");
            echo $counter->GetJS("tamponi");
        }*/

        ?>

        function counter(id, delay, start_val) {
            function timer() {
                start_val++;
                document.getElementById(id).innerHTML = start_val;
            }
            var v = setInterval(timer, delay);
        }
    </script>
    <?php
    $cards->GenerateCharts();
    ?>
</body>

</html>