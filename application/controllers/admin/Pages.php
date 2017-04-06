<?php

class Pages extends MY_Admin_Controller
{

    function __construct() {
        parent::__construct();
        $this->load->model('admin/page_model');
        $this->checkPermission($this->className());
        $this->data['pages'] = $this->page_model->getPages();
        $this->data['element_status'] = $this->config->item('element_status');
        $this->data['page_typy'] = $this->config->item('page_typy');
        $this->data['yes_no'] = $this->config->item('yes_no');
    }

    public function index ()
    {
        $this->checkPermission($this->className(), __METHOD__);
        if ($this->input->post('bulkSubmit') && $this->input->post('bulk'))
            {
                $this->bulkPages();
                $this->data['pages'] = $this->page_model->getPages();
            }

        $data['traits'] = $this->getTraitsForAllPages();
        $data['counts'] = $this->getCounts();

        $this->data = $this->mergeData($this->data, $data);

        $data['filtr'] = $this->config->item('page_filtr');
        if ($this->input->get('filtr_make'))
            {
                $data['filtr'] = array(
                    'type' => $this->input->get('filtr_type'),
                    'categories' => $this->input->get('filtr_cat'),
                    'tags' => $this->input->get('filtr_tag'),
                    'ads' => $this->input->get('filtr_ad'),
                    'search_text' => $this->input->get('search_text')
                );
            }

        if ($this->input->get('filtr_cat') && $this->input->get('filtr_cat') > 0)
            {
                foreach ($this->data['pages'] AS $id_page => $d)
                    {
                        if (!isSet($data['traits']['data'][$id_page]['categories'][$this->input->get('filtr_cat')]))
                            {
                                unset($this->data['pages'][$id_page]);
                            }
                    }
            }
            else if ($this->input->get('filtr_cat') == -1) {
                foreach ($this->data['pages'] AS $id_page => $d)
                    {
                        if (isSet($data['traits']['data'][$id_page]['categories']))
                            {
                                unset($this->data['pages'][$id_page]);
                            }
                    }
            }

        if ($this->input->get('filtr_tag'))
            {
                foreach ($this->data['pages'] AS $id_page => $d)
                    {
                        if (!isSet($data['traits']['data'][$id_page]['tags'][$this->input->get('filtr_tag')]))
                            {
                                unset($this->data['pages'][$id_page]);
                            }
                    }
            }

        if ($this->input->get('filtr_ad'))
            {
                foreach ($this->data['pages'] AS $id_page => $d)
                    {
                        if (!isSet($data['traits']['data'][$id_page]['ads'][$this->input->get('filtr_ad')]))
                            {
                                unset($this->data['pages'][$id_page]);
                            }
                    }
            }

        if ($this->input->get('filtr_type'))
            {
                foreach ($this->data['pages'] AS $id_page => $d)
                    {
                        if ($this->data['pages'][$id_page]->type != $this->input->get('filtr_type'))
                            {
                                unset($this->data['pages'][$id_page]);
                            }
                    }
            }

        if ($this->input->get('search_text') && $this->input->get('search_text') != '')
            {
                foreach ($this->data['pages'] AS $id_page => $d)
                    {
                        if (!$this->searchText($d, $this->input->get('search_text')))
                            {
                                unset($this->data['pages'][$id_page]);
                            }
                    }
            }


        $data['page_permission'] = $this->permission->getPagePermission();

        $this->data = $this->mergeData($this->data, $data);

        $this->load->template_admin('admin/pages/list', $this->data);
    }

    private function searchText($d, $search)
    {

        foreach ($d->lang_data AS $lang => $data)
            {
                if (stripos($data->tytul, $search) !== false || stripos($data->tekst, $search) !== false)
                    {
                        return true;
                    }
            }

        return false;
    }

