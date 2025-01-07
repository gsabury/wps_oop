<?php

class WPS_Factory
{

    public static function build( $class_name )
    {
        //$class_name = > settings
        //$class_name = > optimizer
        //$class_name = > mellat
        //$class_name = > zarinpal
        $final_class_to_create = 'WPS_' . ucfirst( $class_name ); // settings => WPS_Settings
        if ( class_exists( $final_class_to_create ) ) {
            return new $final_class_to_create();
        }
    }

}