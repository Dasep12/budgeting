<?php


class Input_Budget extends CI_Controller
{

    public function index()
    {
        $this->template->load('template_departement', 'input_budget');
    }
}
