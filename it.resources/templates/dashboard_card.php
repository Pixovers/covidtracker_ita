<?php $i = 0;
$titles   =     [
    /*1*/     "Positivi Totali",
    /*2*/     "Positivi Attuali",
    /*3*/     "Nuovi Positivi",
    /*4*/     "Deceduti",
    /*5*/     "Casi Testati",
    /*6*/     "Tamponi",
    /*7*/     "Terapia Intensiva",
    /*8*/     "Guariti"
];
$tooltips =     [
    /*1*/ "Totale casi positivi da inizio pandemia",
    /*2*/  "Totale attualmente positivi (ospedalizzati + isolamento domiciliare)",
    /*3*/  "Nuovi Casi positivi + Variazione del totale positivi (totale positivi giorno corrente - totale positivi giorno precedente)",
    /*4*/  "Persone decedute",
    /*5*/  "Totale dei soggetti sottoposti al test",
    /*6*/  "Tamponi ",
    /*7*/  "terapia intensiva",
    /*8*/  "dimessi guariti"];


$icon  =  [
    /*1*/     "fa-calendar-plus",
    /*2*/     "fa-viruses",
    /*3*/     "fa-user-plus",
    /*4*/     "fa-skull-crossbones",
    /*5*/     "fas fa-user-check ",
    /*6*/     "fas fa-vial",
    /*7*/     "as fa-procedures ",
    /*8*/     "fa-laugh-beam"];
?>


<?php
foreach ($titles as $title) {

?>

    <div class="col-md-6 col-xl-3 col-lg-6 py-2">
        <div class="card bg-dark zoom text-white shadow-large dark_mode_object">
            <div class="card-header d-flex flex-row align-items-center justify-content-between ">
                <h5 class="m-0 font-weight-bold text-primary text-truncate"><?php echo $title ?></h5>
                <div class="">
                    <a class="btn btn-primary btn-sm py-0" href="#" data-toggle="modal" data-target="#myModal" role="button"><i class="fas fa-chart-area "></i></a>



                    <button type="button" class="btn btn-secondary btn-sm py-0" data-toggle="tooltip" data-placement="bottom" title="<?php echo $tooltips[$i] ?>">
                        <i class="fas fa-info fa-sm"></i></button>
                </div>
            </div>
            <div class="card-body border-info ">
                <div class="row">
                    <div class="col-3"> <span class="h4 style=" color: <?php  ?>> <i class="fas <?php echo $icon[$i] ?>"></i> </span></div>
                    <div class="col-9 text-truncate"> <span class="h3 font-weight-bold text-gray-800">1.000.000</span></div>
                </div>
            </div>
        </div>
    </div>

<?php
    $i++;
}
?>