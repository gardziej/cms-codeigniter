<?php  if (isSet($grid, $grid['pages']['list']) && !empty($grid['pages']['list'])) { ?>

<div class="container" id="main-grid-container">

<?php

if ($grid_cells == 1)
{
    echo '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 main-grid main-grid-full">';
    $this->load->view('page/inc/gridcell', array('p' => $grid['pages']['list'][0]));
    echo '</div>';
}
else if ($grid_cells == 2)
{
    echo '<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 main-grid main-grid-full">';
    $this->load->view('page/inc/gridcell', array('p' => $grid['pages']['list'][0]));
    echo '</div>';
    echo '<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 main-grid main-grid-full">';
    $this->load->view('page/inc/gridcell', array('p' => $grid['pages']['list'][1]));
    echo '</div>';
}
else if ($grid_cells == 5)
{
    echo '<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 main-grid main-grid-full">';
    $this->load->view('page/inc/gridcell', array('p' => $grid['pages']['list'][0]));
    echo '</div>';
    echo '<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 main-grid">';

        echo '<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 main-grid main-grid-half">';
        $this->load->view('page/inc/gridcell', array('p' => $grid['pages']['list'][1]));
        echo '</div>';
        echo '<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 main-grid main-grid-half">';
        $this->load->view('page/inc/gridcell', array('p' => $grid['pages']['list'][2]));
        echo '</div>';

        echo '<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 main-grid main-grid-half">';
        $this->load->view('page/inc/gridcell', array('p' => $grid['pages']['list'][3]));
        echo '</div>';
        echo '<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 main-grid main-grid-half">';
        $this->load->view('page/inc/gridcell', array('p' => $grid['pages']['list'][4]));
        echo '</div>';

    echo '</div>';
}
else if ($grid_cells == 8)
{
    echo '<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 main-grid">';

        echo '<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 main-grid main-grid-half">';
        $this->load->view('page/inc/gridcell', array('p' => $grid['pages']['list'][0]));
        echo '</div>';
        echo '<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 main-grid main-grid-half">';
        $this->load->view('page/inc/gridcell', array('p' => $grid['pages']['list'][1]));
        echo '</div>';

        echo '<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 main-grid main-grid-half">';
        $this->load->view('page/inc/gridcell', array('p' => $grid['pages']['list'][2]));
        echo '</div>';
        echo '<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 main-grid main-grid-half">';
        $this->load->view('page/inc/gridcell', array('p' => $grid['pages']['list'][3]));
        echo '</div>';

    echo '</div>';

    echo '<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 main-grid">';

        echo '<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 main-grid main-grid-half">';
        $this->load->view('page/inc/gridcell', array('p' => $grid['pages']['list'][4]));
        echo '</div>';
        echo '<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 main-grid main-grid-half">';
        $this->load->view('page/inc/gridcell', array('p' => $grid['pages']['list'][5]));
        echo '</div>';

        echo '<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 main-grid main-grid-half">';
        $this->load->view('page/inc/gridcell', array('p' => $grid['pages']['list'][6]));
        echo '</div>';
        echo '<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 main-grid main-grid-half">';
        $this->load->view('page/inc/gridcell', array('p' => $grid['pages']['list'][7]));
        echo '</div>';

    echo '</div>';
}

?>

</div>

<?php } ?>
