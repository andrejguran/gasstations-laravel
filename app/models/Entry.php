<?php
class Entry extends Eloquent
{
  protected $table = 'entries';

  protected $fillable = array('station_id', 'fuel', 'price', 'added');

  public function station()
  {
      return $this->belongsTo('Station', 'station_id');
  }

}