    private function bulkPages()
    {
        $bulks = array_keys($this->input->post('bulk'));

        if ($this->input->post('bulkOperation') == 'bulkDel')
            {
                foreach ($bulks AS $b)
                    {
                        $this->checkPermission($this->className(), 'Pages::del', $b);
                        $this->page_model->delPage($b);
                        $this->log('Usunięto stronę', 'page', $b);
                    }

                $data['success_message'] = 'Strony zostały usunięte.';
            }

        if ($this->input->post('bulkOperation') == 'bulkStatus')
            {
                foreach ($bulks AS $b)
                    {
                        $this->checkPermission($this->className(), 'Pages::edit', $b);
                        $this->page_model->setStatus($b, $this->input->post('bulkStatus'));
                        $this->log('Zmieniono status', 'page', $b);
                    }

                $data['success_message'] = 'Statusy zostały zmienione.';
            }

        if ($this->input->post('bulkOperation') == 'bulkType')
            {
                foreach ($bulks AS $b)
                    {
                        $this->checkPermission($this->className(), 'Pages::edit', $b);
                        $this->page_model->setType($b, $this->input->post('bulkType'));
                        $this->log('Zmieniono typ', 'page', $b);
                    }

                $data['success_message'] = 'Typ został zmieniony.';
            }

        if ($this->input->post('bulkOperation') == 'bulkCatAdd')
            {
                foreach ($bulks AS $b)
                    {
                        $this->checkPermission($this->className(), 'Pages::edit', $b);
                        $this->load->model('admin/trait_model');
                        $this->trait_model->setTraitsCon($b, $this->input->post('bulkCatAdd'));
                        $this->log('Przypisano kategorie', 'page', $b);
                    }

                $data['success_message'] = 'Kategorie zostały przypisane.';
            }

        if ($this->input->post('bulkOperation') == 'bulkTagAdd')
            {
                foreach ($bulks AS $b)
                    {
                        $this->checkPermission($this->className(), 'Pages::edit', $b);
                        $this->load->model('admin/trait_model');
                        $this->trait_model->setTraitsCon($b, $this->input->post('bulkTagAdd'));
                        $this->log('Przypisano tag', 'page', $b);
                    }

                $data['success_message'] = 'Tagi zostały przypisane.';
            }

        if ($this->input->post('bulkOperation') == 'bulkAdAdd')
            {
                foreach ($bulks AS $b)
                    {
                        $this->checkPermission($this->className(), 'Pages::edit', $b);
                        $this->load->model('admin/trait_model');
                        $this->trait_model->setTraitsCon($b, $this->input->post('bulkAdAdd'));
                        $this->log('Przypisano do ogłoszeń', 'page', $b);
                    }

                $data['success_message'] = 'Przypisano do ogłoszeń.';
            }

        if ($this->input->post('bulkOperation') == 'bulkCatRemove')
            {
                foreach ($bulks AS $b)
                    {
                        $this->checkPermission($this->className(), 'Pages::edit', $b);
                        $this->load->model('admin/trait_model');
                        $this->trait_model->removeTraitsCon($this->input->post('bulkCatRemove'), $b);
                        $this->log('Odpięto kategorie', 'page', $b);
                    }

                $data['success_message'] = 'Kategorie zostały odpięte.';
            }

        if ($this->input->post('bulkOperation') == 'bulkTagRemove')
            {
                foreach ($bulks AS $b)
                    {
                        $this->checkPermission($this->className(), 'Pages::edit', $b);
                        $this->load->model('admin/trait_model');
                        $this->trait_model->removeTraitsCon($this->input->post('bulkTagRemove'), $b);
                        $this->log('Odpięto tag', 'page', $b);
                    }

                $data['success_message'] = 'Tagi zostały odpięte.';
            }

            if ($this->input->post('bulkOperation') == 'bulkAdRemove')
                {
                    foreach ($bulks AS $b)
                        {
                            $this->checkPermission($this->className(), 'Pages::edit', $b);
                            $this->load->model('admin/trait_model');
                            $this->trait_model->removeTraitsCon($this->input->post('bulkAdRemove'), $b);
                            $this->log('Odpięto z ogłoszeń', 'page', $b);
                        }

                    $data['success_message'] = 'Odpięto z ogłoszeń.';
                }

        if ($this->input->post('bulkOperation') == 'bulkPermsAdd')
            {
                foreach ($bulks AS $b)
                    {
                        $this->checkPermission('Users', 'Users::edit');
                        $this->permission->setPagePermission($b, 1, $this->input->post('bulkPermsAdd'));
                    }

                $data['success_message'] = 'Przywileje zostały dodane.';
            }

        if ($this->input->post('bulkOperation') == 'bulkPermsRemove')
            {
                foreach ($bulks AS $b)
                    {
                        $this->checkPermission('Users', 'Users::edit');
                        $this->permission->removePagePermission($b, $this->input->post('bulkPermsRemove'));
                    }

                $data['success_message'] = 'Przywileje zostały usunięte.';
            }

    }


