<?php

class Newsletter extends MY_Admin_Controller
{
    function __construct() {
        parent::__construct();
        $this->load->model('admin/newsletter_model');
        $this->checkPermission($this->className());
        $this->data['posts'] = $this->newsletter_model->getPosts();
        $this->data['element_status'] = $this->config->item('element_confirm');
    }

    public function index ()
    {
        $this->data['filtr'] = $this->config->item('newsletter_filtr');

        if ($this->input->get('filtr_status'))
            {
                $this->data['filtr'] = array(
                    'status' => $this->input->get('filtr_status'),
                    'lang' => $this->input->get('filtr_lang')
                );
                $this->data['posts'] = $this->newsletter_model->getPosts($this->data['filtr']['status'], $this->data['filtr']['lang']);
            }

        if ($this->input->post('bulkSubmit') && $this->input->post('bulk'))
            {
                $this->bulkPosts();
                $this->data['posts'] = $this->newsletter_model->getPosts();
            }

        $this->load->template_admin('admin/newsletter/list', $this->data);
    }

    private function bulkPosts()
    {
        $bulks = array_keys($this->input->post('bulk'));

        if ($this->input->post('bulkOperation') == 'bulkDel')
            {
                foreach ($bulks AS $b)
                    {
                        $this->checkPermission($this->className(), 'Newsletter::del');
                        $this->newsletter_model->delPost($b);
                        $this->log('Usunięto wpis', 'newsletter', $b);
                    }

                $data['success_message'] = 'Wpis został usunięty.';
            }

        if ($this->input->post('bulkOperation') == 'bulkStatus')
            {
                foreach ($bulks AS $b)
                    {
                        $this->checkPermission($this->className(), 'Newsletter::edit');
                        $this->newsletter_model->setStatus($b, $this->input->post('bulkStatus'));
                        $this->log('Zmieniono status', 'newsletter', $b);
                    }

                $data['success_message'] = 'Statusy zostały zmienione.';
            }
    }

    public function lists ()
    {
        $this->data['lists'] = $this->newsletter_model->getLists();
        $this->data['subTitle'] = 'Listy do pobrania';
        $this->load->template_admin('admin/newsletter/lists', $this->data);
    }

    public function edit ()
    {
        $this->load->library('form_validation');
        $this->load->helper(array('form'));
        $id = $this->uri->segment(4);

        if (!$this->isCorrectPostId($id))
            {
            redirect('admin/newsletter');
            }

        $this->checkPermission($this->className(), __METHOD__);

        if ($this->input->post('submit'))
            {
            $this->form_validation->set_error_delimiters('<p class="alert alert-danger">', '</p>');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');

            if (!$this->form_validation->run())
                {
                    $data['alert_message'][] = 'Uwaga! Formularz zawiera błędy oznaczone na czerwono, popraw je proszę.';
                }
                else
                {
                    $data = array (
                        'id' => $id,
                        'email' => $this->input->post('email'),
                        'lang' => $this->input->post('lang'),
                        'status' => $this->input->post('status')
                    );

                    $result = $this->newsletter_model->updatePost($data);

                    $this->log('Aktualizacja', 'newsletter', $id);

                    if ($result)
                        {
                            $data['success_message'] = 'Dane zostały zapisane.';
                        }
                        else
                        {
                            $data['alert_message'] = 'Uwaga! Pojawił sie błąd przy zapisie do bazy danych, dane nie zostały zapisane.';
                        }
                }

                $this->data['posts'] = $this->newsletter_model->getPosts();
            }


        $data['element_status'] = $this->config->item('element_confirm');
        $data['p'] = $this->data['posts'][$id];
        $data['id'] = $id;
        $data['action'] = 'edit';
        $this->data['subTitle'] = 'edycja';
        $this->data = $this->mergeData($this->data, $data);
        $this->load->template_admin('admin/newsletter/edit', $this->data);
    }

    public function newPost ()
    {
        $this->checkPermission($this->className(), __METHOD__);
        $this->load->library('form_validation');
        $this->load->helper(array('form'));

        $data['element_status'] = $this->config->item('element_confirm');
        $data['p'] = $this->newsletter_model->getEmptyPost();
        $data['action'] = 'new';

        $this->data = $this->mergeData($this->data, $data);


        if ($this->input->post('submit'))
            {
            $this->form_validation->set_error_delimiters('<p class="alert alert-danger">', '</p>');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');

            if (!$this->form_validation->run())
                {
                    $data['alert_message'][] = 'Uwaga! Formularz zawiera błędy oznaczone na czerwono, popraw je proszę.';
                }
                else
                {
                    $data = array (
                        'email' => $this->input->post('email'),
                        'lang' => $this->input->post('lang'),
                        'status' => $this->input->post('status')
                    );

                    $result = $this->newsletter_model->addPost($data);

                    $this->log('Utworzenie nowego wpisu', 'newsletter', 0);

                    if ($result)
                        {
                            $data['success_message'] = 'Dane zostały zapisane.';
                        }
                        else
                        {
                            $data['alert_message'] = 'Uwaga! Pojawił sie błąd przy zapisie do bazy danych, dane nie zostały zapisane.';
                        }

                    redirect('admin/newsletter');
                    return true;
                }
            }
        $this->data['subTitle'] = 'nowy wpis';
        $this->load->template_admin('admin/newsletter/edit', $this->data);
    }

    private function isCorrectPostId($id)
    {
        if (!is_numeric($id) || !isSet($this->data['posts'][$id]))
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    public function del ($id = 0)
    {
        $this->checkPermission($this->className(), __METHOD__);
        if ($id == 0) $id = $this->uri->segment(4);
        $posts = $this->newsletter_model->delPost($id);
        $data['success_message'] = 'Wpis został usunięty.';
        $this->log('Usunięcie wpisu', 'newsletter', $id);
        $this->data['posts'] = $this->newsletter_model->getPosts();
        $this->data = $this->mergeData($this->data, $data);
        $this->index();
    }

}
