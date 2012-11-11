<?php
/**
 * ILFATE PHP ENGINE
 * @autor Ilya Rubinchik ilfate@gmail.com
 * 2012
 */

/**
 * Description of CoreLogger
 *
 * @author ilfate
 */
class CoreLogger_Sql
{
  private $started = 0;
  
  private $query_log = array();
  
  public function addQuery()
  {
    
  }
  
  public function getLog()
  {
    return $this->query_log;
  }
  
  public function start($query)
  {
    if($this->started)
    {
      throw new CoreException_Error('Error due CoreLogger_Sql. Double starter timer');
    }
    $this->started = microtime(true);
    
    $this->query_log[] = array('query' => $query, 'time' => $this->started);
  }
  
  public function finish()
  {
    $this->started = 0;
    $key = sizeof($this->query_log)-1;
    $this->query_log[$key]['time'] = microtime(true) - $this->query_log[$key]['time'];
  }
}


?>
