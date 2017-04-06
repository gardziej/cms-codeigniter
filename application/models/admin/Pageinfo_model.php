<?php

class Pageinfo_model extends MY_Model
{
    public function __construct ()
    {
        parent::__construct();
    }

    private $info = array (
        'Dashboard' => array (
            'title' => 'Panel',
            'subTitle' => 'podsumowanie',
            'curMenu' => 'admin/dashboard'
        ),
        'Pages' => array (
            'title' => 'Strony',
            'subTitle' => 'edytor CMS',
            'curMenu' => 'admin/pages'
        ),
        'Traits' => array (
            'title' => 'Cechy',
            'subTitle' => '',
            'curMenu' => 'admin/traits'
        ),
        'Menu' => array (
            'title' => 'Menu',
            'subTitle' => 'edycja',
            'curMenu' => 'admin/menu'
        ),
        'Settings' => array (
            'title' => 'Ustawienia',
            'subTitle' => 'konfiguracja',
            'curMenu' => 'admin/settings'
        ),
        'Banners' => array (
            'title' => 'Banery, reklamy',
            'subTitle' => 'lista',
            'curMenu' => 'admin/banners'
        ),
        'Addons' => array (
            'title' => 'Dodatki HTML i JS',
            'subTitle' => 'lista',
            'curMenu' => 'admin/addons'
        ),
        'Guestbook' => array (
            'title' => 'Księga gości',
            'subTitle' => 'lista',
            'curMenu' => 'admin/guestbook'
        ),
        'Newsletter' => array (
            'title' => 'Newsletter',
            'subTitle' => 'lista',
            'curMenu' => 'admin/newsletter'
        ),
        'Fileman' => array (
            'title' => 'Menadżer',
            'subTitle' => 'plików',
            'curMenu' => 'admin/fileman'
        ),
        'Users' => array (
            'title' => 'Użytkownicy',
            'subTitle' => 'konfiguracja',
            'curMenu' => 'admin/users'
        )
    );

    public function get ($page)
        {
            if (isSet( $this->info[$page]))
                {
                return $this->info[$page];
                }
                else
                {
                return array (
                    'title' => '',
                    'subTitle' => '',
                    'curMenu' => ''
                    );
                }
        }

}
