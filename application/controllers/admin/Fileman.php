<?php

class Fileman extends MY_Admin_Controller
{
    public function index ()
    {
        $this->load->template_admin('admin/fileman', $this->data);
    }
}
