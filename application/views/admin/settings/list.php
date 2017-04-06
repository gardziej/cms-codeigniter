<?php

    $attributes = array('class' => 'form-horizontal');
    echo form_open('', $attributes);

    foreach ($fieldsets AS $kf => $fields)
        {
            echo form_fieldset($fieldsets_names[$kf]);
            foreach ($fields AS $f)
                {
                    switch ($f['cfg_type'])
                        {
                            case 0:
                                if ($f['lang_diff'])
                                    {
                                        $this->load->view('admin/settings/types/inputLangs', array('f'=>$f));
                                    }
                                    else
                                    {
                                        $this->load->view('admin/settings/types/input', array('f'=>$f));
                                    }
                                break;
                            case 1:
                                if ($f['lang_diff'])
                                    {
                                        $this->load->view('admin/settings/types/textareaLangs', array('f'=>$f));
                                    }
                                    else
                                    {
                                        $this->load->view('admin/settings/types/textarea', array('f'=>$f));
                                    }
                                break;
                            case 2:
                                if ($f['lang_diff'])
                                    {
                                        $this->load->view('admin/settings/types/radioLangs', array('f'=>$f));
                                    }
                                    else
                                    {
                                        $this->load->view('admin/settings/types/radio', array('f'=>$f));
                                    }
                                break;
                        }
                }
            echo '</fieldset>';

        ?>
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-9">
                    <button name="submit" value="true" type="submit" class="btn btn-primary">Zapisz zmiany</button>
                    * pola wymagane
                </div>
            </div>
        <?php

        }
    ?>


</form>
