<?php

class Ajax extends MY_Admin_Controller
{

    function __construct() {
        parent::__construct();
        $data = $this->pageinfo_model->get(__CLASS__);
        $this->data = $this->mergeData($this->data, $data);
    }

    public function checkPermission($class = false, $method = false, $id = false)
    {
        if (!$this->permission->hasPermission($class, $method, $id))
            {
                $data = array ('error' => $this->permission->getMessage());
                echo $this->load->template_admin_XML('admin/ajax', $data, true);
                exit;
                return false;
            }
    }

    private function ret ($result)
    {
        if ($result === 'OK' || $result)
            {
                $data['save'] = 'OK';
                $data['error'] = 'OK';
            }
            else
            {
                $data['error'] = $result;
            }
        return $data;
    }

    public function addNewTrait ()
    {
        $data = array (
            'table' => $_REQUEST['table'],
            'nazwa' => $_REQUEST['name'],
            'kolor' => $_REQUEST['kolor']
            );
        $this->checkPermission('Traits', 'Traits::add');
        $this->load->model('admin/trait_model');
        $id_trait = $this->trait_model->addTrait($data);
        $result = json_encode(
            array (
                'nazwa' => $data['nazwa'],
                'id' => $id_trait,
                'type' => $data['table']
            )
        );
        $data = array ('save' => 'OK', 'output' => $result);

        $this->load->template_admin_XML('admin/ajax', $data);
    }

    public function setFileName ()
    {
        $id = $_REQUEST['id'];
        $this->checkPermission('Pages', 'Pages::files', $id);

        $this->load->model('admin/file_model');
        $result = $this->file_model->setFileName($id, $_REQUEST['lang'], $_REQUEST['newName']);
        $this->load->template_admin_XML('admin/ajax', $this->ret($result));
    }

    public function setTraitName ()
    {
        $id = $_REQUEST['id'];
        $this->checkPermission('Traits', 'Traits::edit', $id);

        $this->load->model('admin/trait_model');
        $result = $this->trait_model->setTraitName($id, $_REQUEST['lang'], $_REQUEST['newName']);
        $this->load->template_admin_XML('admin/ajax', $this->ret($result));
    }

    public function setTraitColor ()
        {
        $id = $_REQUEST['id'];
        $this->checkPermission('Traits', 'Traits::edit', $id);
        $this->load->model('admin/trait_model');
        $result = $this->trait_model->setTraitColor($id, $_REQUEST['color'], $_REQUEST['type']);
        $this->load->template_admin_XML('admin/ajax', $this->ret($result));
        }

    public function setTraitView ()
        {
        $id = $_REQUEST['id'];
        //$this->checkPermission('Traits', 'Traits::edit', $id);
        $this->load->model('admin/trait_model');
        $result = $this->trait_model->setTraitView($id, $_REQUEST['view']);
        $this->load->template_admin_XML('admin/ajax', $this->ret($result));
        }

    public function editTraitTekst ()
        {
            $this->load->model('admin/trait_model');
            $id = $_REQUEST['id'];
            $lang = $_REQUEST['lang'];

            if ($_REQUEST['action'] == 'get')
                {
                    $result = $this->trait_model->getTraitTekst($id, $lang);
                    echo $result;
                }

            if ($_REQUEST['action'] == 'set')
                {
                    $tekst = $_REQUEST['tekst'];
                    $result = $this->trait_model->setTraitTekst($id, $lang, $tekst);
                    $this->load->template_admin_XML('admin/ajax', $this->ret($result));
                }

        }

    public function setPhotoName ()
    {
        $this->checkPermission('Pages', 'Pages::photos');

        $this->load->model('admin/photo_model');
        $result = $this->photo_model->setPhotoName($_REQUEST['id'], $_REQUEST['lang'], $_REQUEST['newName']);
        $this->load->template_admin_XML('admin/ajax', $this->ret($result));
    }

    public function order ()
    {
        $class = ucfirst($_REQUEST['type']);
        $this->checkPermission($class, $class.'::edit');

        $this->load->model('admin/ajax_model');
        $result = $this->ajax_model->setOrder($_REQUEST['type'], $_REQUEST['dane']);
        $this->log('Zmiana kolejności', $class, 0);
        $this->load->template_admin_XML('admin/ajax', $this->ret($result));
    }


    public function menuShowForm ()
    {
        $this->checkPermission('Menu', 'Menu::edit');

        $this->load->model('admin/menu_model');
        if (isSet($_REQUEST['id'])) { $id = $_REQUEST['id']; } else { $id = ''; }
        $result = $this->menu_model->menuShowForm($id);
        $data = array ('save' => 'OK', 'output' => $result);
        $this->load->template_admin_XML('admin/ajax', $data);
    }

