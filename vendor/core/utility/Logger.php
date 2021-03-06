<?php

namespace vendor\core\utility;

use Throwable;

final class Logger
{
    private function __construct() { }

    private const SEPERATOR       = "------------------------------------------------------------------------------------------------------------------------------";
    private const SMALL_SEPERATOR = "----";
    private const ENDLINE         = PHP_EOL;


    private static $append;
    private static $logPath;

    public static function initialize()
    {
        self::$logPath = ROOT . "/" . "log.txt";
    }

    private static function writeException( Throwable $throwable, int $tabCount = 0 ) : string
    {
        $result = "";

        $result .= self::tabLine( "Exception", $tabCount );
        $result .= self::tabLine( "Type: " . get_class( $throwable ), $tabCount );
        $result .= self::tabLine( "Message: " . $throwable->getMessage(), $tabCount );
        $result .= self::tabLine( "File: " . $throwable->getFile(), $tabCount );
        $result .= self::tabLine( "Line: " . $throwable->getLine(), $tabCount );
        $result .= self::tabLine( "Code: " . $throwable->getCode(), $tabCount );
        if( $throwable->getPrevious() !== null )
        {
            $result .= self::tabLine( "Inner exception: ", $tabCount );
            $result .= self::writeException( $throwable->getPrevious(), $tabCount + 1 );
        }
        else
            $result .= self::tabLine( "Inner exception: null", $tabCount );

        for( $i = 0; $i < $tabCount; $i++ )
            $result .= self::SMALL_SEPERATOR;

        return $result;
    }

    private static function tabLine( string $string, int $tabCount = 0 ) : string
    {
        $result = "";

        while( $tabCount )
        {
            $result .= "    ";
            --$tabCount;
        }

        return $result . "|" . $string . self::ENDLINE;
    }

    public static function log( string $message, Throwable $throwable = null ) : void
    {
        $log = self::ENDLINE."Date: " . date( DATE_RFC822 ) . self::ENDLINE;
        $log .= self::writeException( $throwable );
        $log .= self::SEPERATOR;
        file_put_contents( self::$logPath, $log, FILE_APPEND );
    }

    public static function message( string $message = "", $object = null ) : void
    {
        $log = "Date: " . date( DATE_RFC822 ) . self::ENDLINE;
        $log .= "Message: {$message}" . self::ENDLINE;
        $log .= self::SEPERATOR . self::ENDLINE;
        $log .= $object . self::ENDLINE . self::SEPERATOR . self::ENDLINE;
        file_put_contents( self::$logPath, $log, FILE_APPEND );
    }
}