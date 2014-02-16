<?php

namespace CeskyBenzin;

use Station;
use Entry;

class Feed {

    protected $stations = array();

    public function getStations() {
        return $this->stations;
    }

    public function feedStations()
    {
        foreach ($this->stations as $cbid => &$station) {
            if (false === Station::where('cbid', $cbid)->exists()) {
                Station::create($station);
            }


            $station['numEntries'] = $this->feedStation($cbid);
        }

        return count($this->stations);
    }

    public function feedStation($cbid, $fuel = 1)
    {
        $entries = $this->getStationData($cbid, $fuel);

        foreach ($entries as $entry) {
            $station = Station::where('cbid', $cbid)->with(array('entries' => function($query) use($entry) {
                            $query->where('price', '=', $entry['price'])
                                  ->where('fuel', '=', $entry['fuel'])
                                  ->where('added', '=', $entry['added']);
                        }))->first();

            if (null !== $station && 0 === $station->entries->count()) {
                $entry['station_id'] = $station->id;
                Entry::create($entry);
            }
        }

        return count($entries);
    }

    public function getStationsData($url = 'http://www.ceskybenzin.cz/mapa/0')
    {
        $site =  $this->file_get_contents_curl($url);

        $stations = array();

        $pattern = "/var bublina = '(.*?)<br>(.*?)<br>(.*?)<br>(.*?)<br>.*\s.*'green', (\d{1,6}), bublina, 0 \);.*\s.*google\.maps\.LatLng\(([0-9]{2}\.[0-9]{0,10}), ([0-9]{2}\.[0-9]{0,10})\);/m";

        $i = 0;

        while (preg_match($pattern, $site, $matches)) {
            $site = str_replace($matches[0], "", $site);
            unset($matches[0]);
            $stations[(int)$matches[5]]['cbid'] = $matches[5];
            $stations[(int)$matches[5]]['name'] = $matches[1];
            $stations[(int)$matches[5]]['city'] = $matches[2];
            $stations[(int)$matches[5]]['address'] = $matches[3];
            $stations[(int)$matches[5]]['latitude'] = $matches[6];
            $stations[(int)$matches[5]]['longtitude'] = $matches[7];
        }

        $this->stations = $stations;

        return count($this->stations);
    }

    public function getStationData($cbid, $fuel = 1)
    {
        $url = 'http://www.ceskybenzin.cz/cenapumpagraf2.php?id='.$cbid.'&palivo='.$fuel;

        $fuels = array(
            1 => 'Natural 95',
            3 => 'Nafta'
        );

        $data = $this->file_get_contents_curl($url);

        $noStart = substr($data, strpos($data, 'ceny = [') + 9);

        if (strlen($noStart) < 30)
            return array();

        $prices = substr($noStart, 0, strpos($noStart, '];') - 1);

        $prices = str_replace('],[', ';', $prices);
        $prices = explode(';', $prices);

        $entries = array_map(function($a) use($fuels, $fuel){
            if ($a == '') return;

            $data = explode(',', $a);

            $entry = array(
                'added' => date('Y-m-d', (int)$data[0]),
                'price' => $data[1],
                'fuel' => $fuels[$fuel]
            );

            return $entry;
        }, $prices);

        return $entries;
    }


    protected function file_get_contents_curl($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:23.0) Gecko/20100101 Firefox/23.0');
        curl_setopt($ch, CURLOPT_URL, $url);
        $data = curl_exec($ch);
        curl_close($ch);
        return  iconv('windows-1250', 'utf-8', $data);
    }
}