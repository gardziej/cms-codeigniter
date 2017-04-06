<?php

class Comments_model extends MY_Model
{

    public function __construct ()
    {
        parent::__construct();
        $this->load->library('languages');
        $this->load->helper('menu_helper');
        $this->langs = $this->languages->getLangs();
    }

    public function getCommentsCountList ($id_page = false)
    {
        $res = array();
        $this->db->select('id_page, COUNT(id) as ile');
        $this->db->where('status', 0);
        if ($id_page)
            {
                $this->db->where('id_page', $id_page);
            }
        $this->db->group_by('id_page');
        $this->db->order_by('dodano', 'ASC');
        $query = $this->db->get('comments');

        $result = $query->result_array();

        if ($id_page)
            {
                if (!isSet($result[0])) return 0;
                return $result[0]['ile'];
            }

        if ($result) foreach ($result AS $r)
            {
                $res[$r['id_page']] = $r['ile'];
            }

        return $res;
    }

    public function getCommentsTree ($id_page)
    {
        $res = array();
        $this->db->select('*');
        $this->db->where('id_page', $id_page);
        $query = $this->db->get('comments');

        $result = $query->result_array();

        $res = $this->buildTree($result);

        return $res;
    }

    public function insertComment ($data)
    {
        return $this->db->insert('comments', $data);
    }

    public function buildTree ($ar, $pid = 0)
    {
        $op = array();
        foreach( $ar as $item ) {
            if( $item['parent_id'] == $pid ) {
                $op[$item['id']] = $item;
                // using recursion
                $children =  $this->buildTree( $ar, $item['id'] );
                if( $children ) {
                    $op[$item['id']]['children'] = $children;
                }
            }
        }
        return $op;
    }

    public function getLastComments ($lang)
    {
        $this->db->select('f.tresc AS tresc, f.username AS username, f.dodano AS dodano, f.id_page AS id_p, tytul, tytul_frd');

        $this->db->from('( select tresc, id_page, max(dodano) as maxdodano from comments  where parent_id=0 and status=0 group by id_page )
        as x inner join comments as f on f.id_page = x.id_page and f.dodano = x.maxdodano');

        $this->db->join('pages', 'pages.id = f.id_page');
        $this->db->join('pages_lang', 'pages.id = pages_lang.id_page');

        $this->db->where('pages_lang.lang', $lang);
        $this->db->where('pages.type', 1);
        $this->db->where('pages.status', 0);
        $this->db->where('f.parent_id', 0);

        $this->db->group_start();
        $this->db->where('pages.publish_up', 0);
        $this->db->or_where('pages.publish_up <=', nowDateTime());
        $this->db->group_end();

        $this->db->group_start();
        $this->db->where('pages.publish_down', 0);
        $this->db->or_where('pages.publish_down >=', nowDateTime());
        $this->db->group_end();

        $this->db->group_by('f.id_page');
        $this->db->limit($this->cfg->get('comments_last_count'));
        $this->db->order_by('f.dodano', 'DESC');

        $query = $this->db->get();

        $result = $query->result_array();

        return $result;
    }

    public function getMostComments ($lang)
    {
        $most_days = $this->cfg->get('comments_most_days');
        $this->db->select('count(comments.id) as ile, comments.dodano AS dodano, comments.id_page AS id_p, tytul, tytul_frd');

        $this->db->from('comments');

        $this->db->join('pages', 'pages.id = comments.id_page');
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
        $this->db->where('pages.type', 1);
        $this->db->where('pages.status', 0);

        if ($most_days > 0)
            {
                $this->db->where('pages.dodano > '.'DATE_SUB(NOW(), INTERVAL '.$most_days.' DAY)');
            }

        $this->db->group_by('comments.id_page');
        $this->db->limit($this->cfg->get('comments_most_count'));
        $this->db->order_by('ile', 'DESC');

        $query = $this->db->get();

        $result = $query->result_array();
        return $result;
    }

}
