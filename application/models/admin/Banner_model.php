<?php

class MaskBanner {
    public $nazwa = '';
}

class Banner_model extends MY_Model
{

    public function __construct ()
    {
        parent::__construct();
        $this->load->library('languages');
        $this->langs = $this->languages->getLangs();
    }

    public function getEmptyBanner ()
    {
        $return = (object) array(
            'id' => 0,
            'link' => '',
            'plik' => '',
            'cat_only' => 0,
            'link_target' => '',
            'zone' => 0,
            'status' => 0
        );

        foreach ($this->langs AS $lang_id => $lang)
            {
                $return->lang_data[$lang_id] = new MaskBanner();
            }
        return $return;
    }

    public function getBanners ()
    {
        $this->db->from('banners_lang');
        $result = $this->db->get()->result();
        if ($result) foreach ($result AS $r)
            {
                $lang_data[$r->id_banner][$r->lang] = $r;
            }

        $banners = array();
        $this->db->from('banners');
        $this->db->order_by("zone", "asc");
        $this->db->order_by("kolej", "desc");
        $query = $this->db->get();

        foreach ($query->result() AS $f)
        {
            $banners[$f->id] = $f;
            foreach ($this->langs AS $lang_id => $lang)
                {
                    if (!isSet($lang_data[$f->id][$lang_id]))
                        {
                            $lang_data[$f->id][$lang_id] = new MaskBanner();
                        }
                }
            $banners[$f->id]->lang_data = $lang_data[$f->id];
        }

        return $banners;
    }

    private function removeBannerLang($id_banner, $lang)
    {
        $this->db->where('lang', $lang);
        $this->db->where('id_banner', $id_banner);
        $this->db->delete('banners_lang');
    }

    public function setBannerName ($id_banner, $lang, $newName)
    {
        $this->removeBannerLang($id_banner, $lang);
        $data = array (
            'nazwa' => $newName,
            'id_banner' => $id_banner,
            'lang' =>  $lang
            );
        $this->db->insert('banners_lang', $data);
        return 'OK';
    }

    private function deleteBannerLangs ($id)
    {
        $this->db->where('id_banner', $id);
        $this->db->delete('banners_lang');
    }

    private function updateBannerLangs ($d)
    {
        $id_banner = $d['id'];
        $this->deleteBannerLangs($id_banner);

        foreach ($this->langs AS $lang_id => $lang)
            {
                $data = array (
                    'id_banner' => $d['id'],
                    'lang' => $lang_id,
                    'nazwa' => $d['nazwa'][$lang_id]

                );
                $this->db->insert('banners_lang', $data);
            }
    }

    public function updateBanner ($d)
    {
        $data = array (
            'status' => $d['status'],
            'zone' => $d['zone'],
            'link' => $d['link'],
            'link_target' => $d['link_target'],
            'zmieniono' => date('Y-m-d H:i:s')
            );

        if (isSet($d['plik'])) $data['plik'] = $d['plik'];

        $this->db->where('id', $d['id']);
        $this->db->update('banners', $data);

        $this->updateBannerTraits($d);

        $this->updateBannerLangs($d);

        return true;
    }

    public function addBanner ($d)
    {
        $data = array (
            'status' => $d['status'],
            'zone' => $d['zone'],
            'link' => $d['link'],
            'link_target' => $d['link_target'],
            'dodano' => date('Y-m-d H:i:s')
        );

        if (isSet($d['plik'])) $data['plik'] = $d['plik'];

        $this->db->insert('banners', $data);
        $id_banner = $this->db->insert_id();

        $data['kolej'] = $id_banner;
        $this->db->where('id', $id_banner);
        $this->db->update('banners', $data);

        foreach ($this->langs AS $lang_id => $lang)
            {
                $data = array (
                    'id_banner' => $id_banner,
                    'lang' => $lang_id,
                    'nazwa' => $d['nazwa'][$lang_id]
                );
                $this->db->insert('banners_lang', $data);
            }

        $d['id'] = $id_banner;
        $this->updateBannerTraits($d);


    }

    public function setStatus($id, $status)
    {
        $data['status'] = $status;
        $this->db->where('id', $id);
        $this->db->update('banners', $data);
    }

    public function setZone($id, $zone)
    {
        $data['zone'] = $zone;
        $this->db->where('id', $id);
        $this->db->update('banners', $data);
    }

    public function delBanner ($id_banner)
    {
        $this->removeTraitsCon($id_banner);
        $this->db->where('id', $id_banner);
        $this->db->select('plik');
        $query = $this->db->get('banners');
        $result = $query->result();
        if (isSet($result[0], $result[0]->plik))
            {
                $this->db->where('id', $id_banner);
                $this->db->delete('banners');

                if ($result[0]->plik != '' && file_exists(BANNER_UPLOAD_FOLDER.$result[0]->plik))
                    {
                        unlink(BANNER_UPLOAD_FOLDER.$result[0]->plik);
                    }

            }

        return true;

    }

    public function updateBannerTraits($d)
    {
        $this->removeTraitsCon($d['id']);

        if (isSet($d['cat_only'])) foreach ($d['cat_only'] AS $ct)
        {
            $data = array (
                'id_banner' => $d['id'],
                'id_trait' => $ct,
                'dodano' => date('Y-m-d H:i:s')
            );
            $this->db->insert('banners_con', $data);
        }

    }

    public function getTraitsCon ($id_banner)
    {
        $res = array();

        $this->db->from('banners_con');
        $this->db->where('id_banner', $id_banner);
        $query = $this->db->get();

        $result = $query->result_array();

        foreach ($result AS $r)
            {
                $res[] = $r['id_trait'];
            }

        return $res;
    }

    public function removeTraitsCon ($id_banner)
    {
        $this->db->where('id_banner', $id_banner);
        $this->db->delete('banners_con');
    }

}
