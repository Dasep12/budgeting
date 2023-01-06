<?php

class ReportVoucher extends CI_Controller
{
    public function __construct(Type $var = null)
    {
        parent::__construct();
        $this->load->model('M_departement', 'model');
        $this->load->helper('convertbulan');
        date_default_timezone_set('Asia/Jakarta');

        $role = $this->session->userdata("level");
        if ($role != 'DPT') {
            redirect('Login');
        }
    }

    public function reportVoucher()
    {
        $data = [
            'uri'           => $this->uri->segment(2),
            'plant'         => $this->model->ambilData("transaksi_plant_voucher", ['approve_fin' => 1, 'stat_lapor' => 0])
        ];
        $this->template->load('template_departement', 'report_voucher', $data);
    }

    public function getBudget()
    {
        $id = $this->input->get("kode");
        $query = $this->db->query("SELECT tpv.id , tpv.request_code , 
        (select sum(tdv.ammount) from transaksi_detail_voucher tdv where tdv.transaksi_plant_voucher_id  = tpv.id  ) as total_voucher
        from transaksi_plant_voucher tpv 
        where tpv.id = $id ")->row();
        echo json_encode($query);
    }

    public function input()
    {
        $id = $this->input->post("id_planning");
        $parti = $this->input->post("particullar");
        $ammount = $this->input->post("ammount");
        $plant = $this->input->post("budget_real");
        $data = [
            'stat_lapor'        => 1,
            'plant_sebelumnya'  => $plant
        ];

        $update = $this->model->updateData($data, "transaksi_plant_voucher", ['id' => $id]);
        if ($update > 0) {
            $this->db->trans_commit();

            $part = array();
            if ($parti[0] != "" || $parti[0] != null) {
                for ($i = 0; $i < count($parti); $i++) {
                    $pa = array(
                        'particullar'                 => $parti[$i],
                        'ammount'                     => $ammount[$i],
                        'transaksi_plant_voucher_id'  => $id
                    );
                    array_push($part, $pa);
                }
                $this->db->insert_batch("transaksi_detail_voucher", $part);
            }
            $this->session->set_flashdata("ok", "Plant Voucher di Laporkan");
            redirect('departement/ReportVoucher/reportVoucher');
        } else {
            $this->db->trans_rollback();
            $this->session->set_flashdata("nok", "terjadi kesalahan");
            redirect('departement/ReportVoucher/reportVoucher');
        }
    }

    public function histori_lapor()
    {
        $data = [
            'uri'           => $this->uri->segment(2),
            'retur'         => $this->model->historiVoucherReport($this->session->userdata("departement_id"))
        ];
        $this->template->load('template_departement', 'histori_report_voucher', $data);
    }
}
