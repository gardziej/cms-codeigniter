<?php

class Captcha_model extends MY_Model
{

    public function __construct ()
    {
        parent::__construct();
    }

    public function create ()
    {
        $this->config->load('my_config');
        $cap = create_captcha($this->config->item('captcha'));
        $data = array(
                'captcha_time'  => $cap['time'],
                'ip_address'    => $this->input->ip_address(),
                'word'          => $cap['word']
        );
        $query = $this->db->insert_string('captcha', $data);
        $this->db->query($query);

        return $cap;
    }

}
