<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mail {

    private $config = Array(
        'mailtype'  => 'html',
        'charset'   => 'utf-8'
    );

    function __construct() {
        $this->ci =& get_instance();
        $this->ci->load->library('cfg');
        $this->ci->load->library('email');

        $this->pre = '<p>Informacja z witryny: '.$this->ci->cfg->get('page_name').'</p>';
        $this->autoSuf = '<p>--<br>Wiadomość wygenerowana automatycznie<br>Pozdrawiamy<br>ekipa '.$this->ci->cfg->get('page_name').'</p>';
        $this->ekipaSuf = '<p>--<br>Pozdrawiamy<br>ekipa '.$this->ci->cfg->get('page_name').'</p>';
    }

    public function send ($to, $subject, $message, $auto = true)
    {
        if ($auto)
            {
                $message = $this->pre.$message.$this->autoSuf;
            }
            else
            {
                $message = $this->pre.$message.$this->ekipaSuf;
            }

        if (!$this->isSMTP() || !$this->send_smtp($to, $subject, $message))
            {
            if (!$this->send_mail($to, $subject, $message))
                {
                    return false;
                }
            }
        return true;
    }

    private function isSMTP ()
        {
            if ($this->ci->cfg->get('smtp_host') &&
            $this->ci->cfg->get('smtp_port') &&
            $this->ci->cfg->get('smtp_user') &&
            $this->ci->cfg->get('smtp_pass'))
                {
                    return true;
                }
                else
                {
                    return false;
                }

        }

    private function send_smtp ($to, $subject, $message)
        {
            $config = $this->config;
            $config['protocol'] = 'smtp';
            $config['smtp_host'] = $this->ci->cfg->get('smtp_host');
            $config['smtp_port'] = $this->ci->cfg->get('smtp_port');
            $config['smtp_user'] = $this->ci->cfg->get('smtp_user');
            $config['smtp_pass'] = $this->ci->cfg->get('smtp_pass');

            $this->ci->email->initialize($config);
            $this->ci->email->from($this->ci->cfg->get('page_email'), $this->ci->cfg->get('page_email_name'));
            $this->ci->email->to($to);
            $this->ci->email->subject($subject);
            $this->ci->email->message($message);
            $this->ci->email->set_newline("\r\n");

            if (!$this->ci->email->send())
                {
                    return false;
                }
            return true;
        }

    private function send_mail ($to, $subject, $message)
        {
            $config = $this->config;
            $config['protocol'] = 'mail';

            $this->ci->email->initialize($config);
            $this->ci->email->from($this->ci->cfg->get('page_email'), $this->ci->cfg->get('page_email_name'));
            $this->ci->email->to($to);
            $this->ci->email->subject($subject);
            $this->ci->email->message($message);
            $this->ci->email->set_newline("\r\n");
            if (!$this->ci->email->send())
                {
                    return false;
                }
            return true;
        }
}
