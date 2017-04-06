<?php

class Guestbook extends MY_Page_Controller
{
    function __construct() {
        parent::__construct();
        $this->load->model('page/guestbook_model');
        $this->load->library('form_validation');
        $this->load->helper(array('form'));
    }

    public function index ()
    {

        if ($this->input->post('submit'))
            {
            $this->form_validation->set_error_delimiters('<p class="alert alert-danger">', '</p>');
            $this->form_validation->set_rules('autor', 'Autor', 'trim|required');
            $this->form_validation->set_rules('tekst', 'Tekst', 'trim|required');
            $this->form_validation->set_rules('email', 'Email', 'exact_length[0]');

            if (!$this->form_validation->run())
                {
                    $this->data['alert_message'][] = 'Uwaga! Formularz zawiera błędy oznaczone na czerwono, popraw je proszę.';
                }
                else
                {
                    $data = array (
                        'autor' => $this->input->post('autor', true),
                        'tekst' => $this->input->post('tekst', true),
                        'lang' => $this->data['lang_page']
                    );

                    $result = $this->guestbook_model->addPost($data);

                    if ($result)
                        {
                            $this->data['success_message'] = '<h4>Dziękujemy za Twój udział</h4><p>Twój wpis będzie widoczny po zatwierdzeniu go przez administratora.</p>';
                            $this->session->set_userdata('guestbook_post', true);
                        }
                        else
                        {
                            $this->data['alert_message'] = 'Uwaga! Pojawił sie błąd przy zapisie do bazy danych, dane nie zostały zapisane.';
                        }
                }
            }

        $cacheID = 'guestbook-'.$this->data['lang_page'];
        $cache[$cacheID] = $this->cache->get($cacheID);
        if ($cache[$cacheID] === false)
            {
                $posts = $this->guestbook_model->getPosts($this->data['lang_page']);
                $this->cache->save($cacheID, $posts, CACHE_TIME);
            }
            else
            {
                $posts = $cache[$cacheID];
            }

        $this->data['posts'] = $posts;
        $this->load->template_page('page/guestbook', $this->data);
    }

}
