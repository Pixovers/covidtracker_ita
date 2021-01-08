<?php

include '/home/covid/it.resources/classes/sanitizer.php';


/*
 *  Data:                   04 / 11 / 2020
 *  Descrizione:            Generazione della tabella MySql con i nomi e codici
 *                          regioni
 */
function createRegioni() {

    //eliminazione della tabella precendente
    $GLOBALS['COVID_IT_DB_CONN']->query("DROP TABLE IF EXISTS regioni");

    //creazione della nuova tabella
    $GLOBALS['COVID_IT_DB_CONN']->query( "CREATE TABLE regioni (".
                                         "codice INT UNSIGNED PRIMARY KEY, ".
                                         "denominazione VARCHAR(30) NOT NULL, ".
                                         "url_encoded VARCHAR(30) NOT NULL )");
    
    //nomi regioni
    $denoms =      array(   1 => "Piemonte", 
                            2 => "Valle d'Aosta",
                            3 => "Lombardia",
                            4 => "Trentino-Alto Adige",
                            5 => "Veneto",
                            6 => "Friuli Venezia Giulia",
                            7 => "Liguria",
                            8 => "Emilia Romagna",
                            9 => "Toscana",
                            10 => "Umbria",
                            11 => "Marche",
                            12 => "Lazio",
                            13 => "Abruzzo",
                            14 => "Molise",
                            15 => "Campania",
                            16 => "Puglia",
                            17 => "Basilicata",
                            18 => "Calabria",
                            19 => "Sicilia",
                            20 => "Sardegna"
                            );


    //inserimento dei dati in tabella
    foreach( $denoms as $codice => $denom ) {
        $GLOBALS['COVID_IT_DB_CONN']->query('INSERT INTO regioni (codice, denominazione, url_encoded) VALUES ("'.$codice.'","'.$denom.'","'.Sanitizer::encode_url_name($denom).'") ' );
    }
}


/*
 *  Data:                   04 / 11 / 2020
 *  Descrizione:            Generazione della tabella MySql con i nomi e codici
 *                          province
 */
