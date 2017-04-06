<?php

class Main extends MY_Page_Controller
{

    function __construct ()
    {
        parent::__construct();
        $this->load->model('page/trait_model');
        $this->load->model('page/page_model');
        $this->load->model('page/photo_model');
        $this->load->model('page/file_model');
        $this->load->model('page/comments_model');
        $this->load->helper('pagination_helper');
        $this->data['banners_cats'] = array();
    }

    public function index ()
    {
        $cacheID = 'slider';
        $cache[$cacheID] = $this->cache->get($cacheID);
        if ($cache[$cacheID] === false)
            {
                $data['slider'] = $this->getSlider(SLIDERCAT, $this->data['lang_page']);
                $this->cache->save($cacheID, $data['slider'], CACHE_TIME);
            }
            else
            {
                $data['slider'] = $cache[$cacheID];
            }

        $cacheID = 'grid';
        $cache[$cacheID] = $this->cache->get($cacheID);
        if ($cache[$cacheID] === false)
            {
                $data['grid'] = $this->getSlider(GRIDCAT, $this->data['lang_page']);
                $this->cache->save($cacheID, $data['grid'], CACHE_TIME);
            }
            else
            {
                $data['grid'] = $cache[$cacheID];
            }

        $options_array = $this->cfg->getOptions('grid_main_cells');
        $all = count($data['grid']['pages']['list']);
        $dest = $options_array[$this->cfg->get('grid_main_cells')];
        $data['grid_cells'] = gridMaxNumber($options_array, $all, $dest);

        $this->data = $this->mergeData($this->data, $data);
        $this->showCategory(CATEGORY_POST_ID, array('showTitle' => false));
    }

    public function _remap($method)
    {
        if ($method == 'index')
            {
                $this->index();
            }
            else
            {
                $cacheID = 'dest-'.$method.'-'.$this->data['lang_page'];
                $cache[$cacheID] = $this->cache->get($cacheID);
                if ($cache[$cacheID] === false)
                    {
                        $dest = $this->findDestination($method);
                        $this->cache->save($cacheID, $dest, CACHE_TIME);
                    }
                    else
                    {
                        $dest = $cache[$cacheID];
                    }

                if ($dest['type'] == 'page')
                    {
                        $this->showPage($dest['id']);
                    }
                    else if ($dest['type'] == 'trait')
                    {
                        $this->showCategory($dest['id']);
                    }
                    else
                    {
                        $this->load->view('errors/my/error_404.php');
                    }
            }
    }

    public function findDestination($method)
    {
        $test_traits = $this->trait_model->findDestinationInTraits($method);
        if ($test_traits) { return $test_traits; }
        $test_pages = $this->page_model->findDestinationInPages($method);
        if ($test_pages) { return $test_pages; }

    }

    public function showPage ($id_page)
    {

        if ($this->input->post('username'))
            {
                $input = array (
                    'parent_id' => $this->input->post('parent_id', true),
                    'username' => $this->input->post('username', true),
                    'tresc' => $this->input->post('tresc', true),
                    'email' => $this->input->post('email', true),
                    'id_page' => $id_page,
                    'dodano' => date('Y-m-d H:i:s'),
                    'ip' => $_SERVER["REMOTE_ADDR"]
                );
                if ($this->comments_model->insertComment($input))
                    {
                        $this->session->set_flashdata('info_message','Twój komentarz został dodany.');
                        redirect($this->uri->uri_string());
                    }
                    else
                    {
                        $this->data['alert_message'] = 'Twój komentarz nie został dodany.';
                    }
            }

        $cacheID = 'page-'.$id_page.'-'.$this->data['lang_page'];
        $cache[$cacheID] = $this->cache->get($cacheID);
        if ($cache[$cacheID] === false)
            {
                $data['page'] = $this->page_model->getPage($id_page, $this->data['lang_page']);

                if (!$data['page'])
                    {
                        $this->load->view('errors/my/error_404.php');
                        return;
                    }

                $data['files'] = $this->file_model->getFiles($data['page']['id'], $this->data['lang_page']);
                $data['photos'] = $this->photo_model->getPhotos($data['page']['id'], $this->data['lang_page']);

                preg_match_all('|{foto:([0-9]*)}|U', $data['page']['tekst'], $pregs);
                if (!empty($pregs[1]))
                {
                    foreach ($pregs[1] AS $k => $v)
                        {
                            if (isSet($data['photos'][($v-1)]))
                                {
                                    $data['page']['tekst'] = str_replace($pregs[0][$k], '<img src="'.PHOTO_UPLOAD_FOLDER.$data['photos'][($v-1)]['plik'].'">', $data['page']['tekst']);
                                    $data['photos'][($v-1)]['noshow'] = 1;
                                }
                                else
                                {
                                    $data['page']['tekst'] = str_replace($pregs[0][$k], '', $data['page']['tekst']);
                                }
                        }
                }


                $data['traits'] = $this->trait_model->getTraitsForPage($data['page']['id'], $this->data['lang_page']);
                $data['tags'] = array();
                foreach ($data['traits'] AS $key => $value)
                    {
                        $this->data['banners_cats'][] = $value['id'];
                        if ($value['typ'] == 'tags') $data['tags'][] = $value;

                    }
                $data['page']['comments_count'] = $this->comments_model->getCommentsCountList($data['page']['id']);

                if ($data['page']['type'] == 1)
                    {
                        $data['comments_last'] = $this->comments_model->getLastComments($this->data['lang_page']);
                        $data['comments_most'] = $this->comments_model->getMostComments($this->data['lang_page']);
                    }

                if ($data['page']['type'] == 3)
                    {
                        $data['addad'] = true;
                    }


                if (isSet($data['page']['cons']))
                    {
                        foreach ($data['page']['cons'] AS $cons)
                            {
                                if ($cons['type'] == TYPE_GALLERY)
                                    {
                                        $addPhotos = $this->photo_model->getPhotos($cons['id'], $this->data['lang_page']);
                                        if ($addPhotos) $data['photos'] = array_merge($data['photos'], $addPhotos);
                                    }
                            }
                    }

                $data['walk_pages'] = $this->page_model->getWalkPage($data['page'], $this->data['lang_page']);

                $this->cache->save($cacheID, $data, CACHE_TIME);
            }
            else
            {
                $data = $cache[$cacheID];
            }

        $this->data = $this->mergeData($this->data, $data);
        $this->load->template_page('page/page', $this->data);
    }

