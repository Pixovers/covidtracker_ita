<?php

function get_timestamp( $data_name ) {
    
    switch( $data_name ) {
        case "italia":
            $remote_file = fopen("https://raw.githubusercontent.com/pcm-dpc/COVID-19/master/dati-andamento-nazionale/dpc-covid19-ita-andamento-nazionale-latest.csv", "r");
            break;
        case "regioni":
            $remote_file = fopen("https://raw.githubusercontent.com/pcm-dpc/COVID-19/master/dati-regioni/dpc-covid19-ita-regioni-latest.csv", "r");
            break;
        case "province":
            $remote_file = fopen("https://raw.githubusercontent.com/pcm-dpc/COVID-19/master/dati-province/dpc-covid19-ita-province-latest.csv", "r");
            break;
        default:
            return FALSE;
    }
    
    fgetcsv($remote_file, 10000, ",");
    return fgetcsv($remote_file, 10000, ",")[0];
    
}



/*
 *  Nome:           load_italia()
 *  Descrizione:    Carica i dati dell'andamento nazionale, dal file CSV remoto
 *                  (repository della protezione civile), al database MySql locale
 *  Parametri:      $force_reload: se True, forza il caricamento
 */
function load_italia( $force_reload = FALSE ) {
    $starttime = microtime(true);
     
    //verifica aggiornamento
    if( substr(get_timestamp('italia'),0,10) > $GLOBALS['COVID_IT_DB_CONN']->query("SELECT data FROM dati_italia ORDER BY data DESC LIMIT 1")->fetch_assoc()['data'] ||
        $force_reload == TRUE ) {
        
        //eliminazione della tabella precendente
        $GLOBALS['COVID_IT_DB_CONN']->query("DROP TABLE IF EXISTS dati_italia");
    
        //testo della query per la creazione della tabella
        $table_query_text =    "CREATE TABLE dati_italia (
                            	id INT AUTO_INCREMENT PRIMARY KEY,
                            	data DATE,
                            	stato VARCHAR(3),
                            	ricoverati_con_sintomi INT,
                            	terapia_intensiva INT,
                            	totale_ospedalizzati INT,
                            	isolamento_domiciliare INT,
                            	totale_positivi INT,
                            	variazione_totale_positivi INT,
                            	nuovi_positivi INT,
                            	dimessi_guariti INT,
                            	deceduti INT,
                            	casi_da_sospetto_diagnostico INT,
                            	casi_da_screening INT,
                            	totale_casi INT,
                            	tamponi INT,
                            	casi_testati INT,
                            	note VARCHAR(500) )";
                            	
        //creazione della tabella
        $GLOBALS['COVID_IT_DB_CONN']->query( $table_query_text );
        
        //Apertura in lettura del file csv
        $remote_file = fopen("https://raw.githubusercontent.com/pcm-dpc/COVID-19/master/dati-andamento-nazionale/dpc-covid19-ita-andamento-nazionale.csv", "r");
        
        //lettura del file csv, riga per riga
        fgetcsv($remote_file, 10000, ",");
        while( ($data_column = fgetcsv($remote_file, 10000, ",") ) !== FALSE )
        {
                $sql_text =    "INSERT INTO dati_italia (
                                data,
                                stato,
                                ricoverati_con_sintomi,
                                terapia_intensiva,
                                totale_ospedalizzati,
                                isolamento_domiciliare,
                                totale_positivi,
                                variazione_totale_positivi,
                                nuovi_positivi,
                                dimessi_guariti,
                                deceduti,
                                casi_da_sospetto_diagnostico,
                                casi_da_screening,
                                totale_casi,
                                tamponi,
                                casi_testati,
                                note 
                                ) VALUES (
                                \"$data_column[0]\",
                                \"$data_column[1]\",
                                \"$data_column[2]\",
                                \"$data_column[3]\",
                                \"$data_column[4]\",
                                \"$data_column[5]\",
                                \"$data_column[6]\",
                                \"$data_column[7]\",
                                \"$data_column[8]\",
                                \"$data_column[9]\",
                                \"$data_column[10]\",
                                \"$data_column[11]\",
                                \"$data_column[12]\",
                                \"$data_column[13]\",
                                \"$data_column[14]\",
                                \"$data_column[15]\",
                                \"$data_column[16]\"
                                )";
    
                $GLOBALS['COVID_IT_DB_CONN']->query( $sql_text );
        }
        
        fclose($remote_file);
        
    } else {
        echo " Gia' aggiornato - ";
    }
    return microtime(true) - $starttime;
}

