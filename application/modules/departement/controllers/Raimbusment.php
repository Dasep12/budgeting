<?php


class Raimbusment extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_departement', 'model');
    }
    public function form_raimbusment()
    {
        $code_dept = $this->db->query("SELECT kode_departement as code FROM master_departement WHERE id='" . $this->session->userdata("departement_id") . "' ")->row();
        $data = [
            'uri'       => $this->uri->segment(2),
            'code_dept'     => $code_dept->code . 'REQ/RAIMB' . rand(13, 15) . '/' . rand(10, 30)
        ];
        $this->template->load('template_departement', 'form_raimbusment', $data);
    }

    public function input()
    {
        $ammount = $this->input->post("ammount");
        $particullars = $this->input->post("particullar");
        $part = array();
        for ($i = 0; $i < count($ammount); $i++) {
            $arr = [
                'ammount'           => $ammount[$i],
                'particullars'      => $particullars[$i]
            ];
            array_push($part, $arr);
        }
        echo "<pre>";
        print_r($part);
    }
}
