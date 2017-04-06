<div class="container">

<?php
if (isSet($alert_message))
    {
        if (is_array($alert_message))
            {
                echo '<div class="alert alert-danger" role="alert">'.implode('<br>',$alert_message).'</div>';
            }
            else
            {
                echo '<div class="alert alert-danger" role="alert">'.$alert_message.'</div>';
            }
    }

if (isSet($info_message))
    {
        if (is_array($info_message))
            {
                echo '<div class="alert alert-info" role="alert">'.implode('<br>',$info_message).'</div>';
            }
            else
            {
                echo '<div class="alert alert-info" role="alert">'.$info_message.'</div>';
            }
    }

if (isSet($warning_message))
    {
        if (is_array($warning_message))
            {
                echo '<div class="alert alert-warning" role="alert">'.implode('<br>',$warning_message).'</div>';
            }
            else
            {
                echo '<div class="alert alert-warning" role="alert">'.$warning_message.'</div>';
            }
    }

if (isSet($success_message))
    {
        if (is_array($success_message))
            {
                echo '<div class="alert alert-success" role="alert">'.implode('<br>',$success_message).'</div>';
            }
            else
            {
                echo '<div class="alert alert-success" role="alert">'.$success_message.'</div>';
            }
    }

?>

</div>
