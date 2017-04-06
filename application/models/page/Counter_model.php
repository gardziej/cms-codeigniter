<?php

class Counter_model extends MY_Model
{

    public function __construct ()
    {
        parent::__construct();
        $this->load->helper('cookie');
    }

    public function update ()
    {
        if (!get_cookie('counter'))
            {
                $this->updateCounter('counter');
                $this->setCookie('counter', 60*60*24);
            }

        if (!get_cookie('counter_unique'))
            {
                $this->updateCounter('counter_unique');
                $this->setCookie('counter_unique', 60*60*24*365);
            }
    }

    public function getActiveSessionsCount()
    {
        
    }

    private function setCookie ($counter, $time)
    {
        $cookie = array(
            'name'   => $counter,
            'value'  => '1',
            'expire' => time() + $time
        );
        set_cookie($cookie);
        return true;
    }

    private function updateCounter ($counter)
    {
        $this->db->where('cfg_name', $counter);
        $this->db->set('cfg_value', 'cfg_value+1', FALSE);
        $this->db->update('settings');
    }

}
