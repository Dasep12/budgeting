<?php


class Approve_voucher extends CI_Controller
{
    public function __construct(Type $var = null)
    {
        parent::__construct();
        $this->load->model('M_manager', 'model');
        date_default_timezone_set('Asia/Jakarta');
        $role = $this->session->userdata("level");
        if ($role != 'MGR') {
            redirect('Login');
        }
    }

    public function list_approveVoucher()
    {
        $sess = $this->session->userdata("nik");
        $data = [
            'uri'        => $this->uri->segment(2),
            'wait'       => $this->model->listVoucher($this->session->userdata("nik"), 0),
            'proces'    => $this->model->listVoucher($this->session->userdata("nik"), 1),
        ];
        $this->template->load('template_manager', 'list_approved_voucher', $data);
    }

    public function approve()
    {
        $id = $this->input->get("id_budget");
        $kode = $this->input->get("kode");
        $data = [
            'ket'               => $kode == 1 ? 'accept manager' : 'reject manager',
            'date_approve_mgr'  => date('Y-m-d H:i:s'),
            'approve_mgr'       => $kode,
            'approve_mgr_user'  => $this->session->userdata("nik")
        ];
        $update = $this->model->updateData($data, "transaksi_plant_voucher", ['id' => $id]);
        if ($update > 0) {
            $this->session->set_flashdata("ok",  $kode == 1 ? 'Voucher Approve' : 'Voucher Rejected' . 'silahkan konfirmasi ke pihak terkait');
            redirect('manager/Approve_voucher/list_approveVoucher');
        } else {
            $this->session->set_flashdata("nok", "terjadi kesalahan");
            redirect('manager/Approve_voucher/list_approveVoucher');
        }
    }

    public function viewDetailPlant()
    {
        $id = $this->input->post("id");
        $data['data']  = $this->model->detailBudget($id);
        $this->load->view("detail_budget", $data);
    }


    public function multiApprove()
    {
        $multi = $this->input->post("multi[]");
        $data = array();
        for ($i = 0; $i < count($multi); $i++) {
            $params = array(
                'status'            => 1,
                'ket'               => 'accept manager',
                'date_approve_mgr'  => date('Y-m-d H:i:s'),
                'approve_mgr'       => 1,
                'approve_mgr_user'  => $this->session->userdata("nik"),
                'id'                => $multi[$i]
            );
            array_push($data, $params);
        }
        $this->db->update_batch('transaksi_plant_voucher', $data, 'id');
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata("ok", 'budget telah di setujui,silahkan konfirmasi ke departement terkait');
            redirect('manager/Approve_voucher/list_approveVoucher');
        } else {
            $this->session->set_flashdata("nok", "terjadi kesalahan");
            redirect('manager/Approve_voucher/list_approveVoucher');
        }
    }
}
