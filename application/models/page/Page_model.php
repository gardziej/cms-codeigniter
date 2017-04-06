<?php

class Page_model extends MY_Model
{
    public function __construct ()
    {
        parent::__construct();
        $this->load->library('languages');
        $this->langs = $this->languages->getLangs();
        $this->load->helper('pg_helper');
        $this->load->model('admin/friendlink_model');

        $this->eventsProperties = array('id', 'event_start', 'event_end', 'event_location', 'event_lat', 'event_lng', 'event_country',
                                    'tytul', 'tytul_frd', 'event_organizer', 'event_country', //'lead', 'tekst'
                                    );

    }

    public function getPage ($in, $lang)
    {
        $this->db->from('pages');
        $this->db->join('pages_lang', 'pages.id = pages_lang.id_page');

        if (is_numeric($in)) $this->db->where('pages.id', $in);
            else  $this->db->where('pages_lang.tytul_frd', $in);


        $this->db->group_start();
        $this->db->where('pages.publish_up', 0);
        $this->db->or_where('pages.publish_up <=', nowDateTime());
        $this->db->group_end();

        $this->db->group_start();
        $this->db->where('pages.publish_down', 0);
        $this->db->or_where('pages.publish_down >=', nowDateTime());
        $this->db->group_end();

        $this->db->where('pages.status', 0);
        $this->db->where('pages_lang.lang', $lang);
        $this->db->order_by("kolej", "asc");
        $query = $this->db->get();

        $result = $query->result_array();

        if (isSet($result[0]))
        {
            $data = $result[0];

            $this->db->select('pages.id AS id, pages.type AS type, tytul, tytul_frd');
            $this->db->from('pages_con');
            $this->db->join('pages', 'pages.id = pages_con.id_page');
            $this->db->join('pages_lang', 'pages_con.id_page = pages_lang.id_page');
            $this->db->where('id_parent', $data['id']);
            $this->db->where('lang', $lang);

            $this->db->order_by('pages.kolej', "desc");
            $result = $this->db->get()->result_array();

            if ($result) foreach ($result AS $r)
                {
                    $data['cons'][] = $r;
                }

            return $data;
        }
        return false;
    }

    public function getWalkPage ($org, $lang)
    {
        $ret = array ('next' => array(), 'prev' => array());

        $this->db->select('pages.id AS id, kolej, tytul, tytul_frd');
        $this->db->from('pages');
        $this->db->join('pages_lang', 'pages_lang.id_page = pages.id');
        $this->db->where('pages_lang.lang', $lang);

        $this->db->group_start();
        $this->db->where('pages.publish_up', 0);
        $this->db->or_where('pages.publish_up <=', nowDateTime());
        $this->db->group_end();

        $this->db->group_start();
        $this->db->where('pages.publish_down', 0);
        $this->db->or_where('pages.publish_down >=', nowDateTime());
        $this->db->group_end();

        $this->db->where('pages.status', 0);
        $this->db->where('pages.type', $org['type']);
        $this->db->where('pages.autor >', 2);
        $this->db->order_by("pages.kolej", "desc");


        $result = $this->db->get()->result_array();

        $prev_k = $next_k = $org_k = false;
        $max_k = count($result)-1;

        foreach ($result AS $k => $v)
            {
                if ($v['id'] == $org['id'])
                    {
                        $org_k = $k;
                        break;
                    }
            }
//echo 'org_k: '.$org_k.'<br>';
        if ($org_k !== false)
            {
                $next_k = $org_k + 1;
//echo 'next_k: '.$next_k.'<br>';
                if ($next_k > $max_k) $next_k = 0;
                if ($next_k == $org_k) $next_k = false;
                $prev_k = $org_k - 1;
//echo 'prev_k: '.$prev_k.'<br>';
                if ($prev_k < 0) $prev_k = $max_k;
                if ($prev_k == $org_k) $prev_k = false;
            }

        if ($prev_k !== false)
            {
                $ret['prev'] = $result[$prev_k];
            }

        if ($next_k !== false)
            {
                $ret['next'] = $result[$next_k];
            }

        return $ret;
    }

    public function getPagesForMenu ($lang)
    {
        $pages = array();
        $this->db->select('id, tytul_frd');
        $this->db->from('pages');
        $this->db->join('pages_lang', 'pages.id = pages_lang.id_page');

        $this->db->group_start();
        $this->db->where('pages.publish_up', 0);
        $this->db->or_where('pages.publish_up <=', nowDateTime());
        $this->db->group_end();

        $this->db->group_start();
        $this->db->where('pages.publish_down', 0);
        $this->db->or_where('pages.publish_down >=', nowDateTime());
        $this->db->group_end();

        $this->db->where('pages_lang.lang', $lang);
        $this->db->order_by("kolej", "asc");
        $query = $this->db->get();
        $pages_result = $query->result_array();

        foreach ($pages_result AS $f)
            {
                $pages[$f['id']] = $f['tytul_frd'];
            }
        return $pages;
    }


