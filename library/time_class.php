<?php
  class time_class extends common_objects
  {
      public $unix_time, $stored_time;
      
      function __construct()
      {
        $unix_time = time();
                  parent::__construct();
          $this->define_class(get_class($this));
      }
      
      function record_time()
      {
        $this->stored_time = time(); 
      }
      
      function print_datetime($date_format = 'Y-m-d H:i:s')
      {
          return date($date_format, time());
      
      }
      
      function print_index($index = 0)
      {
        $today[] = date("F j, Y, g:i a");                 // March 10, 2001, 5:16 pm
        $today[] = date("m.d.y");                         // 03.10.01
        $today[] = date("j, n, Y");                       // 10, 3, 2001
        $today[] = date("Ymd");                           // 20010310
        $today[] = date('l jS, F');     // 05-16-18, 10-03-01, 1631 1618 6 Satpm01
        $today[] = date('\i\t \i\s \t\h\e jS \d\a\y.');   // it is the 10th day.
        $today[] = date("D M j G:i:s T Y");               // Sat Mar 10 17:16:18 MST 2001
        $today[] = date('H:m:s \m \i\s\ \m\o\n\t\h');     // 17:03:18 m is month
        $today[] = date("H:i:s");                         // 17:16:18
        $today[] = date("Y-m-d H:i:s");                   // 2001-03-10 17:16:18 (the MySQL DATETIME format)
      
        return $today[$index];
      }
      
      function unix_time_to_win_time($unix_time) {
     //add the seconds between 1601-01-01 and 1970-01-01 and make it 100-nanosecond precision
     $win_time = ($unix_time + 11644477200) * 10000000;
     return $win_time;
   }
   
   function time_difference($start_unix_time = '', $finish_unix_time = '')
   {
      return $this->time_duration($finish_unix_time - $start_unix_time);
   
   }
   
   function add_time($str_time = '', $add = '1', $unit = 'Secs', $date_format = 'Y-m-d H:i:s')
   {
         
         echo strtotime(date($date_format,$str_time). ' + ' . $add . ' ' . $unit) ;
         return date($date_format,strtotime(date($date_format,$str_time). ' + ' . $add . ' ' . $unit));
   
   }
   
   
   function time_duration($seconds = '', $use = null, $zeros = false)
{
    /*Converts seconds into a string of hours, days, minutes etcs*/

    // Define time periods
    $periods = array (
        'years'     => 31556926,
        'Months'    => 2629743,
        'weeks'     => 604800,
        'days'      => 86400,
        'hours'     => 3600,
        'minutes'   => 60,
        'seconds'   => 1
        );
 
    // Break into periods
    $seconds = (float) $seconds;
    $segments = array();
    foreach ($periods as $period => $value) {
        if ($use && strpos($use, $period[0]) === false) {
            continue;
        }
        $count = floor($seconds / $value);
        if ($count == 0 && !$zeros) {
            continue;
        }
        $segments[strtolower($period)] = $count;
        $seconds = $seconds % $value;
    }
 
    // Build the string
    $string = array();
    foreach ($segments as $key => $value) {
        $segment_name = substr($key, 0, -1);
        $segment = $value . ' ' . $segment_name;
        if ($value != 1) {
            $segment .= 's';
        }
        $string[] = $segment;
    }
 
    return implode(', ', $string);
}

  
  
  
  
  
  
  }
?>