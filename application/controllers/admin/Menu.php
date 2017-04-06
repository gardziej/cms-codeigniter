<?php

class Menu extends MY_Admin_Controller
{

    function __construct() {
        parent::__construct();
        $this->checkPermission($this->className());
    }

    public function index ()
    {
        $this->checkPermission($this->className(), __METHOD__);

        $this->load->model('admin/menu_model');
        $this->load->helper('menu_helper');

        foreach ($this->data['langs'] AS $lang_id => $lang)
            {
                $menuData = $this->menu_model->getMenu($lang_id);
                $data['menu'][$lang_id] = buildTree($menuData);
            }

        $this->data = $this->mergeData($this->data, $data);
        $this->load->template_admin('admin/menu/menu', $this->data);
    }
}
