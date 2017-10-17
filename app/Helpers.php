<?php

namespace App;

class Helpers
{
    //limit for fetching journals
    public static $iLimit = 5;

    public static function isCurrPage( $sPath )
    {
        // "/" === "/"
        if ( request()->path() === $sPath ) {
            return '#';
        }
        // "/" !== "/about"
        return url( $sPath );
    }

    public static function isActive( $sPath ) {
        if( request()->path() === $sPath ) {
            return 'is-active';
        }
        return '';
    }
}
