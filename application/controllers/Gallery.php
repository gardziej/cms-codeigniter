<?php

class Gallery extends MY_Page_Controller
{
    function __construct() {
        parent::__construct();
        $this->load->model('page/photo_model');
        $this->load->model('page/page_model');
    }

    public function index ()
    {
        $cacheID = 'gallery-'.$this->data['lang_page'];
        $cache[$cacheID] = $this->cache->get($cacheID);
        if ($cache[$cacheID] === false)
            {
                $data['photos'] = $this->photo_model->getFirstPhotos($this->data['lang_page']);
                $data['pages'] = $this->page_model->getPagesForGallery($this->data['lang_page']);
                $this->cache->save($cacheID, $data, CACHE_TIME);
            }
            else
            {
                $data = $cache[$cacheID];
            }

        if ($data['pages']) foreach ($data['pages'] AS $k => $f)
            {
                if (isSet($data['photos'][$k]))
                    {
                        $data['pages'][$k]['photo'] = array (
                            'plik' => $data['photos'][$k]['crop'],
                            'ile' => $data['photos'][$k]['ile']
                            );
                    }
            }

        $this->data['pages'] = $data['pages'];

        $this->load->template_page('page/gallery', $this->data);
    }

}