    private function getTraitsForAllPages()
    {
        $this->load->model('admin/trait_model');
        return $this->trait_model->getTraitsForAllPages();
    }

    private function getCounts()
    {
        $count = array();
        $this->load->model('admin/photo_model');
        $c['photos'] = $this->photo_model->getPhotosCountList();

        foreach ($c['photos'] AS $f)
            {
            $count[$f->id_page]['photos'] = $f->ile;
            }

        $this->load->model('admin/file_model');
        $c['files'] = $this->file_model->getFilesCountList();

        foreach ($c['files'] AS $f)
            {
            $count[$f->id_page]['files'] = $f->ile;
            }

        $this->load->model('admin/comments_model');
        $c['comments'] = $this->comments_model->getCommentsCountList();

        foreach ($c['comments'] AS $f)
            {
            $count[$f->id_page]['comments'] = $f->ile;
            }

        return $count;
    }

    public function del ($id = 0)
    {
        $this->checkPermission($this->className(), __METHOD__, $id);
        if ($id == 0) $id = $this->uri->segment(4);
        $pages = $this->page_model->delPage($id);
        $data['success_message'] = 'Strona została usunięta.';
        $this->log('Usunięcie pages', 'page', $id);
        $this->data = $this->mergeData($this->data, $data);
        $this->index();
    }

    public function newPage ()
    {
        $this->checkPermission($this->className(), __METHOD__);
        $this->load->library('form_validation');
        $this->load->helper('form');

        $data['p'] = $this->page_model->getEmptyPage();
        $data['traits'] = $this->getTraitsForAllPages();
        $data['action'] = 'new';

        $data['page_permission'] = $this->permission->getPagePermission();

        $this->data = $this->mergeData($this->data, $data);

        if ($this->input->post('submit'))
            {
            $this->form_validation->set_error_delimiters('<p class="alert alert-danger">', '</p>');
            $this->form_validation->set_rules('tytul['.$this->data['lang_main'].']', 'Tytuł '.$this->data['langs'][$this->data['lang_main']]['name'], 'trim|required');
            $this->form_validation->set_rules('dodano', 'Data utworzenia', 'trim|callback_check_valid_date');
            $this->form_validation->set_rules('publish_up', 'Rozpocznij publikację', 'trim|callback_check_valid_date');
            $this->form_validation->set_rules('publish_down', 'Zakończ publikację', 'trim|callback_check_valid_date');

            if ($this->form_validation->run() != FALSE)
                {
                    $data = array (
                        'tytul' => $this->input->post('tytul'),
                        'podstrony' => $this->input->post('podstrony'),
                        'tekst' => $this->input->post('tekst'),
                        'lead' => $this->input->post('lead'),
                        'type' => $this->input->post('type'),
                        'status' => $this->input->post('status'),
                        'comments_allow' => $this->input->post('comments_allow'),
                        'comments_show' => $this->input->post('comments_show'),
                        'dodano' => $this->input->post('dodano'),
                        'publish_up' => $this->input->post('publish_up'),
                        'publish_down' => $this->input->post('publish_down'),
                        'event_location' => $this->input->post('event_location'),
                        'event_organizer' => $this->input->post('event_organizer'),
                        'event_start' => $this->input->post('event_start'),
                        'event_end' => $this->input->post('event_end'),
                        'autor' => $this->session->admin_id
                    );

                    $result = $id = $this->page_model->addPage($data);
                    $this->saveTraits($id);
                    $this->log('Utworzenie nowej strony', 'page', $id);

                    if ($this->permission->hasPermission('Users', 'Users::edit'))
                        {
                            $perms = array();
                            if ($this->input->post('perms')) $perms = $this->input->post('perms');
                            $this->permission->setPagesPermissions($id, $perms);
                        }

                    if ($result)
                        {
                            $data['success_message'] = 'Strona została utworzona.';
                        }
                        else
                        {
                            $data['alert_message'] = 'Uwaga! Pojawił sie błąd przy zapisie do bazy danych, dane nie zostały zapisane.';
                        }

                    $this->data = $this->mergeData($this->data, $data);
                    $this->data['pages'] = $this->page_model->getPages();
                    redirect('admin/pages');
                    return true;

                }
                else
                {
                    $data['alert_message'] = 'There are errors in your form submission, please see below for details.';
                }

            }

        $this->load->template_admin('admin/pages/edit', $this->data);
    }

