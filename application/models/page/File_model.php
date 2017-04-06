<?php

class MaskFile {
    public $nazwa = '';
}

class File_model extends MY_Model
{

    public function __construct ()
    {
        parent::__construct();
        $this->load->library('languages');
        $this->langs = $this->languages->getLangs();
    }

    public function getFiles ($id, $lang)
    {
        $files = array();
        $this->db->from('pages_zalaczniki');
        $this->db->where('id_page', $id);
        $this->db->order_by("kolej", "desc");
        $query = $this->db->get();
        $files = $query->result_array();

        $this->db->from('pages_zalaczniki_lang');
        $this->db->where('lang', $lang);
        $result = $this->db->get()->result_array();
        if ($result) foreach ($result AS $r)
            {
                $lang_data[$r['id_file']] = $r['nazwa'];
            }

        foreach ($files AS $k => $p)
        {
            if (isSet($lang_data[$p['id']]))
                {
                    $files[$k]['nazwa'] = $lang_data[$p['id']];
                }
                else
                {
                    unset($files[$k]);
                }
        }

        return $files;
    }

    public function getOneRecord ($id)
    {
        $this->db->from('pages_zalaczniki');
        $this->db->where('id', $id);
        $query = $this->db->get();
        $result = $query->result_array();
        if (isSet($result[0])) return $result[0];
        return false;
    }

    public function getFilesCountList ()
    {
        $this->db->select('id_page, COUNT(id) as ile');
        $this->db->group_by('id_page');
        $query = $this->db->get('pages_zalaczniki');
        return $query->result();
    }

    public function getFirstFiles ($lang)
    {
        $files = array();

        $result = $this->db->query('SELECT plik, t.id_page, COUNT(id) AS ile, waga
        FROM (SELECT * FROM pages_zalaczniki ORDER BY kolej DESC) t GROUP BY t.id_page DESC')->result_array();

        if ($result) foreach ($result AS $f)
            {
                $files[$f['id_page']] = $f;
            }

        return $files;
    }

}
