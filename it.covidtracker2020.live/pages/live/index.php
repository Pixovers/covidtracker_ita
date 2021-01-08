<?php

include "/home/covid/it.resources/config.php";
include "/home/covid/resources/classes/counter.php";
include "/home/covid/it.resources/classes/sanitizer.php";



?>

<!DOCTYPE html>



<html lang="it">

<head>

 
    <?php include "/home/covid/resources/templates/head.php"; ?>

    <meta name="mobile-web-app-capable" content="yes">
    <link rel='manifest' href='/manifest.json'>
    <link rel='apple-touch-icon' href='https://it.covidtracker2020.live/pwa/img/150x150.png'>
    <meta name="theme-color" content="#009578">


</head>

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




    <div class="py-2">
        <div class="container-fluid">
            <div class="row">

                <?php
                $italia_counter = new CounterItalia();
                ?>




                <div class="col-md-6 col-xl-3 col-lg-6 py-2">
                    <div class="card bg-dark zoom text-white shadow-large dark_mode_object">
                        <div class="card-header d-flex flex-row align-items-center justify-content-between py-1">
                            <h5 class="m-0 font-weight-bold text-primary text-truncate"> Casi Totali </h5>
                            
                            <div class="">

                           <span class="h5 py-0"><span class=" badge badge-danger"> Live</span></span> 
                          
                            
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-3"> <span class="h4 dark_mode_div"> <i class="fas fa-calendar-plus"></i> </span></div>
                                <div class="col-9 text-truncate"> <span class="h3 dark_mode_div font-weight-bold text-gray-800"> <?php echo $italia_counter->GetDOM("totale_casi"); ?> </span></div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-md-6 col-xl-3 col-lg-6 py-2">
                    <div class="card bg-dark zoom text-white shadow-large dark_mode_object">
                        <div class="card-header d-flex flex-row align-items-center justify-content-between py-1">
                            <h5 class="m-0 font-weight-bold text-primary text-truncate">Positivi Totali</h5>
                            <div class="">

                            <span class="h5 py-0"><span class=" badge badge-danger"> Live</span></span> 

                            </div>
                        </div>
                        <div class="card-body border-info ">
                            <div class="row">
                            <div class="col-3"> <span class="h4 dark_mode_div"> <i class="fas fa-skull-crossbones"></i> </span></div>
                            <div class="col-9 text-truncate"> <span class="h3 dark_mode_div font-weight-bold text-gray-800"> <?php echo $italia_counter->GetDOM("totale_positivi"); ?>
                                    </span></div>
                            </div>
                        </div>
                    </div>
                </div>




                <div class="col-md-6 col-xl-3 col-lg-6 py-2">
                    <div class="card bg-dark zoom text-white shadow-large dark_mode_object">
                        <div class="card-header d-flex flex-row align-items-center justify-content-between py-1">
                            <h5 class="m-0 font-weight-bold text-primary text-truncate">Deceduti</h5>
                            <div class="">                       
                                    <span class="h5 py-0"><span class=" badge badge-danger"> Live</span></span> 

                            </div>
                        </div>
                        <div class="card-body border-info ">
                            <div class="row">
                                <div class="col-3"> <span class="h4 dark_mode_div"> <i class="fas fa-viruses"></i> </span></div>
                                <div class="col-9 text-truncate"> <span class="h3 dark_mode_div font-weight-bold text-gray-800"> <?php echo $italia_counter->GetDOM("deceduti"); ?>
                                    </span></div>
                            </div>
                        </div>
                    </div>
                </div>





                <div class="col-md-6 col-xl-3 col-lg-6 py-2">
                    <div class="card bg-dark zoom text-white shadow-large dark_mode_object">
                        <div class="card-header d-flex flex-row align-items-center justify-content-between py-1">
                            <h5 class="m-0 font-weight-bold text-primary text-truncate"> Tamponi</h5>
                            <div class="">
                            <span class="h5 py-0"><span class=" badge badge-danger"> Live</span></span> 

                            </div>
                        </div>
                        <div class="card-body border-info ">
                            <div class="row">
                            <div class="col-3"> <span class="h4 dark_mode_div"> <i class="fas fa-vial"></i> </span></div>
                            <div class="col-9 text-truncate"> <span class="h3 dark_mode_div font-weight-bold text-gray-800"> <?php echo $italia_counter->GetDOM("tamponi"); ?>
                                    </span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">

                <?php

                $counters = array();

                foreach ($regions as $region) {
                    $counters += array($region => new CounterRegioni($region));
                    $region_url_encoded = Sanitizer::encode_url_name($region);
                ?>

                    <div class="col-md-6 col-xl-3 col-lg-4 py-2">



                        <div class="card shadow-lg dark_mode_object zoom">

                            <img src="https://it.covidtracker2020.live/images/previews/<?php echo $region_url_encoded ?>-it-covidtracker2020.png" class="card-img-top" alt="...">
                            <div class="card-body py-2 text-center text-truncate ">
                                <p> <span class="h2  font-weight-bold dark_mode_div"><?php echo $counters[$region]->GetDOM("totale_casi"); ?></span> <i style="font-size:25px" class="fas fa-viruses  text-success"></i> </p>

                                <p> <span class="h2  font-weight-bold  dark_mode_div"><?php echo $counters[$region]->GetDOM("deceduti"); ?></span> <i style="font-size:25px" class="fas fa-skull-crossbones text-danger"></i> </p>

                                <p> <span class="h2  font-weight-bold  dark_mode_div"><?php echo $counters[$region]->GetDOM("tamponi"); ?></span> <i style="font-size:25px" class="fas fa-vial text-info"></i> </p>
                            </div>
                            <div class="card-footer d-flex flex-row  justify-content-between ">
                                <h5 class="m-0 font-weight-bold text-primary text-truncate"> <?php echo $region ?></h5>



                                <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                                    <div class="btn-group mr-2" role="group" aria-label="First group">
                                        <button type="button" class="btn btn-secondary btn-md py-0" data-toggle="tooltip" data-placement="bottom" title="Calcoli statistici "> <i class="fas fa-info fa-sm"></i></button>

                                    </div>


                                </div>

                            </div>
                        </div>




                    </div>

                <?php
                }
                ?>

            </div>
        </div>
    </div>



    <?php
    include '/home/covid/resources/templates/footer.php';
    include '/home/covid/resources/templates/cookie-popup.php';
    ?>
    <script>
        <?php

        echo $italia_counter->GetAllJS();


        foreach ($counters as $counter) {
            echo $counter->GetJS("totale_casi");
            echo $counter->GetJS("deceduti");
            echo $counter->GetJS("tamponi");
        }

        ?>

        function counter(id, delay, start_val) {
            function timer() {
                start_val++;
                document.getElementById(id).innerHTML = start_val;
            }
            var v = setInterval(timer, delay);
        }
    </script>
    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
</body>

</html>