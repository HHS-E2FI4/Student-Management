<?php
namespace Core\Helper;

abstract class HelperAbstract
{
    public function convertUmlauts( $phrase )
    {
        $mapping = array(
                            "ä" => "ae",
                            "ü" => "ue",
                            "ö" => "oe",
                            "Ä" => "Ae",
                            "Ü" => "Ue",
                            "Ö" => "Oe",
                            "ß" => "ss",
                    );
        
        return strtr($phrase, $mapping);
    }
    
    public function convertEncoding( $phrase, $toEncoding = 'UTF-8', $fromEncoding = null )
    {
        $converted = null;
        if( null === $fromEncoding ) {
            $toEncoding = mb_detect_encoding($phrase);
        }
        if( $toEncoding == $fromEncoding ) {
           $converted = $phrase;
        } else {
            $converted = mb_convert_encoding($phrase, $toEncoding, $fromEncoding);
        }
        return $converted;
    }
}