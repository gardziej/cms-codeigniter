<?php
class MY_Admin_Controller extends MY_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('admin/pageinfo_model');
        $this->load->helper('pg_helper');
        $this->load->library('permission');

        if (!$this->session->userdata('logged'))
            {
            //$this->session->sess_destroy();
            $this->load->library('user_agent');
            $this->session->set_userdata('durl', current_url());
            redirect('admin/login');
            }

        $this->data = array (
            'login' => $this->session->userdata('login'),
            'langs' => $this->languages->getLangs(),
            'lang_main' => $this->languages->getMainLang(),
            'admin_menu' => $this->config->item('admin_menu')
        );

        $this->cache->clean();

        $this->getPagesCategories();

        $data = $this->pageinfo_model->get($this->className());

        $this->load->model('admin/guestbook_model');
        $this->data['postToAccept'] = $this->guestbook_model->getPostsToAccept();

        $this->data = $this->mergeData($this->data, $data);




    }

    private function getPagesCategories()
    {
        $this->load->model('admin/trait_model');
        $h = $this->trait_model->get('categories');
        $categories = $h['categories'];

        if ($categories) foreach ($categories AS $c)
            {
                $this->data['admin_menu']['pages']['subs'][] = array (
                    'name' => $c->lang_data['pl']->nazwa,
                    'href' => base_url('admin/pages').'?filtr_cat='.$c->id.'&filtr_tag=&filtr=true',
                    'icon' => 'fa-tag',
                );
            }
    }

    public function checkPermission($class = false, $method = false, $id = false)
    {
        if (!$this->permission->hasPermission($class, $method, $id))
            {
                $this->data['warning_message'] = $this->permission->getMessage();
                echo $this->load->template_admin('admin/empty', $this->data, true);
                exit;
                return false;
            }
    }

    public function className()
    {
        return get_class($this);
    }

}
