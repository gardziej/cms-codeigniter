<?php

class Dashboard extends MY_Admin_Controller
{

    function __construct() {
        parent::__construct();
        $data = $this->pageinfo_model->get(__CLASS__);
        $this->load->model('admin/dashboard_model');
        $this->load->model('admin/trait_model');
        $this->data = $this->mergeData($this->data, $data);
    }

    public function index()
    {
        $this->data['count'] = array(
            'pages' => $this->dashboard_model->getPagesCount(TYPE_PAGE),
            'galleries' => $this->dashboard_model->getPagesCount(TYPE_GALLERY),
            'adds' => $this->dashboard_model->getPagesCount(TYPE_ADD),
            'events' => $this->dashboard_model->getPagesCount(TYPE_EVENT),

            'comments' => $this->dashboard_model->getCommentsCount(),
            'banners' => $this->dashboard_model->getBannersCount(),
            'newsletter' => $this->dashboard_model->getNewsletterCount(),
            'guestbook' => $this->dashboard_model->getGuestbookCount(),
        );


        $traits =  $this->trait_model->getTraitsForAllPages();

        $categories = array();
        $tags = array();

        if (!empty($traits['data'])) foreach ($traits['data'] AS $page_id => $d)
            {
                if (!empty($d['categories'])) foreach ($d['categories'] AS $trait_id => $trait)
                    {
                        $categories[$trait_id]['nazwa'] = $trait->lang_data['pl']->nazwa;
                        $categories[$trait_id]['nazwa_frd'] = $trait->lang_data['pl']->nazwa_frd;
                        if (!isSet($categories[$trait_id]['count'])) { $categories[$trait_id]['count'] = 0; }
                        $categories[$trait_id]['count']++;
                    }

                if (!empty($d['tags'])) foreach ($d['tags'] AS $trait_id => $trait)
                    {
                        $tags[$trait_id]['nazwa'] = $trait->lang_data['pl']->nazwa;
                        $tags[$trait_id]['nazwa_frd'] = $trait->lang_data['pl']->nazwa_frd;
                        if (!isSet($tags[$trait_id]['count'])) { $tags[$trait_id]['count'] = 0; }
                        $tags[$trait_id]['count']++;
                    }
            }

        $this->data['categories'] = $categories;
        $this->data['tags'] = $tags;

        $this->load->template_admin('admin/dashboard', $this->data);
    }

}
