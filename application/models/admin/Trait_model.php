<?php

class MaskTrait {
    public $nazwa = '';
}

class Trait_model extends MY_Model
{
    public function __construct ()
    {
        parent::__construct();
        $this->langs = $this->languages->getLangs();
        $this->load->model('admin/friendlink_model');
    }

    public function get ($typ = false)
    {
        $traits = array();
        $this->db->from('traits_lang');
        $result = $this->db->get()->result();
        if ($result) foreach ($result AS $r)
            {
                $lang_data[$r->id_trait][$r->lang] = $r;
            }
        unset($result);

        $result = array(
            'categories' => array (),
            'tags' => array (),
            'ads' => array (),
            'params' => array ()
        );
        $this->db->from('traits');
        if ($typ) $this->db->where('typ', $typ);
        $this->db->order_by("kolej", "desc");
        $query = $this->db->get();

        $traits = $query->result();

        foreach ($traits AS $k => $f)
            {
                foreach ($this->langs AS $lang_id => $lang)
                    {
                        if (!isSet($lang_data[$f->id][$lang_id]))
                            {
                                $lang_data[$f->id][$lang_id] = new MaskTrait();
                            }
                    }
                $result[$f->typ][$k] = $f;
                $result[$f->typ][$k]->lang_data = $lang_data[$f->id];
            }

        return $result;
    }

