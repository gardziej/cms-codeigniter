                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="<?=site_url('admin/main')?>">panel</a>
                            </li>

                            <li class="active">

                            <?php foreach ($admin_menu AS $m) { if ($m['href'] == site_url($curMenu)) { ?>
                                <a href="<?=site_url($curMenu)?>"><?=$title?></a>
                            <?php } } ?>
                            </li>
                            <li class="active"><?=$subTitle?>
                            </li>
                        </ol>