    public function getPagesForGallery ($lang)
    {
        $this->db->select('pages.id AS id, tytul, tytul_frd, dodano');
        $this->db->from('pages');
        $this->db->join('pages_lang', 'pages_lang.id_page = pages.id');
        $this->db->where('pages.type', TYPE_GALLERY);
        $this->db->where('pages_lang.lang', $lang);

        $this->db->group_start();
        $this->db->where('pages.publish_up', 0);
        $this->db->or_where('pages.publish_up <=', nowDateTime());
        $this->db->group_end();

        $this->db->group_start();
        $this->db->where('pages.publish_down', 0);
        $this->db->or_where('pages.publish_down >=', nowDateTime());
        $this->db->group_end();

        $this->db->where('pages.status', 0);
        $this->db->order_by("pages.kolej", "desc");
        $result = $this->db->get()->result_array();

        if ($result) foreach ($result AS $f)
            {
                $pages[$f['id']] = $f;
            }

        return $pages;
    }

    public function getOneDayForCalendar ($lang, $start_date)
    {
        $ret = array();

        $pages = $this->getPagesForCalendar ($lang, $start_date);
        foreach ($pages AS $p)
            {
                $event = array();
                foreach ($p AS $k => $v)
                    {
                        if (in_array($k, $this->eventsProperties))
                            {
                                $event[$k] = $v;
                            }
                    }

                if (!empty($event)) $ret[] = $event;

            }
        return $ret;
    }

    public function getInitialDataForCalendar ($lang)
    {

        $now = new DateTime('now');
        $ret = array('dates' => array(), 'events' => array());
        $pages = $this->getPagesForCalendar ($lang);
        foreach ($pages AS $p)
            {
                $start = new DateTime($p['event_start']);
                $end = new DateTime($p['event_end']);
                $start_F = $start->format('Y-m-d');
                $end_F = $end->format('Y-m-d');

                if ($start >= $now || $end >= $now)
                    {
                        $event = array();
                        foreach ($p AS $k => $v)
                            {
                                if (in_array($k, $this->eventsProperties))
                                    {
                                        $event[$k] = $v;
                                    }
                            }
                    }

                if (!empty($event)) $ret['events'][] = $event;

                $range = createDateRangeArray($start_F, $end_F);

                foreach ($range AS $t)
                    {
                        if (isSet($ret['dates'][$t])) { $ret['dates'][$t]++; } else { $ret['dates'][$t] = 1; }
                    }
            }
        return $ret;
    }

    public function getPagesForCalendar ($lang, $start_date = false)
    {
        $pages = array();

        $this->db->select('*');
        $this->db->from('pages');
        $this->db->join('pages_lang', 'pages_lang.id_page = pages.id');
        $this->db->where('pages.type', TYPE_EVENT);
        $this->db->where('pages_lang.lang', $lang);

        $this->db->group_start();
        $this->db->where('pages.publish_up', 0);
        $this->db->or_where('pages.publish_up <=', nowDateTime());
        $this->db->group_end();

        $this->db->group_start();
        $this->db->where('pages.publish_down', 0);
        $this->db->or_where('pages.publish_down >=', nowDateTime());
        $this->db->group_end();

        //(StartA <= EndB)  and  (EndA >= StartB)
        if ($start_date != false)
            {
                $start_date_object = new DateTime($start_date);
                $this->db->group_start();
                $this->db->where('pages.event_end >=', $start_date_object->format('Y-m-d 00:00:00'));
                $this->db->where('pages.event_start <=', $start_date_object->format('Y-m-d 23:59:59'));
                $this->db->group_end();
            }

        $this->db->where('pages.status', 0);
        $this->db->order_by("pages.event_start", "asc");
        $result = $this->db->get()->result_array();
//echo $this->db->last_query();
        if ($result) foreach ($result AS $f)
            {
                $pages[$f['id']] = $f;
            }

        return $pages;
    }

