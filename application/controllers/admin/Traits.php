<?php

class Traits extends MY_Admin_Controller
{
    private $typ = '';
    private $subTitle = '';

    function __construct() {
        parent::__construct();
        $this->load->model('admin/trait_model');
        $this->data['element_status'] = $this->config->item('element_status');
        $this->data['category_typy'] = $this->config->item('category_typy');
        $this->load->library('form_validation');
        $this->load->helper(array('form'));

        $this->data['types'] = array (
            array('href' => 'categories', 'name' => 'kategorie'),
            array('href' => 'tags', 'name' => 'tagi'),
            array('href' => 'params', 'name' => 'parametry'),
            array('href' => 'ads', 'name' => 'ogłoszenia')
        );

        $this->checkPermission($this->className());
    }

    private function methodExists($method)
    {
        foreach ($this->data['types'] AS $dt)
            {
                if ($dt['href'] == $method)
                {
                    return true;
                }
            }
        return false;
    }

    public function _remap($method)
    {

        if ($this->input->post('bulkSubmit') && $this->input->post('bulk'))
            {
                $this->bulkTraits();
            }

        $this->checkPermission('Traits', 'Traits::index');
        if ($method == 'index' || !$this->methodExists($method))
            {
                redirect('admin/traits/categories');
            }

        $this->typ = $method;
        $this->subTitle = $this->subTitle($method);
        $this->curMenu = 'admin/traits/'.$method;

        if ($this->input->post('submit'))
            {
            $this->checkPermission('Traits', 'Traits::newTrait');
            $this->form_validation->set_error_delimiters('<p class="alert alert-danger">', '</p>');
            $this->form_validation->set_rules('nazwa', 'Nazwa', 'trim|required');

            if ($this->form_validation->run() != FALSE)
                {
                    $data = array (
                        'nazwa' => $this->input->post('nazwa'),
                        'table' => $this->typ,
                        'kolor' => $this->input->post('kolor'),
                        'view' => $this->cfg->get('category_typy')
                    );

                    $result = $this->trait_model->addTrait($data);

                    if ($result)
                        {
                            $data['success_message'] = 'Dane zostały zapisane.';
                        }
                        else
                        {
                            $data['alert_message'] = 'Uwaga! Pojawił sie błąd przy zapisie do bazy danych, dane nie zostały zapisane.';
                        }
                }
                else
                {
                    $data['alert_message'] = 'Uwaga! Formularz zawiera błędy oznaczone na czerwono, popraw je proszę.';
                }

            }


        if ($this->uri->segment(4) == 'del' && is_numeric($this->uri->segment(5)))
            {
                $id = $this->uri->segment(5);
                $this->checkPermission('Traits', 'Traits::del', $id);
                $this->trait_model->delTrait($id);
            }

        $this->listAll($this->typ);
    }

    private function bulkTraits()
    {
        $bulks = array_keys($this->input->post('bulk'));

        if ($this->input->post('bulkOperation') == 'bulkDel')
            {
                foreach ($bulks AS $b)
                    {
                        $this->checkPermission($this->className(), 'Traits::del', $b);
                        if ($this->trait_model->delTrait($b))
                            {
                            $data['success_message'][] = 'Cecha została usunięta.';
                            $this->log('Usunięcie cechy', 'trait', $b);
                            }
                            else
                            {
                            $data['warning_message'][] = 'Cecha nie została usunięta.';
                            }
                    }
            }


        if ($this->input->post('bulkOperation') == 'bulkStatus')
            {
                foreach ($bulks AS $b)
                    {
                        $this->checkPermission($this->className(), 'Traits::edit');
                        $this->trait_model->setStatus($b, $this->input->post('bulkStatus'));
                        $this->log('Zmieniono status', 'trait', $b);
                    }

                $data['success_message'] = 'Statusy zostały zmienione.';
            }


        if ($this->input->post('bulkOperation') == 'bulkView')
            {
                foreach ($bulks AS $b)
                    {
                        $this->checkPermission($this->className(), 'Traits::edit');
                        $this->trait_model->setTraitView($b, $this->input->post('bulkView'));
                        $this->log('Zmieniono widok', 'trait', $b);
                    }

                $data['success_message'] = 'Widoki zostały zmienione.';
            }
    }

    private function subTitle($method)
    {
        foreach ($this->data['types'] AS $value)
            {
                if ($value['href'] == $method) return $value['name'];
            }
        return false;
    }

    public function index ()
    {
        redirect('admin/traits/categories');
    }


    public function listAll ($typ)
    {
        $data['lista'] = $this->trait_model->get($typ);
        $data['subTitle'] = $this->subTitle;
        $data['typ'] = $this->typ;
        $data['category_typy'] =  $this->config->item('category_typy');
        $this->data = $this->mergeData($this->data, $data);
        $this->load->template_admin('admin/traits/list', $this->data);
    }

}