    public function menuSave ()
    {
        $this->checkPermission('Menu', 'Menu::edit');

        $this->load->model('admin/menu_model');
        $result = $this->menu_model->menuSave($_REQUEST['new_menu'], $_REQUEST['lang']);
        $this->log('Edycja', 'menu', 0);
        $this->load->template_admin_XML('admin/ajax', $this->ret($result));
    }

    public function delPage ()
    {
        $id = $_REQUEST['id'];
        $this->checkPermission('Pages', 'Pages::del', $id);

        $this->load->model('admin/page_model');

        $result = $this->page_model->delPage($id);
        $this->log('Usunięcie strony', 'page', $id);
        $this->load->template_admin_XML('admin/ajax', $this->ret($result));
    }

    public function delBanner ()
    {
        $id = $_REQUEST['id'];
        $this->checkPermission('Banners', 'Banners::del', $id);

        $this->load->model('admin/banner_model');

        $result = $this->banner_model->delBanner($id);
        $this->log('Usunięcie banera', 'banner', $id);
        $this->load->template_admin_XML('admin/ajax', $this->ret($result));
    }

    public function delAddon ()
    {
        $id = $_REQUEST['id'];
        $this->checkPermission('Addons', 'Addons::del', $id);

        $this->load->model('admin/addon_model');

        $result = $this->addon_model->delAddon($id);
        $this->log('Usunięcie dodatku', 'addon', $id);
        $this->load->template_admin_XML('admin/ajax', $this->ret($result));
    }

    public function delGuestbook ()
    {
        $id = $_REQUEST['id'];
        $this->checkPermission('Guestbook', 'Guestbook::del', $id);

        $this->load->model('admin/guestbook_model');

        $result = $this->guestbook_model->delPost($id);
        $this->log('Usunięcie wpisu', 'guestbook', $id);
        $this->load->template_admin_XML('admin/ajax', $this->ret($result));
    }

    public function delNewsletter ()
    {
        $id = $_REQUEST['id'];
        $this->checkPermission('Newsletter', 'Newsletter::del', $id);

        $this->load->model('admin/newsletter_model');

        $result = $this->newsletter_model->delPost($id);
        $this->log('Usunięcie wpisu', 'newsletter', $id);
        $this->load->template_admin_XML('admin/ajax', $this->ret($result));
    }

    public function delComment ()
    {
        $id = $_REQUEST['id'];
        $this->checkPermission('Pages', 'Pages::edit', $id);

        $this->load->model('admin/comments_model');

        $result = $this->comments_model->delComment($id);
        $this->log('Usunięcie komentarza', 'pages', $id);
        $this->load->template_admin_XML('admin/ajax', $this->ret($result));
    }

    public function switchStatus ()
    {
        $id = $_REQUEST['id'];
        $table = $_REQUEST['table'];
        $class = ucfirst($_REQUEST['table']);
        $this->checkPermission($class, $class.'::edit', $id);

        $this->load->model('admin/ajax_model');
        $result = $this->ajax_model->switchStatus($id, $table);
        $this->log('Zmiana statusu', $class, $id);
        $data = array ('save' => 'OK', 'output' => $result);
        $this->load->template_admin_XML('admin/ajax', $data);
    }

    public function switchConfirm ()
    {
        $id = $_REQUEST['id'];
        $table = $_REQUEST['table'];
        $class = ucfirst($_REQUEST['table']);
        $this->checkPermission($class, $class.'::edit', $id);

        $this->load->model('admin/ajax_model');
        $result = $this->ajax_model->switchConfirm($id, $table);
        $this->log('Zmiana statusu', $class, $id);
        $data = array ('save' => 'OK', 'output' => $result);
        $this->load->template_admin_XML('admin/ajax', $data);
    }

    public function delUser ()
    {
        $this->checkPermission('Users', 'Users::del');

        $this->load->model('admin/user_model');
        $id = $_REQUEST['id'];
        $result = $this->user_model->delUser($id);
        if ($result)
            {
            $this->log('Usunięcie użytkownika', 'user', $id);
            $this->load->template_admin_XML('admin/ajax', $this->ret($result));
            }
            else
            {
            $data = array ('error' => 'Brak uprawnień do usunięcia użytkownika.');
            $this->load->template_admin_XML('admin/ajax', $data);
            }
    }

    public function delTrait ()
    {
        $id = $_REQUEST['id'];
        $this->checkPermission('Traits', 'Traits::del', $id);
        $this->load->model('admin/trait_model');
        $result = $this->trait_model->delTrait($id);
        $this->load->template_admin_XML('admin/ajax', $this->ret($result));
    }

    public function getPageHistory ()
    {
        $this->load->model('admin/pagehistory_model');
        $ver = $_REQUEST['ver'];
        $page_id = $_REQUEST['page_id'];
        $result = $this->pagehistory_model->getOne($ver, $page_id);
        $data = array ('save' => 'OK', 'output' => $result);
        $this->load->template_admin_XML('admin/ajax', $data);
    }

}
