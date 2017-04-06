<?php

class Friendlink_model extends MY_Model
{

    public function __construct ()
    {
        parent::__construct();
    }

    public function generateName($name, $lang)
    {
        $set = array ();

        $this->db->select('tytul_frd AS frd');
        $this->db->from('pages_lang');
        $this->db->where('lang', $lang);
        $query = $this->db->get();
        $result = $query->result_array();

        foreach ($result AS $f)
            {
                $set[] = $f['frd'];
            }

        $this->db->select('nazwa_frd AS frd');
        $this->db->from('traits_lang');
        $this->db->where('lang', $lang);
        $query = $this->db->get();
        $result = $query->result_array();

        foreach ($result AS $f)
            {
                $set[] = $f['frd'];
            }

        $test = $name_frd = no_pl($name);
        $k = 1;
        while (in_array($test, $set))
            {
                $test = $name_frd.$k;
                $k++;
            }

        $name_frd = $test;
        return $name_frd;
    }


}
