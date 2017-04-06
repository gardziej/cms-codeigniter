<?php

class MY_Loader extends CI_Loader
{

    private $arr = array(
        'page/inc/header',
        'page/inc/top',
        'page/inc/topmenu',
        'page/inc/grid',
        'page/inc/slider',
        'page/inc/leftcolumn',
        'page/inc/messages',
        'TEMPLATE_NAME',
        'page/inc/rightcolumn',
        'page/inc/footer',
        'page/inc/credits',
        'page/inc/cookies'
    );

    // public function template_page($template_name, $vars = array(), $return = FALSE)
    // {
    //     if ($return)
    //     {
    //         $output = '';
    //         $output .= $this->view('page/inc/header', $vars, $return);
    //         $output .= $this->view('page/inc/top', $vars, $return);
    //         $output .= $this->view('page/inc/topmenu', $vars, $return);
    //         $output .= $this->view('page/inc/grid', $vars, $return);
    //         $output .= $this->view('page/inc/slider', $vars, $return);
    //         $output .= $this->view('page/inc/leftcolumn', $vars, $return);
    //         $output .= $this->view('page/inc/messages', $vars, $return);
    //         $output .= $this->view($template_name, $vars, $return);
    //         $output .= $this->view('page/inc/rightcolumn', $vars, $return);
    //         $output .= $this->view('page/inc/footer', $vars, $return);
    //         $output .= $this->view('page/inc/credits', $vars, $return);
    //         $output .= $this->view('page/inc/cookies', $vars, $return);
    //         return $output;
    //     }
    //     else
    //     {
    //         $this->view('page/inc/header', $vars);
    //         $this->view('page/inc/top', $vars);
    //         $this->view('page/inc/topmenu', $vars);
    //         $this->view('page/inc/grid', $vars);
    //         $this->view('page/inc/slider', $vars);
    //         $this->view('page/inc/leftcolumn', $vars);
    //         $this->view('page/inc/messages', $vars);
    //         $this->view($template_name, $vars);
    //         $this->view('page/inc/rightcolumn', $vars);
    //         $this->view('page/inc/footer', $vars);
    //         $this->view('page/inc/credits', $vars);
    //         $this->view('page/inc/cookies', $vars);
    //     }
    // }

    public function template_page($template_name, $vars = array(), $return = FALSE)
    {
        if ($return)
        {
            $output = '';
            foreach ($this->arr AS $a)
                {
                    if ($a == 'TEMPLATE_NAME') $a = $template_name;
                    $output .= $this->view($a, $vars, $return);
                }
            return $output;
        }
        else
        {
            foreach ($this->arr AS $a)
                {
                    if ($a == 'TEMPLATE_NAME') $a = $template_name;
                    $this->view($a, $vars);
                }
        }
    }


/////////////////////////////////////////////////////////////////////////////////


    public function template_admin($template_name, $vars = array(), $return = FALSE)
    {
        if ($return)
        {
            $output = '';
            $output .= $this->view('admin/inc/header', $vars, $return);
            if ($this->session->userdata('logged'))
                {
                    $output .= $this->view('admin/inc/topbar', $vars, $return);
                    $output .= $this->view('admin/inc/sidebar', $vars, $return);
                    $output .= $this->view('admin/inc/pagename', $vars, $return);
                }
            $output .= $this->view('admin/inc/messages', $vars, $return);
            $output .= $this->view($template_name, $vars, $return);
            if ($this->session->userdata('logged'))
                {
                    $output .= $this->view('admin/inc/breadcrumbs', $vars, $return);
                    $output .= $this->view('admin/inc/prefooter', $vars, $return);
                }
            $output .= $this->view('admin/inc/footer', $vars, $return);
            return $output;
        }
        else
        {
            $this->view('admin/inc/header', $vars);
            if ($this->session->userdata('logged'))
                {
                    $this->view('admin/inc/topbar', $vars);
                    $this->view('admin/inc/sidebar', $vars);
                    $this->view('admin/inc/breadcrumbs', $vars);
                    $this->view('admin/inc/pagename', $vars);

                }
            $this->view('admin/inc/messages', $vars);
            $this->view($template_name, $vars);
            if ($this->session->userdata('logged'))
                {
                    $this->view('admin/inc/breadcrumbs', $vars);
                    $this->view('admin/inc/prefooter', $vars);
                }
            $this->view('admin/inc/footer', $vars);
        }
    }


    public function template_admin_XML($template_name, $vars = array(), $return = FALSE)
    {
        if ($return)
            {
            $output = '';
            $output .= $this->view('admin/xml/header', $vars, $return);
            $output .= $this->view($template_name, $vars, $return);
            $output .= $this->view('admin/xml/footer', $vars, $return);
            return $output;
            }
            else
            {
            $this->view('admin/xml/header', $vars);
            $this->view($template_name, $vars);
            $this->view('admin/xml/footer', $vars);
            }

    }


}