/*
 *  Nome:           load_regioni()
 *  Descrizione:    Carica i dati delle regioni, dal file CSV remoto
 *                  (repository della protezione civile), al database MySql locale
 *  Parametri:      $force_reload: se True, forza il caricamento
 */
function load_regioni( $force_reload = FALSE ) {
    $starttime = microtime(true);
    
    //verifica aggiornamento
    if( substr(get_timestamp('regioni'),0,10) > $GLOBALS['COVID_IT_DB_CONN']->query("SELECT data FROM dati_regioni ORDER BY data DESC LIMIT 1")->fetch_assoc()['data'] ||
        $force_reload == TRUE ) {
        
        //eliminazione della tabella precendente
        $GLOBALS['COVID_IT_DB_CONN']->query("DROP TABLE IF EXISTS dati_regioni");
    
        //testo della query per la creazione della tabella
        $table_query_text =    "CREATE TABLE dati_regioni (
                            	id INT AUTO_INCREMENT PRIMARY KEY,
                            	data DATE,
                            	stato VARCHAR(3),
                            	codice_regione INT,
                            	denominazione_regione VARCHAR(30),
                            	lat DOUBLE,
                            	lon DOUBLE,
                            	ricoverati_con_sintomi INT,
                            	terapia_intensiva INT,
                            	totale_ospedalizzati INT,
                            	isolamento_domiciliare INT,
                            	totale_positivi INT,
                            	variazione_totale_positivi INT,
                            	nuovi_positivi INT,
                            	dimessi_guariti INT,
                            	deceduti INT,
                            	casi_da_sospetto_diagnostico INT,
                            	casi_da_screening INT,
                            	totale_casi INT,
                            	tamponi INT,
                            	casi_testati INT,
                            	note VARCHAR(500) )";
                            	
        //creazione della tabella
        $GLOBALS['COVID_IT_DB_CONN']->query( $table_query_text ) . "<";
        
        //Apertura in lettura del file csv
        $remote_file = fopen("https://raw.githubusercontent.com/pcm-dpc/COVID-19/master/dati-regioni/dpc-covid19-ita-regioni.csv", "r");
        
        //lettura del file csv, riga per riga
        fgetcsv($remote_file, 10000, ",");
        while( ($data_column = fgetcsv($remote_file, 10000, ",") ) !== FALSE )
        {
                $sql_text =    "INSERT INTO dati_regioni (
                                data,
                                stato,
                                codice_regione,
                            	denominazione_regione,
                            	lat,
                            	lon,
                                ricoverati_con_sintomi,
                                terapia_intensiva,
                                totale_ospedalizzati,
                                isolamento_domiciliare,
                                totale_positivi,
                                variazione_totale_positivi,
                                nuovi_positivi,
                                dimessi_guariti,
                                deceduti,
                                casi_da_sospetto_diagnostico,
                                casi_da_screening,
                                totale_casi,
                                tamponi,
                                casi_testati,
                                note 
                                ) VALUES (
                                \"$data_column[0]\",
                                \"$data_column[1]\",
                                \"$data_column[2]\",
                                \"$data_column[3]\",
                                \"$data_column[4]\",
                                \"$data_column[5]\",
                                \"$data_column[6]\",
                                \"$data_column[7]\",
                                \"$data_column[8]\",
                                \"$data_column[9]\",
                                \"$data_column[10]\",
                                \"$data_column[11]\",
                                \"$data_column[12]\",
                                \"$data_column[13]\",
                                \"$data_column[14]\",
                                \"$data_column[15]\",
                                \"$data_column[16]\",
                                \"$data_column[17]\",
                                \"$data_column[18]\",
                                \"$data_column[19]\",
                                \"$data_column[20]\"
                                )";
    
                $GLOBALS['COVID_IT_DB_CONN']->query( $sql_text );

            
        }

        //elenco delle date
        $result = $GLOBALS['COVID_IT_DB_CONN']->query( "SELECT DISTINCT data FROM dati_regioni" );
        
        
        
        while( $data = $result->fetch_assoc() ) {
 
            $result_trentino = $GLOBALS['COVID_IT_DB_CONN']->query( "SELECT * FROM dati_regioni WHERE ( codice_regione = 21 OR codice_regione = 22 ) AND data = '".$data['data']."' ORDER BY codice_regione ASC" );
            $bolzano = $result_trentino->fetch_assoc();
            $trento = $result_trentino->fetch_assoc();

            $sql_text =    "INSERT INTO dati_regioni (
                            data,
                            stato,
                            codice_regione,
                            denominazione_regione,
                            lat,
                            lon,
                            ricoverati_con_sintomi,
                            terapia_intensiva,
                            totale_ospedalizzati,
                            isolamento_domiciliare,
                            totale_positivi,
                            variazione_totale_positivi,
                            nuovi_positivi,
                            dimessi_guariti,
                            deceduti,
                            casi_da_sospetto_diagnostico,
                            casi_da_screening,
                            totale_casi,
                            tamponi,
                            casi_testati,
                            note 
                            ) VALUES (
                            \"".$data['data']."\",
                            \"ITA\",
                            \"4\",
                            \"Trentino-Alto Adige\",
                            \"".$trento['lat']."\",
                            \"".$trento['lon']."\",
                            \"".($trento['ricoverati_con_sintomi']+$bolzano['ricoverati_con_sintomi'])."\",
                            \"".($trento['terapia_intensiva']+$bolzano['terapia_intensiva'])."\",
                            \"".($trento['totale_ospedalizzati']+$bolzano['totale_ospedalizzati'])."\",
                            \"".($trento['isolamento_domiciliare']+$bolzano['isolamento_domiciliare'])."\",
                            \"".($trento['totale_positivi']+$bolzano['totale_positivi'])."\",
                            \"".($trento['variazione_totale_positivi']+$bolzano['variazione_totale_positivi'])."\",
                            \"".($trento['nuovi_positivi']+$bolzano['nuovi_positivi'])."\",
                            \"".($trento['dimessi_guariti']+$bolzano['dimessi_guariti'])."\",
                            \"".($trento['deceduti']+$bolzano['deceduti'])."\",
                            \"".($trento['casi_da_sospetto_diagnostico']+$bolzano['casi_da_sospetto_diagnostico'])."\",
                            \"".($trento['casi_da_screening']+$bolzano['casi_da_screening'])."\",
                            \"".($trento['totale_casi']+$bolzano['totale_casi'])."\",
                            \"".($trento['tamponi']+$bolzano['tamponi'])."\",
                            \"".($trento['casi_testati']+$bolzano['casi_testati'])."\",
                            \"-\"
                            )";


            $GLOBALS['COVID_IT_DB_CONN']->query( $sql_text ); 

        }

        $GLOBALS['COVID_IT_DB_CONN']->query( "DELETE FROM dati_regioni WHERE codice_regione = 21 OR codice_regione = 22" ); 
        
        fclose($remote_file);
    } else {
        echo " Gia' aggiornato - ";
    }
    
    return microtime(true) - $starttime;
}

