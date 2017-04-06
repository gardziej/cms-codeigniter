<?php

class Calendar_model extends MY_Model
{

    public function __construct ()
    {
        parent::__construct();
    }

    public function getLatLngCtr ($location)
    {
        if (empty($location)) return ['','',''];
        
        $string = file_get_contents("http://maps.googleapis.com/maps/api/geocode/json?address=".str_replace(" ","+",$location));
        $json = json_decode($string, true);
        if ($json && isSet($json['results'][0], $json['results'][0]['geometry']))
            {

                $lat = $json['results'][0]['geometry']['location']['lat'];
                $lng = $json['results'][0]['geometry']['location']['lng'];
                $ctr = '';

                if (isSet($json['results'][0]['address_components']))
                    {
                        foreach ($json['results'][0]['address_components'] AS $ac)
                            {
                                if (isSet($ac['types']) && in_array('country', $ac['types']))
                                    {
                                        $c = $ac;
                                    }
                            }
                    }

                $ctr = strtolower($c['short_name']);
                return array($lat, $lng, $ctr);
            }
        return false;
    }

}
