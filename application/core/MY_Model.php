<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Model extends CI_Model {
    function __construct() {
        parent::__construct();
        $this->load->library('cfg');
        $this->load->helper('pg_helper');
    }
}
