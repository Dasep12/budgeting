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

        $query2 = $this->model->ambilData("transaksi_detail_voucher", ['transaksi_plant_voucher_id' => $id])->result();

        $data = array([
            'header'      => $query,
            'detail'      => $query2
        ]);
        echo json_encode($data);
    }

    public function input()
    {
        $id = $this->input->post("id_planning");
        $parti = $this->input->post("particullar");
        $ammount = $this->input->post("ammount");
        $ammountPlant = $this->input->post("ammount_plant");
        $fiterAmmount = array_filter($ammount);
        $fiterParti = array_filter($parti);
        $detailVoucher = array();
        $plant = $this->input->post("budget_real");

        $totAm = 0;
        for ($o = 0; $o < count($fiterAmmount); $o++) {
            $dtl  = array(
                'ammount'       => $fiterAmmount[$o],
                'particullar'   => $fiterParti[$o],
                'ammount_plant' => $ammountPlant[$o],
                'transaksi_plant_voucher_id'  => $id,
            );
            array_push($detailVoucher, $dtl);
            $totAm += $ammountPlant[$o];
        }


        $config = array(
            'upload_path'   => './assets/lampiran/',
            'allowed_types' => 'jpg|png|jpeg|pdf',
            'overwrite'     => false,
            'file_name'     =>  time() . $_FILES["lampiran"]['name']
        );
        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if ($this->upload->do_upload('lampiran')) {
            $file = $this->upload->data();
            $data = [
                'stat_lapor'        => 1,
                'plant_sebelumnya'  => $totAm,
                'lampiran_po'       => $file['file_name'],
            ];
            $update = $this->model->updateData($data, "transaksi_plant_voucher", ['id' => $id]);
            if ($update > 0) {
                $this->db->trans_commit();
                $this->model->delete(["transaksi_plant_voucher_id" => $id], "transaksi_detail_voucher");
                $this->db->insert_batch("transaksi_detail_voucher", $detailVoucher);
                $this->session->set_flashdata("ok", "Plant Voucher di Laporkan");
                redirect('departement/ReportVoucher/reportVoucher');
            } else {
                $this->db->trans_rollback();
                $this->session->set_flashdata("nok", "terjadi kesalahan");
                redirect('departement/ReportVoucher/reportVoucher');
            }
        } else {
            // $res = '01';
            $res = array('error' => $this->upload->display_errors());
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
