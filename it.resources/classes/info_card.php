<?php

include_once '/home/covid/it.resources/classes/tables.php';
include_once '/home/covid/resources/classes/date_managment.php';


/*
 *  Nome:           InfoCard()
 *  Descrizione:    Gestisce le card con le info generali, per l'italia e per le regioni
 */
class InfoCard
{
    private $location;      //location (può essere l'italia o una regione)
    private $date;          //data
    private $titles;
    private $parameters;
    private $tooltips;
    private $icon;

    //costruttore
    public function __construct($location, $date)
    {
        $this->location = $location;
        $this->date = $date;

        // --- parametri utilizzati nella generazione del codice HTML ---

        $this->titles = array( /*1*/
            "Positivi Totali",
            /*2*/     "Positivi Attuali",
            /*3*/     "Nuovi Positivi",
            /*4*/     "Deceduti",
            /*5*/     "Casi Testati",
            /*6*/     "Tamponi",
            /*7*/     "Terapia Intensiva",
            /*8*/     "Guariti"
        );

        $this->parameters = array( /*1*/
            "totale_casi",
            /*2*/     "totale_positivi",
            /*3*/     "nuovi_positivi",
            /*4*/     "deceduti",
            /*5*/     "casi_testati",
            /*6*/     "tamponi",
            /*7*/     "terapia_intensiva",
            /*8*/     "dimessi_guariti"
        );

        $this->tooltips = array(  /*1*/
            "Totale casi positivi da inizio pandemia",
            /*2*/  "Totale attualmente positivi (ospedalizzati + isolamento domiciliare)",
            /*3*/  "Nuovi Casi positivi + Variazione del totale positivi (totale positivi giorno corrente - totale positivi giorno precedente)",
            /*4*/  "Persone decedute",
            /*5*/  "Totale dei soggetti sottoposti al test",
            /*6*/  "Tamponi ",
            /*7*/  "terapia intensiva",
            /*8*/  "dimessi guariti"
        );


        $this->icon  = array( /*1*/
            "fa-calendar-plus",
            /*2*/     "fa-viruses",
            /*3*/     "fa-user-plus",
            /*4*/     "fa-skull-crossbones",
            /*5*/     "fas fa-user-check ",
            /*6*/     "fas fa-vial",
            /*7*/     "as fa-procedures ",
            /*8*/     "fa-laugh-beam"
        );
    }

    /*
     *  Nome:           InfoCard::GenerateCode()
     *  Descrizione:    Genera il codice delle card
     */
    public function GenerateCode()
    {

        //verifica che $location sia un parametro valido
        $current_table = TablesManagment::getTableName($this->location);

        //se il parametro è FALSE significa che $location non è valida
        if ($current_table !== FALSE) {

            //scelta della query corretta da eseguire
            switch ($current_table) {
                case 'dati_italia':
                    $query_str =   "SELECT 
                                    	totale_casi,
                                    	totale_positivi,
                                        nuovi_positivi,
                                        deceduti,
                                        casi_testati,
                                        tamponi,
                                        terapia_intensiva,
                                        dimessi_guariti
                                    FROM 
                                    	dati_italia
                                    WHERE 
                                    	data = \"$this->date\"";
                    break;

                case 'dati_regioni':
                    $query_str =   "SELECT 
                                    	totale_casi,
                                    	totale_positivi,
                                        nuovi_positivi,
                                        deceduti,
                                        casi_testati,
                                        tamponi,
                                        terapia_intensiva,
                                        dimessi_guariti,
                                        url_encoded
                                    FROM 
                                    	dati_regioni dati 
                                    INNER JOIN regioni info 
                                    	ON dati.codice_regione = info.codice 
                                    WHERE 
                                    	data = \"$this->date\" AND url_encoded = \"$this->location\"";
                    break;
            }

            //esecuzione della query
            $sql_result = $GLOBALS['COVID_IT_DB_CONN']->query($query_str)->fetch_assoc();


            //generazione del codice
            for ($i = 0; $i < count($this->titles); $i++) {

?>

                <div class="col-md-6 col-xl-3 col-lg-6 py-2">
                    <div class="card bg-dark zoom text-white shadow-md dark_mode_object">
                        <div class="card-header d-flex flex-row align-items-center justify-content-between py-1">
                            <h5 class="m-0 font-weight-bold text-primary text-truncate"><?php echo $this->titles[$i] ?></h5>
                            <div class="dark_mode_div">
                                <a class="btn btn-primary btn-sm py-0" href="#modal-<?php echo $this->parameters[$i]; ?>" data-toggle="modal" data-target="#modal-<?php echo $this->parameters[$i]; ?>" role="button"><i class="fas fa-chart-area "></i></a>

                                <button type="button" class="btn btn-secondary btn-sm py-0" data-toggle="tooltip" data-placement="bottom" title="<?php echo $this->tooltips[$i] ?>">
                                    <i class="fas fa-info fa-sm"></i></button>
                            </div>
                        </div>
                        <div class="card-body border-info d-flex flex-row align-items-center justify-content-between">
                            <div class="col-3"> <span class="h4 style=" color: <?php  ?>> <i class="dark_mode_div fas <?php echo $this->icon[$i] ?>"></i> </span></div>
                            <div class="col-9 text-truncate"> <span class="dark_mode_div h3 font-weight-bold text-gray-800"><?php echo number_format($sql_result[$this->parameters[$i]], 0, ",", ".") ?></span></div>
                        </div>
                    </div>
                </div>
            <?php


            }
        } else {
            //location errata: non è ne' "italia" ne' una regione
            echo "<b>Error: Unknown location</b><br>";
        }
    }

