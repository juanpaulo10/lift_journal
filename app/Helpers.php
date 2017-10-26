<?php

namespace App;
use Redis;

class Helpers
{
    //limit for fetching journals
    public static $iLimit = 5;
    public static $sIsActive = 'is-active';
    public static $sEmptyStr = '';

    private static function isFullUrl( $sPath )
    {
        if( request()->fullUrl() === $sPath ) return true;
        return false;
    }

    private static function isCurrPath( $sPath )
    {
        if( request()->path() === $sPath ) 
            return true;
        return false;
    }

    /**
     * for <a href="#"> tags
     * check if the curr page is the requested path
     *
     * @param [type] $sPath
     * @return boolean
     */
    public static function isCurrPage( $sPath )
    {
        // request path "/" === $sPath "/posts"
        if ( self::isCurrPath($sPath) === true ) {
            return '#';
        }
        // "/" !== "/about"
        return url( $sPath );
    }

    /**
     * for <li class="is-active"> tags 
     * check if the curr page is requested path
     *
     * @param [type] $sPath
     * @return boolean
     */
    public static function isActive( $sPath ) {
        if( self::isCurrPath($sPath) === true ) {
            return self::$sIsActive;
        }
        return self::$sEmptyStr;
    }

    public static function isActiveFull( $sPath ) {
        if( self::isFullUrl($sPath) === true ) {
            return self::$sIsActive;
        }
        return self::$sEmptyStr;
    }

    /**
     * for redis publishing events
     *
     * @param [type] $sEvent
     * @param [type] $oData
     * @return array on exception
     */
    public static function RedisPublish($sEvent, $oData)
    {
        try{
            $oRedis = Redis::connection();
            //publish to redis server with dynamic event and data
            $oRedis->publish($sEvent, json_encode($oData));
        }catch( \Exception $e ) {
            self::msgPublished();
        }
    }

    /**
     * for returning data
     *
     * @return array
     */
    public static function msgPublished()
    {
        return ['message' => 'Journal Published!'];
    }
}
