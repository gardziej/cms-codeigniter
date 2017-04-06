<?php

class Search extends MY_Page_Controller
{

    function __construct ()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->input->get('q'))
            {
                $q = $this->input->get('q');

                $cacheID = 'search-'.$q.'-'.$this->data['lang_page'];
                $cache[$cacheID] = $this->cache->get($cacheID);
                if ($cache[$cacheID] === false)
                    {
                        $this->load->model('page/page_model');
                        $search = $this->page_model->getSearch($q, $this->data['lang_page']);
                        $this->cache->save($cacheID, $search, CACHE_TIME);
                    }
                    else
                    {
                        $search = $cache[$cacheID];
                    }


                $this->showSearchList($search);
            }
            else
            {
                redirect(base_url());
            }
    }

    public function showSearchList ($categories)
    {
        $this->data['categories'] = $categories;
        $this->load->template_page('page/search', $this->data);
    }

}