function createProvince() {
    
    //eliminazione della tabella precendente
    $GLOBALS['COVID_IT_DB_CONN']->query("DROP TABLE IF EXISTS province");

    //creazioni della nuova tabella
    $GLOBALS['COVID_IT_DB_CONN']->query( "CREATE TABLE province (".
                                         "codice INT UNSIGNED PRIMARY KEY, ".
                                         "denominazione VARCHAR(30) NOT NULL, ".
                                         "url_encoded VARCHAR(30) NOT NULL, ".
                                         "sigla VARCHAR(2) NOT NULL )" );
                                         
    //array con sigle e nomi delle province
    $denoms = array( 'AG' => 'Agrigento',
                     'AL' => 'Alessandria',
                     'AN' => 'Ancona',
                     'AO' => 'Aosta',
                     'AR' => 'Arezzo',
                     'AP' => 'Ascoli Piceno',
                     'AT' => 'Asti',
                     'AV' => 'Avellino',
                     'BA' => 'Bari',
                     'BT' => 'Barletta-Andria-Trani',
                     'BL' => 'Belluno',
                     'BN' => 'Benevento',
                     'BG' => 'Bergamo',
                     'BI' => 'Biella',
                     'BO' => 'Bologna',
                     'BZ' => 'Bolzano',
                     'BS' => 'Brescia',
                     'BR' => 'Brindisi',
                     'CA' => 'Cagliari',
                     'CL' => 'Caltanissetta',
                     'CB' => 'Campobasso',
                     'CE' => 'Caserta',
                     'CT' => 'Catania',
                     'CZ' => 'Catanzaro',
                     'CH' => 'Chieti',
                     'CO' => 'Como',
                     'CS' => 'Cosenza',
                     'CR' => 'Cremona',
                     'KR' => 'Crotone',
                     'CN' => 'Cuneo',
                     'EN' => 'Enna',
                     'FM' => 'Fermo',
                     'FE' => 'Ferrara',
                     'FI' => 'Firenze',
                     'FG' => 'Foggia',
                     'FC' => 'Forlì-Cesena',
                     'FR' => 'Frosinone',
                     'GE' => 'Genova',
                     'GO' => 'Gorizia',
                     'GR' => 'Grosseto',
                     'IM' => 'Imperia',
                     'IS' => 'Isernia',
                     'SP' => 'La Spezia',
                     'AQ' => 'L\'Aquila',
                     'LT' => 'Latina',
                     'LE' => 'Lecce',
                     'LC' => 'Lecco',
                     'LI' => 'Livorno',
                     'LO' => 'Lodi',
                     'LU' => 'Lucca',
                     'MC' => 'Macerata',
                     'MN' => 'Mantova',
                     'MS' => 'Massa-Carrara',
                     'MT' => 'Matera',
                     'ME' => 'Messina',
                     'MI' => 'Milano',
                     'MO' => 'Modena',
                     'MB' => 'Monza e della Brianza',
                     'NA' => 'Napoli',
                     'NO' => 'Novara',
                     'NU' => 'Nuoro',
                     'OR' => 'Oristano',
                     'PD' => 'Padova',
                     'PA' => 'Palermo',
                     'PR' => 'Parma',
                     'PV' => 'Pavia',
                     'PG' => 'Perugia',
                     'PU' => 'Pesaro e Urbino',
                     'PE' => 'Pescara',
                     'PC' => 'Piacenza',
                     'PI' => 'Pisa',
                     'PT' => 'Pistoia',
                     'PN' => 'Pordenone',
                     'PZ' => 'Potenza',
                     'PO' => 'Prato',
                     'RG' => 'Ragusa',
                     'RA' => 'Ravenna',
                     'RC' => 'Reggio Calabria',
                     'RE' => 'Reggio Emilia',
                     'RI' => 'Rieti',
                     'RN' => 'Rimini',
                     'RM' => 'Roma',
                     'RO' => 'Rovigo',
                     'SA' => 'Salerno',
                     'SS' => 'Sassari',
                     'SV' => 'Savona',
                     'SI' => 'Siena',
                     'SR' => 'Siracusa',
                     'SO' => 'Sondrio',
                     'SU' => 'Sud Sardegna',
                     'TA' => 'Taranto',
                     'TE' => 'Teramo',
                     'TR' => 'Terni',
                     'TO' => 'Torino',
                     'TP' => 'Trapani',
                     'TN' => 'Trento',
                     'TV' => 'Treviso',
                     'TS' => 'Trieste',
                     'UD' => 'Udine',
                     'VA' => 'Varese',
                     'VE' => 'Venezia',
                     'VB' => 'Verbano-Cusio-Ossola',
                     'VC' => 'Vercelli',
                     'VR' => 'Verona',
                     'VV' => 'Vibo Valentia',
                     'VI' => 'Vicenza',
                     'VT' => 'Viterbo',
                     );
    
    //codici provincia
    $codici = array(84,  6, 42,  7, 51, 44,  5, 64, 72,110,
                    25, 62, 16, 96, 37, 21, 17, 74, 92, 85,
                    70, 61, 87, 79, 69, 13, 78, 19,101,  4,
                    86,109, 38, 48, 71, 40, 60, 10, 31, 53,
                     8, 94, 11, 66, 59, 59, 97, 49, 98, 46,
                    43, 20, 45, 77, 83, 15, 36,108, 63,  3,
                    91, 95, 28, 82, 34, 18, 54, 41, 68, 33,
                    50, 47, 93, 76,100, 88, 39, 80, 35, 57,
                    99, 58, 29, 65, 90,  9, 52, 89, 14,111,
                    73, 67, 55,  1, 81, 22, 26, 32, 30, 12,
                    27,103,  2, 23,102, 24, 56);
                    
    
    //inserimento dei dati in tabella    
    $i = 0;
    foreach( $denoms as $sigla => $denom ) {
        $GLOBALS['COVID_IT_DB_CONN']->query('INSERT INTO province (codice, denominazione, url_encoded, sigla) VALUES ("'.$codici[$i].'","'.$denom.'","'.Sanitizer::encode_url_name($denom).'","'.$sigla.'") ' );
        $i += 1;
    }
}

?>