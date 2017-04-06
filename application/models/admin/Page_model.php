<?php

class MaskPage {
    public $tytul = '';
    public $tytul_frd = '';
    public $lead = '';
    public $tekst = '';
    public $event_organizer = '';
    public $dodano = '';
    public $publish_up = '';
    public $publish_down = '';
}

class Page_model extends MY_Model
{
    public function __construct ()
    {
        parent::__construct();
        $this->load->library('languages');
        $this->langs = $this->languages->getLangs();
        $this->load->helper('pg_helper');
        $this->load->model('admin/friendlink_model');
        $this->load->model('admin/calendar_model');
    }

    public function getEmptyPage ()
    {
        $return = (object) array(
            'id' => 0,
            'cons' => array(),
            'status' => 0,
            'comments_allow' => $this->cfg->get('comments_allow'),
            'comments_show' => $this->cfg->get('comments_show'),
            'type' => 1,
            'ip' => '',
            'notes' => '',
            'dodano' => nowDateTime(),
            'publish_up' => nowDateTime(),
            'publish_down' => 'nigdy',
            'event_start' => nowDateTime(false),
            'event_end' => nowDateTime(false),
            'event_location' => ''
        );

        foreach ($this->langs AS $lang_id => $lang)
            {
                $return->lang_data[$lang_id] = new MaskPage();
            }
        return $return;
    }

    public function getPages ()
    {
        $this->db->select('id_page, id_parent');
        $this->db->from('pages_con');
        $this->db->join('pages', 'pages_con.id_page = pages.id');
        $this->db->order_by('pages.kolej', "desc");
        $result = $this->db->get()->result();

        if ($result) foreach ($result AS $r)
            {
                $cons[$r->id_parent][] = $r->id_page;
            }
        unset($result);

        $this->db->from('pages_lang');
        $result = $this->db->get()->result();
        if ($result) foreach ($result AS $r)
            {
                $lang_data[$r->id_page][$r->lang] = $r;
            }

        unset($result);

        $this->db->from('pages');
        $this->db->order_by("kolej", "desc");
        $query = $this->db->get();

        $result = array();
        foreach ($query->result() AS $f)
            {
                $result[$f->id] = $f;

                if ($result[$f->id]->publish_down == 0)
                    {
                        $result[$f->id]->publish_down = 'nigdy';
                    }
                    else if ($result[$f->id]->publish_down < nowDateTime())
                    {
                        $result[$f->id]->publish_info[] = 'koniec publikacji';
                    }

                if ($result[$f->id]->publish_up > nowDateTime())
                    {
                        $result[$f->id]->publish_info[] = 'przed publikacją';
                    }


                if (isSet($cons[$f->id]))
                    {
                        $result[$f->id]->cons = $cons[$f->id];
                    }
                if (isSet($lang_data[$f->id]))
                    {
                        $result[$f->id]->lang_data = $lang_data[$f->id];
                    }

                foreach ($this->langs AS $lang_id => $lang)
                    {
                        if (!isSet($result[$f->id]->lang_data[$lang_id]))
                            {
                            $result[$f->id]->lang_data[$lang_id] = new MaskPage();
                            $result[$f->id]->lang_data[$lang_id]->lang_id = $f->id;
                            $result[$f->id]->lang_data[$lang_id]->lang = $lang_id;
                            }
                    }


            }

        return $result;
    }

