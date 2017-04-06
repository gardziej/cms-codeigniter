<?php

// UWAGA ustaw sciezke fileman/conf.json

$config['seeting_type'] = array (
	'0' => 'input',
	'1' => 'textarea',
	'2' => 'radio'
);

$config['system_locked'] = array (
	'Traits' => array (
		2 => array ('Traits::del', 'Traits::edit'),
		3 => array ('Traits::del'),
		4 => array ('Traits::del'),
		5 => array ('Traits::del'),
		50 => array ('Traits::del')
	),
	'Pages' => array (
		1 => array ('Pages::del', 'Pages::edit', 'Pages::files'),
		2 => array ('Pages::del', 'Pages::edit', 'Pages::files'),
		3 => array ('Pages::del', 'Pages::edit', 'Pages::files'),
		4 => array ('Pages::del', 'Pages::edit', 'Pages::files'),
	),
	'Users' => array (
		2 => array ('Users::del', 'Users::edit'),
		3 => array ('Users::del', 'Users::edit'),
		)
);

$config['link_typy'] = array (
	'0' => 'element statyczny (bez linku)',
	'1' => 'link do podanego URL',
	'2' => 'link do strony',
	'3' => 'link do kategorii',
	'4' => 'link do tagu',
	'5' => 'link do galerii',
	'6' => 'link do działu ogłoszeń'
);

$config['banner_zones'] = array (
	'0' => 'top strony',
	'100' => 'na górze, na całą szerokość, nad sliderem',
	'150' => 'na górze, na całą szerokość, pod sliderem',
	'200' => 'na górze, lewa kolumna',
	'250' => 'w artykułach',
	'500' => 'na dole, lewa kolumna',
	'300' => 'na górze, prawa kolumna',
	'400' => 'na dole, prawa kolumna',
	'600' => 'stopka, na całą szerokość'
);

$config['addon_zones'] = array (
	'0' => 'sekcja HEAD',
	'1' => 'początek BODY',
	'2' => 'koniec BODY'
);

$config['link_targets'] = array (
	'0' => 'w tym samym oknie',
	'1' => 'w nowym oknie'
);

$config['admin_menu'] = array (
    'pages' => array (
		'name' => 'Strony',
		'href' => base_url('admin/pages'),
		'icon' => 'fa-files-o',
		'id' => 'Pages',
        'subs' => array (
            array (
                'name' => 'wszystkie',
				'href' => base_url('admin/pages'),
				'icon' => 'fa-files-o',
            ),
            array (
                'name' => 'nowa',
				'href' => base_url('admin/pages/newPage'),
				'icon' => 'fa-file-o',
            ),
			array (
				'name' => 'strony tekstowe',
				'href' => base_url('admin/pages').'?filtr_type=1&filtr_cat=&filtr_tag=&filtr=true',
				'icon' => 'fa-file-text',
			),
			array (
				'name' => 'albumy galerii',
				'href' => base_url('admin/pages').'?filtr_type=2&filtr_cat=&filtr_tag=&filtr=true',
				'icon' => 'fa-file-image-o',
			),
			array (
				'name' => 'ogłoszenia',
				'href' => base_url('admin/pages').'?filtr_type=3&filtr_cat=&filtr_tag=&filtr=true',
				'icon' => 'fa-building-o',
			),
			array (
				'name' => 'wydarzenia',
				'href' => base_url('admin/pages').'?filtr_type=4&filtr_cat=&filtr_tag=&filtr=true',
				'icon' => 'fa-calendar-o',
			),
			array (
				'name' => 'nieprzypisane',
				'href' => base_url('admin/pages').'?filtr_cat=-1&filtr_tag=&filtr=true',
				'icon' => 'fa-question-circle',
			)

		),
		'permissions' => array (
			'index' => 'przeglądanie',
			'edit' => 'edycja',
			'del' => 'usuwanie',
			'newPage' => 'nowa',
			'photos' => 'zdjęcia',
			'photoEdit' => 'kadrowanie zdjęć',
			'files' => 'załączniki'
		)
	),
    'menu' => array (
		'name' => 'Menu',
		'href' => base_url('admin/menu'),
		'icon' => 'fa-list',
		'id' => 'Menu',
		'permissions' => array (
			'index' => 'przeglądanie',
			'edit' => 'edycja'
		)
	),
	'traits' => array (
		'name' => 'Cechy',
		'href' => base_url('admin/traits'),
		'icon' => 'fa-tags',
		'id' => 'Traits',
        'subs' => array (
            array (
                'name' => 'Kategorie',
				'href' => base_url('admin/traits/categories'),
				'icon' => 'fa-tag',
            ),
            array (
                'name' => 'Tagi',
				'href' => base_url('admin/traits/tags'),
				'icon' => 'fa-tag',
            ),
            array (
                'name' => 'Parametry',
				'href' => base_url('admin/traits/params'),
				'icon' => 'fa-tag',
            ),
			array (
                'name' => 'Ogłoszenia',
				'href' => base_url('admin/traits/ads'),
				'icon' => 'fa-tag',
            ),
        ),
		'permissions' => array (
			'index' => 'przeglądanie',
			'edit' => 'edycja',
			'del' => 'usuwanie',
			'newTrait' => 'nowa'
		)
	),
    'guestbook' => array (
		'name' => 'Księga gości',
		'href' => base_url('admin/guestbook'),
		'icon' => 'fa-smile-o',
		'id' => 'Guestbook',
		'permissions' => array (
			'index' => 'przeglądanie',
			'edit' => 'edycja',
			'del' => 'usuwanie'
		)
	),
    'newsletter' => array (
		'name' => 'Newsletter',
		'href' => base_url('admin/newsletter'),
		'icon' => 'fa-envelope',
		'id' => 'Newsletter',
		'permissions' => array (
			'index' => 'przeglądanie',
			'edit' => 'edycja',
			'del' => 'usuwanie'
		)
	),
    'users' => array (
		'name' => 'Użytkownicy',
		'href' => base_url('admin/users'),
		'icon' => 'fa-users',
		'id' => 'Users',
		'permissions' => array (
			'index' => 'przeglądanie',
			'edit' => 'edycja',
			'del' => 'usuwanie',
			'newUser' => 'nowy'
		)
	),
    'filemanager' => array (
		'name' => 'Menadżer plików',
		'href' => base_url('admin/fileman'),
		'icon' => 'fa-file',
		'id' => 'Fileman',
		'permissions' => array (
			'index' => 'przeglądanie'
		)
	),
    'settings' => array (
		'name' => 'Ustawienia',
		'href' => base_url('admin/settings'),
		'icon' => 'fa-cog',
		'id' => 'Settings',
		'permissions' => array (
			'index' => 'przeglądanie',
			'edit' => 'edycja'
		)
	),
    'banners' => array (
		'name' => 'Banery, reklamy',
		'href' => base_url('admin/banners'),
		'icon' => 'fa-image',
		'id' => 'Banners',
		'permissions' => array (
			'index' => 'przeglądanie',
			'edit' => 'edycja',
			'del' => 'usuwanie',
			'newBaner' => 'nowy'
		)
	),
    'addons' => array (
		'name' => 'Dodatki HTML i JS',
		'href' => base_url('admin/addons'),
		'icon' => 'fa-code',
		'id' => 'Addons',
		'permissions' => array (
			'index' => 'przeglądanie',
			'edit' => 'edycja',
			'del' => 'usuwanie',
			'newAddon' => 'nowy'
		)
	),
    'logout' => array (
		'name' => 'Wyloguj się',
		'href' => base_url('admin/logout'),
		'icon' => 'fa-power-off'
		)
);

