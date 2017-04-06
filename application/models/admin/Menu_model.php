<?php

class Menu_model extends MY_Model
{

    public function __construct ()
    {
        parent::__construct();
    }

    public function getMenu ($id_lang)
    {
        $this->db->from('menu');
        $this->db->where('lang', $id_lang);
        $this->db->order_by("kolej", "asc");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function menuShowForm ($id)
    {
        $lang = 'pl';
        $data = array();

    	if (isSet($id))
    	{
            $this->db->from('menu');
            $this->db->where('id', $id);
            $query = $this->db->get();
            $select = $query->result_array();

    		if ($select) foreach ($select AS $s)
    		{
    			$data = $s;
                $lang = $s['lang'];
    		}
    	}

    	$output = '<form id="setMenuLink">';

    	if (isSet($data['tekst']))
    	{
    		$output .= '<h1>'.$data['tekst'].'</h1>';
    	}


        $this->config->load('my_config');

        $output .= '<input type="hidden" name="link_lang" value="'.$lang.'"/>';

    	$output .= '<table>';
    	foreach ($this->config->item('link_typy') AS $clt_id => $clt)
    	{
    		$output .= '<tr>';
    		$output .= '<td class="col1">';
    		$output .= '<input type="radio" name="link_typ" value="'.$clt_id.'"';
    		if (isSet($data['link_typ']) AND $data['link_typ'] == $clt_id) $output .= ' checked=true';
    		$output .= '>';
    		$output .= '</td>';
    		$output .= '<td class="col2">';
    		$output .= '<p class="info">'.$clt.'</p>';

    		$output .= '<p>';

    		if ($clt_id == 0)
    		{
    			$output .= '<input type="hidden" name="link_value" value="">';
    		}
    		if ($clt_id == 1)
    		{
    			$output .= '<input type="text" name="link_value" value="';
    			if (isSet($data['link_value']) && !is_numeric($data['link_value'])) $output .= $data['link_value'];
    			$output .= '">';
    		}
    		if ($clt_id == 2)
    		{
                $this->load->model('admin/page_model');
                $pages = $this->page_model->getPagesWithLang($lang, 1);

    			$output .= '<select name="link_value">';
                $output .= '<option value="">---wybierz z listy---</option>';
    			if ($pages) foreach ($pages AS $s)
    			{
    				$output .= '<option value="'.$s['id'].'"';
    				if (isSet($data['link_value']) && $s['id'] == $data['link_value'] AND $data['link_typ'] == $clt_id) $output .= ' selected';
    				$output .= '>';
    				$output .= $s['tytul'] . ' (id: '.$s['id'].')';
    				$output .= '</option>';
    			}
    			$output .= '</select>';
    		}
    		if ($clt_id == 5)
    		{
                $this->load->model('admin/page_model');
                $pages = $this->page_model->getPagesWithLang($lang, 2);

    			$output .= '<select name="link_value">';
                $output .= '<option value="">---wybierz z listy---</option>';
    			if ($pages) foreach ($pages AS $s)
    			{
    				$output .= '<option value="'.$s['id'].'"';
    				if (isSet($data['link_value']) && $s['id'] == $data['link_value'] AND $data['link_typ'] == $clt_id) $output .= ' selected';
    				$output .= '>';
    				$output .= $s['tytul'] . ' (id: '.$s['id'].')';
    				$output .= '</option>';
    			}
    			$output .= '</select>';
    		}
    		if ($clt_id == 3)
    		{
                $this->load->model('admin/trait_model');
                $categories = $this->trait_model->getTraitsWithLang('categories', $lang);

    			$output .= '<select name="link_value">';
                $output .= '<option value="">---wybierz z listy---</option>';
    			if ($categories) foreach ($categories AS $s)
    			{
    				$output .= '<option value="'.$s['id'].'"';
    				if (isSet($data['link_value']) && $s['id'] == $data['link_value'] AND $data['link_typ'] == $clt_id) $output .= ' selected';
    				$output .= '>';
    				$output .= $s['nazwa'] . ' (id: '.$s['id'].')';
    				$output .= '</option>';
    			}
    			$output .= '</select>';
    		}
    		if ($clt_id == 4)
    		{
                $this->load->model('admin/trait_model');
                $tags = $this->trait_model->getTraitsWithLang('tags', $lang);

    			$output .= '<select name="link_value">';
                $output .= '<option value="">---wybierz z listy---</option>';
    			if ($tags) foreach ($tags AS $s)
    			{
    				$output .= '<option value="'.$s['id'].'"';
    				if (isSet($data['link_value']) && $s['id'] == $data['link_value'] AND $data['link_typ'] == $clt_id) $output .= ' selected';
    				$output .= '>';
    				$output .= $s['nazwa'] . ' (id: '.$s['id'].')';
    				$output .= '</option>';
    			}
    			$output .= '</select>';
    		}
            if ($clt_id == 6)
    		{
                $this->load->model('admin/trait_model');
                $ads = $this->trait_model->getTraitsWithLang('ads', $lang);

    			$output .= '<select name="link_value">';
                $output .= '<option value="">---wybierz z listy---</option>';
    			if ($ads) foreach ($ads AS $s)
    			{
    				$output .= '<option value="'.$s['id'].'"';
    				if (isSet($data['link_value']) && $s['id'] == $data['link_value'] AND $data['link_typ'] == $clt_id) $output .= ' selected';
    				$output .= '>';
    				$output .= $s['nazwa'] . ' (id: '.$s['id'].')';
    				$output .= '</option>';
    			}
    			$output .= '</select>';
    		}
    		$output .= '</p>';

    		$output .= '</td>';
    		$output .= '</tr>';
    	}
    	$output .= '</table>';
    	$output .= '</form>';


        return $output;
    }

    public function menuSave ($data, $lang)
    {
        $new_menu = json_decode($data, true);

        $this->db->from('menu');
        $this->db->where('lang', $lang);
        $this->db->order_by("kolej", "asc");
        $query = $this->db->get();
        $select = $query->result_array();

    	if ($select) foreach ($select AS $s)
    	{
    		$obecne[$s['id']] = $s['parent_id'];
    	}

    	foreach ($new_menu AS $nm)
    	{
            if (isSet($nm['li_attr']['rel']))
    		    {
                $menu_slownik[$nm['id']] = $nm['li_attr']['rel'];
                }
    	}

    	$kolej = 0;
    	foreach ($new_menu AS $nm)
    	{
    		if (!isSet($menu_slownik[$nm['parent']])) $menu_slownik[$nm['parent']] = 0;
    		if (!isSet($nm['li_attr']['data-link_typ'])) $nm['li_attr']['data-link_typ'] = 0;
    		if (!isSet($nm['li_attr']['data-link_value'])) $nm['li_attr']['data-link_value'] = '';

            if (!isSet($nm['li_attr']['rel']))
    		    {
                    $nm['li_attr']['rel'] = '';
                }

    		$menu[] = array (
    			'id' => $nm['li_attr']['rel'],
    			'link_typ' => $nm['li_attr']['data-link_typ'],
    			'link_value' => $nm['li_attr']['data-link_value'],
    			'tekst' => clear_text($nm['text']),
                'lang' => $lang,
    			'parent_id' => $menu_slownik[$nm['parent']],
    			'kolej' => $kolej
    			);
    		$nowe[] = $nm['li_attr']['rel'];
    		$kolej++;
    	}

    	foreach ($menu AS $m)
    	{
            $data = array (
                'tekst' => $m['tekst'],
                'parent_id' => $m['parent_id'],
                'lang' => $lang,
                'link_typ' => $m['link_typ'],
                'link_value' => $m['link_value'],
                'kolej' => $m['kolej']
            );

    		if (isSet($obecne[$m['id']]))
    		{
                $this->db->where('id', $m['id']);
                $this->db->update('menu', $data);

    		}
    		else
    		{
    			$this->db->insert('menu', $data);
    		}
    	}

    	foreach($obecne AS $id => $dane)
    	{
    		if (!in_array($id, $nowe))
    		{
                $this->db->where('id', $id);
                $this->db->delete('menu');
    		}
    	}


        return 'OK';
    }

}
