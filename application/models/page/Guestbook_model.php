<?php

class Guestbook_model extends MY_Model
{

    public function __construct ()
    {
        parent::__construct();
        $this->load->library('languages');
        $this->langs = $this->languages->getLangs();
        $this->main_lang = $this->languages->getMainLang();
    }

    public function getPosts ($lang)
    {
        $posts = array();
        $this->db->from('guestbook');
        $this->db->where('status', 0);
        $this->db->where('lang', $lang);
        $this->db->order_by("status", "desc");
        $this->db->order_by("id", "desc");
        $posts = $this->db->get()->result_array();
        return $posts;
    }

    public function addPost ($d)
    {
        $data = array (
            'status' => 9,
            'autor' => $d['autor'],
            'tekst' => $d['tekst'],
            'lang' => $d['lang'],
            'dodano' => date('Y-m-d H:i:s')
        );

        $return = $this->db->insert('guestbook', $data);
        $id_post = $this->db->insert_id();
        return $return;
    }

}
