<?php

class Ajax extends MY_Page_Controller
{
    function __construct ()
    {
        parent::__construct();
        $this->output->enable_profiler(FALSE);
    }

    public function hideCookiesInfo ()
    {
        $this->load->helper('cookie');

        $cookie = array(
            'name'   => 'cookiesInfo',
            'value'  => 'hidden',
            'expire' => time()+86500
        );

        set_cookie($cookie);
        return true;
    }

    public function commentsForPage()
    {
        $id_page = $this->input->post('id_page');

        $this->load->model('page/comments_model');

        $data['comments'] = $this->comments_model->getCommentsTree($id_page);

        $this->load->view('page/comments', $data);
    }


    public function getTemplateForCalendar ()
    {
        $this->load->view('page/calendar_event_row');
    }

    public function getOneDayForCalendar ()
    {
        $events = array();
        $this->load->model('page/page_model');
        $this->load->model('page/trait_model');
        $data = $this->page_model->getOneDayForCalendar($this->data['lang_page'], $_GET['date']);

        $tags = $this->trait_model->getTraitsForPages($this->data['lang_page'], 'tags');
        foreach ($data AS $k => $v)
            {
                if (isSet($tags[$v['id']]))
                    {
                        $data[$k]['tags'] = $tags[$v['id']];
                    }
                $events[] = $this->event->getEvent($data[$k], true);
            }

        echo json_encode($events);
    }

    public function getInitialDataForCalendar ()
    {
        $this->load->model('page/page_model');
        $this->load->model('page/trait_model');
        $data = $this->page_model->getInitialDataForCalendar($this->data['lang_page']);

        $tags = $this->trait_model->getTraitsForPages($this->data['lang_page'], 'tags');
        foreach ($data['events'] AS $k => $v)
            {
                if (isSet($tags[$v['id']]))
                    {
                        $data['events'][$k]['tags'] = $tags[$v['id']];
                    }
                $events[] = $this->event->getEvent($data['events'][$k]);
            }

        $data['events'] = $events;

        echo json_encode($data);
    }

}
