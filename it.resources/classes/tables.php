<?php

include_once '/home/covid/it.resources/classes/sanitizer.php';


/*
 *  Nome:           TablesManagment()
 *  Data:           05 / 11 / 2020
 *  Descrizione:    Classe statica per la gestione dei nomi, e informazioni sulle tabelle
 */
Class TablesManagment {
    
    /*
     *  Nome:           TablesManagment::getTableName()
     *  Descrizione:    Restituisce il nome della tabella in cui è presente
     *                  la location indicata. Se la location non è presente in
     *                  nessuna tabella restituisce FALSE
     */
    public static function getTableName( $location ) {
        
        //trasforma $location in url encode
        $loc = Sanitizer::encode_url_name( $location );
        
        if( $loc == "italia" ) {
            return "dati_italia";
        } else if( TablesManagment::isRegione( $loc ) ) {
            return "dati_regioni";
        } else if( TablesManagment::isProvincia( $loc ) ) {
            return "dati_province";
        } else return FALSE;
    }
    
    /*
     *  Nome:           TablesManagment::isRegione()
     *  Descrizione:    Restituisce TRUE se location è una regione, FALSE altrimenti
     */
    public static function isRegione( $location ) {
        
        //trasforma $location in url encode
        $loc = Sanitizer::encode_url_name( $location );
        
        $result = $GLOBALS['COVID_IT_DB_CONN']->query("SELECT * FROM regioni WHERE url_encoded = \"$loc\"");
        
        if( $result->fetch_assoc() ) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    /*
     *  Nome:           TablesManagment::isProvincia()
     *  Descrizione:    Restituisce TRUE se location è una provincia, FALSE altrimenti
     */
    public static function isProvincia( $location ) {
        
        //trasforma $location in url encode
        $loc = Sanitizer::encode_url_name( $location );
        
        $result = $GLOBALS['COVID_IT_DB_CONN']->query("SELECT * FROM province WHERE url_encoded = \"$loc\"");
        
        if( $result->fetch_assoc() ) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}

?>