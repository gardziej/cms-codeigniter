<?php

class Comments_model extends MY_Model
{

    public function __construct ()
    {
        parent::__construct();
        $this->load->library('languages');
        $this->load->helper('menu_helper');
        $this->langs = $this->languages->getLangs();
    }

    public function getCommentsCountList ()
    {
        $res = array();
        $this->db->select('id_page, COUNT(id) as ile');
        $this->db->where('status', 0);
        $this->db->group_by('id_page');
        $query = $this->db->get('comments');
        $result = $query->result();
        return $result;
    }

    public function getOneRecord($id)
    {
        $this->db->select('*');
        $this->db->where('id', $id);
        $query = $this->db->get('comments');
        $result = $query->result();
        return $result;
    }

    public function getCommentsTree ($id_page)
    {
        $res = array();
        $this->db->select('*');
        $this->db->where('id_page', $id_page);
        $query = $this->db->get('comments');

        $result = $query->result_array();

        $res = $this->buildTree($result);

        return $res;
    }

    public function editComment($data)
    {
        $this->db->where('id', $data['id']);
        $this->db->update('comments', $data);

        return true;
    }

    public function delComment($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('comments');

        return true;
    }

    public function buildTree ($ar, $pid = 0)
    {
        $op = array();
        foreach( $ar as $item ) {
            if( $item['parent_id'] == $pid ) {
                $op[$item['id']] = $item;
                // using recursion
                $children =  $this->buildTree( $ar, $item['id'] );
                if( $children ) {
                    $op[$item['id']]['children'] = $children;
                }
            }
        }
        return $op;
    }

}
