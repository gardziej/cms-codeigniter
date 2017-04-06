<?php

class MaskAddon {
    public $tekst = '';
}

class Addon_model extends MY_Model
{

    public function __construct ()
    {
        parent::__construct();
        $this->load->library('languages');
        $this->langs = $this->languages->getLangs();
    }

    public function getEmptyAddon ()
    {
        $return = (object) array(
            'id' => 0,
            'nazwa' => '',
            'tekst' => '',
            'zone' => 0,
            'status' => 0
        );

        foreach ($this->langs AS $lang_id => $lang)
            {
                $return->lang_data[$lang_id] = new MaskAddon();
            }
        return $return;
    }

    public function getAddons ()
    {
        $this->db->from('addons_lang');
        $result = $this->db->get()->result();
        if ($result) foreach ($result AS $r)
            {
                $lang_data[$r->id_addon][$r->lang] = $r;
            }

        $addons = array();
        $this->db->from('addons');
        $this->db->order_by("zone", "asc");
        $this->db->order_by("kolej", "desc");
        $query = $this->db->get();

        foreach ($query->result() AS $f)
        {
            $addons[$f->id] = $f;
            foreach ($this->langs AS $lang_id => $lang)
                {
                    if (!isSet($lang_data[$f->id][$lang_id]))
                        {
                            $lang_data[$f->id][$lang_id] = new MaskAddon();
                        }
                }
            $addons[$f->id]->lang_data = $lang_data[$f->id];
        }

        return $addons;
    }

    private function removeAddonLang($id_addon, $lang)
    {
        $this->db->where('lang', $lang);
        $this->db->where('id_addon', $id_addon);
        $this->db->delete('addons_lang');
    }

    private function deleteAddonLangs ($id)
    {
        $this->db->where('id_addon', $id);
        $this->db->delete('addons_lang');
    }

    private function updateAddonsLangs ($d)
    {
        $id_addon = $d['id'];
        $this->deleteAddonLangs($id_addon);

        foreach ($this->langs AS $lang_id => $lang)
            {
                $data = array (
                    'id_addon' => $d['id'],
                    'lang' => $lang_id,
                    'tekst' => $d['tekst'][$lang_id]

                );
                $this->db->insert('addons_lang', $data);
            }
    }

    public function updateAddon ($d)
    {
        $data = array (
            'status' => $d['status'],
            'zone' => $d['zone'],
            'nazwa' => $d['nazwa'],
            'zmieniono' => date('Y-m-d H:i:s')
            );

        $this->db->where('id', $d['id']);
        $this->db->update('addons', $data);

        $this->updateAddonsLangs($d);

        return true;
    }

    public function addAddon ($d)
    {
        $data = array (
            'status' => $d['status'],
            'zone' => $d['zone'],
            'nazwa' => $d['nazwa'],
            'dodano' => date('Y-m-d H:i:s')
        );

        $this->db->insert('addons', $data);
        $id_addon = $this->db->insert_id();

        foreach ($this->langs AS $lang_id => $lang)
            {
                $data = array (
                    'id_addon' => $id_addon,
                    'lang' => $lang_id,
                    'tekst' => $d['tekst'][$lang_id]
                );
                $this->db->insert('addons_lang', $data);
            }
    }

    public function setStatus($id, $status)
    {
        $data['status'] = $status;
        $this->db->where('id', $id);
        $this->db->update('addons', $data);
    }

    public function setZone($id, $zone)
    {
        $data['zone'] = $zone;
        $this->db->where('id', $id);
        $this->db->update('addons', $data);
    }

    public function delAddon ($id_addon)
    {
        $this->db->where('id', $id_addon);
        $this->db->delete('addons');
        return true;
    }




}
