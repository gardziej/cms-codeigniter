<?php

class Addons extends MY_Admin_Controller
{
    function __construct() {
        parent::__construct();
        $this->load->model('admin/addon_model');
        $this->checkPermission($this->className());
        $this->data['addons'] = $this->addon_model->getAddons();
        $this->data['addon_zones'] = $this->config->item('addon_zones');
        $this->data['element_status'] = $this->config->item('element_status');
    }

    public function index ()
    {
        if ($this->input->post('bulkSubmit') && $this->input->post('bulk'))
            {
                $this->bulkAddons();
                $this->data['addons'] = $this->addon_model->getAddons();
            }

        $this->load->template_admin('admin/addons/list', $this->data);
    }


    private function bulkAddons()
    {
        $bulks = array_keys($this->input->post('bulk'));

        if ($this->input->post('bulkOperation') == 'bulkDel')
            {
                foreach ($bulks AS $b)
                    {
                        $this->checkPermission($this->className(), 'Addons::del');
                        $this->addon_model->delAddon($b);
                        $this->log('Usunięto dodatek', 'addon', $b);
                    }

                $data['success_message'] = 'Dodatek został usunięty.';
            }

        if ($this->input->post('bulkOperation') == 'bulkStatus')
            {
                foreach ($bulks AS $b)
                    {
                        $this->checkPermission($this->className(), 'Addons::edit');
                        $this->addon_model->setStatus($b, $this->input->post('bulkStatus'));
                        $this->log('Zmieniono status', 'addon', $b);
                    }

                $data['success_message'] = 'Statusy zostały zmienione.';
            }

        if ($this->input->post('bulkOperation') == 'bulkZone')
            {
                foreach ($bulks AS $b)
                    {
                        $this->checkPermission($this->className(), 'Addons::edit');
                        $this->addon_model->setZone($b, $this->input->post('bulkZone'));
                        $this->log('Zmieniono strefę', 'addon', $b);
                    }

                $data['success_message'] = 'Strefy zostały przypisane.';
            }
    }


    public function newAddon ()
    {
        $this->checkPermission($this->className(), __METHOD__);
        $this->load->library('form_validation');
        $this->load->helper(array('form'));

        $data['element_status'] = $this->config->item('element_status');
        $data['p'] = $this->addon_model->getEmptyAddon();
        $data['action'] = 'new';

        $this->data = $this->mergeData($this->data, $data);

        if ($this->input->post('submit'))
            {
            $this->form_validation->set_error_delimiters('<p class="alert alert-danger">', '</p>');
            $this->form_validation->set_rules('nazwa', 'nazwa', 'trim|required');

            if (!$this->form_validation->run())
                {
                    $data['alert_message'][] = 'Uwaga! Formularz zawiera błędy oznaczone na czerwono, popraw je proszę.';
                }
                else
                {
                    $data = array (
                        'nazwa' => $this->input->post('nazwa'),
                        'zone' => $this->input->post('zone'),
                        'tekst' => $this->input->post('tekst'),
                        'status' => $this->input->post('status')
                    );

                    $result = $this->addon_model->addAddon($data);

                    $this->log('Utworzenie nowego dodatku', 'addon', 0);

                    if ($result)
                        {
                            $data['success_message'] = 'Dane zostały zapisane.';
                        }
                        else
                        {
                            $data['alert_message'] = 'Uwaga! Pojawił sie błąd przy zapisie do bazy danych, dane nie zostały zapisane.';
                        }

                    redirect('admin/addons');
                    return true;
                }
            }
        $this->data['subTitle'] = 'nowy dodatek';
        $this->load->template_admin('admin/addons/edit', $this->data);
    }

    private function isCorrectAddonId($id)
    {
        if (!is_numeric($id) || !isSet($this->data['addons'][$id]))
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

        if (!$this->isCorrectAddonId($id))
            {
            redirect('admin/addons');
            }

        $this->checkPermission($this->className(), __METHOD__);

        if ($this->input->post('submit'))
            {
            $this->form_validation->set_error_delimiters('<p class="alert alert-danger">', '</p>');
            $this->form_validation->set_rules('nazwa', 'nazwa', 'trim|required');

            if (!$this->form_validation->run())
                {
                    $data['alert_message'][] = 'Uwaga! Formularz zawiera błędy oznaczone na czerwono, popraw je proszę.';
                }
                else
                {
                    $data = array (
                        'id' => $id,
                        'nazwa' => $this->input->post('nazwa'),
                        'zone' => $this->input->post('zone'),
                        'tekst' => $this->input->post('tekst'),
                        'status' => $this->input->post('status')
                    );

                    $result = $this->addon_model->updateAddon($data);

                    $this->log('Aktualizacja', 'addon', $id);

                    if ($result)
                        {
                            $data['success_message'] = 'Dane zostały zapisane.';
                        }
                        else
                        {
                            $data['alert_message'] = 'Uwaga! Pojawił sie błąd przy zapisie do bazy danych, dane nie zostały zapisane.';
                        }
                }

                $this->data['addons'] = $this->addon_model->getAddons();
            }


        $data['element_status'] = $this->config->item('element_status');
        $data['p'] = $this->data['addons'][$id];
        $data['id'] = $id;
        $data['action'] = 'edit';
        $this->data['subTitle'] = 'edycja';
        $this->data = $this->mergeData($this->data, $data);
        $this->load->template_admin('admin/addons/edit', $this->data);
    }

    public function del ($id = 0)
    {
        $this->checkPermission($this->className(), __METHOD__);
        if ($id == 0) $id = $this->uri->segment(4);
        $addons = $this->addon_model->delAddon($id);
        $data['success_message'] = 'Dodatek został usunięty.';
        $this->log('Usunięcie dodatku', 'addon', $id);
        $this->data = $this->mergeData($this->data, $data);
        $this->index();
    }

}
