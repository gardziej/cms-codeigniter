<header>
    <h1>księga gości</h1>
</header>

<?php
if (!$this->session->userdata('guestbook_post'))
    {
        $this->load->view('page/guestbook/form', $this->data);
    }
$this->load->view('page/guestbook/list', $this->data);
