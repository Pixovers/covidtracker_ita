<?php

include '/home/covid/it.resources/config.php';
include_once '/home/covid/it.resources/classes/it_table.php';
include_once '/home/covid/it.resources/classes/tables.php';

//setup dell header: file JSON
header('Content-Type: application/json');

//verifica che il parametro type sia stato passato. 
//Il parametro type specifica la struttura della tabella
if( isset( $_GET['tipo']) ) {

    //array rows utilizzato per memorizzare le righe della tabella
    $rows = array();
    
    //esecuzione delle istruzioni corrispondenti al type passato come parametro GET
    if( $_GET['tipo'] == "div" &&
        isset($_GET['data']) &&
        isset($_GET['location']) ) 
    {
        if( $_GET['location'] == "italia" ) {
            //creazione di un oggetto Table della tipologia corretta
            $current_table = new ItTable();
            
            //creazione del testo della query del contenuto della tabella
            $sql_text = "SELECT  ";
            foreach( $current_table->getParameters() as $param ) {
                $sql_text .= $param[2].",";
            }
                
            $sql_text = rtrim($sql_text,",");
                
            if( Sanitizer::encode_url_name($_GET['location']) == "italia" ) {
                $nome_tabella = "dati_regioni";
            }    
            
            $sql_text .= " FROM $nome_tabella WHERE data = '".$_GET['data']."' ";
            
            //echo "<".$sql_text.">";  
            
            //esecuzione della query
            $result = $GLOBALS['COVID_IT_DB_CONN']->query("$sql_text");
            
            //parametri attuali
            $params = $current_table->getParameters();

            while($query_row = $result->fetch_assoc()) {
                $current_row = array();
                
                $keys = array_keys($query_row);

                for( $i = 0; $i < count( $query_row ); $i++ ) {

                    $current_row += [$params[$i][1] => $query_row[$keys[$i]]];
                    
                }
                $rows[] = $current_row;
            }
        } else {

            //creazione di un oggetto Table della tipologia corretta
            $current_table = new RegioneTable();
            
            //creazione del testo della query del contenuto della tabella
            $sql_text = "SELECT  ";
            foreach( $current_table->getParameters() as $param ) {
                $sql_text .= $param[2].",";
            }

            $sql_text .= " codice_regione FROM dati_province dati INNER JOIN regioni reg ON reg.denominazione = dati.denominazione_regione WHERE data = '".$_GET['data']."' AND url_encoded =\"".$_GET['location']."\" AND sigla_provincia != \"\"";

            //echo $sql_text;


            //esecuzione della query
            $result = $GLOBALS['COVID_IT_DB_CONN']->query("$sql_text");
            
                        //parametri attuali
                        $params = $current_table->getParameters();

                        while($query_row = $result->fetch_assoc()) {
                            $current_row = array();
                            
                            $keys = array_keys($query_row);
            
                            for( $i = 0; $i < count( $query_row ) - 1; $i++ ) {
            
                                $current_row += [$params[$i][1] => $query_row[$keys[$i]]];
                                
                            }
                            $rows[] = $current_row;
                        }
        }
        

    }
    
    $table = array( "total" => count($rows),
                    "totalNotFiltered" => count($rows),
                    "rows"=> $rows);
                        
    $json_table_text = json_encode($table);
    print_r($json_table_text);

}

?>