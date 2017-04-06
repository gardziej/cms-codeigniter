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


    public function getEmptyPost ()
    {
        $return = (object) array(
            'id' => 0,
            'lang' => $this->main_lang,
            'tekst' => '',
            'autor' => '',
            'status' => 0
        );

        return $return;
    }

    public function getPostsToAccept ()
    {
        $this->db->from('guestbook');
        $this->db->where('status !=', 0);
        return $this->db->count_all_results();      
    }

    public function getPosts ($status = false, $lang = false)
    {
        $posts = array();
        $this->db->from('guestbook');
        if ($status) $this->db->where('status', $status);
        if ($lang) $this->db->where('lang', $lang);
        $this->db->order_by("status", "desc");
        $this->db->order_by("id", "desc");
        $query = $this->db->get();

        foreach ($query->result() AS $f)
        {
            $posts[$f->id] = $f;
        }

        return $posts;
    }

    public function updatePost ($d)
    {
        $data = array (
            'status' => $d['status'],
            'autor' => $d['autor'],
            'tekst' => $d['tekst'],
            'lang' => $d['lang'],
            'zmieniono' => date('Y-m-d H:i:s')
            );

        $this->db->where('id', $d['id']);
        $this->db->update('guestbook', $data);

        return true;
    }

    public function addPost ($d)
    {
        $data = array (
            'status' => $d['status'],
            'autor' => $d['autor'],
            'tekst' => $d['tekst'],
            'lang' => $d['lang'],
            'dodano' => date('Y-m-d H:i:s')
        );

        $this->db->insert('guestbook', $data);
        $id_post = $this->db->insert_id();
    }

    public function setStatus($id, $status)
    {
        $data['status'] = $status;
        $this->db->where('id', $id);
        $this->db->update('guestbook', $data);
    }

    public function delPost ($id_post)
    {
        $this->db->where('id', $id_post);
        $this->db->delete('guestbook');
        return true;
    }




}
