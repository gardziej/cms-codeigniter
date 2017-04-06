<?php

class Newsletter_model extends MY_Model
{

    public function __construct ()
    {
        parent::__construct();
        $this->load->library('languages');
        $this->langs = $this->languages->getLangs();
        $this->main_lang = $this->languages->getMainLang();
    }

    public function addEmail ($d)
    {
        $data = array (
            'lang' => $d['lang'],
            'email' => $d['email'],
            'token' => do_hash($d['email']),
            'dodano' => date('Y-m-d H:i:s')
        );

        $return = $this->db->insert('newsletter', $data);
        $id_post = $this->db->insert_id();
        return $return;
    }

    public function confirmEmail ($token)
    {
        $data['status'] = 0;
        $this->db->where('token', $token);
        return $this->db->update('newsletter', $data);
    }

    public function removeEmail ($token)
    {
        $this->db->where('token', $token);
        return $this->db->delete('newsletter');
    }

    public function email_exists ($email)
    {
        $this->db->from('newsletter');
        $this->db->where('email', $email);
        return $this->db->count_all_results();
    }

}
