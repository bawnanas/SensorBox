<?php

/*
  parses the temperature from a temperature alert type device

*/

class TemperatureAlert implements ITemperatureParser
{
  private $xml;

  public function __construct($ip_address)
  {
    try
    {
      $this->xml = simplexml_load_file($ip_address);
      if (!$this->xml)
      { 
        throw new Exception();
      }
    }

    catch(Exception $e)
    {
      Log::write('error', $e->getMessage());
    }
  }


/**
* checks if the xml file was gotten
*
* @param:
*
* @return: boolean
*/
  public function is_connected()
  {
    if ($this->xml == false)
      return false;
    else
      return true;
  }


/**
* gets the temperature at a given port
*
* @param: int
*
* @return: float
*/
  public function get_temperature($port_num)
  {
    $current_temp = floatval($this->xml->ports->port[$port_num]->condition->currentReading);
  
    return $current_temp;
  }


}
