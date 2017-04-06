<?php

class Login extends MY_Controller
{

    function __construct() {
        parent::__construct();

        $this->load->model('admin/user_model');
		$this->load->library('form_validation');
        $this->load->helper(array('form'));
        $this->load->helper('captcha');
        $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
    }

    public function index ()
    {
        if ($this->session->userdata('logged'))
            {
                redirect('admin/main');
            }

        $this->form_validation->set_rules('email', 'Adres Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'Hasło', 'trim|required|min_length[5]|callback_check_login_database');

        if ($this->input->post('captcha'))
            {
                $this->form_validation->set_rules('captcha', 'captcha', 'trim|required|callback_check_captcha_database');
            }

		if ($this->form_validation->run() == FALSE)
		    {
            if ($this->input->post('email') && $this->session->bad_login_attemps > 1)
                {
                    $this->load->model('admin/captcha_model');
                    $cap = $this->captcha_model->create();

                    $data = array (
                        'captcha' => true,
                        'captcha_img' => $cap['image']
                    );
                    $this->load->template_admin('admin/login/login', $data);
                    return true;
                }

		    $this->load->template_admin('admin/login/login');
		    }
		else
		    {
			$email = $this->input->post('email');
            $userData = $this->user_model->get_user_by_email($email);

            if ($userData['locked'] === '1')
                {
                    $data['alert_message'] = 'Niestety, Twoje konto jest zablokowane, skontaktuj się z administratorem.';
                    $this->load->template_admin('admin/empty', $data);
                    return;
                }

            if (is_array($userData))
                {
                    $data = array (
                        'email' => $userData['email'],
                        'login' => $userData['login'],
                        'admin_id' => $userData['admin_id'],
                        'level' => $userData['level'],
                        'logged' => true
                    );
                    $this->session->set_userdata($data);
                    if ($this->session->durl)
                        {
                            $redirect = $this->session->durl;
                        }
                        else {
                            $redirect = 'admin/main';
                        }
                    $this->session->unset_userdata('durl');
                    redirect($redirect);
                }
		    }

    }

    public function forgotten_password ()
    {
        $this->form_validation->set_rules('email', 'Adres Email', 'trim|required|valid_email|callback_check_email_database');

		if ($this->form_validation->run() == FALSE)
		    {
		    $this->load->template_admin('admin/login/forgotten_password');
		    }
		else
		    {
			$email = $this->input->post('email');
            $token = $this->user_model->set_token($email);

            $this->load->library('mail');
            $message = '<p>Aby zainicjować procedurę zmiany hasła kliknij na poniższy link i podążaj wg. instrukcji</p>';
            $message .= '<p><a href="'.base_url('admin/login/reset_password').'/'.$token.'">'.base_url('admin/login/reset_password').'/'.$token.'</a></p>';

            if ($this->mail->send ($email, 'Zmiana hasła', $message))
                {
                    $data['info_message'] = 'Na podany email została wysłana wiadomość zawierająca link do zmiany hasła.';
                }
                else
                {
                    $data['alert_message'] = 'Wystąpił problem z wysłaniem maila, skontaktuj się z administratorem strony.';
                }


            $this->load->template_admin('admin/empty', $data);
		    }

    }

    public function reset_password ()
    {
        $token = $this->uri->segment(4);
        $email = $this->user_model->get_email_from_token($token);

        if (!$email)
            {
                $data['info_message'] = 'Hasła nie można zresetować, przeprowadź jeszcze raz proces resetowania hasła.';
                $this->load->template_admin('admin/empty', $data);
            }

        $this->form_validation->set_rules('password', 'Hasło', 'trim|required|matches[password2]|min_length[5]');
        $this->form_validation->set_rules('password2', 'Powtórz hasło', 'trim|required');

		if ($this->form_validation->run() == FALSE)
		    {
		    $this->load->template_admin('admin/login/reset_password');
		    }
		else
		    {
            $password = $this->input->post('password');
            $this->user_model->set_new_password($email, $password);
            $this->user_model->clear_token($email);
            $data['info_message'] = 'Hasło zostało zresetowane, możesz się teraz zalogować <a href="'.base_url('admin/login').'">tutaj</a>.';
            $this->load->template_admin('admin/empty', $data);
		    }

    }

    public function check_captcha_database($captcha)
    {
        $expiration = time() - 60;
        $this->db->where('captcha_time < ', $expiration)
                 ->delete('captcha');

        $sql = 'SELECT COUNT(*) AS count FROM captcha WHERE word = ? AND ip_address = ? AND captcha_time > ?';
        $binds = array($captcha, $this->input->ip_address(), $expiration);
        $query = $this->db->query($sql, $binds);
        $row = $query->row();

        if ($row->count == 0)
            {
                $this->form_validation->set_message('check_captcha_database', 'Nieprawidłowy kod z obrazka.');
                return false;
            }

        return true;
    }

    private function check_email_database($email)
    {
        $email = $this->input->post('email');
        $check = $this->user_model->get_user_by_email($email);
        $id = $this->uri->segment(4);
        if ($check)
            {
                return true;
            }
            else
            {
                $this->form_validation->set_message('check_email_database', 'Nie ma użytkownika z takim emailem.');
                return false;
            }
    }

    public function check_login_database($password)
    {
        $email = $this->input->post('email');
        $password = do_hash($password);
        $check = $this->user_model->check_login($email, $password);
        if ($check)
            {
            return true;
            }
            else
            {
            $this->session->bad_login_attemps++;
            $this->form_validation->set_message('check_login_database', 'Nieprawidłowy email lub hasło.');
            return false;
            }
    }

    public function refreshCaptcha ()
    {
        $this->load->model('admin/captcha_model');
        $result = $this->captcha_model->create();
        $data = array ('save' => 'OK', 'output' => $result['image']);
        $this->load->template_admin_XML('admin/ajax', $data);
    }

    public function logout ()
    {
        $this->session->sess_destroy();
        redirect('admin/main');
    }

}
