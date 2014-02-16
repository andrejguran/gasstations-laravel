<?php

use CeskyBenzin\Feed;

class FeedController extends BaseController {

    protected $feeder;

    public function __construct() {
        $this->feed = new Feed;
    }

    public function feed()
    {
        set_time_limit(0);
        $start_time = time();
        $start = memory_get_usage();
        $this->feed->getStationsData();
        $this->feed->feedStations();
        var_dump("time: ". (time() - $start_time));
    }

    public function getStationData($cbid, $fuel = 3)
    {
        return $this->feed->getStationData($cbid, $fuel = 3);
    }

    public function feedStation($cbid)
    {
        return $this->feed->feedStation($cbid);
    }


}