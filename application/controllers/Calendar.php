<?php

class Calendar extends MY_Page_Controller
{

    function __construct ()
    {
        parent::__construct();

    }

    public function index ()
        {
            //$p = $this->page_model->getPagesForCalendar($this->data['lang_page'], '2016-10-01', '2016-10-02');
            $this->load->template_page('page/calendar', $this->data);
        }

}
