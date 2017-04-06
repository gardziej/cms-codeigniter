<?php

class Page extends MY_Page_Controller
{

    function __construct ()
    {
        parent::__construct();
        $this->load->model('page/photo_model');
    }

    public function goToId ($id)
        {
            $page = $this->page_model->getPage($id, $this->data['lang_page']);
            redirect('');
        }

}
