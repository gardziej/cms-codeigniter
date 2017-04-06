<?php

class Errors extends MY_Controller
{
    public function index ()
    {
        $this->load->view('errors/my/error_404');
    }

	public function error_404 ()
	{
		$this->load->view('errors/my/error_404');
	}

    public function error_page_closed ()
    {
        $this->load->view('errors/my/error_page_closed');
    }

}
