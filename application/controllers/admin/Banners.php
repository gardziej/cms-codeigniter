<?php

class Banners extends MY_Admin_Controller
{
    function __construct() {
        parent::__construct();
        $this->load->model('admin/banner_model');
        $this->load->model('admin/trait_model');
        $this->checkPermission($this->className());
        $this->data['banners'] = $this->banner_model->getBanners();
        $this->data['banner_zones'] = $this->config->item('banner_zones');
        $this->data['link_targets'] = $this->config->item('link_targets');
        $this->data['element_status'] = $this->config->item('element_status');
        $this->data['traits_dic'] = $this->config->item('traits_dic');
        $this->data['traits'] = $this->trait_model->get();
    }

    public function index ()
    {
        if ($this->input->post('bulkSubmit') && $this->input->post('bulk'))
            {
                $this->bulkBanners();
                $this->data['banners'] = $this->banner_model->getBanners();
            }

        $this->load->template_admin('admin/banners/list', $this->data);
    }


    private function bulkBanners()
    {
        $bulks = array_keys($this->input->post('bulk'));

        if ($this->input->post('bulkOperation') == 'bulkDel')
            {
                foreach ($bulks AS $b)
                    {
                        $this->checkPermission($this->className(), 'Banners::del');
                        $this->banner_model->delBanner($b);
                        $this->log('Usunięto baner', 'banner', $b);
                    }

                $data['success_message'] = 'Baner został usunięty.';
            }

        if ($this->input->post('bulkOperation') == 'bulkStatus')
            {
                foreach ($bulks AS $b)
                    {
                        $this->checkPermission($this->className(), 'Banners::edit');
                        $this->banner_model->setStatus($b, $this->input->post('bulkStatus'));
                        $this->log('Zmieniono status', 'banner', $b);
                    }

                $data['success_message'] = 'Statusy zostały zmienione.';
            }

        if ($this->input->post('bulkOperation') == 'bulkZone')
            {
                foreach ($bulks AS $b)
                    {
                        $this->checkPermission($this->className(), 'Banners::edit');
                        $this->banner_model->setZone($b, $this->input->post('bulkZone'));
                        $this->log('Zmieniono strefę', 'banner', $b);
                    }

                $data['success_message'] = 'Strefy zostały przypisane.';
            }
    }


    public function newBanner ()
    {
        $this->checkPermission($this->className(), __METHOD__);
        $this->load->library('form_validation');
        $this->load->helper(array('form'));

        $data['traits_con'] = array(0);
        $data['element_status'] = $this->config->item('element_status');
        $data['p'] = $this->banner_model->getEmptyBanner();
        $data['action'] = 'new';

        $this->data = $this->mergeData($this->data, $data);


        if ($this->input->post('submit'))
            {
            $this->form_validation->set_error_delimiters('<p class="alert alert-danger">', '</p>');
            $this->form_validation->set_rules('link', 'Link', 'trim|required');
            $this->load->library('upload');

            $config['upload_path'] = BANNER_UPLOAD_FOLDER;
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = 2048;

            $ext = pathinfo($_FILES['userfile']['name'], PATHINFO_EXTENSION);
            $filename = pathinfo($_FILES['userfile']['name'], PATHINFO_FILENAME);
            $new_name = no_pl($filename).'.'.$ext;
            $config['file_name'] = $new_name;

            $this->upload->initialize($config);

            $data = array (
                'nazwa' => $this->input->post('nazwa'),
                'link' => $this->input->post('link'),
                'zone' => $this->input->post('zone'),
                'cat_only' => $this->input->post('cat_only'),
                'link_target' => $this->input->post('link_target'),
                'status' => $this->input->post('status')
            );

            if ($this->upload->do_upload())
                {
                    $d = $this->upload->data();
                    $data['plik'] = $d['file_name'];
                }

            $result = $this->banner_model->addBanner($data);

            $this->log('Utworzenie nowego baneru', 'banner', 0);

            if ($result)
                {
                    $data['success_message'] = 'Dane zostały zapisane.';
                }
                else
                {
                    $data['alert_message'] = 'Uwaga! Pojawił sie błąd przy zapisie do bazy danych, dane nie zostały zapisane.';
                }

            redirect('admin/banners');
            return true;

            }
        $this->data['subTitle'] = 'nowy baner';
        $this->load->template_admin('admin/banners/edit', $this->data);
    }

    private function isCorrectBannerId($id)
    {
        if (!is_numeric($id) || !isSet($this->data['banners'][$id]))
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    public function edit ()
    {
        $this->load->library('form_validation');
        $this->load->helper(array('form'));
        $id = $this->uri->segment(4);

        if (!$this->isCorrectBannerId($id))
            {
            redirect('admin/banners');
            }

        $this->checkPermission($this->className(), __METHOD__);

        if ($this->input->post('submit'))
            {
            $this->load->library('upload');

            $config['upload_path'] = BANNER_UPLOAD_FOLDER;
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = 2048;

            $ext = pathinfo($_FILES['userfile']['name'], PATHINFO_EXTENSION);
            $filename = pathinfo($_FILES['userfile']['name'], PATHINFO_FILENAME);
            $new_name = no_pl($filename).'.'.$ext;
            $config['file_name'] = $new_name;

            $this->upload->initialize($config);

            $data = array (
                'id' => $id,
                'nazwa' => $this->input->post('nazwa'),
                'link' => $this->input->post('link'),
                'zone' => $this->input->post('zone'),
                'cat_only' => $this->input->post('cat_only'),
                'link_target' => $this->input->post('link_target'),
                'status' => $this->input->post('status')
            );

            if ($this->upload->do_upload())
                {
                    $d = $this->upload->data();
                    $data['plik'] = $d['file_name'];
                }

            $result = $this->banner_model->updateBanner($data);

            $this->log('Aktualizacja', 'banner', $id);

            if ($result)
                {
                    $data['success_message'] = 'Dane zostały zapisane.';
                }
                else
                {
                    $data['alert_message'] = 'Uwaga! Pojawił sie błąd przy zapisie do bazy danych, dane nie zostały zapisane.';
                }


                $this->data['banners'] = $this->banner_model->getBanners();
            }


        $data['traits_con'] = $this->banner_model->getTraitsCon($id);

        $data['element_status'] = $this->config->item('element_status');
        $data['p'] = $this->data['banners'][$id];
        $data['id'] = $id;
        $data['action'] = 'edit';
        $this->data['subTitle'] = 'edycja';
        $this->data = $this->mergeData($this->data, $data);
        $this->load->template_admin('admin/banners/edit', $this->data);
    }

    public function del ($id = 0)
    {
        $this->checkPermission($this->className(), __METHOD__);
        if ($id == 0) $id = $this->uri->segment(4);
        $banners = $this->banner_model->delBanner($id);
        $data['success_message'] = 'Baner został usunięty.';
        $this->log('Usunięcie banera', 'banner', $id);
        $this->data = $this->mergeData($this->data, $data);
        $this->index();
    }

}
