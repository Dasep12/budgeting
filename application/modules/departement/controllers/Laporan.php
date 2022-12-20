<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Laporan extends CI_Controller
{
    public function __construct(Type $var = null)
    {
        parent::__construct();
        $this->load->model('M_departement', 'model');
        date_default_timezone_set('Asia/Jakarta');
        $role = $this->session->userdata("level");
        if ($role != 'dpt') {
            redirect('Login');
        }
    }

    public function payment()
    {
        $data = [
            'uri'           => $this->uri->segment(2),
            'departement'   => $this->model->ambilData("master_departement", ['id' => $this->session->userdata("departement_id")]),
            'jenis'         => $this->db->query("SELECT id , jenis_transaksi from master_jenis_transaksi WHERE jenis_transaksi = 'PAYMENT VOUCHER'  ")
        ];
        $this->template->load('template_departement', 'form_laporan_payment', $data);
    }

    public function panjer()
    {
        $data = [
            'uri'           => $this->uri->segment(2),
            'departement'   => $this->model->ambilData("master_departement", ['id' => $this->session->userdata("departement_id")]),
            'jenis'         => $this->db->query("SELECT id , jenis_transaksi from master_jenis_transaksi WHERE jenis_transaksi = 'PANJAR' ")
        ];
        $this->template->load('template_departement', 'form_laporan_panjer', $data);
    }


    public function list_payment()
    {
        $dept = $this->input->get("deptId");
        $start = $this->input->get("start");
        $end = $this->input->get("end");
        $jenis = $this->input->get("jenis");
        $data = [];
        $data = $this->model->reportPayment($dept, $jenis, $start, $end)->result();
        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode($data));
    }


    public function downloadPayment()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $style_col = [
            'font' => [
                'bold' => true,        'color' => [
                    'rgb' => 'FFFFFF'
                ],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'top' => [
                    'borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                ],
                'right' => [
                    'borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                ],
                'bottom' => [
                    'borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                ],
                'left' => [
                    'borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                ],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => 'e74c3c'
                ]
            ],
        ];
        // 
        $style_row = [
            'alignment' => [
                // 'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                // 'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'top' => [
                    'borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                ],
                'right' => [
                    'borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                ],
                'bottom' => [
                    'borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                ],
                'left' => [
                    'borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                ],
            ]
        ];

        $styleSubTotal = [
            'font' => [
                'color' => [
                    'rgb' => 'FFFFFF'
                ],
                'bold' => true,
                // 'size' => 11
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => 'e74c3c'
                ]
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
            ],
            'borders' => [
                'top' => [
                    'borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                ],
                'right' => [
                    'borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                ],
                'bottom' => [
                    'borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                ],
                'left' => [
                    'borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                ],
            ]
        ];
        // 
    }

    public function cetak_pdfPayment()
    {
        $id              = $this->input->get("id");
        $mpdf            = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4-P']);
        $data['raim']    = $this->db->get_where("trans_detail_jenis_pembayaran", ['transaksi_jenis_pembayaran_id' => $id])->result();
        $data['remarks'] = $this->db->query("SELECT remarks , tanggal_request as tanggal , `to`, bank , rekening , bk from transaksi_jenis_pembayaran where id='" . $id  . "' ")->row();

        $data['depthead'] = $this->db->query("SELECT  nama_lengkap FROM master_akun WHERE departement_id = '" . $this->session->userdata("departement_id") . "' and level='mgr' ")->row();
        $data['acc'] = $this->db->query("SELECT  nama_lengkap FROM master_akun WHERE  level='bc' ")->row();
        $data['gm'] = $this->db->query("SELECT  nama_lengkap FROM master_akun WHERE  level='gm' ")->row();
        $data['fin'] = $this->db->query("SELECT  nama_lengkap FROM master_akun WHERE  level='fin' ")->row();
        $res = $this->load->view('pdfRaimbusment', $data, TRUE);
        $mpdf->WriteHTML($res);
        $mpdf->Output();
    }

    public function cetak_pdfPanjer()
    {
        $id              = $this->input->get("id");
        // $mpdf            = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4']);
        $mpdf            = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => [120, 236]]);
        $data['panjar']    = $this->db->get_where("trans_detail_jenis_pembayaran", ['transaksi_jenis_pembayaran_id' => $id])->result();
        $data['remarks'] = $this->db->query("SELECT remarks , bk , tanggal_request  from transaksi_jenis_pembayaran where id='" . $id  . "' ")->row();
        $res = $this->load->view('pdfPanjer', $data, TRUE);
        $mpdf->WriteHTML($res);
        $mpdf->Output();
    }
}
