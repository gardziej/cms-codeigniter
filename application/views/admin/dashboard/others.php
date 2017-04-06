<div class="row">

    <div class="col-xs-3">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-comments fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?=$count['comments']?></div>
                        <div>Komentarze</div>
                    </div>
                </div>
            </div>
            <a href="<?=base_url('admin/pages')?>">
                <div class="panel-footer">
                    <span class="pull-left">przejdź</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>

    <div class="col-xs-3">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-image fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?=$count['banners']?></div>
                        <div>Banery / reklamy</div>
                    </div>
                </div>
            </div>
            <a href="<?=base_url('admin/banners')?>">
                <div class="panel-footer">
                    <span class="pull-left">przejdź</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>

    <div class="col-xs-3">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-envelope fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?=$count['newsletter']?></div>
                        <div>Newsletter</div>
                    </div>
                </div>
            </div>
            <a href="<?=base_url('admin/newsletter')?>">
                <div class="panel-footer">
                    <span class="pull-left">przejdź</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>

    <div class="col-xs-3">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-smile-o fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?=$count['guestbook']?></div>
                        <div>Księga gości</div>
                    </div>
                </div>
            </div>
            <a href="<?=base_url('admin/guestbook')?>">
                <div class="panel-footer">
                    <span class="pull-left">przejdź</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>

</div>
