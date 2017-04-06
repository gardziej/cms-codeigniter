<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Languages {

    const TABLE = 'langs';
    private $ci;
    private $langs;
    private $lang_main;

    function __construct()
    {
        $this->ci =& get_instance();
        $this->ci->load->driver('cache', array ('adapter' => CACHE_ADAPTER));

        $cacheID = 'langs';
        $cache[$cacheID] = $this->ci->cache->get($cacheID);
        if ($cache[$cacheID] === false)
            {


                $this->ci->db->where('lang_activ', 1);
                $this->ci->db->order_by('lang_main', 'desc');
                $query = $this->ci->db->get(self::TABLE);

                foreach ($query->result() as $row)
                   {
                        $this->data['langs'][$row->lang_id] = array (
                            'name' => $row->lang_name,
                            'flag' => $row->lang_flag
                        );

                        if ($row->lang_main == 1)
                            {
                                $this->data['lang_main'] = $row->lang_id;
                            }
                   }

                $this->ci->cache->save($cacheID, $this->data, CACHE_TIME);
            }
            else
            {
                $this->data = $cache[$cacheID];
            }



    }

    public function getLangs ()
    {
        return $this->data['langs'];
    }

    public function getMainLang ()
    {
        return $this->data['lang_main'];
    }

    public function langExists ($lang)
    {
        return isSet($this->data['langs'][$lang]);
    }

}
