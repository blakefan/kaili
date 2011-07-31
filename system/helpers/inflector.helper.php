<?php  if (!defined('ROOT')) exit('No direct script access allowed');

/**
 * HTML Helpers
 *
 * @package		Kaili
 * @subpackage	Helpers
 * @category	Helpers
 * @author		Luigi Marco Simonetti
 */

/**
 * Transform a word from plural to singular form
 * @param string $str a word
 * @return string
 */
if(!function_exists('singular'))
{
    function singular($str)
    {
        $str = strtolower($str);
        $last_letters = substr($str, -3);
        if($last_letters == 'ies')
            return substr($str, 0, -3).'y';
        else if($last_letters == 'ses')
            return substr($str, 0, -2);
        else{
            $last_letters = substr($str, -1);
            if($last_letters == 's')
                return substr($str, 0, -1);            
        }
        return $str;
    }
}

/**
 * Transform a word from singular to plural form
 * @param string $str a word
 * @return string
 */
if(!function_exists('plural'))
{
    function plural($str)
    {
        $str = strtolower($str);
        $last_letter = substr($str, -1);
        switch($last_letter)
        {
            case 'y':
                $vowels = array('a','e','i','o','u');
                if(in_array(substr($str, -2, 1), $vowels))
                    return $str.'s';
                else
                    return substr($str,0,-1).'ies';
                break;
            case 's':
                return $str.'es';
                break;
            default:
                return $str.'s';            
        }
    }
}
