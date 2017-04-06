    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">nawigacja</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?=site_url('admin/dashboard')?>"><i class="fa fa-dashboard"></i> Panel Administracyjny</a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">

                <?php if ($postToAccept > 0) { ?>
                <li>
                    <a href="<?=base_url('admin/guestbook')?>?filtr_status=9&amp;filtr_lang="><i class="fa fa-smile-o"></i> <?=$postToAccept?> wpisy do zatwierdzenia</a>
                </li>
                <?php } ?>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-plus"></i> dodaj <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="<?=site_url('admin/pages/newPage')?>"><i class="fa fa-fw fa-file"></i> stronę</a>
                        </li>
                        <li>
                            <a href="<?=site_url('admin/users/newUser')?>"><i class="fa fa-fw fa-user"></i> użytkownika</a>
                        </li>
                        <li>
                            <a href="<?=site_url('admin/banners/newBanner')?>"><i class="fa fa-fw fa-image"></i> baner</a>
                        </li>
                        <li>
                            <a href="<?=site_url('admin/addons/newAddon')?>"><i class="fa fa-fw fa-code"></i> dodatek</a>
                        </li>

                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?=$this->session->login?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="<?=site_url('admin/users/profil')?>"><i class="fa fa-fw fa-gear"></i> Twój profil</a>
                        </li>
                        <li>
                            <a href="<?=site_url('admin/logout')?>"><i class="fa fa-fw fa-power-off"></i> Wyloguj się</a>
                        </li>
                    </ul>
                </li>
            </ul>