    public function GenerateModals()
    {
        for ($i = 0; $i < count($this->titles); $i++) {
            ?>

            <div class="modal" id="modal-<?php echo $this->parameters[$i]; ?>" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header d-flex flex-row align-items-center justify-content-between">
                            <h5 class="modal-title m-0 font-weight-bold text-primary text-truncate"><?php echo $this->titles[$i] ?></h5>
                            <div class="">


                                <button type="button" class="btn btn-secondary btn py-0" data-toggle="tooltip" data-placement="bottom" title="<?php echo $this->tooltips[$i] ?>">
                                    <i class="fas fa-info fa-sm"></i></button>
                            </div>



                        </div>
                        <div class="modal-body">
                            <canvas id="chart-<?php echo $this->parameters[$i]; ?>"></canvas>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

        <?php

        }
    }

    public function GenerateCharts()
    {
        $start_date = substr($this->date, 0, 8) . "01";
        $data_iniziale = date("Y-m-d", strtotime("$start_date -5 months"));
        $dates = DateManagment::intervalsFromDate($data_iniziale, "months");
        $dates[] = $this->date;
        $months = array("Gen", "Feb", "Mar", "Apr", "Mag", "Giu", "Lug", "Ago", "Set", "Ott", "Nov", "Dic");


        //verifica che $location sia un parametro valido

        $current_table = TablesManagment::getTableName($this->location);
        //creazione della query

        $date_conditions = "(";
        foreach ($dates as $date) {
            $date_conditions .= "data='" . $date . "' OR ";
        }
        $date_conditions = substr($date_conditions, 0, count($date_conditions) - 4) . ")";

        for ($i = 0; $i < count($this->titles); $i++) {

            if ($current_table == "dati_italia") {
                $sql_text = "SELECT " . $this->parameters[$i] . " FROM dati_italia WHERE $date_conditions";
                //echo $sql_text;
            } else if ($current_table == "dati_regioni") {
                $sql_text = "SELECT " . $this->parameters[$i] . " FROM dati_regioni dat INNER JOIN regioni reg ON reg.denominazione = dat.denominazione_regione WHERE $date_conditions AND url_encoded = \"$this->location\"";
            
            }

            $values = $GLOBALS['COVID_IT_DB_CONN']->query($sql_text)->fetch_all();
            //echo var_dump( $values );
        ?>
            <script>
                //bar
                var ctxB = document.getElementById("chart-<?php echo $this->parameters[$i]; ?>").getContext('2d');
                var myBarChart = new Chart(ctxB, {
                    type: 'line',
                    data: {
                        labels: [<?php
                                    //forgulag
                                    for ($j = 0; $j < count($dates) - 1; $j++) {
                                        echo "'" . $months[intval(substr($dates[$j], 5, 2)) - 1] . "',";
                                    }
                                    echo "'Oggi'";
                                    ?>],
                        datasets: [{
                            data: [<?php
                                    foreach ($values as $value) {
                                        echo $value[0] . ",";
                                    }
                                    ?>],
                            backgroundColor: [
                                'rgba(208, 0, 28, 0.2)'
                               
                            ],
                            borderColor: [
                                'rgba(208, 0, 28, 1)'
                              
                            ],
                            borderWidth: 1,
                            pointBorderWidth: 7,
                            pointHoverRadius: 7,
                            pointHoverBorderWidth: 1,
                            pointRadius: 3,
                            pointBackgroundColor: "rgba(208, 0, 28, 0.8)"
                        }]
                    },
                    options: {
                        legend: {
                            display: false
                        },

                        animation: {
                            duration: 500,
                            easing: "linear"
                        },
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

<?php

        }
    }
}
?>