/*
 *  Nome:           load_province()
 *  Descrizione:    Carica i dati delle province, dal file CSV remoto
 *                  (repository della protezione civile), al database MySql locale
 *  Parametri:      $force_reload: se True, forza il caricamento
 */
function load_province( $force_reload = FALSE ) {
    $starttime = microtime(true);
    
    //verifica aggiornamento
    if( substr(get_timestamp('province'),0,10) > $GLOBALS['COVID_IT_DB_CONN']->query("SELECT data FROM dati_province ORDER BY data DESC LIMIT 1")->fetch_assoc()['data'] ||
        $force_reload == TRUE ) {
    
        //eliminazione della tabella precendente
        $GLOBALS['COVID_IT_DB_CONN']->query("DROP TABLE IF EXISTS dati_province");
    
        //testo della query per la creazione della tabella
        $table_query_text =    "CREATE TABLE dati_province (
                            	id INT AUTO_INCREMENT PRIMARY KEY,
                            	data DATE,
                            	stato VARCHAR(3),
                            	codice_regione INT,
                            	denominazione_regione VARCHAR(30),
                            	codice_provincia INT,
                            	denominazione_provincia VARCHAR(30),
                            	sigla_provincia VARCHAR(2),
                            	lat DOUBLE,
                            	lon DOUBLE,
                            	totale_casi INT,
                            	note VARCHAR(500) )";
                            	
        //creazione della tabella
        $GLOBALS['COVID_IT_DB_CONN']->query( $table_query_text ) . "<";
        
        //Apertura in lettura del file csv
        $remote_file = fopen("https://raw.githubusercontent.com/pcm-dpc/COVID-19/master/dati-province/dpc-covid19-ita-province.csv", "r");
        
        //lettura del file csv, riga per riga
        fgetcsv($remote_file, 10000, ",");
        while( ($data_column = fgetcsv($remote_file, 10000, ",") ) !== FALSE )
        {
                $sql_text =    "INSERT INTO dati_province (
                                data,
                            	stato,
                            	codice_regione,
                            	denominazione_regione,
                            	codice_provincia,
                            	denominazione_provincia,
                            	sigla_provincia,
                            	lat,
                            	lon,
                            	totale_casi,
                            	note 
                                ) VALUES (
                                \"$data_column[0]\",
                                \"$data_column[1]\",
                                \"$data_column[2]\",
                                \"$data_column[3]\",
                                \"$data_column[4]\",
                                \"$data_column[5]\",
                                \"$data_column[6]\",
                                \"$data_column[7]\",
                                \"$data_column[8]\",
                                \"$data_column[9]\",
                                \"$data_column[10]\"
                                )";
    
                $GLOBALS['COVID_IT_DB_CONN']->query( $sql_text );
        }
        
        $GLOBALS['COVID_IT_DB_CONN']->query("UPDATE dati_province SET codice_regione = 4, denominazione_regione = \"Trentino-Alto Adige\" WHERE denominazione_provincia=\"Bolzano\"");
        $GLOBALS['COVID_IT_DB_CONN']->query("UPDATE dati_province SET codice_regione = 4, denominazione_regione = \"Trentino-Alto Adige\" WHERE denominazione_provincia=\"Trento\"");
        
        fclose($remote_file);
    } else {
        echo " Gia' aggiornato - ";
    }
    
    return microtime(true) - $starttime;
}


/*
 *  Nome:           load_all()
 *  Descrizione:    Carica tutti i dati da file in remoto, al database locale
 */
function  load_all( $force_reload = FALSE ) {
    $starttime = microtime(true);
    echo "Caricamento dati Italia ==> Tempo di esecuzione: " . round(load_italia($force_reload),1) . "s<br>";
    echo "Caricamento dati Italia ==> Tempo di esecuzione: " . round(load_regioni($force_reload),1) . "s<br>";
    echo "Caricamento dati Italia ==> Tempo di esecuzione: " . round(load_province($force_reload),1) . "s<br>";
    $timediff = microtime(true) - $starttime;
    echo "Tempo totale di esecuzione: " . round($timediff,1) . "s<br>";
}


?>