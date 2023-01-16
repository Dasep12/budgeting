<?php


class Approve_voucher extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_finance', 'model');
        date_default_timezone_set('Asia/Jakarta');
        $role = $this->session->userdata("level");
        if ($role != 'FIN') {
            redirect('Login');
        }
    }

    public function list_approveVoucher()
    {
        $sess = $this->session->userdata("nik");
        $data = [
            'uri'        => $this->uri->segment(2),
            'wait'       => $this->model->listVoucher(0),
            'proces'    => $this->model->listVoucher(1),
        ];
        $this->template->load('template_fin', 'list_approved_voucher', $data);
    }

    public function approve()
    {
        $id = $this->input->get("id_budget");
        $kode = $this->input->get("kode");
        $data = [
            'ket'                => $kode == 1 ? 'accept finance' : 'reject finance',
            'date_approve_fin'   => date('Y-m-d H:i:s'),
            'approve_fin'        => $kode,
            'approve_fin_user'   => $this->session->userdata("nik")
        ];
        $update = $this->model->updateData($data, "transaksi_plant_voucher", ['id' => $id]);
        if ($update > 0) {
            $this->session->set_flashdata("ok",  $kode == 1 ? 'Voucher Approve' : 'Voucher Rejected' . 'silahkan konfirmasi ke pihak terkait');
            redirect('finance/Approve_voucher/list_approveVoucher');
        } else {
            $this->session->set_flashdata("nok", "terjadi kesalahan");
            redirect('finance/Approve_voucher/list_approveVoucher');
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
                'status'             => 1,
                'ket'                => 'accept budget controller',
                'date_approve_fin'   => date('Y-m-d H:i:s'),
                'approve_fin'        => 1,
                'approve_fin_user'   => $this->session->userdata("nik"),
                'id'                 => $multi[$i]
            );
            array_push($data, $params);
        }
        $this->db->update_batch('transaksi_plant_voucher', $data, 'id');
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata("ok", 'budget telah di setujui,silahkan konfirmasi ke departement terkait');
            redirect('finance/Approve_voucher/list_approveVoucher');
        } else {
            $this->session->set_flashdata("nok", "terjadi kesalahan");
            redirect('finance/Approve_voucher/list_approveVoucher');
        }
    }

    public function multiApproveLapor()
    {
        $multi = $this->input->post("multi[]");
        $data = array();
        for ($i = 0; $i < count($multi); $i++) {
            $params = array(
                'date_lapor_fin'           => date('Y-m-d H:i:s'),
                'approve_lapor_fin'        => 1,
                'id'                       => $multi[$i]
            );
            array_push($data, $params);
        }
        $this->db->update_batch('transaksi_plant_voucher', $data, 'id');
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata("ok", 'voucher telah di setujui,silahkan konfirmasi ke departement terkait');
            redirect('finance/Approve_voucher/list_approve_lapor');
        } else {
            $this->session->set_flashdata("nok", "terjadi kesalahan");
            redirect('finance/Approve_voucher/list_approve_lapor');
        }
    }


    public function list_approve_lapor()
    {
        $sess = $this->session->userdata("nik");
        $data = [
            'uri'        => $this->uri->segment(2),
            'wait'       => $this->model->listLaporVoucher(0),
            'proces'    => $this->model->listLaporVoucher(1),
        ];
        $this->template->load('template_fin', 'list_approved_lapor_voucher', $data);
    }

    public function approveLapor()
    {
        $id = $this->input->get("id_budget");
        $kode = $this->input->get("kode");
        $data = [
            'date_lapor_fin'          => date('Y-m-d H:i:s'),
            'approve_lapor_fin'       => $kode,
        ];

        $getTrans = $this->model->ambilData("transaksi_plant_voucher", ['id' => $id])->row();
        $getDetailTrans = $this->model->ambilData("transaksi_detail_voucher", ['transaksi_plant_voucher_id' => $id])->result();

        $dataTrans = [
            'master_departement_id'             => $getTrans->master_departement_id,
            'master_jenis_transaksi_id'         => $getTrans->master_jenis_transaksi_id,
            'master_planning_budget_id_planing' => $getTrans->master_planning_budget_id_planing,
            'master_acc_id'                     => 1,
            'payment_close'                     => 1,
            'date_payment_close'                => date('Y-m-d H:i:s'),
            'request_code'                      => $getTrans->request_code,
            'tanggal_request'                   => $getTrans->tanggal_request,
            'remarks'                           => $getTrans->remarks,
            'ket'                               => $getTrans->ket,
            'lampiran_1'                        => $getTrans->lampiran_1,
            'lampiran_2'                        => $getTrans->lampiran_2,
            'lampiran_3'                        => $getTrans->lampiran_3,
            'bk'                                => $getTrans->bk,
            'to'                                => $getTrans->to,
            'bank'                              => $getTrans->bank,
            'rekening'                          => $getTrans->rekening,
            'approve_spv'                       => $getTrans->approve_spv,
            'approve_spv_user'                  => $getTrans->approve_spv_user,
            'date_approve_spv'                  => $getTrans->date_approve_spv,
            'approve_mgr'                       => $getTrans->approve_mgr,
            'approve_mgr_user'                  => $getTrans->approve_mgr_user,
            'date_approve_mgr'                  => $getTrans->date_approve_mgr,
            'approve_fin'                       => $getTrans->approve_fin,
            'approve_fin_user'                  => $getTrans->approve_fin_user,
            'date_approve_fin'                  => $getTrans->date_approve_fin,
            'approve_acc'                       => $getTrans->approve_acc,
            'approve_acc_user'                  => $getTrans->approve_acc_user,
            'date_approve_acc'                  => $getTrans->date_approve_acc,
            'approve_gm'                        => $getTrans->approve_gm,
            'approve_gm_user'                   => $getTrans->approve_gm_user,
            'date_approve_gm'                   => $getTrans->date_approve_gm,
            'date_approve_acc'                  => $getTrans->date_approve_acc,
            'created_at'                        => $getTrans->created_at,
            'created_by'                        => $getTrans->created_by,
        ];

        // echo "<pre>";
        // print_r($dataTrans);
        // print_r($dataDetailTrans);

        $update = $this->model->updateData($data, "transaksi_plant_voucher", ['id' => $id]);
        $save   = $this->model->inserData("transaksi_jenis_pembayaran", $dataTrans);
        if ($update > 0 && $save > 0) {
            $this->db->trans_commit();
            $dataDetailTrans = array();
            $id_last =  $this->db->insert_id();
            foreach ($getDetailTrans as $dtl) {
                $dataDet = array(
                    'transaksi_jenis_pembayaran_id'    => $id_last,
                    'particullar'                      => $dtl->particullar,
                    'ammount'                          => $dtl->ammount,
                    'ammount_plant'                    => $dtl->ammount_plant
                );
                array_push($dataDetailTrans, $dataDet);
            }
            $this->db->insert_batch("trans_detail_jenis_pembayaran",  $dataDetailTrans);
            $this->session->set_flashdata("ok",  $kode == 1 ? 'Voucher Approve' : 'Voucher Rejected' . 'silahkan konfirmasi ke pihak terkait');
            redirect('finance/Approve_voucher/list_approve_lapor');
        } else {
            $this->db->trans_rollback();
            $this->session->set_flashdata("nok", "terjadi kesalahan");
            redirect('finance/Approve_voucher/list_approve_lapor');
        }
    }
}
