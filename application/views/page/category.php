<?php

if (isSet($categories['list']))
    {
    echo '<div class="categoriesList">';

    $per_page = $this->cfg->get('pagination');

    if ($per_page > 0)
        {
            $start = ($categories['p'] - 1) * $per_page;
            $categories['list'] = array_slice($categories['list'], $start, $per_page);
        }

    foreach ($categories['list'] AS $k => $f)
    {
        if (isSet($categories['photos'][$f['id']]['crop']))
            {
                $categories['list'][$k]['leading_photo'] = $categories['photos'][$f['id']]['crop'];
            }
        if (isSet($categories['files'][$f['id']]['plik']))
            {
                $categories['list'][$k]['leading_file'] = $categories['files'][$f['id']]['plik'];
            }
        if (isSet($categories['tags'][$f['id']]))
            {
                $categories['list'][$k]['traits']['tags'] = $categories['tags'][$f['id']];
            }
        if (isSet($categories['cats'][$f['id']]))
            {
                $categories['list'][$k]['traits']['cats'] = $categories['cats'][$f['id']];
            }
        if (isSet($categories['comments_count'][$f['id']]))
            {
                $categories['list'][$k]['comments']['count'] = $categories['comments_count'][$f['id']];
            }
            else
            {
                $categories['list'][$k]['comments']['count'] = 0;
            }

        $categories['list'][$k]['comments']['text'] = commentsText($categories['list'][$k]['comments']['count']);

    }

    if ($options && !$options['showTitle'])
        {

        }
    else
        {
            echo '<h1>'.$categories['nazwa'].'</h1>';
        }

    echo '<h2>'.$categories['tekst'].'</h2>';

    $k = 0; $pack = 0;

    foreach ($categories['list'] AS $f)
        {

            switch ($categories['view']) {
                case '0':
                    $this->load->view('page/page_short', array('page' => $f));
                    break;
                case '1':
                    $this->load->view('page/page_short_leading_photo', array('page' => $f));
                    break;
                case '2':
                    $this->load->view('page/page_short_boxes', array('page' => $f));
                    break;
                case '3':
                    $this->load->view('page/page_short_boxes_big', array('page' => $f));
                    break;
                default:
                    $this->load->view('page/page_short', array('page' => $f));
                    break;
            }


            if (isSet($banners[250]))
                {
                    if (($k+1) % $this->cfg->get('banners_in_article_step') == 0)
                        {
                            $banners_pack = $banners[250];
                            //echo "<pre>"; print_r($banners_pack); echo "</pre><hr>"; exit;
                            foreach ($banners_pack AS $key => $v)
                                {
                                    if (!empty( $v['cat_only']) && !in_array($categories['id_trait'], $v['cat_only']))
                                        {
                                            unset($banners_pack[$key]);
                                        }
                                }

                            $start = $pack * $this->cfg->get('banners_in_article_group_count');
                            $start = $start + intval ($per_page / $this->cfg->get('banners_in_article_step')) * $this->cfg->get('banners_in_article_group_count') * ($categories['p']-1);
                            $banners_pack = array_slice($banners_pack, $start, $this->cfg->get('banners_in_article_group_count'));
                            $banners_chunk[250] = $banners_pack;
                            $this->load->view('page/inc/banner_zone', array('zone_id' => 250, 'banners' => $banners_chunk, 'banners_cats' => $banners_cats));
                            $pack++;
                        }
                }
            $k++;
        }
    echo '</div>';

    pagination($categories['count'], $categories['p'], $per_page);

    }
