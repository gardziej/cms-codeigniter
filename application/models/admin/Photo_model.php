<?php

class MaskPhoto {
    public $nazwa = '';
}

class Photo_model extends MY_Model
{

    public function __construct ()
    {
        parent::__construct();
        $this->load->library('languages');
        $this->langs = $this->languages->getLangs();
    }

    public function getPhotos ($id)
    {
        $photos = array();
        $this->db->from('pages_zdjecia');
        $this->db->where('id_page', $id);
        $this->db->order_by("kolej", "desc");
        $query = $this->db->get();
        $photos = $query->result();

        $this->db->from('pages_zdjecia_lang');
        $result = $this->db->get()->result();
        if ($result) foreach ($result AS $r)
            {
                $lang_data[$r->id_photo][$r->lang] = $r;
            }

        foreach ($photos AS $k => $p)
        {
            foreach ($this->langs AS $lang_id => $lang)
                {
                    if (!isSet($lang_data[$p->id][$lang_id]))
                        {
                            $lang_data[$p->id][$lang_id] = new MaskPhoto();
                        }
                }
            $photos[$k]->lang_data = $lang_data[$p->id];
        }

        return $photos;
    }

    public function getOneRecord ($id)
    {
        $this->db->from('pages_zdjecia_lang');
        $this->db->where('id_photo', $id);
        $result = $this->db->get()->result();
        if ($result) foreach ($result AS $r)
            {
                $lang_data[$r->lang] = $r;
            }

        $this->db->from('pages_zdjecia');
        $this->db->where('id', $id);
        $query = $this->db->get();
        $result = $query->result();
        if (isSet($result[0]))
            {
                $return = $result[0];
                if (isSet($lang_data))
                    {
                        $return->nazwa = $lang_data;
                    }
                return $return;
            }
        return false;
    }

    public function addPhoto ($d)
    {

        $data = array (
            'id_page' => $d['page_id'],
            'plik' => $d['file_name'],
            'icon' => $d['icon_name'],
            'crop' => $d['crop_name'],
            'waga' => $d['file_size'],
            'rozszerzenie' => str_replace('.','',$d['file_ext']),
            'dodano' => date('Y-m-d H:i:s')
        );
        $this->db->insert('pages_zdjecia', $data);
        $id_photo = $this->db->insert_id();

        $this->addLangData($id_photo, $d['name']);

    }


    public function addLangData ($id_photo, $nameData)
    {
        if (is_string($nameData))
            {
            foreach ($this->langs AS $lang_id => $lang)
                {
                    $nameData = clear_text($nameData);
                    $data = array (
                        'id_photo' => $id_photo,
                        'lang' => $lang_id,
                        'nazwa' => $nameData
                    );
                    $this->db->insert('pages_zdjecia_lang', $data);
                }
            }
            else if (is_array($nameData))
            {
                foreach ($this->langs AS $lang_id => $lang)
                    {
                        if (isSet($nameData[$lang_id], $nameData[$lang_id]->nazwa))
                            {
                                $copyName = $nameData[$lang_id]->nazwa;
                            }
                            else
                            {
                                $copyName = '';
                            }

                        $copyName = clear_text($copyName);
                        $data = array (
                            'id_photo' => $id_photo,
                            'lang' => $lang_id,
                            'nazwa' => $copyName
                        );
                        $this->db->insert('pages_zdjecia_lang', $data);
                    }
            }
    }

    public function getPhotosCountList ()
    {
        $this->db->select('id_page, COUNT(id) as ile');
        $this->db->group_by('id_page');
        $query = $this->db->get('pages_zdjecia');
        return $query->result();
    }

    private function removePhotoLang($id_photo, $lang)
    {
        $this->db->where('lang', $lang);
        $this->db->where('id_photo', $id_photo);
        $this->db->delete('pages_zdjecia_lang');
    }

    public function setPhotoName ($id_photo, $lang, $newName)
    {
        $newName = clear_text($newName);
        $this->removePhotoLang($id_photo, $lang);
        $data = array (
            'nazwa' => $newName,
            'id_photo' => $id_photo,
            'lang' =>  $lang
            );
        $this->db->insert('pages_zdjecia_lang', $data);
        return 'OK';
    }

    public function movePhoto ($id, $destPage)
    {
        $data['id_page'] = $destPage;
        $this->db->where('id', $id);
        $this->db->update('pages_zdjecia', $data);
        return 'OK';
    }

    public function updatePhotoWeight ($id, $waga)
    {
        $data['waga'] = $waga;
        $this->db->where('id', $id);
        $this->db->update('pages_zdjecia', $data);
        return 'OK';
    }

