<?php

namespace App;
use Redis;

class Helpers
{
    //limit for fetching journals
    public static $iLimit = 5;
    public static $sIsActive = 'is-active';
    public static $sEmptyStr = '';

    /**
     * checks if given $sPath is the current path
     *
     * @param [type] $sPath
     * @return boolean
     */
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
     * @param string $sPath
     * @param string $sRequest
     * @return boolean
     */
    public static function isCurrPage( $sPath, $sRequest = '' )
    {
        // request path "/" === $sPath "/posts"
        if ( self::isCurrPath($sPath) === true ) {
            return '#';
        }
        // "/" !== "/about"
        return url( $sPath ) . $sRequest;
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

    /**
     * checks if url request param has month and year
     * checks if the month is same with $sMonth (same with year)
     *
     * @param string $sMonth
     * @param int $iYear
     * @return 'is-active' as class for html tag
     */
    public static function isActiveByDate( $sMonth, $iYear ) {
        if( request()->exists('month') !== true || request()->exists('year') !== true ) {
            return self::$sEmptyStr;
        }

        //force iYear (int) to be (string)
        if( request('month') === $sMonth && request('year') === (string) $iYear ){
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
