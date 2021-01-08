<?php


/*
 *  Data:               04 / 11 / 2020
 *  Descrizione:        Sanitizzazione di stringhe
 */
Class Sanitizer {
    
    /*
     *  Nome:               encode( $name, $rules )
     *  Descrizione:        Sostituzione di caratteri e sottostringhe in una
     *                      stringa, secondo il parametro $rules
     *  Parametri:          
     *                      $name: Stringa in cui fare l'encode
     *                      $rules: Array di stringhe. La stringa chiave
     *                              viene sostituita con la stringa valore.
     *  Return:             Stringa sanitizzata
     */
    public static function encode( $name, $rules ) {
        $encoded_name = $name;
        
        foreach( $rules as $str => $substitute ) {
            $encoded_name = str_replace( $str, $substitute, $encoded_name );
        }
        
        $encoded_name = strtolower( $encoded_name );
        
        return $encoded_name;
    }
    
    
    /*
     *  Nome:               encode_url_name( $name )
     *  Descrizione:        Trasformazione di una stringa in url encode
     *  Parametri:          
     *                      $name: Stringa in cui fare l'encode
     *  Return:             Stringa sanitizzata
     */
    public static function encode_url_name( $name ) {
        $encoded_name = Sanitizer::encode( $name,
                                            array( 
                                                    " " => "-",
                                                    "." => "",
                                                    "'" => "-" 
                                                 ) 
                                         );
        return strtolower( $encoded_name );
    }
    
}


?>