    public function copyPhoto ($id, $destPage)
    {
        $this->load->library('upload');

        $org = $this->getOneRecord($id);

        $fileExt = $this->upload->get_extension($org->plik);
        $fileName = str_replace($fileExt, '', $org->plik);
        $fileName = preg_replace("/\d+$/","",$fileName);

		$new_filename = '';
		for ($i = 1; $i < 100; $i++)
		{
			if (!file_exists(PHOTO_UPLOAD_FOLDER.$fileName.$i.$fileExt))
			{
				$new_filename = $fileName.$i;
				break;
			}
		}

        if ($new_filename === '') $new_filename = md5(uniqid(mt_rand()));

        $icon_name = $new_filename.'_i'.$fileExt;
        $crop_name = $new_filename.'_c'.$fileExt;
        $new_filename = $new_filename.$fileExt;

        $new  = array(
            'page_id' => $destPage,
            'name' => $org->nazwa,
            'file_name' => $new_filename,
            'icon_name' => $icon_name,
            'crop_name' => $crop_name,
            'file_size' => $org->waga,
            'file_ext' => $fileExt
        );

        copy (PHOTO_UPLOAD_FOLDER.$org->plik, PHOTO_UPLOAD_FOLDER.$new_filename);
        copy (PHOTO_UPLOAD_FOLDER.$org->icon, PHOTO_UPLOAD_FOLDER.$icon_name);
        copy (PHOTO_UPLOAD_FOLDER.$org->crop, PHOTO_UPLOAD_FOLDER.$crop_name);
        $this->addPhoto($new);

        return 'OK';
    }

    public function imageCreateHelper ($img_r, $data, $ratio)
    {
        $dst_r = ImageCreateTrueColor( $ratio * $data['w'], $ratio * $data['h'] );
        imagecopyresampled($dst_r, $img_r, 0, 0, $ratio * $data['x'], $ratio * $data['y'],
            $ratio * $data['w'], $ratio * $data['h'], $ratio * $data['w'], $ratio * $data['h']);
        return $dst_r;
    }

    public function cropAll($data, $id)
    {
        $mainPhoto = PHOTO_UPLOAD_FOLDER.$data['org']['plik'];
        $iconPhoto = PHOTO_UPLOAD_FOLDER.$data['icon']['plik'];
        $cropPhoto = PHOTO_UPLOAD_FOLDER.$data['crop']['plik'];
        $mainPhotoSize = getimagesize($mainPhoto);
        $ratio = $mainPhotoSize[0] / 800;
        if ($ratio < 1) $ratio = 1;

        $ext = $mainPhotoSize[2];
        $jpeg_quality = 90;

        switch($ext)
            {
            case 1:       //GIF
                $img_r = imagecreatefromgif($mainPhoto);
                break;
            case 2:       //JPEG
                $img_r = imagecreatefromjpeg($mainPhoto);
                break;
            case 3:       //PNG
                $img_r = imagecreatefrompng($mainPhoto);
                break;
            default:
                return FALSE;
                break;
            }

        $dst_r = $this->imageCreateHelper($img_r, $data['org']['cords'], $ratio);
        $dst_i = $this->imageCreateHelper($img_r, $data['icon']['cords'], $ratio);
        $dst_c = $this->imageCreateHelper($img_r, $data['crop']['cords'], $ratio);

        switch($ext)
            {
            case 1:
                imagegif($dst_r,$mainPhoto);
                imagegif($dst_i,$iconPhoto);
                imagegif($dst_c,$cropPhoto);
                break;
            case 2:
                imagejpeg($dst_r,$mainPhoto, $jpeg_quality);
                imagejpeg($dst_i,$iconPhoto, $jpeg_quality);
                imagejpeg($dst_c,$cropPhoto, $jpeg_quality);
                break;
            case 3:
                imagepng($dst_r,$mainPhoto);
                imagepng($dst_i,$iconPhoto);
                imagepng($dst_c,$cropPhoto);
                break;
            }

        zmniejsz_fotke($iconPhoto, $iconPhoto, 400);
        cropImage($cropPhoto, $cropPhoto, 400, 400);

        $this->updatePhotoWeight($id, filesize($mainPhoto)/1000);

        return true;

    }

    public function delPhoto ($id)
    {
        $this->db->where('id', $id);
        $this->db->select('plik, icon, crop');
        $query = $this->db->get('pages_zdjecia');
        $result = $query->result();
        if (isSet($result[0], $result[0]->plik))
            {
                $this->db->where('id', $id);
                $this->db->delete('pages_zdjecia');

                if (file_exists(PHOTO_UPLOAD_FOLDER.$result[0]->plik))
                    {
                        unlink(PHOTO_UPLOAD_FOLDER.$result[0]->plik);
                    }
                if (file_exists(PHOTO_UPLOAD_FOLDER.$result[0]->icon))
                    {
                        unlink(PHOTO_UPLOAD_FOLDER.$result[0]->icon);
                    }
                if (file_exists(PHOTO_UPLOAD_FOLDER.$result[0]->crop))
                    {
                        unlink(PHOTO_UPLOAD_FOLDER.$result[0]->crop);
                    }
            }
    }

    public function setStatus($id, $status)
    {
        $data['status'] = $status;
        $this->db->where('id', $id);
        $this->db->update('pages_zdjecia', $data);
    }


}
