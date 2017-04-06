<?php

class AddAd extends MY_Page_Controller
{
    function __construct() {
        parent::__construct();
        $this->load->model('page/trait_model');
        $this->load->model('page/photo_model');
        $this->load->model('page/page_model');
        $this->load->helper('photo_helper');
    }

    public function index ()
    {

        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->form_validation->set_error_delimiters('<p class="error">', '</p>');

        if ($this->input->post('submit'))
            {
                $this->form_validation->set_rules('tytul', 'Tytuł', 'trim|required|min_length[10]');
                $this->form_validation->set_rules('tresc', 'Treść', 'trim|required');
                $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');

                if (!$this->form_validation->run())
                    {
                        $this->data['alert_message'][] = 'W formularzu pojawiły się błędy, popraw je.';
                        $number_of_files = sizeof($_FILES['userfile']['tmp_name']);
                        if ($number_of_files >1)
                            {
                                $this->data['alert_message'][] = 'Pamiętaj, aby ponownie dołączyć zdjęcia do formularza.';
                            }
                    }
                    else
                    {
                        $data = array (
                            'tytul' => $this->input->post('tytul'),
                            'tekst' => $this->input->post('tresc'),
                            'type' => 3,
                            'autor' => -10,
                            'status' => 0,
                            'comments_allow' => $this->cfg->get('comments_allow'),
                            'comments_show' => $this->cfg->get('comments_show'),
                            'dodano' => nowDateTime(),
                            'publish_up' => nowDateTime(),
                            'publish_down' => '0000-00-00 00:00:00',
                            'ip' => $_SERVER['REMOTE_ADDR'],
                            'notes' => 'email: '.$this->input->post('email')
                        );

                        $result = $id_new_page = $this->page_model->addPage($data);
                        $this->trait_model->setTraitsCon($id_new_page, $this->input->post('category'));

                        if ($id_new_page)
                            {
                                $this->session->set_flashdata('info_message', 'Twoje ogłoszenie zostało dodane');

                                $this->load->library('upload');

                                $config['upload_path'] = PHOTO_UPLOAD_FOLDER;
                                $config['allowed_types'] = 'gif|jpg|png';
                                $config['max_size'] = FILE_MAX_SIZE;

                                $files = $_FILES['userfile'];

                                $number_of_files = sizeof($_FILES['userfile']['tmp_name']);

                                for ($i = 0; $i < $number_of_files; $i++)
                                    {
                                    $_FILES['userfile']['name'] = $files['name'][$i];
                                    $_FILES['userfile']['type'] = $files['type'][$i];
                                    $_FILES['userfile']['tmp_name'] = $files['tmp_name'][$i];
                                    $_FILES['userfile']['error'] = $files['error'][$i];
                                    $_FILES['userfile']['size'] = $files['size'][$i];
                                    $ext = pathinfo($_FILES['userfile']['name'], PATHINFO_EXTENSION);
                                    $filename = pathinfo($_FILES['userfile']['name'], PATHINFO_FILENAME);
                                    $new_name = no_pl($filename).'.'.$ext;
                                    $config['file_name'] = $new_name;

                                    $this->upload->initialize($config);

                                    if (!$this->upload->do_upload() || !$this->form_validation->run())
                                        {
                                            $data['alert_message'][] = 'W formularzu pojawiły się błędy, popraw je';
                                            $data['alert_message'][] = $this->upload->display_errors();
                                        }
                                    else
                                        {
                                            $d = $this->upload->data();
                                            $d['page_id'] = $id_new_page;
                                            $d['name'] = $this->input->post('tytul');
                                            $d['icon_name'] = $d['raw_name'].'_i'.$d['file_ext'];
                                            $d['crop_name'] = $d['raw_name'].'_c'.$d['file_ext'];

                        			        zmniejsz_fotke(PHOTO_UPLOAD_FOLDER.$d['file_name'], PHOTO_UPLOAD_FOLDER.$d['icon_name'], PHOTO_ICON_X);
                                            cropImage(PHOTO_UPLOAD_FOLDER.$d['file_name'], PHOTO_UPLOAD_FOLDER.$d['crop_name'], PHOTO_CROP_X, PHOTO_CROP_Y);

                                            $this->photo_model->addPhoto($d);
                                        }
                                    }

                                redirect('dodaj-ogloszenie');
                            }

                    }

            }


        $this->data['ads_cats'] = $this->trait_model->getTraits($this->data['lang_page'], 'ads');
        $this->load->template_page('page/addad', $this->data);
    }

}
