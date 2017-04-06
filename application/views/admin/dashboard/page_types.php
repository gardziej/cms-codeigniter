<div class="row">

    <div class="col-xs-3">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-files-o fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?=$count['pages']?></div>
                        <div>Strony tekstowe</div>
                    </div>
                </div>
            </div>
            <a href="<?=base_url('admin/pages')?>?filtr_type=1&filtr_cat=&filtr_tag=&filtr_ad=&search_text=&filtr_make=true">
                <div class="panel-footer">
                    <span class="pull-left">przejdź</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>

    <div class="col-xs-3">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-file-image-o fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?=$count['galleries']?></div>
                        <div>Albumy galerii</div>
                    </div>
                </div>
            </div>
            <a href="<?=base_url('admin/pages')?>?filtr_type=2&filtr_cat=&filtr_tag=&filtr_ad=&search_text=&filtr_make=true">
                <div class="panel-footer">
                    <span class="pull-left">przejdź</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>

    <div class="col-xs-3">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-building-o fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?=$count['adds']?></div>
                        <div>Ogłoszenia</div>
                    </div>
                </div>
            </div>
            <a href="<?=base_url('admin/pages')?>?filtr_type=3&filtr_cat=&filtr_tag=&filtr_ad=&search_text=&filtr_make=true">
                <div class="panel-footer">
                    <span class="pull-left">przejdź</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>

    <div class="col-xs-3">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-calendar-o fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?=$count['events']?></div>
                        <div>Wydarzenia</div>
                    </div>
                </div>
            </div>
            <a href="<?=base_url('admin/pages')?>?filtr_type=4&filtr_cat=&filtr_tag=&filtr_ad=&search_text=&filtr_make=true">
                <div class="panel-footer">
                    <span class="pull-left">przejdź</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>

</div>
