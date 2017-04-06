<?php

class Users extends MY_Admin_Controller
{

    function __construct() {
        parent::__construct();
        $this->load->model('admin/user_model');
        $this->checkPermission($this->className());
    }


    public function index ()
    {
        $this->checkPermission($this->className(), __METHOD__);

        if ($this->input->post('bulkSubmit') && $this->input->post('bulk'))
            {
                $this->bulkUsers();
            }

        $data['users'] = $this->user_model->get();
        $data['admin_role'] = $this->config->item('admin_role');
        $data['admin_locked'] = $this->config->item('admin_locked');
        $this->data = $this->mergeData($this->data, $data);
        $this->load->template_admin('admin/users/list', $this->data);
    }


    private function bulkUsers()
    {
        $bulks = array_keys($this->input->post('bulk'));

        if ($this->input->post('bulkOperation') == 'bulkDel')
            {
                foreach ($bulks AS $b)
                    {
                        $this->checkPermission($this->className(), 'Users::del');
                        if ($this->user_model->delUser($b))
                            {
                            $data['success_message'][] = 'Użytkownik został usunięty.';
                            $this->log('Usunięto użytkownika', 'page', $b);
                            }
                            else
                            {
                            $data['warning_message'][] = 'Użytkownik nie został usunięty.';
                            }
                    }


            }

        if ($this->input->post('bulkOperation') == 'bulkStan')
            {
                foreach ($bulks AS $b)
                    {
                        $this->checkPermission($this->className(), 'Users::edit');
                        $this->user_model->setStatus($b, $this->input->post('bulkStan'));
                    }

                $data['success_message'] = 'Stany zostały zmienione.';
            }
    }

    public function newUser ()
    {
        $this->checkPermission($this->className(), __METHOD__);

        $this->load->library('form_validation');
        $this->load->helper(array('form'));

        $data['admin_role'] = $this->config->item('admin_role');
        $data['admin_locked'] = $this->config->item('admin_locked');
        $data['p'] = (object) array('login' => '', 'email' => '', 'level' => 5, 'password' => '', 'password2' => '', 'locked' => 0);

        if ($this->input->post('submit'))
            {
            $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
            $this->form_validation->set_rules('login', 'Imię', 'trim|required|min_length[3]');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[admin_user.email]');
            $this->form_validation->set_rules('password', 'Hasło', 'trim|required|matches[password2]|min_length[5]');
            $this->form_validation->set_rules('password2', 'Powtórz hasło', 'trim|required');

            if ($this->form_validation->run() != FALSE)
                {
                    $data = array (
                        'login' => $this->input->post('login'),
                        'email' => $this->input->post('email'),
                        'password' => $this->input->post('password'),
                        'password2' => $this->input->post('password2'),
                        'level' => $this->input->post('level'),
                        'locked' => $this->input->post('locked')
                    );

                    $result = $id = $this->user_model->addUser($data);
                    $this->log('Utworzenie nowego użytkownika', 'user', $id);

                    if ($result)
                        {
                            $data['success_message'] = 'Użytkownik został utworzony.';
                        }
                        else
                        {
                            $data['alert_message'] = 'Uwaga! Pojawił sie błąd przy zapisie do bazy danych, dane nie zostały zapisane.';
                        }

                    $this->data = $this->mergeData($this->data, $data);
                    $this->index();
                    return true;
                }
                else
                {
                    $data['alert_message'] = 'Uwaga! Formularz zawiera błędy oznaczone na czerwono, popraw je proszę.';
                }
            }

        $this->data['subTitle'] = 'tworzenie';

        $data['user_permission'] = $this->permission->getUserModulePermissions();

        $this->data = $this->mergeData($this->data, $data);
        $this->load->template_admin('admin/users/edit', $this->data);
    }

    public function check_email_database($email)
    {
        $email = $this->input->post('email');
        $check = $this->user_model->get_user_by_email($email);
        $id = $this->uri->segment(4);
        if (!$check)
            {
                return true;
            }
            else if ($check['admin_id'] == $id)
            {
                return true;
            }
            else
            {
                $this->form_validation->set_message('check_email_database', 'Ten email jest już przypisany do innego użytkownika.');
                return false;
            }
    }


    public function edit ()
    {
        $this->checkPermission($this->className(), __METHOD__);

        $this->load->library('form_validation');
        $this->load->helper(array('form'));
        $id = $this->uri->segment(4);
        if (!is_numeric($id))
            {
            redirect('admin/users');
            }

        if ($this->input->post('submit'))
            {
            $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
            $this->form_validation->set_rules('login', 'Imię', 'trim|required|min_length[3]');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_check_email_database');

            $changePassword = false;
            if (strlen(trim($this->input->post('password'))) > 0 && strlen(trim($this->input->post('password2'))) > 0)
                {
                    $changePassword = true;
                }

            if ($changePassword)
                {
                $this->form_validation->set_rules('password', 'Hasło', 'trim|required|matches[password2]|min_length[5]');
                $this->form_validation->set_rules('password2', 'Powtórz hasło', 'trim|required');
                }

            if ($this->form_validation->run() != FALSE)
                {

                    $this->permission->setUserModulePermissions($id, $this->input->post('perms'));

                    $data = array (
                        'login' => $this->input->post('login'),
                        'email' => $this->input->post('email'),
                        'level' => $this->input->post('level'),
                        'locked' => $this->input->post('locked')
                    );

                    if ($changePassword)
                        {
                            $data['password'] = $this->input->post('password');
                            $data['password2'] = $this->input->post('password2');
                        }
                    $data['admin_id'] = $id;
                    $result = $this->user_model->editUser($data);
                    $this->log('Zmiana danych użytkownika', 'user', $id);

                    if ($result)
                        {
                            $data['success_message'] = 'Dane użytkownika zostały zmienione.';
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


        $user = $this->user_model->get($id);
        if (!$user)
        {
            redirect('admin/users');
        }
        $data['p'] = $user;
        $data['p']->password = '';
        $data['p']->password2 = '';

        $this->data['subTitle'] = 'edycja';

        $data['user_permission'] = $this->permission->getUserModulePermissions($id);

        $data['admin_role'] = $this->config->item('admin_role');
        $data['admin_locked'] = $this->config->item('admin_locked');

        $this->data = $this->mergeData($this->data, $data);
        $this->load->template_admin('admin/users/edit', $this->data);
    }

    public function profil ()
    {
        redirect('admin/users/edit/'.$this->session->userdata('admin_id'));
    }

    public function del ($id = 0)
    {
        $this->checkPermission($this->className(), __METHOD__);

        if ($id == 0) $id = $this->uri->segment(4);
        $users = $this->user_model->delUser($id);
        $data['success_message'] = 'Użytkownik został usunięty.';
        $this->log('Usunięcie użytkownika', 'user', $id);
        $this->data = $this->mergeData($this->data, $data);
        $this->index();
    }

}
