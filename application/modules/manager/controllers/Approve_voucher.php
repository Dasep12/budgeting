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
        $id    = $this->input->post("id");
        $file1 = $this->input->post("file1");
        $file2 = $this->input->post("file2");
        $file3 = $this->input->post("file3");
        $nama  = $this->input->post("nama");
        $remarks  = $this->input->post("remarks");
        $jenis  = $this->input->post("jenis");
        $data = [
            'raimbus'   => $this->model->ambilData('transaksi_detail_voucher', ['transaksi_plant_voucher_id' => $id]),
            'file1'      => $file1,
            'file2'      => $file2,
            'file3'      => $file3,
            'nama'       => $nama,
            'remarks'    => $remarks,
            'jenis'       => $jenis,
        ];
        $this->load->view("detail_trans_voucher", $data);
    }


    public function multiApprove()
    {
        $multi = $this->input->post("multi[]");
        $data = array();
        for ($i = 0; $i < count($multi); $i++) {
            $params = array(
                // 'status'            => 1,
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

    public function multiApproveLapor()
    {
        $multi = $this->input->post("multi[]");
        $data = array();
        for ($i = 0; $i < count($multi); $i++) {
            $params = array(
                // 'status'                  => 1,
                'date_lapor_mgr'          => date('Y-m-d H:i:s'),
                'approve_lapor_mgr'       => 1,
                'id'                      => $multi[$i]
            );
            array_push($data, $params);
        }
        $this->db->update_batch('transaksi_plant_voucher', $data, 'id');
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata("ok", 'budget telah di setujui,silahkan konfirmasi ke departement terkait');
            redirect('manager/Approve_voucher/list_approve_lapor');
        } else {
            $this->session->set_flashdata("nok", "terjadi kesalahan");
            redirect('manager/Approve_voucher/list_approve_lapor');
        }
    }


    public function list_approve_lapor()
    {
        $sess = $this->session->userdata("nik");
        $data = [
            'uri'        => $this->uri->segment(2),
            'wait'       => $this->model->listLaporVoucher($this->session->userdata("nik"), 0),
            'proces'    => $this->model->listLaporVoucher($this->session->userdata("nik"), 1),
        ];
        $this->template->load('template_manager', 'list_approved_lapor_voucher', $data);
    }

    public function approveLapor()
    {
        $id = $this->input->get("id_budget");
        $kode = $this->input->get("kode");
        $data = [
            'date_lapor_mgr'          => date('Y-m-d H:i:s'),
            'approve_lapor_mgr'       => $kode,
        ];
        $update = $this->model->updateData($data, "transaksi_plant_voucher", ['id' => $id]);
        if ($update > 0) {
            $this->session->set_flashdata("ok",  $kode == 1 ? 'Voucher Approve' : 'Voucher Rejected' . 'silahkan konfirmasi ke pihak terkait');
            redirect('manager/Approve_voucher/list_approve_lapor');
        } else {
            $this->session->set_flashdata("nok", "terjadi kesalahan");
            redirect('manager/Approve_voucher/list_approve_lapor');
        }
    }
}
