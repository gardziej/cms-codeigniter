<div class="message">

<?php

$messages_types = array(
    "alert_message" => array('type' => 'danger'),
    "info_message" => array('type' => 'info'),
    "warning_message" => array('type' => 'warning'),
    "success_message" => array('type' => 'success')
);

foreach ($messages_types AS $type => $value)
    {
        $show = false;
        if (isSet($$type))
            {
                if (is_array($$type))
                    {
                        $show = $$type;
                    }
                    else if (is_string($$type))
                    {
                        $show[] = $$type;
                    }
            }

        if ($this->session->flashdata($type))
            {
                $show[] = $this->session->flashdata($type);
            }

        if ($show && is_array($show))
            {
                if (count($show) > 1)
                    {
                        echo '<div class="alert alert-'.$value['type'].'" role="alert">';
                    }
                    else
                    {
                        echo '<div class="alert alert-one alert-'.$value['type'].'" role="alert">';
                    }
                echo '<ul>';
                foreach ($show AS $s)
                    {
                        echo '<li>';
                        echo $s;
                        echo '</li>';
                    }
                echo '</ul>';
                echo '</div>';
            }
    }
?>

</div>