    private function isCorrectPageId($id)
    {
        if (!is_numeric($id) || !isSet($this->data['pages'][$id]))
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    public function edit ()
    {
        $this->load->library('form_validation');
        $this->load->helper('form');
        $id = $this->uri->segment(4);

        if (!$this->isCorrectPageId($id))
            {
            redirect('admin/pages');
            }

        $this->checkPermission($this->className(), __METHOD__, $id);

        if ($this->input->post('submit'))
            {
            $this->form_validation->set_error_delimiters('<p class="alert alert-danger">', '</p>');
            $this->form_validation->set_rules('tytul['.$this->data['lang_main'].']', 'Tytuł '.$this->data['langs'][$this->data['lang_main']]['name'], 'trim|required|xss_clean');
            $this->form_validation->set_rules('dodano', 'Data utworzenia', 'trim|callback_check_valid_date');
            $this->form_validation->set_rules('publish_up', 'Rozpocznij publikację', 'trim|callback_check_valid_date');
            $this->form_validation->set_rules('publish_down', 'Zakończ publikację', 'trim|callback_check_valid_date');

    		if ($this->form_validation->run() != FALSE)
    		    {
                    if ($this->permission->hasPermission('Users', 'Users::edit'))
                        {
                            $perms = array();
                            if ($this->input->post('perms')) $perms = $this->input->post('perms');
                            $this->permission->setPagesPermissions($id, $perms);
                        }

                    $data = array (
                        'id' => $id,
                        'tytul' => $this->input->post('tytul'),
                        'podstrony' => $this->input->post('podstrony'),
                        'tekst' => $this->input->post('tekst'),
                        'lead' => $this->input->post('lead'),
                        'type' => $this->input->post('type'),
                        'status' => $this->input->post('status'),
                        'comments_allow' => $this->input->post('comments_allow'),
                        'comments_show' => $this->input->post('comments_show'),
                        'dodano' => $this->input->post('dodano'),
                        'publish_up' => $this->input->post('publish_up'),
                        'publish_down' => $this->input->post('publish_down'),
                        'event_location' => $this->input->post('event_location'),
                        'event_organizer' => $this->input->post('event_organizer'),
                        'event_start' => $this->input->post('event_start'),
                        'event_end' => $this->input->post('event_end')
                    );

                    $result = $this->page_model->updatePage($data);
                    $this->saveTraits($id);
                    $this->log('Aktualizacja', 'page', $id);

                    if ($result)
                        {
                            $data['success_message'] = 'Dane zostały zapisane.';
                        }
                        else
                        {
                            $data['alert_message'] = 'Uwaga! Pojawił sie błąd przy zapisie do bazy danych, dane nie zostały zapisane.';
                        }
                }
                else
                {
                    $data['alert_message'] = 'There are errors in your form submission, please see below for details.';
                }
                $this->data['pages'] = $this->page_model->getPages();
            }


        $this->load->model('admin/pagehistory_model');
        $data['pageHistory'] = $this->pagehistory_model->getPageHistory($id);

        $data['page_permission'] = $this->permission->getPagePermission($id);

        $data['traits'] = $this->getTraitsForAllPages();
        $data['p'] = $this->data['pages'][$id];
        $data['id'] = $id;
        $data['action'] = 'edit';
        $this->data = $this->mergeData($this->data, $data);
        $this->load->template_admin('admin/pages/edit', $this->data);
    }

    public function check_valid_date($date)
    {
        if ($date == '' || $date == 'nigdy')
            {
                return true;
            }
            else if (checkDateTimeFormat($date) || checkDateFormat($date))
            {
                return true;
            }
            else
            {
                $this->form_validation->set_message('check_valid_date', 'Nieprawidłowy format daty lub nieprawidłowa data. Podaj datę, pustą wartość lub "nigdy".');
                return false;
            }
    }

    public function files ()
    {
        $this->load->library('form_validation');
        $this->load->helper('form');
        $id = $this->uri->segment(4);
        if (!$this->isCorrectPageId($id))
            {
            redirect('admin/pages');
            }

        $this->checkPermission($this->className(), __METHOD__, $id);

        $data['p'] = $this->data['pages'][$id];
        $data['id'] = $id;
        $this->data['subTitle'] = 'załączniki';

        $this->load->model('admin/file_model');

        $this->form_validation->set_error_delimiters('<p class="alert alert-danger">', '</p>');
        $this->form_validation->set_rules('nazwa', 'Nazwa pliku', 'trim|required');

        if ($this->input->post('submit'))
            {
                $this->load->library('upload');

                $config['upload_path'] = FILE_UPLOAD_FOLDER;
                $config['allowed_types'] = '*';
                $config['max_size'] = FILE_MAX_SIZE;

                $files = $_FILES['userfile'];

                $number_of_files = sizeof($_FILES['userfile']['tmp_name']);

                for ($i = 0; $i < $number_of_files; $i++)
                    {
                    $_FILES['userfile']['name'] = $files['name'][$i];
                    $_FILES['userfile']['type'] = $files['type'][$i];
                    $_FILES['userfile']['tmp_name'] = $files['tmp_name'][$i];
                    $_FILES['userfile']['error'] = $files['error'][$i];
                    $_FILES['userfile']['size'] = $files['size'][$i];
                    $ext = pathinfo($_FILES['userfile']['name'], PATHINFO_EXTENSION);
                    $filename = pathinfo($_FILES['userfile']['name'], PATHINFO_FILENAME);
                    $new_name = no_pl($filename).'.'.$ext;
                    $config['file_name'] = $new_name;


                    //now we initialize the upload library
                    $this->upload->initialize($config);

            		if (!$this->upload->do_upload() || !$this->form_validation->run())
            		    {
                            $data['alert_message'][] = 'There are errors in your form submission, please see below for details.';
            			    $data['alert_message'][] = $this->upload->display_errors();
            		    }
            		else
            		    {
                            $d = $this->upload->data();
                            $d['page_id'] = $id;
                            $d['name'] = $this->input->post('nazwa');
            			    $this->file_model->addFile($d);
                            $data['success_message'] = 'Załącznik został dodany.';
                            $this->log('Dodano załącznik', 'page', $id);
            		    }
                }
            }

        if ($this->uri->segment(5) == 'del' && is_numeric($this->uri->segment(6)))
            {
                $this->file_model->delFile($this->uri->segment(6));
                $this->log('Usunięto załącznik', 'page', $id);
            }

        if ($this->input->post('bulkSubmit') && $this->input->post('bulk'))
            {
                $bulks = array_keys($this->input->post('bulk'));

                if ($this->input->post('bulkOperation') == 'bulkDel')
                    {
                        foreach ($bulks AS $b)
                            {
                                $this->file_model->delFile($b);
                                $this->log('Usunięto załącznik', 'page', $b);
                            }

                        $data['success_message'] = 'Załączniki zostały usunięte.';
                    }

                if ($this->input->post('bulkOperation') == 'bulkStatus')
                    {
                        foreach ($bulks AS $b)
                            {
                                $this->file_model->setStatus($b, $this->input->post('bulkStatus'));
                                $this->log('Zmieniono status', 'file', $b);
                            }
                        $data['success_message'] = 'Statusy zostały zmienione.';
                    }

                if ($this->input->post('bulkOperation') == 'bulkMove')
                    {
                        foreach ($bulks AS $b)
                            {
                                $this->file_model->moveFile($b, $this->input->post('bulkMove'));
                                $this->log('Przeniesiono załączniki', 'page', $b);
                            }

                        $data['success_message'] = 'Przeniesiono załączniki.';
                    }

                if ($this->input->post('bulkOperation') == 'bulkCopy')
                    {
                        foreach ($bulks AS $b)
                            {
                                $this->file_model->copyFile($b, $this->input->post('bulkCopy'));
                                $this->log('Skopiowano załączniki', 'page', $b);
                            }

                        $data['success_message'] = 'Skopiowano załączniki.';
                    }
            }


        $data['files'] = $this->file_model->getFiles($id);

        $this->data = $this->mergeData($this->data, $data);
        $this->load->template_admin('admin/pages/files', $this->data);
    }


    public function photos ()
    {
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->helper('photo_helper');
        $id = $this->uri->segment(4);
        if (!$this->isCorrectPageId($id))
            {
            redirect('admin/pages');
            }

        $this->checkPermission($this->className(), __METHOD__, $id);

        if ($this->uri->segment(5) == 'edit' && is_numeric($this->uri->segment(6)))
            {
                $this->photoEdit($id, $this->uri->segment(6));
                return true;
            }

        $data['p'] = $this->data['pages'][$id];
        $data['id'] = $id;
        $this->data['subTitle'] = 'zdjęcia';

        $this->load->model('admin/photo_model');

        $this->form_validation->set_error_delimiters('<p class="alert alert-danger">', '</p>');
        $this->form_validation->set_rules('nazwa', 'Nazwa pliku', 'trim|required');

        if ($this->input->post('submit'))
            {
                $this->load->library('upload');

                $config['upload_path'] = PHOTO_UPLOAD_FOLDER;
                $config['allowed_types'] = 'gif|jpg|jpeg|png';
                $config['max_size'] = FILE_MAX_SIZE;

                $files = $_FILES['userfile'];

                $number_of_files = sizeof($_FILES['userfile']['tmp_name']);

                for ($i = 0; $i < $number_of_files; $i++)
                    {
                    $_FILES['userfile']['name'] = $files['name'][$i];
                    $_FILES['userfile']['type'] = $files['type'][$i];
                    $_FILES['userfile']['tmp_name'] = $files['tmp_name'][$i];
                    $_FILES['userfile']['error'] = $files['error'][$i];
                    $_FILES['userfile']['size'] = $files['size'][$i];
                    $ext = pathinfo($_FILES['userfile']['name'], PATHINFO_EXTENSION);
                    $filename = pathinfo($_FILES['userfile']['name'], PATHINFO_FILENAME);
                    $new_name = no_pl($filename).'.'.$ext;
                    $config['file_name'] = $new_name;

                    $this->upload->initialize($config);

                    if (!$this->upload->do_upload() || !$this->form_validation->run())
                        {
                            $data['alert_message'][] = 'There are errors in your form submission, please see below for details.';
                            $data['alert_message'][] = $this->upload->display_errors();
                        }
                    else
                        {
                            $d = $this->upload->data();
                            $d['page_id'] = $id;
                            $d['name'] = $this->input->post('nazwa');
                            $d['icon_name'] = $d['raw_name'].'_i'.$d['file_ext'];
                            $d['crop_name'] = $d['raw_name'].'_c'.$d['file_ext'];

        			        zmniejsz_fotke(PHOTO_UPLOAD_FOLDER.$d['file_name'], PHOTO_UPLOAD_FOLDER.$d['file_name'], PHOTO_MAX_X);
        			        zmniejsz_fotke(PHOTO_UPLOAD_FOLDER.$d['file_name'], PHOTO_UPLOAD_FOLDER.$d['icon_name'], PHOTO_ICON_X);
                            cropImage(PHOTO_UPLOAD_FOLDER.$d['file_name'], PHOTO_UPLOAD_FOLDER.$d['crop_name'], PHOTO_CROP_X, PHOTO_CROP_Y);

                            $this->photo_model->addPhoto($d);
                            $data['success_message'] = 'Zdjęcie zostało dodane.';
                            $this->log('Dodano zdjęcie', 'page', $id);
                        }
                    }
            }

        if ($this->uri->segment(5) == 'del' && is_numeric($this->uri->segment(6)))
            {
                $this->photo_model->delPhoto($this->uri->segment(6));
                $this->log('Usunięto zdjęcie', 'page', $id);
            }

        if ($this->input->post('bulkSubmit') && $this->input->post('bulk'))
            {
                $bulks = array_keys($this->input->post('bulk'));

                if ($this->input->post('bulkOperation') == 'bulkDel')
                    {
                        foreach ($bulks AS $b)
                            {
                                $this->photo_model->delPhoto($b);
                                $this->log('Usunięto zdjęcie', 'page', $b);
                            }

                        $data['success_message'] = 'Zdjęcia zostały usunięte.';
                    }

                if ($this->input->post('bulkOperation') == 'bulkStatus')
                    {
                        foreach ($bulks AS $b)
                            {
                                $this->photo_model->setStatus($b, $this->input->post('bulkStatus'));
                                $this->log('Zmieniono status', 'file', $b);
                            }
                        $data['success_message'] = 'Statusy zostały zmienione.';
                    }

                if ($this->input->post('bulkOperation') == 'bulkMove')
                    {
                        foreach ($bulks AS $b)
                            {
                                $this->photo_model->movePhoto($b, $this->input->post('bulkMove'));
                                $this->log('Przeniesiono zdjęcia', 'page', $b);
                            }

                        $data['success_message'] = 'Przeniesiono zdjęcia.';
                    }

                if ($this->input->post('bulkOperation') == 'bulkCopy')
                    {
                        foreach ($bulks AS $b)
                            {
                                $this->photo_model->copyPhoto($b, $this->input->post('bulkCopy'));
                                $this->log('Skopiowano zdjęcia', 'page', $b);
                            }

                        $data['success_message'] = 'Skopiowano zdjęcia.';
                    }
            }


        $data['photos'] = $this->photo_model->getPhotos($id);

            foreach ($this->data['langs'] AS $lang_id => $lang)
                {
                if (isSet($data['p']->lang_data[$lang_id]->tekst) && $data['p']->lang_data[$lang_id]->tekst != '')
                    {
                        preg_match_all("/embed\/([^\"]*)\"/", $data['p']->lang_data[$lang_id]->tekst, $output_array);
                        if (isSet($output_array, $output_array[1]) && !empty($output_array[1]))
                            {
                                foreach ($output_array[1] AS $e)
                                    {
                                        $imgs[] = '<a class="youtube-add-icon" href="https://img.youtube.com/vi/'.$e.'/hqdefault.jpg"><img src="https://img.youtube.com/vi/'.$e.'/hqdefault.jpg"></a>';
                                    }

                                $data['warning_message'] = 'Artykuł prawdopodobnie zawiera film z youtube, możesz pobrać tutaj miniaturkę i wgrać ją do zdjęć.<br>'.implode(' ',$imgs);
                            }

                    }
                }


        $this->data = $this->mergeData($this->data, $data);
        $this->load->template_admin('admin/pages/photos', $this->data);
    }

    public function comments ()
    {
        $this->load->model('admin/comments_model');
        $id = $this->uri->segment(4);
        if (!$this->isCorrectPageId($id))
            {
            redirect('admin/pages');
            }

        $data['p'] = $this->data['pages'][$id];
        $data['id'] = $id;
        $this->data['subTitle'] = 'komentarze';

        $data['comments'] = $this->comments_model->getCommentsTree($id);

        if ($this->uri->segment(5) == 'edit' && is_numeric($this->uri->segment(6)))
            {
                $this->commentEdit($id, $this->uri->segment(6));
                return true;
            }

        $this->data = $this->mergeData($this->data, $data);
        $this->load->template_admin('admin/pages/comments', $this->data);

    }


    public function commentEdit ($page_id, $id)
    {
        $this->load->model('admin/comments_model');
        $this->load->helper('form');

        if ($this->input->post('submit'))
            {
                $input = array (
                    'id' => $id,
                    'parent_id' => $this->input->post('parent_id', true),
                    'username' => $this->input->post('username', true),
                    'tresc' => $this->input->post('tresc', true),
                    'email' => $this->input->post('email', true),
                    'id_page' => $page_id,
                    'edytowano' => $this->input->post('edytowano', true),
                    'ip' => $this->input->post('ip', true)
                );
                $this->comments_model->editComment($input);
            }

        $data['subTitle'] = 'komentarz edycja';
        $data['comment'] = $this->comments_model->getOneRecord($id);

        if (!$data['comment'])
            {
            redirect('admin/pages');
            }

        $data['page_id'] = $page_id;
        $this->data = $this->mergeData($this->data, $data);
        $this->load->template_admin('admin/pages/commentEdit', $this->data);
    }

    public function check_photo_size ($size)
    {
        if ($size > 50)
            {
                return true;
            }
            else
            {
                $this->form_validation->set_message('check_photo_size', 'Nieprawidłowe wymiary przycięcia.');
                return false;
            }
    }

    public function photoEdit ($page_id, $id)
    {
        $this->checkPermission($this->className(), __METHOD__, $page_id);
        $this->load->model('admin/photo_model');
        $this->load->library('form_validation');
        $this->load->helper('form');

        if ($this->input->post('submit'))
            {
            $this->form_validation->set_error_delimiters('<p class="alert alert-danger">', '</p>');
            $this->form_validation->set_rules('org[cords][w]', 'Org', 'trim|required|callback_check_photo_size');
            $this->form_validation->set_rules('icon[cords][h]', 'Icon', 'trim|required|callback_check_photo_size');
            $this->form_validation->set_rules('crop[cords][w]', 'Crop', 'trim|required|callback_check_photo_size');

            if ($this->form_validation->run() != FALSE)
                {
                    $data = array (
                        'org' => $this->input->post('org'),
                        'icon' => $this->input->post('icon'),
                        'crop' => $this->input->post('crop')
                    );
                    $result = $this->photo_model->cropAll($data, $id);
                    if ($result)
                        {
                            $data['success_message'] = 'Dane zostały zapisane.';
                        }
                        else
                        {
                            $data['alert_message'] = 'Uwaga! Pojawił sie błąd przy zapisie plików, dane nie zostały zapisane.';
                        }
                }
                else
                {
                    $data['alert_message'] = 'Uwaga! Dane nie zostały zapisane, ponieważ przycięcia zawiera błędy.';
                }

            }


        $data['subTitle'] = 'zdjęcie edycja';
        $data['photo'] = $this->photo_model->getOneRecord($id);

        if (!$data['photo'])
            {
            redirect('admin/pages');
            }

        $data['page_id'] = $page_id;
        $this->data = $this->mergeData($this->data, $data);
        $this->load->template_admin('admin/pages/photoEdit', $this->data);
    }

    private function saveTraits($page_id)
    {
        $this->load->model('admin/trait_model');
        $this->trait_model->delAllTraitsCon($page_id);
        if ($this->input->post('categories'))
            {
                $this->trait_model->saveCategories($this->input->post('categories'), $page_id);
            }
        if ($this->input->post('tags'))
            {
                $this->trait_model->saveTags($this->input->post('tags'), $page_id);
            }
        if ($this->input->post('ads'))
            {
                $this->trait_model->saveTags($this->input->post('ads'), $page_id);
            }
        if ($this->input->post('params'))
            {
                $this->trait_model->saveParams($this->input->post('params'), $page_id);
            }
    }

}
