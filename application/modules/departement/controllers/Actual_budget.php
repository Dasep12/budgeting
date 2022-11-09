<?php

class Actual_budget extends CI_Controller
{

    public function list_actual()
    {
        $data = [
            'uri'       => $this->uri->segment(2)
        ];
        $this->template->load('template_departement', 'daftar_actual_budget_activity', $data);
    }

    public function form_input_actual()
    {
        $data = [
            'uri'       => $this->uri->segment(2)
        ];
        $this->template->load('template_departement', 'input_actual_activity', $data);
    }
}
