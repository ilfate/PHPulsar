<?php

/**
 * Класс позволяет создовать события и привязывать Js код к ним
 * Например
 * Js::add(Js::C_ONLOAD, '$("#inner-content").hide().toggle(1000)');
 */

Class Js
{
  /** Событие вызывается при загрузке страницы без аякса*/
  const C_ONLOAD = 'onload';
  /** Событие вызывается при загрузке страницы без аякса после C_ONLOAD*/
  const C_ONAFTERLOAD = 'onafterload';

  /** Событие вызывается при загрузке страницы через аякс*/
  const C_AJAXONLOAD = 'ajaxonload';

  /** Событие вызывается при загрузке страницыч ерез аякс. Вызывается ПОСЛЕ C_AJAXONLOAD, в этот момент загружены все сопряженные css, js*/
  const C_AJAXLOADCOMPLETED = 'ajaxloadcompleted';

  /** Событие срабатывает при ресайзе страницы */
  const C_ONRESIZE = 'onresize';

  /** Событие срабатывает при ресайзе страницы. Добавляется из страниц, загруженных через ajax */
  const C_AJAXONRESIZE = 'ajaxonresize';
  
  private static $events = array();
  // type="text/javascript"
  //Возможные события
  public static $handledEvents = array ('onload', 'onresize', 'ajaxonload', 'ajaxonresize', 'ajaxloadcompleted', 'onmousedown');
  
  
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
      }
      else  Logger::error('Попытка присвоить js скрипт несуществующему событию '.$eve);
    }
    
  }
  
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


Class JsEvent
{
  public $name;
  
  
  public function __construct($name)
  {
    $this->name = $name;
  }
}


?>
