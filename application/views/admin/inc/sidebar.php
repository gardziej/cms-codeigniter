
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">

                    <?php
                        foreach ($admin_menu AS $m)
                            {
                            echo '<li class="';
                            if ($m['href'] == base_url($curMenu)) echo 'active';
                            echo '">';

                            if (isSet($m['subs']))
                                {
                                echo '<a href="javascript:;" data-toggle="collapse" data-target="#'.$m['id'].'">';
                                echo '<i class="fa fa-fw '.$m['icon'].'"></i> '.$m['name'].' <i class="fa fa-fw fa-caret-down"></i>';
                                echo '</a>';
                                echo '<ul id="'.$m['id'].'" class="collapse">';
                                foreach ($m['subs'] AS $sub)
                                    {
                                        echo '<li><a href="'.$sub['href'].'"><i class="fa fa-fw '.$sub['icon'].'"></i> '.$sub['name'].'</a></li>';
                                    }
                                echo '</ul>';
                                }
                                else
                                {
                                    echo '<a href="'.$m['href'].'"><i class="fa fa-fw '.$m['icon'].'"></i> '.$m['name'].'</a>';
                                }
                            echo '</li>';
                            }
                    ?>

                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">

            <div class="container-fluid">
