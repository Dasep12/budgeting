<?php

class Laporan extends CI_Controller
{
    public function index()
    {
        $data = [
            'uri'   => $this->uri->segment(2)
        ];
        $this->template->load("template_departement", "laporan_panjer", $data);
    }

    public function cetak_pdfPayment()
    {
        $id  = $this->input->get("id");
        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4-P']);
        $data['raim'] = $this->db->get_where("trans_detail_jenis_pembayaran", ['transaksi_jenis_pembayaran_id' => $id])->result();
        $data['remarks'] = $this->db->query("SELECT remarks , tanggal_request as tanggal , `to`, bank , rekening from transaksi_jenis_pembayaran where id='" . $id  . "' ")->row();
        $res = $this->load->view('pdfRaimbusment', $data, TRUE);
        $mpdf->WriteHTML($res);
        $mpdf->Output();
    }

    public function cetak_pdfPanjer()
    {
        $id  = $this->input->get("id");
        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4-P']);
        $data['raim'] = $this->db->get_where("trans_detail_jenis_pembayaran", ['transaksi_jenis_pembayaran_id' => $id])->result();
        $data['remarks'] = $this->db->query("SELECT remarks from transaksi_jenis_pembayaran where id='" . $id  . "' ")->row();
        $res = $this->load->view('pdfRaimbusment', $data, TRUE);
        $mpdf->WriteHTML($res);
        $mpdf->Output();
    }
}
