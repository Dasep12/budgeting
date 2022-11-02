<?php

class Laporan extends CI_Controller
{
    public function __construct(Type $var = null)
    {
        parent::__construct();
        $this->load->model('M_pic', 'admin');
        date_default_timezone_set('Asia/Jakarta');
    }

    public function patroli()
    {
        $data = [
            'plant'   =>  $this->admin->show("master_plant")->result(),
        ];
        $this->load->view("template/pic/header");
        $this->load->view("pic/laporan_patroli", $data);
        $this->load->view("template/pic/footer");
    }

    public function abnormality()
    {
        $data = [
            'plant'   =>  $this->admin->show("master_plant")->result(),
        ];
        $this->load->view("template/pic/header");
        $this->load->view("pic/laporan_abnormality", $data);
        $this->load->view("template/pic/footer");
    }
}
