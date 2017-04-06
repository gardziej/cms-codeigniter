<?php

class Settings_model extends MY_Model
{

    const TABLE = 'config';

    public function __construct() {
        parent::__construct();
    }

    public function getAll()
    {
        return $this->cfg->getAll();
    }

    public function getFieldsets()
    {
        $data = $this->cfg->getAll();

        foreach ($data AS $d)
            {
                $new[$d['fieldset']][$d['cfg_name']] = $d;
            }

        return $new;

    }

    public function saveAll($data)
    {
        foreach ($data AS $key => $value)
            {
                $this->cfg->set($key, $value);
            }
    }


}
