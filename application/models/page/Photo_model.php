<?php

class MaskPhoto {
    public $nazwa = '';
}

class Photo_model extends MY_Model
{

    public function __construct ()
    {
        parent::__construct();
        $this->load->library('languages');
        $this->langs = $this->languages->getLangs();
    }

    public function getPhotos ($id, $lang)
    {
        $photos = array();
        $this->db->from('pages_zdjecia');
        $this->db->where('id_page', $id);
        $this->db->order_by("kolej", "desc");
        $query = $this->db->get();
        $photos = $query->result_array();

        $this->db->from('pages_zdjecia_lang');
        $this->db->where('lang', $lang);
        $result = $this->db->get()->result_array();
        if ($result) foreach ($result AS $r)
            {
                $lang_data[$r['id_photo']] = $r['nazwa'];
            }

        foreach ($photos AS $k => $p)
        {
            if (isSet($lang_data[$p['id']])) $photos[$k]['nazwa'] = $lang_data[$p['id']];
        }

        return $photos;
    }

    public function getFirstPhotos ($lang)
    {
        $photos = array();

        $result = $this->db->query('SELECT plik, icon, crop, t.id_page, COUNT(id) AS ile
        FROM (SELECT * FROM pages_zdjecia ORDER BY kolej DESC) t GROUP BY t.id_page DESC')->result_array();

        if ($result) foreach ($result AS $f)
            {
                $photos[$f['id_page']] = $f;
            }

        return $photos;
    }

    public function getOneRecord ($id)
    {
        $this->db->from('pages_zdjecia');
        $this->db->where('id', $id);
        $query = $this->db->get();
        $result = $query->result_array();
        if (isSet($result[0])) return $result[0];
        return false;
    }

    public function getPhotosCountList ()
    {
        $this->db->select('id_page, COUNT(id) as ile');
        $this->db->group_by('id_page');
        $query = $this->db->get('pages_zdjecia');
        return $query->result();
    }


    public function addPhoto ($d)
    {

        $data = array (
            'id_page' => $d['page_id'],
            'plik' => $d['file_name'],
            'icon' => $d['icon_name'],
            'crop' => $d['crop_name'],
            'waga' => $d['file_size'],
            'rozszerzenie' => str_replace('.','',$d['file_ext']),
            'dodano' => date('Y-m-d H:i:s')
        );
        $this->db->insert('pages_zdjecia', $data);
        $id_photo = $this->db->insert_id();

        $this->addLangData($id_photo, $d['name']);

    }


    public function addLangData ($id_photo, $nameData)
    {
        if (is_string($nameData))
            {
            foreach ($this->langs AS $lang_id => $lang)
                {
                    $nameData = clear_text($nameData);
                    $data = array (
                        'id_photo' => $id_photo,
                        'lang' => $lang_id,
                        'nazwa' => $nameData
                    );
                    $this->db->insert('pages_zdjecia_lang', $data);
                }
            }
            else if (is_array($nameData))
            {
                foreach ($this->langs AS $lang_id => $lang)
                    {
                        if (isSet($nameData[$lang_id], $nameData[$lang_id]->nazwa))
                            {
                                $copyName = $nameData[$lang_id]->nazwa;
                            }
                            else
                            {
                                $copyName = '';
                            }

                        $copyName = clear_text($copyName);
                        $data = array (
                            'id_photo' => $id_photo,
                            'lang' => $lang_id,
                            'nazwa' => $copyName
                        );
                        $this->db->insert('pages_zdjecia_lang', $data);
                    }
            }
    }

}
