<?php

class Menu_model extends MY_Model
{

    private $grid = array ();

    public function __construct ()
    {
        parent::__construct();
        $this->load->helper('menu_helper');
    }

    public function getMenus ($id_lang)
    {
        $this->load->model('page/page_model');
        $pages = $this->page_model->getPagesForMenu($id_lang);

        $this->load->model('page/trait_model');
        $traits = $this->trait_model->getTraitsForMenu($id_lang);


        $this->db->from('menu');
        $this->db->where('lang', $id_lang);
        $this->db->order_by("kolej", "asc");
        $query = $this->db->get();
        $result = $query->result_array();

        foreach ($result AS $k => $f)
            {
                if (in_array($f['link_typ'], array(2,5)) && isSet($pages[$f['link_value']]))
                    {
                        $result[$k]['link_value'] = $pages[$f['link_value']];
                    }
                else if (in_array($f['link_typ'], array(3,4,6)) && isSet($traits[$f['link_value']]))
                    {
                        $result[$k]['link_value'] = $traits[$f['link_value']];
                    }
                else if ($f['link_typ'] == 1)
                    {

                    }
                else
                    {
                        $result[$k]['link_value'] = '.';
                    }
            }

        $menus = buildTree($result);

        foreach ($result AS $r)
            {
                if ($r['typ'] == 'ROOT')
                    {
                        $this->grid[$r['page_position']] = $r['id'];
                    }
            }

        foreach ($this->grid AS $pos => $id)
            {
                $return[$pos] = $menus[$id];
            }

        return $return;
    }
}
