<?php

class Anggaran extends CI_Controller
{
    public function index(Type $var = null)
    {
        $this->template->load('template/template_admin', 'anggaran_tahunan');
    }
}
