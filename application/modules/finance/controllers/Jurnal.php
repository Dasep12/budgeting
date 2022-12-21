<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Jurnal extends CI_Controller
{
    public function __construct(Type $var = null)
    {
        parent::__construct();
        $this->load->model('M_finance', 'model');
        date_default_timezone_set('Asia/Jakarta');
        $role = $this->session->userdata("level");
        if ($role != 'FIN') {
            redirect('Login');
        }
    }

    public function index()
    {
        $data = [
            'uri'           => $this->uri->segment(2),
            'jenis'         => $this->model->getData("master_jenis_budget"),
            'departement'   => $this->model->getData("master_departement"),
        ];
        $this->template->load('template_fin', 'form_jurnal_report', $data);
    }

    public function download()
    {

        $date = explode('sd', $this->input->post("tanggal"));
        $dept = $this->input->post("departement");
        $tgl1 = $date[0];
        $tgl2 = $date[1];

        $query = $this->model->getReportJurnal($tgl1, $tgl2, $dept);


        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $style_col = [
            'font' => [
                'bold' => true,
                'color' => [
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
        $style_head = [
            'font' => [
                'bold' => true,
                'color' => [
                    'rgb' => '#000'
                ],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
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

        $sheet->mergeCells('A1:L1');
        $sheet->mergeCells('A2:L2');
        $sheet->mergeCells('A3:L3');
        $sheet->mergeCells('D1:D2');
        $sheet->setCellValue('A1', "PT BENECOM TRICOM");
        $sheet->setCellValue('A2', "JURNAL UMUM");
        $sheet->setCellValue('A3', "PER 31 JANUARI 2023");

        $sheet->getStyle('A4:L4')->applyFromArray($style_col);
        $sheet->getStyle('A1:A3')->applyFromArray($style_head);

        $sheet->setCellValue('A4', "Tanggal");
        $sheet->setCellValue('B4', "Kode Budget");
        $sheet->setCellValue('C4', "Dept Name");
        $sheet->setCellValue('D4', "No BK");
        $sheet->setCellValue('E4', "Uraian");
        $sheet->setCellValue('F4', "No Akun");
        $sheet->setCellValue('G4', "Nama Akun");
        $sheet->setCellValue('H4', "Debet");
        $sheet->setCellValue('I4', "Kredit");
        $sheet->setCellValue('J4', "No Invoice");
        $sheet->setCellValue('K4', "No Faktur Pajak");
        $sheet->setCellValue('L4', "Note");

        $p = 5;
        foreach ($query->result() as $qr) {
            $sheet->setCellValue('A' . $p, $qr->tanggal);
            $sheet->setCellValue('B' . $p, $qr->request_code);
            $sheet->setCellValue('C' . $p, $qr->nama_departement);
            $sheet->setCellValue('D' . $p, $qr->bk);
            $sheet->setCellValue('E' . $p, $qr->ket);
            $sheet->setCellValue('F' . $p, $qr->acc_no);
            $sheet->setCellValue('G' . $p, $qr->acc_name);
            $sheet->setCellValue('H' . $p, $qr->debit);
            $sheet->setCellValue('I' . $p, '-');
            $sheet->setCellValue('J' . $p, '-');
            $sheet->setCellValue('K' . $p, '-');
            $sheet->setCellValue('L' . $p, '-');
            $sheet->getStyle('A' . $p)->applyFromArray($style_row);
            $sheet->getStyle('B' . $p)->applyFromArray($style_row);
            $sheet->getStyle('C' . $p)->applyFromArray($style_row);
            $sheet->getStyle('D' . $p)->applyFromArray($style_row);
            $sheet->getStyle('E' . $p)->applyFromArray($style_row);
            $sheet->getStyle('F' . $p)->applyFromArray($style_row);
            $sheet->getStyle('G' . $p)->applyFromArray($style_row);
            $sheet->getStyle('H' . $p)->applyFromArray($style_row);
            $sheet->getStyle('I' . $p)->applyFromArray($style_row);
            $sheet->getStyle('J' . $p)->applyFromArray($style_row);
            $sheet->getStyle('K' . $p)->applyFromArray($style_row);
            $sheet->getStyle('L' . $p)->applyFromArray($style_row);
            $p++;
        }


        for ($i = 'A'; $i !=  $spreadsheet->getActiveSheet()->getHighestColumn(); $i++) {
            $spreadsheet->getActiveSheet()->getColumnDimension($i)->setAutoSize(TRUE);
        }
        $sheet->getDefaultRowDimension()->setRowHeight(-1);
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        $sheet->setTitle("Laporan Jurnal");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Laporan Jurnal.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }
}
