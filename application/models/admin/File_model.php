<?php

class MaskFile {
    public $nazwa = '';
}

class File_model extends MY_Model
{

    public function __construct ()
    {
        parent::__construct();
        $this->load->library('languages');
        $this->langs = $this->languages->getLangs();
    }

    public function getFiles ($id)
    {
        $files = array();
        $this->db->from('pages_zalaczniki');
        $this->db->where('id_page', $id);
        $this->db->order_by("kolej", "desc");
        $query = $this->db->get();
        $files = $query->result();

        $this->db->from('pages_zalaczniki_lang');
        $result = $this->db->get()->result();
        if ($result) foreach ($result AS $r)
            {
                $lang_data[$r->id_file][$r->lang] = $r;
            }

        foreach ($files AS $k => $p)
        {
            foreach ($this->langs AS $lang_id => $lang)
                {
                    if (!isSet($lang_data[$p->id][$lang_id]))
                        {
                            $lang_data[$p->id][$lang_id] = new MaskFile();
                        }
                }
            $files[$k]->lang_data = $lang_data[$p->id];
        }

        return $files;
    }

    public function getOneRecord ($id)
    {
        $this->db->from('pages_zalaczniki_lang');
        $this->db->where('id_file', $id);
        $result = $this->db->get()->result();
        if ($result) foreach ($result AS $r)
            {
                $lang_data[$r->lang] = $r;
            }

        $this->db->from('pages_zalaczniki');
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

    public function getFilesCountList ()
    {
        $this->db->select('id_page, COUNT(id) as ile');
        $this->db->group_by('id_page');
        $query = $this->db->get('pages_zalaczniki');
        return $query->result();
    }

    private function removeFileLang($id_file, $lang)
    {
        $this->db->where('lang', $lang);
        $this->db->where('id_file', $id_file);
        $this->db->delete('pages_zalaczniki_lang');
    }

    public function setFileName ($id_file, $lang, $newName)
    {
        $newName = clear_text($newName);
        $this->removeFileLang($id_file, $lang);
        $data = array (
            'nazwa' => $newName,
            'id_file' => $id_file,
            'lang' =>  $lang
            );
        $this->db->insert('pages_zalaczniki_lang', $data);
        return 'OK';
    }

    public function addFile ($d)
    {
        $data = array (
            'id_page' => $d['page_id'],
            'plik' => $d['file_name'],
            'waga' => $d['file_size'],
            'rozszerzenie' => str_replace('.','',$d['file_ext']),
            'dodano' => date('Y-m-d H:i:s')
        );
        $this->db->insert('pages_zalaczniki', $data);
        $id_file = $this->db->insert_id();

        $this->addLangData($id_file, $d['name']);

    }


    public function addLangData ($id_file, $nameData)
    {

        if (is_string($nameData))
            {
            foreach ($this->langs AS $lang_id => $lang)
                {
                    $nameData = clear_text($nameData);
                    $data = array (
                        'id_file' => $id_file,
                        'lang' => $lang_id,
                        'nazwa' => $nameData
                    );
                    $this->db->insert('pages_zalaczniki_lang', $data);
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
                            'id_file' => $id_file,
                            'lang' => $lang_id,
                            'nazwa' => $copyName
                        );
                        $this->db->insert('pages_zalaczniki_lang', $data);
                    }
            }
    }


    public function moveFile ($id, $destPage)
    {
        $data['id_page'] = $destPage;
        $this->db->where('id', $id);
        $this->db->update('pages_zalaczniki', $data);
        return 'OK';
    }


    public function copyFile ($id, $destPage)
    {
        $this->load->library('upload');

        $org = $this->getOneRecord($id);

        $fileExt = $this->upload->get_extension($org->plik);
        $fileName = str_replace($fileExt, '', $org->plik);
        $fileName = preg_replace("/\d+$/","",$fileName);

		$new_filename = '';
		for ($i = 1; $i < 100; $i++)
		{
			if (!file_exists(FILE_UPLOAD_FOLDER.$fileName.$i.$fileExt))
			{
				$new_filename = $fileName.$i;
				break;
			}
		}

        if ($new_filename === '') $new_filename = md5(uniqid(mt_rand()));

        $new_filename = $new_filename.$fileExt;

        $new  = array(
            'page_id' => $destPage,
            'name' => $org->nazwa,
            'file_name' => $new_filename,
            'file_size' => $org->waga,
            'file_ext' => $fileExt
        );

        copy (FILE_UPLOAD_FOLDER.$org->plik, FILE_UPLOAD_FOLDER.$new_filename);
        $this->addFile($new);

        return 'OK';
    }

    public function delFile ($id)
    {
        $this->db->where('id', $id);
        $this->db->select('plik');
        $query = $this->db->get('pages_zalaczniki');
        $result = $query->result();
        if (isSet($result[0], $result[0]->plik))
            {
                $this->db->where('id', $id);
                $this->db->delete('pages_zalaczniki');

                if (file_exists(FILE_UPLOAD_FOLDER.$result[0]->plik))
                    {
                        unlink(FILE_UPLOAD_FOLDER.$result[0]->plik);
                    }

            }
    }

    public function setStatus($id, $status)
    {
        $data['status'] = $status;
        $this->db->where('id', $id);
        $this->db->update('pages_zalaczniki', $data);
    }


}
