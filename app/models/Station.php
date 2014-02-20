<?php
class Station extends Eloquent
{
  protected $table = 'stations';

  protected $fillable = array('cbid', 'name', 'region', 'city', 'address', 'latitude', 'longtitude');

  public function entries()
  {
      return $this->hasMany('Entry', 'station_id');
  }

}