<?php

class Banner_model extends MY_Model
{
    public function __construct ()
    {
        parent::__construct();
    }

    public function getBanners ($lang)
    {
        $this->db->select('id, zone, plik, link, link_target, nazwa');
        $this->db->from('banners');
        $this->db->join('banners_lang', 'banners.id = banners_lang.id_banner');
        $this->db->where('banners_lang.lang', $lang);
        $this->db->where('banners.status', 0);
        $this->db->order_by("kolej", "desc");
        $query = $this->db->get();
        $banners_result = $query->result_array();

        $this->db->select('*');
        $this->db->from('banners_con');
        $query = $this->db->get();
        $banners_con_result = $query->result_array();
        foreach ($banners_con_result AS $f)
            {
                $cons[$f['id_banner']][] = $f['id_trait'];
            }

        $banners = array();
        foreach ($banners_result AS $f)
            {
                $f['cat_only'] = array();
                if (isSet($cons[$f['id']])) $f['cat_only'] = $cons[$f['id']];
                $banners[$f['zone']][] = $f;
            }

        return $banners;
    }
}
