<?php

class Config_model extends MY_Model
{
  public function __construct()
  {
    parent::__construct();
    $this->table_name = 'album_config';
  }
}