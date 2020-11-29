<?php

    if ( ! defined( 'ABSPATH' ) ) { exit;}

    class DE_DB_WOO
        {
            var $licence;

            var $interface;

            /**
            *
            * Run on class construct
            *
            */
            function __construct( )
                {
                    // $this->licence              =   new DE_DB_WOO_licence();
                    //
                    // $this->interface            =   new DE_DB_WOO_options_interface();

                }

            static function log_data( $data )
                {

                    $data   =   (array)$data;

                    $fp = fopen( DE_DB_WOO_PATH . '/log.txt', 'a');


                    foreach($data   as  $key    =>  $line)
                        {
                            $key    =   trim($key);

                            if(!empty($key))
                                fwrite($fp, $key . " " . $line ."\n");
                                else
                                fwrite($fp, $line ."\n");
                        }

                    fclose($fp);


                }


        }



?>
