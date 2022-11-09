<?php

class Plant_budget extends CI_Controller
{

    public function list_budget()
    {
        $data = [
            'uri'       => $this->uri->segment(2)
        ];
        $this->template->load('template_departement', 'daftar_plant_budget_activity', $data);
    }

    public function form_input_plant(Type $var = null)
    {
        $data = [
            'uri'       => $this->uri->segment(2)
        ];
        $this->template->load('template_departement', 'input_plant_activity', $data);
    }
}
