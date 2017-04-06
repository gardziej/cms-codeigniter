<?php

class Newsletter extends MY_Page_Controller
{

    function __construct ()
    {
        parent::__construct();
        $this->load->model('page/newsletter_model');
    }

    public function index()
    {
        if ($this->input->post('newsletter'))
            {
            $this->form_validation->set_error_delimiters('<p class="alert alert-danger alert-small">', '</p>');

            if ($this->input->post('submit_newsletter'))
                {
                    $this->form_validation->set_rules('newsletter', 'email', 'trim|valid_email|required|callback_check_email_database');
                }
            else if ($this->input->post('remove_newsletter'))
                {
                    $this->form_validation->set_rules('newsletter', 'email', 'trim|valid_email|required');
                }
            if (!$this->form_validation->run())
                {
                    $this->data['alert_message'][] = 'Uwaga! Formularz zawiera błędy oznaczone na czerwono, popraw je proszę.';
                }
                else
                {
                    $data = array (
                        'email' => $this->input->post('newsletter', true),
                        'tekst' => $this->input->post('tekst', true),
                        'lang' => $this->data['lang_page']
                    );

        			$email = $this->input->post('newsletter');
                    $this->load->library('mail');

                    $token = do_hash($email);

                    if ($this->input->post('submit_newsletter'))
                        {
                            $message = '<p>Aby potwierdzić swój email kliknij na poniższy link i podążaj wg. instrukcji</p>';
                            $message .= '<p><a href="'.base_url('newsletter/dodajEmail').'/'.$token.'">'.base_url('newsletter/dodajEmail').'/'.$token.'</a></p>';

                            if ($this->mail->send ($email, 'Potwierdź swój email', $message))
                                {
                                    $this->data['success_message'] = 'Na podany adres został wysłany e-mail zawierający link do potwierdzenia Twojej operacji związanej z newsletterem.';
                                }
                                else
                                {
                                    $this->data['alert_message'] = 'Wystąpił problem z wysłaniem maila, skontaktuj się z administratorem strony.';
                                }

                                $result = $this->newsletter_model->addEmail($data);

                        }
                    else if ($this->input->post('remove_newsletter'))
                        {
                            $message = '<p>Aby potwierdzić rezygnację z newslettera kliknij na poniższy link i podążaj wg. instrukcji</p>';
                            $message .= '<p><a href="'.base_url('newsletter/usunEmail').'/'.$token.'">'.base_url('newsletter/usunEmail').'/'.$token.'</a></p>';

                            if ($this->mail->send ($email, 'Potwierdź rezygnację z newslettera', $message))
                                {
                                    $this->data['success_message'] = 'Na podany adres został wysłany e-mail zawierający link do potwierdzenia Twojej operacji związanej z newsletterem.';
                                }
                                else
                                {
                                    $this->data['alert_message'] = 'Wystąpił problem z wysłaniem maila, skontaktuj się z administratorem strony.';
                                }
                        }

                }

                $this->load->template_page('page/newsletter', $this->data);
            }
            else
            {
                redirect();
            }
    }

    public function dodajEmail()
    {
        if (!$this->uri->segment(3))
        {
            $this->data['alert_message'] = 'Nieprawidłowy link';
        }

        $token = $this->uri->segment(3);

        $result = $this->newsletter_model->confirmEmail($token);

        if ($result)
            {
                $this->data['success_message'] = 'Twój email został potwierdzony, dziękujemy.';
            }
            else
            {
                $this->data['alert_message'] = 'Nieprawidłowy link';
            }

        $this->load->template_page('page/newsletter', $this->data);
    }

    public function usunEmail()
    {
        if (!$this->uri->segment(3))
        {
            $this->data['alert_message'] = 'Nieprawidłowy link';
        }

        $token = $this->uri->segment(3);

        $result = $this->newsletter_model->removeEmail($token);

        if ($result)
            {
                $this->data['success_message'] = 'Twój email został usunięty z naszej bazy danych.';
            }
            else
            {
                $this->data['alert_message'] = 'Nieprawidłowy link';
            }

        $this->load->template_page('page/newsletter', $this->data);
    }



    public function check_email_database($email)
    {
        $check = $this->newsletter_model->email_exists($email);
        if (!$check)
            {
                return true;
            }
            else
            {
                $this->form_validation->set_message('check_email_database', 'Ten email jest już zapisany.');
                return false;
            }
    }

}
