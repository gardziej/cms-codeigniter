<?php

class PageHistory_model extends MY_Model
{

    public function __construct ()
    {
        parent::__construct();
    }

    private function getMaxV ($id_page)
    {
        $this->db->select('ver');
        $this->db->from('pages_history');
        $this->db->where('id_page', $id_page);
        $this->db->order_by('ver', 'desc');
        $this->db->limit(1);
        $query = $this->db->get();
        $result = $query->result();
        if (isSet($result[0]))
        {
            $ver = $result[0]->ver + 1;
        }
        else
        {
            $ver = 1;
        }

        return $ver;
    }

    public function addPageHistory ($history, $id_page)
    {
        $ver = $this->getMaxV($id_page);

        if ($this->session->userdata('admin_id') !== false && $this->session->userdata('login') !== false)
            {
                $autor_id = $this->session->admin_id;
                $autor_name = $this->session->login;
            }
        if (empty($autor_id))
            {
                $autor_id = -1;
                $autor_name = 'klient';
            }

        foreach ($history AS $d)
            {
                $data = array (
                    'id_page' => $id_page,
                    'ver' => $ver,
                    'tytul' => $d['tytul'],
                    'lang' => $d['lang'],
                    'tekst' => $d['tekst'],
                    'autor_id' => $autor_id,
                    'autor_name' => $autor_name,
                    'dodano' => date('Y-m-d H:i:s')
                );

                $result = $this->db->insert('pages_history', $data);
            }
    }

    public function getPageHistory ($id)
    {
        $this->db->from('pages_history');
        $this->db->where('id_page', $id);
        $this->db->group_by('ver');
        $this->db->order_by('id', 'desc');
        $this->db->limit(10,1);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function getOne ($ver, $page_id)
    {
        $this->db->from('pages_history');
        $this->db->where('ver', $ver);
        $this->db->where('id_page', $page_id);
        $this->db->limit(1);
        $query = $this->db->get();
        $result = $query->result_array();
        return json_encode($result);
    }



}
