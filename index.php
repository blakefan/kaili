<?php

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__FILE__));
define('SYSTEM', ROOT.DS.'system');
define('APPLICATION', ROOT.DS.'application');
define('ASSETS', ROOT.DS.'assets');
define('EXT', '.php');

if($this->_config->item('development_environment') == true) {
            error_reporting(E_ALL);
            ini_set('display_errors', 'On');
            ini_set('html_errors', 'On');
        }
        else {
            error_reporting(E_ALL & ~E_DEPRECATED);
            ini_set('display_errors', 'Off');
            ini_set('log_errors', 'On');
            ini_set('error_log', ROOT.DS.'system'.DS.'tmp'.DS.'logs'.DS.'error.log');
        }


require_once(SYSTEM.DS.'kaili'.DS.'loader'.EXT);

use Kaili\Loader;
use Kaili\Logger;



$pre_call = function() {
            $loader = Loader::get_instance();
            $loader->load('benchmark')->start();
            Logger::add('log1');
        };

$post_call = function() {
            $loader = Loader::get_instance();
//            $elapsed = $loader->library('benchmark')->elapsed_time_from_request();
//            Logger::get('log1')->info($elapsed);
        };

$loader = Loader::get_instance();
$loader->register();

$loader->load('request')->handle($pre_call, $post_call);

$loader->load('output')->display();
