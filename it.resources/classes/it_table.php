<?php 

include_once '/home/covid/resources/classes/table.php';
include_once '/home/covid/it.resources/classes/sanitizer.php';

Class ItTable extends Table {
    
    //location specififca a che continent appartengono le nazioni.
    private $location;
    
    //data di visualizzazione dei dati
    private $date;
    
    //costruttore overloaded
    public function __construct( $location = "", $date = "" ) {
        
        //sanitizzazione della location
        $this->location = Sanitizer::encode_url_name( $location );
        
        $this->date = $date;
        
        //chiamata al costruttore di Table
        parent::__construct(    $location, 
                                array(
                                    array( "REGIONE", "regione", "denominazione_regione" ),
                                    array( "CASI TOTALI", "Casi_Totali", "totale_casi" ),
                                    array( "POSITIVI ATTUALI", "Positivi_Attuali", "totale_positivi" ),
                                    array( "DECEDUTI", "Deceduti", "deceduti" ),
                                    array( "CASI TESTATI", "Casi_Testati", "casi_testati" ),
                                    array( "TAMPONI", "Tamponi", "tamponi" ),
                                    array( "TERAPIA INTENSIVA", "Terapia_Intensiva", "terapia_intensiva" ),
                                    array( "GUARITI", "Guariti", "dimessi_guariti" )
                                ),
                                "https://it.covidtracker2020.live/table_json_data.php?data=$this->date&location=$this->location&tipo=div");
    
        
    }
    
    //-----
    
    //metodi GETTER - SETTER
    
    function getLocation() {
        return $this->location;
    }
    
    function setLocation( $location ) {
        $this->location = $location;
    }
    
    function getDate() {
        return $this->date;
    }
    
    function setDate( $date ) {
        $this->date = $date;
    }
    
}

Class RegioneTable extends Table {
    
    //location specififca a che continent appartengono le nazioni.
    private $location;
    
    //data di visualizzazione dei dati
    private $date;
    
    //costruttore overloaded
    public function __construct( $location = "", $date = "" ) {
        
        //sanitizzazione della location
        $this->location = Sanitizer::encode_url_name( $location );
        
        $this->date = $date;
        
        //chiamata al costruttore di Table
        parent::__construct(    $location, 
                                array(
                                    array( "PROVINCIA", "provincia", "denominazione_provincia" ),
                                    array( "SIGLA", "sigla", "sigla_provincia" ),
                                    array( "CASI_TOTALI", "Casi_Totali", "totale_casi" )
                                ),
                                "https://it.covidtracker2020.live/table_json_data.php?data=$this->date&location=$this->location&tipo=div");
    
        
    }
    
    //-----
    
    //metodi GETTER - SETTER
    
    function getLocation() {
        return $this->location;
    }
    
    function setLocation( $location ) {
        $this->location = $location;
    }
    
    function getDate() {
        return $this->date;
    }
    
    function setDate( $date ) {
        $this->date = $date;
    }
    
}

?>