    public function showCategory ($id_trait, $options = false)
    {
        $this->data['banners_cats'][] = $id_trait;
        $cacheID = 'category-'.$id_trait.'-'.$this->data['lang_page'];
        $cache[$cacheID] = $this->cache->get($cacheID);
        if ($cache[$cacheID] === false)
            {
                $categories = $this->page_model->getPagesFromCategory($id_trait, $this->data['lang_page']);
                $categories['photos'] = $this->photo_model->getFirstPhotos($this->data['lang_page']);
                $categories['files'] = $this->file_model->getFirstFiles($this->data['lang_page']);
                $categories['tags'] = $this->trait_model->getTraitsForPages($this->data['lang_page'], 'tags');
                $categories['cats'] = $this->trait_model->getTraitsForPages($this->data['lang_page'], 'categories');
                $categories['cats_list'] = $this->trait_model->getTraits($this->data['lang_page'], 'categories');
                $categories['for_grid'] = $this->trait_model->getPagesWithTrait(GRIDCAT);
                $categories['comments_count'] = $this->comments_model->getCommentsCountList();

                if (in_array($categories['typ'], array('categories', 'tags')))
                    {
                        $categories['comments_last'] = $this->comments_model->getLastComments($this->data['lang_page']);
                        $categories['comments_most'] = $this->comments_model->getMostComments($this->data['lang_page']);
                    }

                    if (in_array($categories['typ'], array('ads')))
                        {
                            $categories['addad'] = true;
                        }


                $this->cache->save($cacheID, $categories, CACHE_TIME);
            }
            else
            {
                $categories = $cache[$cacheID];
            }

        $categories['p'] = 1;
        if ($this->input->get('p'))
            {
                $categories['p'] = $this->input->get('p');
            }


        if (isSet($categories['list']) && count($categories['list']) === 1)
            {
                $this->showPage($categories['list'][0]['id']);
            }
            else if (isSet($categories['list']) && $categories['list'] == NULL && $categories['typ'] !== 'ads')
            {
                $this->load->view('errors/my/error_404.php');
            }
            else
            {
                $this->showCategoryList($categories, $options);
            }
    }

    public function showCategoryList ($categories, $options = false)
    {
        $data['style'] = array();
        if (isSet($categories['cats_list'])) foreach ($categories['cats_list'] AS $c)
            {
                if ($c->id == CATEGORY_HIGHLIGHT)
                {
                    $data['style'][] = '.highlighted, .highlighted a {background-color: #'.$c->kolor.'; color: #'.$c->font.'}';
                }
                else if ($c->id == CATEGORY_SPEED_NEWS)
                {
                    $data['style'][] = '.highlighted_speed, .highlighted_speed a {background-color: #'.$c->kolor.'; color: #'.$c->font.'}';
                }
            }

        if (isSet($categories['comments_last'])) $this->data['comments_last'] = $categories['comments_last'];
        if (isSet($categories['comments_most'])) $this->data['comments_most'] = $categories['comments_most'];
        if (isSet($categories['addad'])) $this->data['addad'] = true;
        $this->data['categories'] = $categories;

        $data['grid']['pages']['list'] = array();
        foreach ($categories['list'] AS $c)
            {
                if (in_array($c['id'], $categories['for_grid']))
                    {
                        $data['grid']['pages']['list'][] = $c;
                    }
            }
        $data['grid']['photos'] = $categories['photos'];
        $data['grid']['tags'] = $categories['tags'];
        $data['grid']['comments_count'] = $categories['comments_count'];

        if (!isSet($this->data['grid_cells']))
            {
                $options_array = $this->cfg->getOptions('grid_cat_cells');
                $all = count($data['grid']['pages']['list']);
                $dest = $options_array[$this->cfg->get('grid_cat_cells')];
                $data['grid_cells'] = gridMaxNumber($options_array, $all, $dest);
            }

        $this->data['options'] = $options;

        $this->data = $this->mergeData($this->data, $data);
        $this->load->template_page('page/category', $this->data);
    }

    public function getSlider($cat, $lang)
    {
        $limit = $this->cfg->get('main_slider_limit');
        $data['pages'] = $this->page_model->getPagesFromCategory($cat, $this->data['lang_page'], $limit);
        $data['photos'] = $this->photo_model->getFirstPhotos($this->data['lang_page']);
        $data['tags'] = $this->trait_model->getTraitsForPages($this->data['lang_page'], 'tags');
        $data['comments_count'] = $this->comments_model->getCommentsCountList();

        return $data;
    }

}
