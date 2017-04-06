<?php

// Update pages_lang Set tekst = replace(tekst, 'http://www.kst-lgd.pl/files', 'files')

class Updater extends MY_Admin_Controller
{

    public function index ()
    {
    }


    private function getSQLData()
    {
        $this->db->from('jos_content');
        $query = $this->db->get();
        $result = $query->result_array();

        foreach ($result AS $r)
            {
                $array[] = array(
                    'tytul' => $r['title'],
                    'tekst' => $r['introtext'],
                    'data' => $r['created']
                );
            }

        return $array;
    }

    public function aktualnosci ()
    {
        $this->load->model('admin/friendlink_model');
        $this->load->model('admin/page_model');
        $this->load->model('admin/trait_model');
        $this->load->model('admin/file_model');
        $this->load->model('admin/photo_model');
        $this->load->helper('photo_helper');

        $data = $this->getSQLData();

        //pre($data, 1);

        foreach ($data AS $k => $d)
            {
                if (!isSet($data[$k]['tytul'])) { $data[$k]['tytul'] = ''; }
                if (!isSet($data[$k]['tekst'])) { $data[$k]['tekst'] = ''; }

                $go = array (
                    'podstrony' => array (),
                    'status' => 0,
                    'type' => 1,
                    'dodano' => $d['data'],
                    'publish_up' => $d['data'],
                    'publish_down' => 0,
                    'tytul' => array('pl' => $d['tytul']),
                    'tekst' => array('pl' => $d['tekst'])
                );

                $insert_id = $this->page_model->addPage($go);
                $this->trait_model->setTraitsCon($insert_id, 2);

            }
    }

}