    public function getPagesWithLang($lang, $type = false)
    {

        $this->db->from('pages');
        $this->db->join('pages_lang', 'pages.id = pages_lang.id_page');
        if ($type) $this->db->where('type', $type);
        $this->db->where('lang', $lang);
        $this->db->where('tytul !=', '');
        $this->db->order_by("kolej", "desc");
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    public function addPage ($d)
    {
        $cons = $d['podstrony'];
        $data['status'] = $d['status'];
        $data['type'] = $d['type'];
        $data['dodano'] = $d['dodano'];
        $data['autor'] = $d['autor'];
        $data['comments_allow'] = $d['comments_allow'];
        $data['comments_show'] = $d['comments_show'];
        $data['publish_up'] = $d['publish_up'];
        $data['publish_down'] = $d['publish_down'];
        $data['event_start'] = $d['event_start'];
        $data['event_end'] = $d['event_end'];
        $data['event_location'] = $d['event_location'];
        $data['zmieniono'] = $d['dodano'];

        if ($data['type'] == TYPE_EVENT)
            {
                $latlngCtr = $this->calendar_model->getLatLngCtr($data['event_location']);
                if ($latlngCtr)
                    {
                        list($data['event_lat'], $data['event_lng'], $data['event_country']) = $latlngCtr;
                    }
            }

        $result = $this->db->insert('pages', $data);

        if ($result)
            {
                $insert_id = $this->db->insert_id();
                $this->updateKolej($insert_id);
                $this->updateCons($cons, $insert_id);
                $d['id'] = $insert_id;
                $this->updatePageLangs($d);
                return $insert_id;
            }
        else return false;
    }

    private function updateKolej ($id_page, $kolej = false)
    {
        if ($kolej)
            {
                $data['kolej'] = $kolej;
            }
            else
            {
                $data['kolej'] = $id_page;
            }

        $this->db->where('id', $id_page);
        $this->db->update('pages', $data);
    }

    public function updatePage ($d)
    {
        $cons = $d['podstrony'];
        $this->updateCons($cons, $d['id']);

        $data['status'] = $d['status'];
        $data['type'] = $d['type'];
        $data['dodano'] = $d['dodano'];
        $data['comments_allow'] = $d['comments_allow'];
        $data['comments_show'] = $d['comments_show'];
        $data['publish_up'] = $d['publish_up'];
        $data['publish_down'] = $d['publish_down'];
        $data['event_start'] = $d['event_start'];
        $data['event_end'] = $d['event_end'];
        $data['event_location'] = $d['event_location'];

        if ($data['type'] == TYPE_EVENT)
            {
                $latlngCtr = $this->calendar_model->getLatLngCtr($data['event_location']);
                if ($latlngCtr)
                    {
                        list($data['event_lat'], $data['event_lng'], $data['event_country']) = $latlngCtr;
                    }
            }

        $data['zmieniono'] = date('Y-m-d H:i:s');
        $this->db->where('id', $d['id']);
        $this->db->update('pages', $data);

        $this->updatePageLangs($d);

        return true;
    }

    private function deletePageLangs ($id)
    {
        $this->db->where('id_page', $id);
        $this->db->delete('pages_lang');
    }

    private function updatePageLangs ($d)
    {

        $id_page = $d['id'];
        $this->deletePageLangs($id_page);

        foreach ($this->langs AS $lang_id => $lang)
            {
                $data = array (
                    'id_page' => $d['id'],
                    'lang' => $lang_id,
                    'tytul' => clear_text($d['tytul'][$lang_id]),
                    'tytul_frd' => $this->friendlink_model->generateName($d['tytul'][$lang_id], $lang_id),
                    'lead' => $d['lead'][$lang_id],
                    'tekst' => $d['tekst'][$lang_id],
                    'event_organizer' => $d['event_organizer'][$lang_id]
                );
                $this->db->insert('pages_lang', $data);
                $history[$lang_id] = $data;
            }

        $this->load->model('admin/pagehistory_model');
        $this->pagehistory_model->addPageHistory($history, $id_page);

    }

    public function delPage ($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('pages');

        $this->db->where('id_page', $id);
        $this->db->delete('pages_lang');

        $this->db->where('id_parent', $id);
        $this->db->delete('pages_con');

        return true;
    }

    public function setStatus($id, $status)
    {
        $data['status'] = $status;
        $this->db->where('id', $id);
        $this->db->update('pages', $data);
    }

    public function setType($id, $type)
    {
        $data['type'] = $type;
        $this->db->where('id', $id);
        $this->db->update('pages', $data);
    }

    private function updateCons ($data, $id)
    {

        $this->db->where('id_parent', $id);
        $this->db->delete('pages_con');


        if (is_array($data)) foreach ($data AS $d)
            {
                $insert = array ('id_page' => $d, 'id_parent' => $id);
                $result = $this->db->insert('pages_con', $insert);
            }

    }

}
