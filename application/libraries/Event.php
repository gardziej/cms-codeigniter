<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Event {

    private $data = array (
        'event_start_full_date' => '',
        'event_end_full_date' => '',
        'event_time_start' => '',
        'event_time_end' => '',
        'event_start_day' => '',
        'event_start_month' => '',
        'event_end_day' => '',
        'event_end_month' => '',
        'event_tytul' => '',
        'event_tytul_frd' => '',
        'event_tags' => '',
        'event_location_data' => '',
        'event_lat' => '',
        'event_lng' => '',
        'event_organizer' => '',
        'event_country' => ''
    );

    private $monthNames = ['Sty','Lut','Mar','Kwi','Maj','Cze','Lip','Sie','Wrz','Paź','Lis','Gru'];
    private $monthFullNames = ['Styczeń','Luty','Marzec','Kwiecień','Maj','Czerwiec','Lipiec','Sierpień','Wrzesień','Październik','Listopad','Grudzień'];

    function __construct()
    {

    }

    public function getEmptyEvent()
    {
        return $this->data;
    }

    public function getEvent($data, $oneDay = false)
    {
        $ret = $this->data;

        $event_start = new DateTime($data['event_start']);
        $event_end = new DateTime($data['event_end']);

        $ret['event_location_data'] = $data['event_location'];
        $ret['event_country'] = $data['event_country'];
        $ret['event_lat'] = $data['event_lat'];
        $ret['event_lng'] = $data['event_lng'];
        $ret['event_tytul'] = $data['tytul'];
        $ret['event_tytul_frd'] = $data['tytul_frd'];
        $ret['event_organizer'] = $data['event_organizer'];
        $ret['event_country'] = $data['event_country'];

        if (isSet($data['tags']))
            {
                foreach ($data['tags'] AS $tag)
                    {
                        $tags[] = $tag['nazwa'];
                    }
                $ret['event_tags'] = implode(', ', $tags);
            }


        if ($oneDay && $this->sameDay($event_start, $event_end))
            {
                if ($this->hasTime($event_start)) $ret['event_time_start'] = $this->getTime($event_start);
                if ($this->hasTime($event_end)) $ret['event_time_end'] = $this->getTime($event_end);
            }
        else if ($oneDay && $this->hasTime($event_start))
            {
                $ret['event_start_full_date'] = $this->getDay($event_start).' '.$this->getMonthName($event_start);
                $ret['event_time_start'] = $this->getTime($event_start);
                if ($this->hasTime($event_end)) $ret['event_time_end'] = $this->getTime($event_end);
                $ret['event_end_full_date'] = $this->getDay($event_end).' '.$this->getMonthName($event_end);
            }
        else if ($this->sameDay($event_start, $event_end))
            {
                $ret['event_start_day'] = $this->getDay($event_start);
                $ret['event_start_month'] = $this->getMonthName($event_start);
            }
        else
            {
                $ret['event_start_day'] = $this->getDay($event_start);
                $ret['event_start_month'] = $this->getMonthName($event_start);
                $ret['event_end_day'] = $this->getDay($event_end);
                if (!$this->sameMonth($event_start, $event_end)) $ret['event_end_month'] = $this->getMonthName($event_end);
            }

        if ($ret['event_time_end'] !== '') $ret['event_time_end'] = '- '.$ret['event_time_end'];
        if ($ret['event_end_day'] !== '') $ret['event_end_day'] = '- '.$ret['event_end_day'];

        return $ret;

    }

        public function hasTime (DateTime $date)
        {
            if ($date->format('H:i:s') !== '00:00:00') return true;
            return false;
        }

        public function sameDay (DateTime $d1, DateTime $d2)
        {
            if ($d1->format('Y-m-d') === $d2->format('Y-m-d')) return true;
            return false;
        }

        public function sameMonth (DateTime $d1, DateTime $d2)
        {
            if ($d1->format('Y-m') === $d2->format('Y-m')) return true;
            return false;
        }

        public function getTime (DateTime $date)
        {
            return $date->format('H:i');
        }

        public function getDay (DateTime $date)
        {
            return $date->format('j');
        }

        public function getMonthName (DateTime $date)
        {
            $n = $date->format('n') -1;
            return $this->monthNames[$n];
        }

}
