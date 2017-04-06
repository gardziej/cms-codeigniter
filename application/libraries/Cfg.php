<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cfg {

    private $data;
    private $ci;

    function __construct()
    {
        $this->ci =& get_instance();
        $this->ci->load->driver('cache', array ('adapter' => CACHE_ADAPTER));
        $this->ci->load->helper('pg_helper');
        $this->ci->load->library('languages');

        $this->data = array (
            'langs' => $this->ci->languages->getLangs(),
            'lang_main' => $this->ci->languages->getMainLang()
        );

        $cacheID = 'settings';
        $cache[$cacheID] = $this->ci->cache->get($cacheID);
        if ($cache[$cacheID] === false)
            {
                $this->ci->db->from('settings_lang');
                $result = $this->ci->db->get()->result_array();
                $lang_data = array();

                foreach ($result AS $f)
                    {
                        $lang_data[$f['id_setting']][$f['lang']] = $f['cfg_value'];
                    }

                $this->ci->db->from('settings');
                $this->ci->db->order_by('fieldset', 'asc');
                $this->ci->db->order_by('kolej', 'asc');
                $result = $this->ci->db->get()->result_array();

                foreach ($result as $f)
                   {
                       $this->settings[$f['cfg_name']] = $f;
                        if ($f['lang_diff'] == 1)
                            {
                                unset($this->settings[$f['cfg_name']]['cfg_value']);
                                foreach ($this->data['langs'] AS $lang => $d)
                                    {
                                        if (isSet($lang_data[$f['id']][$lang]))
                                            {
                                                $this->settings[$f['cfg_name']]['lang_data'][$lang] = $lang_data[$f['id']][$lang];
                                            }
                                            else
                                            {
                                                $this->createLangData($f['id'], $lang);
                                                $this->settings[$f['cfg_name']]['lang_data'][$lang] = '';
                                            }
                                    }
                            }
                    }
                $this->ci->cache->save($cacheID, $this->settings, CACHE_TIME);
            }
            else
            {
                $this->settings = $cache[$cacheID];
            }
    }

    public function createLangData($id, $lang)
    {
        $data = array (
            'id_setting' => $id,
            'lang' => $lang,
            'cfg_value' => ''
        );
        $this->ci->db->insert('settings_lang', $data);
    }


    public function getAll()
    {
        return $this->settings;
    }

    public function get($key, $lang = false)
    {
        if (isSet($this->settings[$key]['cfg_value']))
            {
                return $this->settings[$key]['cfg_value'];
            }
            else if ($lang)
            {
                return $this->settings[$key]['lang_data'][$lang];
            }
        return false;
    }

    public function getOptions($key)
    {
        if (isSet($this->settings[$key]['cfg_options']))
            {
                return json_decode($this->settings[$key]['cfg_options']);
            }
        return false;
    }


    public function set($key, $value)
    {
        if (isset($this->settings[$key]['cfg_value']))
        {
            $this->ci->db->where('cfg_name', $key);
            $this->ci->db->update('settings', array('cfg_value' => $value));
            $this->settings[$key]['cfg_value'] = $value;
        }
        else
        {
            $id = $this->settings[$key]['id'];
            foreach ($value AS $lang => $val)
                {
                    $this->ci->db->where('id_setting', $id);
                    $this->ci->db->where('lang', $lang);
                    $this->ci->db->update('settings_lang', array('cfg_value' => $val));
                    $this->settings[$key]['lang_data'][$lang] = $val;
                }

        }


    }

}
