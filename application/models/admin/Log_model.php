<?php

class Log_model extends MY_Model
{

    public function __construct ()
    {
        parent::__construct();
    }

    public function insert ($co, $typ, $gdzie)
    {
        $data = array (
            'admin_id' => $this->session->admin_id,
            'co' => $co,
            'typ' => $typ,
            'gdzie' => $gdzie,
            'kiedy' => date('Y-m-d H:i:s')
        );

        $this->db->insert('log', $data);

        return true;
    }

}
