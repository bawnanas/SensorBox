<?php

class Sample_Data_Generator implements ITemperatureParser
{
  private $xml;

  public function __construct($ip_address)
  {
      //nothing to see here, move along
  }

  public function is_connected()
  {
      return true;
  }

  public function get_temperature($port_num)
  {
    return ( 50 + lcg_value() * (abs( 100 - 50 )));
  }
}