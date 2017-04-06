<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Permission {

    private $_message = '';
    private $_permission = false;
    private $_admin_menu;
    private $_id_user;

    function __construct()
    {
        $this->ci =& get_instance();
        $this->ci->load->library('session');
        $this->ci->config->load('my_config');
        $this->_admin_menu = $this->ci->config->item('admin_menu');
        $this->_id_user = $this->ci->session->admin_id;
    }

    public function setUserModulePermissions ($id_user, $list)
    {
        $this->ci->db->where('id_user', $id_user);
        $this->ci->db->delete('perm_module');

        if (is_array($list)) foreach ($list AS $k => $v)
            {
                $this->setModulePermission ($k, 1, $id_user);
            }
    }

    public function getUserModulePermissions ($id_user = false)
    {
        foreach ($this->_admin_menu AS $am)
        {
            if (isSet($am['permissions'])) foreach ($am['permissions'] AS $p => $v)
                {
                    $data[$am['id'].'::'.$p] = 0;
                }
        }

        if ($id_user)
            {
            $this->ci->db->where('id_user', $id_user);
            $query = $this->ci->db->get('perm_module');
            $result = $query->result();
            foreach ($result AS $r)
                {
                    $data[$r->id_module] = $r->perm;
                }
            }

        return $data;
    }

    public function setModulePermission ($id_module, $perm, $id_user = false)
    {
        if (!$id_user) $id_user = $this->_id_user;
        $this->removeModulePermission ($id_module, $id_user);
        if ((is_bool($perm) && $perm) || (is_string($perm) && $perm === '1') || (is_numeric($perm) && $perm === 1))
            {
                $data = array (
                    'id_module' => $id_module,
                    'id_user' => $id_user,
                    'perm' => 1,
                    'dodano' => date('Y-m-d H:i:s')
                );
                $this->ci->db->insert('perm_module', $data);
            }
    }

    private function removeModulePermission ($id_module, $id_user = false)
    {
        if (!$id_user) $id_user = $this->_id_user;
        $this->ci->db->where('id_user', $id_user);
        $this->ci->db->where('id_module', $id_module);
        $this->ci->db->delete('perm_module');
    }

    public function getPagePermission ($id_page = false)
    {
        if ($id_page)
            {
            $this->ci->db->select('login, id_page, admin_id');
            $this->ci->db->from('admin_user');
            $this->ci->db->join('perm_pages', 'admin_user.admin_id = perm_pages.id_user
                                               AND perm_pages.id_page = '.$id_page, 'left');
            $this->ci->db->where('admin_user.level >', 1);
            }
            else
            {
            $this->ci->db->select('login, 1 AS id_page, admin_id');
            $this->ci->db->from('admin_user');
            $this->ci->db->where('admin_user.level >', 1);
            }
        $query = $this->ci->db->get();
        $result = $query->result();
        return $result;
    }

    public function setPagesPermissions ($id_page, $list)
    {
        $this->ci->db->where('id_page', $id_page);
        $this->ci->db->delete('perm_pages');

        foreach ($list AS $id_user)
            {
                $this->setPagePermission($id_page, 1, $id_user);
            }
    }

    public function setPagePermission ($id_page, $perm, $id_user = false)
    {
        if (!$id_user) $id_user = $this->_id_user;
        $this->removePagePermission ($id_page, $id_user);
        if ((is_bool($perm) && $perm) || (is_string($perm) && $perm === '1') || (is_numeric($perm) && $perm === 1))
            {
                $data = array (
                    'id_page' => $id_page,
                    'id_user' => $id_user,
                    'perm' => 1,
                    'dodano' => date('Y-m-d H:i:s')
                );
                $this->ci->db->insert('perm_pages', $data);
            }
    }

    public function removePagePermission ($id_page, $id_user = false)
    {
        if (!$id_user) $id_user = $this->_id_user;
        $this->ci->db->where('id_user', $id_user);
        $this->ci->db->where('id_page', $id_page);
        $this->ci->db->delete('perm_pages');
    }

    private function checkPermission ($id_module)
    {
        if (strpos($id_module, '::') === false)
            {
                $id_module .= '::index';
            }
        $this->ci->db->where('id_user', $this->_id_user);
        $this->ci->db->where('id_module', $id_module);
        $query = $this->ci->db->get('perm_module');
        $result = $query->result();
        if (isSet($result[0]) && $result[0]->perm == '1')
            {
                return true;
            }
        return false;
    }

    private function checkIdPermission ($id)
    {
        $this->ci->db->where('id_user', $this->_id_user);
        $this->ci->db->where('id_page', $id);
        $query = $this->ci->db->get('perm_pages');
        $result = $query->result();
        if (isSet($result[0]) && $result[0]->perm == '1')
            {
                return true;
            }
        return false;
    }

    public function hasPermission ($class = false, $method = false, $id = false)
    {
        $this->ci->config->load('my_config');
        $system_locked = $this->ci->config->item('system_locked');
        if ($class &&
            $method &&
            $id &&
            isSet($system_locked[$class]) &&
            isSet($system_locked[$class][$id]) &&
            in_array($method, $system_locked[$class][$id]))
            {
                $this->_message = 'Element systemowy, nie wolno zmieniać.';
                return false;
            }

        if ($this->ci->session->level <= 1)
            {
                return true;
            }

        if ($class)
            {
            if ($this->checkPermission ($class))
                {
                    $this->_permission = true;
                }
                else
                {
                    $this->_message = 'Nie masz uprawnień do tego czynności.';
                    return false;
                }

            }

        if ($method)
            {
            if ($this->checkPermission ($method))
                {
                    $this->_permission = true;
                }
                else
                {
                    $this->_message = 'Nie masz uprawnień do tego czynności.';
                    return false;
                }
            }

        if ($id)
            {
            if ($this->checkIdPermission ($id))
                {
                    $this->_permission = true;
                }
                else
                {
                    $this->_message = 'Nie masz uprawnień do tego czynności.';
                    return false;
                }
            }

        return $this->_permission;
    }

    public function getMessage()
    {
        return $this->_message;
    }

}
