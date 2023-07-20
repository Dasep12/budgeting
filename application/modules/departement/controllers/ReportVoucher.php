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
            'plant'         => $this->model->ambilData("transaksi_plant_voucher", ['approve_fin' => 1, 'stat_lapor' => 0, 'master_departement_id' => $this->session->userdata("departement_id")])
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
                'ammount'       => preg_replace("/[^0-9]/", "", $fiterAmmount[$o]),
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
            $this->session->set_flashdata("nok", $this->upload->display_errors());
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


    public function viewDetailApprove()
    {
        $id = $this->input->post("id");
        $data = [
            'data'  => $this->model->ambilData("transaksi_plant_voucher", ['id' => $id])->row()
        ];
        $this->load->view("timeline_approved_lapor_voucher", $data);
    }

    public function cetak_pdfVoucher()
    {
        $id              = $this->input->get("id");
        $mpdf            = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4-P']);
        $data['raim']    = $this->db->get_where("transaksi_detail_voucher", ['transaksi_plant_voucher_id' => $id])->result();
        $data['remarks'] = $this->db->query("SELECT ma.nik, remarks , tanggal_request as tanggal , `to`, bank , rekening , bk , ma.nama_lengkap from transaksi_plant_voucher
        inner join master_akun ma on ma.nik = created_by 
        where id='" . $id  . "' ")->row();

        $data['depthead'] = $this->db->query("SELECT  nama_lengkap , mt.file FROM master_akun ma 
        INNER JOIN master_level ml on ml.id = ma.level 
        INNER JOIN master_tertanda mt on mt.master_akun_nik = ma.nik
        WHERE departement_id = '" . $this->session->userdata("departement_id") . "' and ml.kode_level='MGR' ")->row();
        $data['acc'] =  $this->model->lisTertanda("BC")->row();
        $data['gm'] =  $this->model->lisTertanda("GM")->row();
        $data['fin'] =  $this->model->lisTertanda("FIN")->row();
        $data['pre'] = $this->db->query("SELECT `file` as tertanda  FROM master_tertanda WHERE master_akun_nik='" . $data['remarks']->nik . "' ")->row();
        $res = $this->load->view('pdfVoucher', $data, TRUE);
        $mpdf->WriteHTML($res);
        $mpdf->Output();
    }
}
