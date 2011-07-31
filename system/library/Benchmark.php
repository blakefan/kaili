<?php  if (!defined('ROOT')) exit('No direct script access allowed');

/**
 * Kaili Benchmark Class
 *
 * Class to manage benchmark of php scripts and to time method's execution.
 *
 * @package		Kaili
 * @subpackage	Library
 * @category	Library
 * @author		Luigi Marco Simonetti
 */

class Benchmark
{
    private $_time_start;
    private $_checkpoints;
    private static $_instance = null;
    
    /**
     * Create new Benchmark object
     */
    function __construct()
    {
        $this->_checkpoints = array();
    }
    
    /**
     * Set the first checkpoint
     */
    function start()
    {
        $this->_time_start = $this->timestamp();
    }
    
    /**
     * Set a new checkpoint
     * @param string the checkpoint's name
     */
    function checkpoint($name)
    {
        $this->_checkpoints[$name] = $this->timestamp();
    }
    
    /**
     * Returns elapsed time betwen two checkpoints. Start and end checkpoints are optional,
     * if start is null, is considered the forst checkpoint, if end is null, a new 
     * checkpoint is created and considered as end checkpoint.
     * 
     * @param string name of start checkpoint
     * @param string name of end checkpoint
     * @return int elapsed time, in milliseconds
     */
    function elapsed_time($start = null, $end = null)
    {
        if($start == null) $t_start = $this->_time_start;
        else $t_start = $this->_checkpoints[$start];
        
        if($end == null) $t_end = $this->timestamp();
        else $t_end = $this->_checkpoints[$end];
        
        return round($t_end - $t_start, 3);
    }
    
    /**
     * Return the current timestamp
     * 
     * @return the current timestamp, in milliseconds
     */
    private function timestamp()
    {
        date_default_timezone_set('Europe/Rome');
        $timeofday = gettimeofday();
        $ms = 1000*($timeofday['sec'] + ($timeofday['usec'] / 1000000));
        return $ms;
    }
    
    static function get_instance()
    {
        if(self::$_instance == null){
            self::$_instance = new Benchmark();
        }
        return self::$_instance;
    }
}

/* End of file Benchmark.php */
/* Location: ./system/library/Benchmark.php */
