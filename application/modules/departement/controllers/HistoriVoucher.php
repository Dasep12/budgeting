<?php

class HistoriVoucher extends CI_Controller
{

    public function __construct(Type $var = null)
    {
        parent::__construct();
        $this->load->model('M_departement', 'model');
        date_default_timezone_set('Asia/Jakarta');
        $role = $this->session->userdata("level");
        if ($role != 'DPT') {
            redirect('Login');
        }
    }

    public function list_plantVoucher()
    {
        $data = [
            'uri'       => $this->uri->segment(2),
            'plant'     => $this->model->daftarPlantVoucher($this->session->userdata("departement_id"))
        ];
        $this->template->load('template_departement', 'daftar_plant_voucher', $data);
    }



    public function viewDetailPlant()
    {
        $id = $this->input->post("id");
        $data = [
            'data'      => $this->model->ambilData("transaksi_detail_voucher", ['transaksi_plant_voucher_id' => $id]),
            // 'detail'    => $this->model->DetaildaftarPlantBudgetDepartement($id)->row()
        ];
        $this->load->view("detail_plant_voucher", $data);
    }

    public function viewDetailApprove()
    {
        $id = $this->input->post("id");
        $data = [
            'data'  => $this->model->ambilData("transaksi_plant_voucher", ['id' => $id])->row()
        ];
        $this->load->view("timeline_approved_voucher", $data);
    }
}
