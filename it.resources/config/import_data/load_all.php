<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "/home/covid/it.resources/config.php";
include '/home/covid/it.resources/config/import_data/data_loader.php';

load_all( TRUE );


?>