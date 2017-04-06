<?php

class User_model extends MY_Model
{

    public function __construct ()
    {
        parent::__construct();
    }

    public function get ($admin_id = null)
    {
        if ($admin_id == null)
            {
                $this->db->order_by('level', 'asc');
                $this->db->order_by('login', 'asc');
                $query = $this->db->get('admin_user');
                return $query->result();
            }
            else
            {
                $query = $this->db->get_where('admin_user', array('admin_id' => $admin_id));
                $result = $query->result();
                if (isSet($result[0])) return $result[0];
            }
        return false;
    }

    public function check_login ($email, $password)
    {
        $query = $this->db->get_where('admin_user', array('email' => $email, 'password' => $password), 1);
        if ($query->num_rows() > 0)
            {
            foreach ($query->result() as $row)
                {
                    return $row->admin_id;
                }
            }
        return false;
    }

    public function get_user_by_email ($email)
    {
        $query = $this->db->get_where('admin_user', array('email' => $email), 1);
        if ($query->num_rows() > 0)
            {
            foreach ($query->result() as $row)
                {
                    $data = array (
                        'admin_id' => $row->admin_id,
                        'email' => $row->email,
                        'login' => $row->login,
                        'admin_id' => $row->admin_id,
                        'level' => $row->level,
                        'locked' => $row->locked
                    );
                    return $data;
                }
            }
        return false;
    }

    public function addUser ($data)
    {
        $data['password'] = do_hash($data['password']);
        unset($data['password2']);
        $result = $this->db->insert('admin_user', $data);

        if ($result)
            {
                $insert_id = $this->db->insert_id();
                return $insert_id;
            }
        else return false;
    }

    public function setStatus ($admin_id, $status)
    {
        $data['locked'] = $status;

        $this->db->where('admin_id', $admin_id);
        $this->db->update('admin_user', $data);

        return true;
    }

    public function editUser ($data)
    {
        if (isSet($data['password']))
            {
                $data['password'] = do_hash($data['password']);
                unset($data['password2']);
            }

        $this->db->where('admin_id', $data['admin_id']);
        $this->db->update('admin_user', $data);

        return true;
    }

    public function delUser ($id)
    {
        $user = $this->get($id);
        $this->db->where('admin_id', $id);
        $this->db->delete('admin_user');
        return true;
    }

    public function set_token ($email)
    {
        $data['token'] = do_hash($email);
        $this->db->where('email', $email);
        $this->db->update('admin_user', $data);
        return $data['token'];
    }

    public function clear_token ($email)
    {
        $data['token'] = '';
        $this->db->where('email', $email);
        $this->db->update('admin_user', $data);
        return true;
    }

    public function set_new_password ($email, $password)
    {
        $data['password'] = do_hash($password);
        $this->db->where('email', $email);
        $this->db->update('admin_user', $data);
    }

    public function get_email_from_token ($token)
    {
        $query = $this->db->get_where('admin_user', array('token' => $token));
        $user = $query->result();

        if (isSet($user[0]))
            {
                return $user[0]->email;
            }

        return false;
    }

}