    public function getPagesFromCategory ($id_trait, $lang, $limit = false)
    {
        $this->db->from('traits_lang');
        $this->db->join('traits', 'traits.id = traits_lang.id_trait');
        $this->db->where('id_trait', $id_trait);
        $this->db->where('lang', $lang);
        $result = $this->db->get()->result_array();

        if ($result)
            {
                foreach ($result AS $r)
                    {
                        $id_trait = $r['id_trait'];
                        $typ = $r['typ'];
                        $nazwa = $r['nazwa'];
                        $nazwa_frd = $r['nazwa_frd'];
                        $tekst = $r['tekst'];
                        $view = $r['view'];
                        $kolor = $r['kolor'];
                        $font = $r['font'];
                    }
            }
            else return false;

        $this->db->select('pages.id AS id, tytul, tytul_frd, autor, lead, tekst, pages.dodano AS data_publikacji');
        $this->db->from('pages');
        $this->db->join('traits_con', 'traits_con.id_page = pages.id');
        $this->db->join('pages_lang', 'pages_lang.id_page = pages.id');
        $this->db->where('traits_con.id_trait', $id_trait);
        $this->db->where('pages_lang.lang', $lang);

        $this->db->group_start();
        $this->db->where('pages.publish_up', 0);
        $this->db->or_where('pages.publish_up <=', nowDateTime());
        $this->db->group_end();

        $this->db->group_start();
        $this->db->where('pages.publish_down', 0);
        $this->db->or_where('pages.publish_down >=', nowDateTime());
        $this->db->group_end();

        $this->db->where('pages.status', 0);
        $this->db->order_by("pages.kolej", "desc");

        if ($limit) $this->db->limit($limit);

        $result = $this->db->get()->result_array();

        $data['typ'] = $typ;
        $data['id_trait'] = $id_trait;
        $data['count'] = count($result);
        $data['view'] = $view;
        $data['nazwa'] = $nazwa;
        $data['nazwa_frd'] = $nazwa_frd;
        $data['tekst'] = $tekst;
        $data['list'] = $result;
        $data['kolor'] = $kolor;
        $data['font'] = $font;
        return $data;

    }

    public function getSearch ($q, $lang)
    {
        $this->db->select('pages.id AS id, tytul, tytul_frd, autor, lead, tekst, pages.dodano AS data_publikacji');
        $this->db->from('pages');
        $this->db->join('traits_con', 'traits_con.id_page = pages.id');
        $this->db->join('pages_lang', 'pages_lang.id_page = pages.id');
        $this->db->where('pages_lang.lang', $lang);
        $this->db->where('pages.status', 0);
        $this->db->like('tytul', $q);
        $this->db->or_like('tekst', $q);
        $this->db->or_like('lead', $q);
        $this->db->group_by("pages.id");
        $this->db->order_by("pages.kolej", "desc");
        $result = $this->db->get()->result_array();

        $data['nazwa'] = 'Wyniki wyszukiwania';
        $data['fraza'] = $q;
        $data['list'] = $result;
        return $data;
    }

    public function findDestinationInPages($method)
    {

        $this->db->select('id_page');
        $this->db->from('pages_lang');

        $this->db->join('pages', 'pages.id = pages_lang.id_page');

        $this->db->group_start();
        $this->db->where('pages.publish_up', 0);
        $this->db->or_where('pages.publish_up <=', nowDateTime());
        $this->db->group_end();

        $this->db->group_start();
        $this->db->where('pages.publish_down', 0);
        $this->db->or_where('pages.publish_down >=', nowDateTime());
        $this->db->group_end();
        $this->db->where('pages.status', 0);
        $this->db->where('tytul_frd', $method);
        $query = $this->db->get();
        $result = $query->result_array();
        if (isSet($result[0]))
            {
                $data = array (
                    'type' => 'page',
                    'id' => $result[0]['id_page']
                );
                return $data;
            }

        return false;
    }


    public function addPage ($d)
    {
        $data['status'] = $d['status'];
        $data['type'] = $d['type'];
        $data['dodano'] = $d['dodano'];
        $data['autor'] = $d['autor'];
        $data['comments_allow'] = $d['comments_allow'];
        $data['comments_show'] = $d['comments_show'];
        $data['publish_up'] = $d['publish_up'];
        $data['publish_down'] = $d['publish_down'];
        $data['zmieniono'] = $d['dodano'];

        $result = $this->db->insert('pages', $data);

        if ($result)
            {
                $insert_id = $this->db->insert_id();
                $this->updateKolej($insert_id);
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

    private function updatePageLangs ($d)
    {
        $id_page = $d['id'];
        $this->deletePageLangs($id_page);

        foreach ($this->langs AS $lang_id => $lang)
            {
                $data = array (
                    'id_page' => $d['id'],
                    'lang' => $lang_id,
                    'tytul' => clear_text($d['tytul']),
                    'tytul_frd' => $this->friendlink_model->generateName($d['tytul'], $lang_id),
                    'lead' => '',
                    'tekst' => $d['tekst'],
                );
                $this->db->insert('pages_lang', $data);
                $history[$lang_id] = $data;
            }

        $this->load->model('admin/pagehistory_model');
        $this->pagehistory_model->addPageHistory($history, $id_page);

    }

    private function deletePageLangs ($id)
    {
        $this->db->where('id_page', $id);
        $this->db->delete('pages_lang');
    }

}
