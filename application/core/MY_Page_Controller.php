<?php

class MY_Page_Controller extends MY_Controller {

    function __construct() {
        parent::__construct();

        $this->output->enable_profiler(FALSE);
        $this->load->helper('menu_helper');
        $this->load->helper('imieniny_helper');
        $this->load->helper(array('form'));
        $this->load->library('form_validation');
        $this->data['banners_cats'] = array();
        $this->setLanguage();

        if (!$this->session->userdata('admin_id') && !$this->cfg->get('page_online', $this->data['lang_page']))
            {
                redirect('errors/error_page_closed');
            }

        $this->data['page_info'] = array (
            'page_name' => $this->cfg->get('page_name', $this->data['lang_page']),
            'page_description' => $this->cfg->get('page_description', $this->data['lang_page']),
            'page_key_words' => $this->cfg->get('page_key_words', $this->data['lang_page'])
            );

        $this->data['main_slider_speed'] = $this->cfg->get('main_slider_speed');

        $this->updateCookies();
        $this->prepareAddons();
        $this->prepareBanners();
        $this->prepareMenus();
    }

    private function updateCookies ()
    {
        $this->load->model('page/counter_model');
        $this->counter_model->update();
    }


    private function setLanguage ()
    {
        if ($this->session->userdata('lang_page'))
            {
                $lang = $this->session->userdata('lang_page');
            }

        if ($this->input->get('lang'))
            {
                $lang = $this->input->get('lang');
            }

        if (!isSet($lang) || !$this->languages->langExists($lang))
            {
                $lang = $this->languages->getMainLang();
            }

        $this->session->set_userdata('lang_page', $lang);
        $this->data['lang_page'] = $lang;
        return $lang;
    }

    protected function prepareMenus ()
    {
        $this->data['link_typy'] =  $this->config->item('link_typy');

        $cacheID = 'menus';
        $cache[$cacheID] = $this->cache->get($cacheID);
        if ($cache[$cacheID] === false)
            {
                $this->load->model('page/menu_model');
                $this->data[$cacheID] = $this->menu_model->getMenus($this->data['lang_page']);
                $this->cache->save($cacheID, $this->data[$cacheID], CACHE_TIME);
            }
            else
            {
                $this->data[$cacheID] = $cache[$cacheID];
            }
    }

    protected function prepareAddons ()
    {
        $cacheID = 'addons';
        $cache[$cacheID] = $this->cache->get($cacheID);
        if ($cache[$cacheID] === false)
            {
                $this->load->model('page/addon_model');
                $this->data['addons'] = $this->addon_model->getAddons($this->data['lang_page']);
                $this->cache->save($cacheID, $this->data['addons'], CACHE_TIME);
            }
            else
            {
                $this->data[$cacheID] = $cache[$cacheID];
            }
    }

    protected function prepareBanners ()
    {
        $cacheID = 'banners';
        $cache[$cacheID] = $this->cache->get($cacheID);
        if ($cache[$cacheID] === false)
            {
                $this->load->model('page/banner_model');
                $this->data['banners'] = $this->banner_model->getBanners($this->data['lang_page']);
                $this->cache->save($cacheID, $this->data['banners'], CACHE_TIME);
            }
            else
            {
                $this->data[$cacheID] = $cache[$cacheID];
            }
    }

}
