<?php

    //visualizzazione degli errori
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $CONTENT_LANGUAGE = "it-it";
    $LANGUAGE = "IT";

    //import delle credenziali di accesso ai database
    $DB_ACCESS = include('db_credentials.php');
    
    //connesisone al database covid_main
    $COVID_IT_DB_CONN = new mysqli( $DB_ACCESS['covid_it']['host'],
                                 $DB_ACCESS['covid_it']['username'],
                                 $DB_ACCESS['covid_it']['password'],
                                 $DB_ACCESS['covid_it']['database'] );

    //check delle connessioni ai database
    if ( $COVID_IT_DB_CONN->connect_error ) {
        die("Database Error.");
    }
    
    //set del timezone italiano.
    date_default_timezone_set('Europe/Rome');
    
    //calcolo della data
    if( isset( $_GET['date'] ) ) {
        //il parametro GET 'data' è settato.
        //verifica della data
        if( $_GET['date'] < $COVID_IT_DB_CONN->query("SELECT data FROM dati_italia ORDER BY data DESC LIMIT 1")->fetch_assoc()['data'] &&
            $_GET['date'] > $COVID_IT_DB_CONN->query("SELECT data FROM dati_italia ORDER BY data ASC LIMIT 1")->fetch_assoc()['data']) {
            $DATE = $_GET['date'];
        } else {
            //data non valida
            $DATE = $COVID_IT_DB_CONN->query("SELECT data FROM dati_italia ORDER BY data DESC LIMIT 1")->fetch_assoc()['data'];
        }
    } else {
        //data non settata. Viene calcolata l'ultima data valida
        $DATE = $COVID_IT_DB_CONN->query("SELECT data FROM dati_italia ORDER BY data DESC LIMIT 1")->fetch_assoc()['data'];
    }
    
    //switch di pagina richiesta
    switch( $_SERVER["SCRIPT_NAME"] ) {
        case '/index.php':
            $CURRENT_PAGE = "it-Home";
            $PAGE_TITLE = "Home";
            $PAGE_DESCRIPTION = "COVID-19 Tempo reale. Keep track of all coronavirus today cases, deaths, and all other news. Download COVID-19 data in PDF and other formats.";
            $PAGE_KEYWORDS = "COVID, CASES TODAY, NEW CASES, DEATHS TODAY, NEW DEATHS, COVID-19, CORONAVIRUS, COUNTER, DEATH RATE, TESTS";
            $PAGE_PREVIEW_IMAGE = "/images/covidtracker2020_logo_image.png";
            break;
        case '/pages/archivio/index.php':
            $CURRENT_PAGE = "it-Archivio";
            $PAGE_TITLE = "Archivio";
            $PAGE_DESCRIPTION = "COVID-19 Tempo reale. Keep track of all coronavirus today cases, deaths, and all other news. Download COVID-19 data in PDF and other formats.";
            $PAGE_KEYWORDS = "COVID, CASES TODAY, NEW CASES, DEATHS TODAY, NEW DEATHS, COVID-19, CORONAVIRUS, COUNTER, DEATH RATE, TESTS";
            $PAGE_PREVIEW_IMAGE = "/images/covidtracker2020_logo_image.png";
            break;
        case '/pages/regione/index.php':
            $CURRENT_PAGE = "it-Regione";
            $PAGE_TITLE = "Regione";
            $PAGE_DESCRIPTION = "COVID-19 Tempo reale. Keep track of all coronavirus today cases, deaths, and all other news. Download COVID-19 data in PDF and other formats.";
            $PAGE_KEYWORDS = "COVID, CASES TODAY, NEW CASES, DEATHS TODAY, NEW DEATHS, COVID-19, CORONAVIRUS, COUNTER, DEATH RATE, TESTS";
            $PAGE_PREVIEW_IMAGE = "/images/covidtracker2020_logo_image.png";
            break;
        case '/pages/mappa/index.php':
                $CURRENT_PAGE = "it-Mappa";
                $PAGE_TITLE = "Mappa";
                $PAGE_DESCRIPTION = "COVID-19 Tempo reale. Keep track of all coronavirus today cases, deaths, and all other news. Download COVID-19 data in PDF and other formats.";
                $PAGE_KEYWORDS = "COVID, CASES TODAY, NEW CASES, DEATHS TODAY, NEW DEATHS, COVID-19, CORONAVIRUS, COUNTER, DEATH RATE, TESTS";
                $PAGE_PREVIEW_IMAGE = "/images/covidtracker2020_logo_image.png";
                break;
            
        case '/pages/live/index.php':
            $CURRENT_PAGE = "it-Live";
            $PAGE_TITLE = "Live";
            $PAGE_DESCRIPTION = "COVID-19 Tempo reale. Keep track of all coronavirus today cases, deaths, and all other news. Download COVID-19 data in PDF and other formats.";
            $PAGE_KEYWORDS = "COVID, CASES TODAY, NEW CASES, DEATHS TODAY, NEW DEATHS, COVID-19, CORONAVIRUS, COUNTER, DEATH RATE, TESTS";
            $PAGE_PREVIEW_IMAGE = "/images/covidtracker2020_logo_image.png";
            break;
    } 
    
    
    
?>