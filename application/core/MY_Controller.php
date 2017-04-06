<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->config->load('my_config');
        $this->load->library('cfg');
        $this->load->library('event');
        $this->load->helper('pg_helper');
        $this->load->library('languages');
        $this->load->driver('cache', array ('adapter' => CACHE_ADAPTER));
    }

    public function mergeData ($data, $add)
    {
        return array_merge($data, $add);
    }

    public function log ($co, $typ, $gdzie)
    {
        if ($this->session->userdata('logged'))
            {
                $this->load->model('admin/log_model');
                $this->log_model->insert($co, $typ, $gdzie);
            }
    }

}

//////////////////////////
require_once('MY_Admin_Controller.php');
require_once('MY_Page_Controller.php');
