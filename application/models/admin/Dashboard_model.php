<?php

class Dashboard_model extends MY_Model
{

    public function __construct ()
    {
        parent::__construct();
        $this->load->library('languages');
        $this->load->helper('menu_helper');
        $this->langs = $this->languages->getLangs();
    }

    public function getCommentsCount ()
    {
        $res = array();
        $query = $this->db->get('comments');
        $result = $query->num_rows();
        return $result;
    }

    public function getPagesCount ($type)
    {
        $this->db->select('id');
        $this->db->from('pages');
        $this->db->where('type', $type);
        $query = $this->db->get();
        $result = $query->num_rows();
        return $result;
    }

    public function getBannersCount ()
    {
        $this->db->select('id');
        $this->db->from('banners');
        $query = $this->db->get();
        $result = $query->num_rows();
        return $result;
    }

    public function getNewsletterCount ()
    {
        $this->db->select('id');
        $this->db->from('newsletter');
        $query = $this->db->get();
        $result = $query->num_rows();
        return $result;
    }


    public function getGuestbookCount ()
    {
        $this->db->select('id');
        $this->db->from('guestbook');
        $query = $this->db->get();
        $result = $query->num_rows();
        return $result;
    }

}
