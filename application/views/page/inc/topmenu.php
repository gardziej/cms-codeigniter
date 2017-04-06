<div class="container-fluid" id="topmenu">
    <nav class="navbar navbar-default" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbars">
                    <span class="sr-only">Przełącz nawigację</span>
                    <i class="fa fa-bars"></i> Menu
                </button>
            </div>

            <div class="collapse navbar-collapse navbars">

				<ul class="nav navbar-nav animated slideInLeft">
					<?php if (isSet($menus[1], $menus[1]['children'])) printMenuHorizontal($menus[1]['children']); ?>
                </ul>

                <div class="col-sm-3 col-md-3 navbar-right animated slideInRight">
                    <form action="<?=base_url('szukaj')?>" class="navbar-form" role="search" method="GET">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="szukaj" name="q" required>
                        <div class="input-group-btn">
                            <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </nav>
</div>

<div class="container-fluid" id="ads_menu">
    <div class="container">
        <div class="collapse navbar-collapse navbars">
            <ul class="nav navbar-nav">
                <?php if (isSet($menus[2], $menus[2]['children'])) printMenuHorizontal($menus[2]['children']); ?>
            </ul>
        </div>
    </div>
</div>

<?php $this->load->view('page/inc/banner_zone', array('zone_id' => 100, 'banners' => $banners, 'banners_cats' => $banners_cats)); ?>
