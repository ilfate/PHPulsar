<?php

/**
 * Class helps to create events and execute js code
 * Example
 * Js::add(Js::C_ONLOAD, '$("#inner-content").hide().toggle(1000)');
 */

Class Js
{
  /** 
   * Event trigers on page load
   */
  const C_ONLOAD = 'onload';
  /** 
   * Event tringgers After C_ONLOAD
   */
  const C_ONAFTERLOAD = 'onafterload';

  /** 
   * Event calls on Ajax load
   */
  const C_AJAXONLOAD = 'ajaxonload';

  /** 
   * Event triggers after C_AJAXONLOAD and when loading is complitly finished
   */
  const C_AJAXLOADCOMPLETED = 'ajaxloadcompleted';

  /** 
   * event triggers on page resize
   */
  const C_ONRESIZE = 'onresize';

  /** 
   * Custom event form ajax load pages
   */
  const C_AJAXONRESIZE = 'ajaxonresize';
  
  private static $events = array();
  // type="text/javascript"
  //possible events
  public static $handledEvents = array (
    self::C_ONLOAD,
    self::C_ONAFTERLOAD,
    self::C_AJAXONLOAD,
    self::C_AJAXLOADCOMPLETED,
    self::C_ONRESIZE,
    self::C_AJAXONRESIZE
  );
  
  /**
   * Adds js code to event
   * 
   * @param String $event
   * @param String $js
   */
  public static function add($event,$js)
  {
    $js = str_replace(chr(13), "", $js);
    $js = str_replace(chr(10), "", $js);
    if(!is_array($event))
    {
      $event = array($event);
    }
    foreach ($event as $eve)
    {
      if(in_array($eve,self::$handledEvents))
      {
        if(!isset(self::$events[$eve])) self::$events[$eve] = array();
        self::$events[$eve][] = $js . ';';
      } else {  
        throw new CoreException_Error('Error on attempt to add JS code to an unexisting event named: '.$eve);
      }
    }
    
  }
  
  /**
   * Returns Html that needs to be included to page for this module normal work.
   * 
   * @return string
   */
  public static function getHtml()
  {
    $result = '';
    foreach (self::$events as $name => $scripts)
    {
      $result .= 'F.manageEvent("' . $name . '",function(event, target){' . implode(';', $scripts) . '});';
    }
    $result = '<script type="text/javascript">' . $result . '</script>';
    return $result;
  }
}


?>
