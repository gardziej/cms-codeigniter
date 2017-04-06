<?php

class Settings extends MY_Admin_Controller
{

    function __construct() {
        parent::__construct();
        $this->load->model('admin/settings_model');
        $this->checkPermission($this->className());
    }

    public function index ()
    {
        $this->checkPermission($this->className(), __METHOD__);
        $data['fieldsets_names'] = $this->config->item('fieldsets_names');
        $this->load->library('form_validation');
        $this->load->helper(array('form'));

        if ($this->input->post('submit'))
            {
                $this->checkPermission($this->className(), 'Settings::edit');
                $data['fieldsets'] = $this->settings_model->getFieldsets();

                $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
                foreach ($data['fieldsets'] AS $kf => $fields)
                    {
                        foreach ($fields AS $f)
                            {
                                $rules = 'trim|required';
                                if ($f['cfg_rules'] !== '') { $rules .= '|'.$f['cfg_rules']; }
                                if ($f['req'])
                                    {
                                        if ($f['lang_diff'])
                                            {
                                                foreach ($this->data['langs'] AS $lang_id => $lang)
                                                {
                                                    $this->form_validation->set_rules('dane['.$f['cfg_name'].']['.$lang_id.']', $data['fieldsets_names'][$kf].': '.$f['cfg_description'], $rules);
                                                }
                                            }
                                            else
                                            {
                                                $this->form_validation->set_rules('dane['.$f['cfg_name'].']', $data['fieldsets_names'][$kf].': '.$f['cfg_description'], $rules);
                                            }

                                    }
                            }
                    }

                if ($this->form_validation->run() != FALSE)
                    {
                        $this->settings_model->saveAll($this->input->post('dane'));
                        $data['success_message'] = 'Ustawienia zostały zapisane';
                    }
                    else
                    {
                        $data['alert_message'] = 'Uwaga! Formularz zawiera błędy oznaczone na czerwono, popraw je proszę.';
                    }

            }

        $data['fieldsets'] = $this->settings_model->getFieldsets();
        $this->data = $this->mergeData($this->data, $data);
        $this->load->template_admin('admin/settings/list', $this->data);
    }
}