    public function getTraitsWithLang($typ, $lang)
    {

        $this->db->from('traits');
        $this->db->join('traits_lang', 'traits.id = traits_lang.id_trait');
        $this->db->where('lang', $lang);
        $this->db->where('nazwa !=', '');
        $this->db->where('typ', $typ);
        $this->db->order_by("kolej", "desc");
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    public function getTraitsForAllPages ()
    {

        $this->db->from('traits_lang');
        $result = $this->db->get()->result();
        if ($result) foreach ($result AS $r)
            {
                $lang_data[$r->id_trait][$r->lang] = $r;
            }

        $this->db->select('id_page, traits.id AS id_trait, traits.typ AS typ, kolor, font, value');
        $this->db->from('traits_con');
        $this->db->join('pages', 'traits_con.id_page = pages.id');
        $this->db->join('traits', 'traits_con.id_trait = traits.id', 'right');
        $this->db->order_by("traits.kolej", "desc");
        $query = $this->db->get();

        $result = array();

        foreach ($query->result() AS $f)
            {
                if ($f->id_page)
                    {

                        foreach ($this->langs AS $lang_id => $lang)
                            {
                                if (!isSet($lang_data[$f->id_trait][$lang_id]))
                                    {
                                        $lang_data[$f->id_trait][$lang_id] = new MaskTrait();
                                    }
                            }
                        $f->lang_data = $lang_data[$f->id_trait];
                        $result['data'][$f->id_page][$f->typ][$f->id_trait] = $f;
                        $result['filtr'][$f->typ][$f->id_trait] = $f->lang_data['pl']->nazwa;
                    }

            }

        $result['list'] = $this->get();

        return $result;
    }

    public function getTraitTekst ($id_trait, $lang)
    {
        $this->db->select('tekst');
        $this->db->from('traits_lang');
        $this->db->where('id_trait', $id_trait);
        $this->db->where('lang', $lang);
        $result = $this->db->get()->result();
        if ($result) foreach ($result AS $r)
            {
                return $r->tekst;
            }
    }

    public function setTraitTekst ($id_trait, $lang, $tekst)
    {
        $data['tekst'] = clear_text($tekst);
        $this->db->where('id_trait', $id_trait);
        $this->db->where('lang', $lang);
        $this->db->update('traits_lang', $data);
        return 'OK';
    }

    private function removeTraitLang($id_trait, $lang = false)
    {
        if ($lang) $this->db->where('lang', $lang);
        $this->db->where('id_trait', $id_trait);
        $this->db->delete('traits_lang');
    }

    public function setTraitName ($id_trait, $lang, $newName)
    {
        $newName = clear_text($newName);
        $this->removeTraitLang($id_trait, $lang);
        $data = array (
            'nazwa' => $newName,
            'nazwa_frd' => $this->friendlink_model->generateName($newName, $lang),
            'id_trait' => $id_trait,
            'lang' =>  $lang
            );
        $this->db->insert('traits_lang', $data);
        return 'OK';
    }

    public function setTraitColor ($id, $color, $type)
    {
        $data[$type] = str_replace('#','',$color);
        $this->db->where('id', $id);
        $this->db->update('traits', $data);
        return 'OK';
    }

    public function setTraitView ($id, $view)
    {
        $data['view'] = $view;
        $this->db->where('id', $id);
        $this->db->update('traits', $data);
        return 'OK';
    }

    public function addTrait($d)
    {
        if (!isSet($d['view'])) $d['view'] = $this->cfg->get('category_typy');
        $data = array (
            'typ' => $d['table'],
            'view' => $d['view'],
            'kolor' => str_replace('#','',$d['kolor']),
            'font' => getContrast(str_replace('#','',$d['kolor'])),
            'dodano' => date('Y-m-d H:i:s')
        );
        $this->db->insert('traits', $data);
        $id_trait = $this->db->insert_id();
        $this->updateKolej($id_trait);
        foreach ($this->langs AS $lang_id => $lang)
            {
                $data = array (
                    'id_trait' => $id_trait,
                    'lang' => $lang_id,
                    'nazwa' => clear_text($d['nazwa']),
                    'nazwa_frd' => $this->friendlink_model->generateName($d['nazwa'], $lang_id)
                );
                $this->db->insert('traits_lang', $data);
            }
        return $id_trait;
    }

    private function updateKolej ($id_trait, $kolej = false)
        {
            if ($kolej)
                {
                    $data['kolej'] = $kolej;
                }
                else
                {
                    $data['kolej'] = $id_trait;
                }

            $this->db->where('id', $id_trait);
            $this->db->update('traits', $data);
        }

    public function delTrait ($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('traits');
        $this->removeTraitLang($id);
        $this->removeTraitsCon($id);
        return 'OK';
    }

    public function delAllTraitsCon ($page_id)
    {
        $this->db->where('id_page', $page_id);
        $this->db->delete('traits_con');
        return 'OK';
    }

    public function setStatus($id, $status)
    {
        $data['status'] = $status;
        $this->db->where('id', $id);
        $this->db->update('traits', $data);
    }

    public function checkIfTraitsCon ($page_id, $trait_id)
    {
        $this->db->from('traits_con');
        $this->db->where('id_trait', $trait_id);
        $this->db->where('id_page', $page_id);
        $query = $this->db->get();

        $result = $query->result();
        if (count($result) > 0) return true;
        else return false;
    }

    public function setTraitsCon ($page_id, $trait_id)
    {
        if ($this->checkIfTraitsCon ($page_id, $trait_id))
            {
                return true;
            }

        $data = array (
            'id_trait' => $trait_id,
            'id_page' => $page_id,
            'dodano' => date('Y-m-d H:i:s')
        );
        $this->db->insert('traits_con', $data);
    }

    public function removeTraitsCon ($trait_id, $page_id = false)
        {
        $this->db->where('id_trait', $trait_id);
        if ($page_id) $this->db->where('id_page', $page_id);
        $this->db->delete('traits_con');
        }

    public function saveCategories ($dataNew, $page_id)
    {
        if (is_array($dataNew))
            {
                foreach ($dataNew AS $d)
                    {
                        $data = array (
                            'id_trait' => $d,
                            'id_page' => $page_id,
                            'dodano' => date('Y-m-d H:i:s')
                        );
                        $this->db->insert('traits_con', $data);
                    }
            }
    }

    public function saveTags ($dataNew, $page_id)
    {
        if (is_array($dataNew))
            {
                foreach ($dataNew AS $d)
                    {
                        $data = array (
                            'id_trait' => $d,
                            'id_page' => $page_id,
                            'dodano' => date('Y-m-d H:i:s')
                        );
                        $this->db->insert('traits_con', $data);
                    }
            }
    }

    public function saveParams ($dataNew, $page_id)
    {
        if (is_array($dataNew))
            {
                foreach ($dataNew AS $d => $value)
                    {
                        if (strlen($value) > 0)
                            {
                                $data = array (
                                    'id_trait' => $d,
                                    'id_page' => $page_id,
                                    'value' => $value,
                                    'dodano' => date('Y-m-d H:i:s')
                                );
                                $this->db->insert('traits_con', $data);
                            }
                    }
            }
    }
}
