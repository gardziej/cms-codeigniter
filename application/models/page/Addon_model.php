<?php

class Addon_model extends MY_Model
{
    public function __construct ()
    {
        parent::__construct();
    }

    public function getAddons ($lang)
    {
        $this->db->select('zone, tekst');
        $this->db->from('addons');
        $this->db->join('addons_lang', 'addons.id = addons_lang.id_addon');
        $this->db->where('addons_lang.lang', $lang);
        $this->db->where('addons.status', 0);
        $this->db->where('tekst !=', '');
        $this->db->order_by("kolej", "desc");
        $query = $this->db->get();
        $addons_result = $query->result_array();
        
        $addons = array();
        foreach ($addons_result AS $f)
            {
                $addons[$f['zone']][] = $f['tekst'];
            }

        return $addons;
    }
}
