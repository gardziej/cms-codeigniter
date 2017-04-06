<?php

class MaskTrait {
    public $nazwa = '';
}

class Trait_model extends MY_Model
{
    public function __construct ()
    {
        parent::__construct();
        $this->langs = $this->languages->getLangs();
    }

    public function getTraits($lang, $type = false)
    {
        $this->db->select('nazwa, nazwa_frd, id, kolor, font');
        $this->db->from('traits');
        $this->db->join('traits_lang', 'traits.id = traits_lang.id_trait');
        $this->db->where('traits_lang.lang', $lang);
        $this->db->where('traits.status', 0);
        if ($type) $this->db->where('traits.typ', $type);
        $this->db->order_by('traits.kolej', 'DESC');
        $result = $this->db->get()->result();
        return $result;
    }

    public function getTraitsForPages($lang, $type = false)
    {
        $res = array();

        $this->db->select('nazwa, nazwa_frd, kolor, font, id_page, id');
        $this->db->from('traits');
        $this->db->join('traits_con', 'traits.id = traits_con.id_trait');
        $this->db->join('traits_lang', 'traits.id = traits_lang.id_trait');
        $this->db->where('traits.status', 0);
        if ($type) $this->db->where('traits.typ', $type);
        $this->db->where('traits_lang.lang', $lang);
        $this->db->order_by('traits.kolej');

        $result = $this->db->get()->result_array();

        if ($result) foreach ($result AS $r)
            {
                $res[$r['id_page']][] = $r;
            }

        return $res;
    }

    public function getTraitsForPage($page_id, $lang, $type = false)
    {
        $this->db->select('id, nazwa, typ, nazwa_frd, kolor, font');
        $this->db->from('traits');
        $this->db->join('traits_con', 'traits.id = traits_con.id_trait');
        $this->db->join('traits_lang', 'traits.id = traits_lang.id_trait');
        $this->db->where('traits_con.id_page', $page_id);
        $this->db->where('traits.status', 0);
        if ($type) $this->db->where('traits.typ', $type);
        $this->db->where('traits_lang.lang', $lang);
        $this->db->order_by('traits.kolej');

        $result = $this->db->get()->result_array();
        return $result;
    }

    public function getTraitsForMenu($lang)
    {
        $traits = array ();
        $this->db->select('id, nazwa_frd');
        $this->db->from('traits');
        $this->db->join('traits_lang', 'traits.id = traits_lang.id_trait');
        $this->db->where('traits_lang.lang', $lang);
        $this->db->order_by("kolej", "asc");
        $query = $this->db->get();
        $traits_result = $query->result_array();

        foreach ($traits_result AS $f)
            {
                $traits[$f['id']] = $f['nazwa_frd'];
            }

        return $traits;
    }

    public function getPagesWithTrait($id)
    {
        $res = array();
        $this->db->select('id_page');
        $this->db->from('traits_con');
        $this->db->where('id_trait', $id);
        $result = $this->db->get()->result_array();
        foreach ($result AS $r)
            {
                $res[] = $r['id_page'];
            }
        return $res;
    }

    public function IdToFrd($id, $lang)
    {
        $this->db->select('nazwa_frd');
        $this->db->from('traits_lang');
        $this->db->where('id_trait', $id);
        $this->db->where('lang', $lang);
        $result = $this->db->get()->result_array();
        if ($result && isSet($result[0]))
            {
                return $result[0]['nazwa_frd'];
            }
            else return false;
    }

    public function findDestinationInTraits($method)
    {
        $this->db->select('id_trait');
        $this->db->from('traits_lang');
        $this->db->where('nazwa_frd', $method);
        $query = $this->db->get();
        $result = $query->result_array();
        if (isSet($result[0]))
            {
                $data = array (
                    'type' => 'trait',
                    'id' => $result[0]['id_trait']
                );
                return $data;
            }

        return false;
    }

    public function checkIfTraitsCon ($page_id, $trait_id)
    {
        $this->db->from('traits_con');
        $this->db->where('id_trait', $trait_id);
        $this->db->where('id_page', $page_id);
        $query = $this->db->get();

        $result = $query->result();
        if (count($result) > 0) return true;
        else return false;
    }

    public function setTraitsCon ($page_id, $trait_id)
    {
        if ($this->checkIfTraitsCon ($page_id, $trait_id))
            {
                return true;
            }

        $data = array (
            'id_trait' => $trait_id,
            'id_page' => $page_id,
            'dodano' => date('Y-m-d H:i:s')
        );
        $this->db->insert('traits_con', $data);
    }

}