$config['yes_no'] = array (
	'0' => array('name' => 'tak', 'icon' => 'glyphicon glyphicon-eye-ok'),
	'1' => array('name' => 'nie', 'icon' => 'glyphicon glyphicon-eye-minus'),
);

$config['element_status'] = array (
	'0' => array('name' => 'widoczny', 'icon' => 'glyphicon glyphicon-eye-open'),
	'9' => array('name' => 'ukryty', 'icon' => 'glyphicon glyphicon-eye-close'),
);

$config['element_confirm'] = array (
	'0' => array('name' => 'potwierdzony', 'icon' => 'glyphicon glyphicon-thumbs-up'),
	'9' => array('name' => 'niepotwierdzony', 'icon' => 'glyphicon glyphicon-thumbs-down'),
);

$config['fieldsets_names'] = array (
	'5'  => 'Ustawienia wyświetlania strony',
	'10' => 'Opis strony (SEO)',
	'20' => 'Liczniki wejść',
	'30' => 'Wyświetlanie',
	'40' => 'Banery / reklamy',
	'50' => 'Konto email',
	'60' => 'Komentarze',
	'70' => 'Social Media',
	'80' => 'Wyświetlanie w panelu'
);

$config['admin_role'] = array (
	'0' => 'autor',
	'1' => 'administrator',
	'5' => 'użytkownik'
);

$config['admin_locked'] = array (
	'0' => 'aktywny',
	'1' => 'zablokowany'
);

$config['page_filtr'] = array (
	'type' => '',
	'categories' => '',
	'tags' => '',
	'ads' => '',
	'search_text' => ''
);

$config['traits_dic'] = array (
	'categories' => 'kategorie',
	'tags' => 'tagi',
	'ads' => 'ogłoszenia'
);

$config['category_typy'] = array (
	'0' => 'skróty',
	'1' => 'skróty ze zdjęciem',
	'2' => 'skróty boks',
	'3' => 'skróty duży boks'

);

$config['page_typy'] = array (
	'1' => 'strona',
	'2' => 'album',
	'3' => 'ogłoszenie',
	'4' => 'wydarzenie'
);

$config['guestbook_filtr'] = array (
	'status' => '',
	'lang' => ''
);

$config['newsletter_filtr'] = array (
	'status' => '',
	'lang' => ''
);

$config['captcha'] = array(
    'img_path'      => './assets/captcha/',
    'img_url'       => base_url('assets/captcha').'/',
    'word_length'   => 5,
    'pool'          => '0123456789',
    'img_width'     => '180',
    'img_height'    => 30,
    'colors'        => array(
        'background' => array(255, 255, 255),
        'border' => array(255, 255, 255),
        'text' => array(0, 0, 0),
        'grid' => array(140, 140, 140)
    )
);
