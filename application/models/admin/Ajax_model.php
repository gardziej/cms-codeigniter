<?php

class Ajax_model extends MY_Model
{

    public function __construct ()
    {
        parent::__construct();
    }

    public function setOrder ($typ, $dane)
    {
        if ($this->db->table_exists($typ) && isSet($dane) && is_array($dane))
            {
                foreach ($dane AS $dn)
                    {
                        $exp = explode(':', $dn);
                        $data = array(
                                       'kolej' => $exp[1]
                                    );
                        $this->db->where('id', $exp[0]);
                        $result = $this->db->update($typ, $data);
                        if (!$result) return 'NOT';
                    }
                return 'OK';
            }
            else
            {
                return 'Nieprawidłowe dane';
            }
    }

    public function switchStatus($id, $table)
    {
        $currentStatus = $this->checkStatus($id, $table);
        $element_status = $this->config->item('element_status');
        $keys = array_keys($element_status);
        $pos = array_search($currentStatus, $keys);
        $pos++;
        if (!isSet($keys[$pos])) $pos = 0;

        $this->setStatus($id, $table, $keys[$pos]);

        $output = '<span class="'.$element_status[$keys[$pos]]['icon'].' switchStatus" title="'.$element_status[$keys[$pos]]['name'].'">';

        return $output;
    }

    private function setStatus($id, $table, $status)
    {
        $data['status'] = $status;
        $this->db->where('id', $id);
        $this->db->update($table, $data);
    }

    private function checkStatus($id, $table)
    {
        $this->db->select('status');
        $this->db->from($table);
        $this->db->where('id', $id);
        $result = $this->db->get()->result();
        return $result[0]->status;
    }

    public function switchConfirm($id, $table)
    {
        $currentConfirm = $this->checkConfirm($id, $table);
        $element_confirm = $this->config->item('element_confirm');
        $keys = array_keys($element_confirm);
        $pos = array_search($currentConfirm, $keys);
        $pos++;
        if (!isSet($keys[$pos])) $pos = 0;

        $this->setConfirm($id, $table, $keys[$pos]);

        $output = '<span class="'.$element_confirm[$keys[$pos]]['icon'].' switchConfrim" title="'.$element_confirm[$keys[$pos]]['name'].'">';

        return $output;
    }

    private function setConfirm($id, $table, $confirm)
    {
        $data['status'] = $confirm;
        $this->db->where('id', $id);
        $this->db->update($table, $data);
    }

    private function checkConfirm($id, $table)
    {
        $this->db->select('status');
        $this->db->from($table);
        $this->db->where('id', $id);
        $result = $this->db->get()->result();
        return $result[0]->status;
    }


}
