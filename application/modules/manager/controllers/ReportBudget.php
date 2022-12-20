<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ReportBudget extends CI_Controller
{
    public function __construct(Type $var = null)
    {
        parent::__construct();
        $this->load->model('M_departement', 'model');
        date_default_timezone_set('Asia/Jakarta');
        $role = $this->session->userdata("level");
        if ($role != 'mgr') {
            redirect('Login');
        }
    }

    public function index()
    {
        $data = [
            'uri'           => $this->uri->segment(2),
            'jenis'         => $this->model->getData("master_jenis_budget"),
            'departement'   => $this->model->ambilData("master_departement", ['id' => $this->session->userdata("departement_id")]),
        ];
        $this->template->load('template_departement', 'form_report_budget', $data);
    }


    public function download()
    {
        $jenis = $this->input->post("jenis_trans");
        $tahun = $this->input->post("tahun");
        $dept = $this->input->post("departement");

        $cari = $this->db->query("SELECT jenis_budget FROM master_jenis_budget WHERE id='" . $jenis . "' ")->row();

        if ($cari->jenis_budget == 'Reguler Cost' || $cari->jenis_budget == 'REGULER COST') {
            $this->reportRegular($jenis, $tahun, $dept);
        } else {
            $this->reportPerspective($jenis, $tahun, $dept);
        }
    }

    private function reportPerspective($jenis, $tahun, $dept)
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

        $sheet->getStyle('A1:A2')->applyFromArray($style_col);
        $sheet->getStyle('B1:B2')->applyFromArray($style_col);
        $sheet->getStyle('C1:C2')->applyFromArray($style_col);
        $sheet->getStyle('D1:D2')->applyFromArray($style_col);
        $sheet->getStyle('E1:E2')->applyFromArray($style_col);
        $sheet->getStyle('F1:F2')->applyFromArray($style_col);
        $sheet->getStyle('G1:G2')->applyFromArray($style_col);
        $sheet->getStyle('I1:I2')->applyFromArray($style_col);
        $sheet->getStyle('J1:J2')->applyFromArray($style_col);
        $sheet->getStyle('K1:V1')->applyFromArray($style_col);
        $sheet->getStyle('K2:V2')->applyFromArray($style_col);

        $sheet->mergeCells('A1:A2');
        $sheet->mergeCells('B1:B2');
        $sheet->mergeCells('C1:C2');
        $sheet->mergeCells('D1:D2');
        $sheet->mergeCells('E1:E2');
        $sheet->mergeCells('F1:F2');
        $sheet->mergeCells('G1:G2');
        $sheet->setCellValue('A1', "JENIS BUDGET");
        $sheet->setCellValue('B1', "KPI");
        $sheet->setCellValue('C1', "TARGET KPI");
        $sheet->setCellValue('D1', "IMPROVEMENT");
        $sheet->setCellValue('E1', "DUE DATE");
        $sheet->setCellValue('F1', "PIC");
        $sheet->setCellValue('G1', "BUDGET");

        $sheet->mergeCells('I1:I2');
        $sheet->mergeCells('J1:J2');
        $sheet->mergeCells('K1:V1');
        $sheet->setCellValue('I1', "CODE");
        $sheet->setCellValue('J1', "ACTIVITY");
        $sheet->setCellValue('K1', "SCHEDULE");
        $sheet->setCellValue('K2', "JAN");
        $sheet->setCellValue('L2', "FEB");
        $sheet->setCellValue('M2', "MAR");
        $sheet->setCellValue('N2', "APR");
        $sheet->setCellValue('O2', "MEI");
        $sheet->setCellValue('P2', "JUN");
        $sheet->setCellValue('Q2', "JUL");
        $sheet->setCellValue('R2', "AGU");
        $sheet->setCellValue('S2', "SEP");
        $sheet->setCellValue('T2', "OKT");
        $sheet->setCellValue('U2', "NOV");
        $sheet->setCellValue('V2', "DES");



        $n = 3;
        $i = 3;
        $p = 3;
        $subTotal = 0;
        $data = $this->model->getReportBudgetPlant($tahun, $jenis, $dept)->result();
        foreach ($data as $hd) {
            $sheet->setCellValue('A' . $i, "PERSPECTIVE");
            $sheet->setCellValue('B' . $i, $hd->kpi);
            $sheet->setCellValue('C' . $i, $hd->target_kpi);
            $sheet->setCellValue('D' . $i, $hd->improvment);
            $sheet->setCellValue('E' . $i, $hd->due_date);
            $sheet->setCellValue('F' . $i, $hd->pic);
            $sheet->setCellValue('G' . $i, number_format($hd->budget, 0));

            $subTotal += $hd->budget;
            $sheet->getStyle('A3:A' . $n)->applyFromArray($style_row);
            $sheet->getStyle('B3:B' . $n)->applyFromArray($style_row);
            $sheet->getStyle('C3:C' . $n)->applyFromArray($style_row);
            $sheet->getStyle('D3:D' . $n)->applyFromArray($style_row);
            $sheet->getStyle('E3:E' . $n)->applyFromArray($style_row);
            $sheet->getStyle('F3:F' . $n)->applyFromArray($style_row);
            $sheet->getStyle('G3:G' . $n)->applyFromArray($style_row);
            $n++;



            $jan = $this->model->getReportDetail($hd->id, "Januari")->row();
            $feb = $this->model->getReportDetail($hd->id, "Februari")->row();
            $mar = $this->model->getReportDetail($hd->id, "Maret")->row();
            $apr = $this->model->getReportDetail($hd->id, "April")->row();
            $mei = $this->model->getReportDetail($hd->id, "Mei")->row();
            $jun = $this->model->getReportDetail($hd->id, "Juni")->row();
            $jul = $this->model->getReportDetail($hd->id, "Juli")->row();
            $agu = $this->model->getReportDetail($hd->id, "Agustus")->row();
            $sep = $this->model->getReportDetail($hd->id, "September")->row();
            $okt = $this->model->getReportDetail($hd->id, "Oktober")->row();
            $nov = $this->model->getReportDetail($hd->id, "November")->row();
            $des = $this->model->getReportDetail($hd->id, "Desember")->row();

            $sheet->setCellValue('I' . $p, $jan->kode_budget);
            $sheet->setCellValue('J' . $p, $jan->activity);
            $sheet->setCellValue('K' . $p, number_format($jan->nilai_budget, 0));
            $sheet->setCellValue('L' . $p, number_format($feb->nilai_budget, 0));
            $sheet->setCellValue('M' . $p, number_format($apr->nilai_budget, 0));
            $sheet->setCellValue('N' . $p, number_format($mar->nilai_budget, 0));
            $sheet->setCellValue('O' . $p, number_format($mei->nilai_budget, 0));
            $sheet->setCellValue('P' . $p, number_format($jun->nilai_budget, 0));
            $sheet->setCellValue('Q' . $p, number_format($jul->nilai_budget, 0));
            $sheet->setCellValue('R' . $p, number_format($agu->nilai_budget, 0));
            $sheet->setCellValue('S' . $p, number_format($sep->nilai_budget, 0));
            $sheet->setCellValue('T' . $p, number_format($okt->nilai_budget, 0));
            $sheet->setCellValue('U' . $p, number_format($nov->nilai_budget, 0));
            $sheet->setCellValue('V' . $p, number_format($des->nilai_budget, 0));

            // 
            $sheet->getStyle('I3:I' . $p)->applyFromArray($style_row);
            $sheet->getStyle('J3:J' . $p)->applyFromArray($style_row);
            $sheet->getStyle('K3:K' . $p)->applyFromArray($style_row);
            $sheet->getStyle('L3:L' . $p)->applyFromArray($style_row);
            $sheet->getStyle('M3:M' . $p)->applyFromArray($style_row);
            $sheet->getStyle('N3:N' . $p)->applyFromArray($style_row);
            $sheet->getStyle('O3:O' . $p)->applyFromArray($style_row);
            $sheet->getStyle('P3:P' . $p)->applyFromArray($style_row);
            $sheet->getStyle('Q3:Q' . $p)->applyFromArray($style_row);
            $sheet->getStyle('R3:R' . $p)->applyFromArray($style_row);
            $sheet->getStyle('S3:S' . $p)->applyFromArray($style_row);
            $sheet->getStyle('T3:T' . $p)->applyFromArray($style_row);
            $sheet->getStyle('U3:U' . $p)->applyFromArray($style_row);
            $sheet->getStyle('V3:V' . $p)->applyFromArray($style_row);
            // 

            $p++;

            $i++;
        }


        $sheet->mergeCells('A' . $n . ':F' . $n);
        $sheet->setCellValue('A' . $n, "Sub Total");
        $sheet->setCellValue('G' . $n, number_format($subTotal, 0));

        $sheet->getStyle('A' . $n . ':G' . $n)->applyFromArray($styleSubTotal);
        $sheet->getStyle('G' . $n)->applyFromArray($styleSubTotal);

        for ($i = 'A'; $i !=  $spreadsheet->getActiveSheet()->getHighestColumn(); $i++) {
            $spreadsheet->getActiveSheet()->getColumnDimension($i)->setAutoSize(TRUE);
        }
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        $sheet->setTitle("Laporan Perspective");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Laporan Perspective.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }


    private function reportRegular($jenis, $tahun, $dept)
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

        $sheet->mergeCells('A1:A2');
        $sheet->mergeCells('B1:B2');
        $sheet->mergeCells('C1:C2');
        $sheet->mergeCells('D1:D2');
        $sheet->setCellValue('A1', "JENIS BUDGET");
        $sheet->setCellValue('B1', "ACCOUNT NAME");
        $sheet->setCellValue('C1', "DESCRIPTION");
        $sheet->setCellValue('D1', "BUDGET");
        $sheet->getStyle('A1:A2')->applyFromArray($style_col);
        $sheet->getStyle('B1:B2')->applyFromArray($style_col);
        $sheet->getStyle('C1:C2')->applyFromArray($style_col);
        $sheet->getStyle('D1:D2')->applyFromArray($style_col);

        $sheet->mergeCells('G1:G2');
        $sheet->mergeCells('H1:H2');
        $sheet->mergeCells('I1:T1');
        $sheet->setCellValue('G1', "CODE");
        $sheet->setCellValue('H1', "ACTIVITY");
        $sheet->setCellValue('I1', "SCHEDULE");
        $sheet->setCellValue('I2', "JAN");
        $sheet->setCellValue('J2', "FEB");
        $sheet->setCellValue('K2', "MAR");
        $sheet->setCellValue('L2', "APR");
        $sheet->setCellValue('M2', "MEI");
        $sheet->setCellValue('N2', "JUN");
        $sheet->setCellValue('O2', "JUL");
        $sheet->setCellValue('P2', "AGU");
        $sheet->setCellValue('Q2', "SEP");
        $sheet->setCellValue('R2', "OKT");
        $sheet->setCellValue('S2', "NOV");
        $sheet->setCellValue('T2', "DES");

        $sheet->getStyle('G1:G2')->applyFromArray($style_col);
        $sheet->getStyle('H1:H2')->applyFromArray($style_col);
        $sheet->getStyle('I1:I2')->applyFromArray($style_col);
        $sheet->getStyle('J1:J2')->applyFromArray($style_col);
        $sheet->getStyle('K1:K2')->applyFromArray($style_col);
        $sheet->getStyle('L1:L2')->applyFromArray($style_col);
        $sheet->getStyle('M1:M2')->applyFromArray($style_col);
        $sheet->getStyle('N1:N2')->applyFromArray($style_col);
        $sheet->getStyle('O1:O2')->applyFromArray($style_col);
        $sheet->getStyle('P1:P2')->applyFromArray($style_col);
        $sheet->getStyle('Q1:Q2')->applyFromArray($style_col);
        $sheet->getStyle('R1:R2')->applyFromArray($style_col);
        $sheet->getStyle('S1:S2')->applyFromArray($style_col);
        $sheet->getStyle('T1:T1')->applyFromArray($style_col);
        $sheet->getStyle('I1:T1')->applyFromArray($style_col);
        $sheet->getStyle('I2:T2')->applyFromArray($style_col);
        $n = 3;
        $l = 3;
        $p = 3;
        $subTotal = 0;
        $data = $this->model->getReportBudgetPlant($tahun, $jenis, $dept)->result();
        foreach ($data as $hd) {
            $sheet->setCellValue('A' . $l, "REGULAR");
            $sheet->setCellValue('B' . $l, $hd->account_bame);
            $sheet->setCellValue('C' . $l, $hd->description);
            $sheet->setCellValue('D' . $l, number_format($hd->budget, 0));

            $subTotal += $hd->budget;
            $sheet->getStyle('A3:A' . $n)->applyFromArray($style_row);
            $sheet->getStyle('B3:B' . $n)->applyFromArray($style_row);
            $sheet->getStyle('C3:C' . $n)->applyFromArray($style_row);
            $sheet->getStyle('D3:D' . $n)->applyFromArray($style_row);
            $n++;

            $jan = $this->model->getReportDetail($hd->id, "Januari")->row();
            $feb = $this->model->getReportDetail($hd->id, "Februari")->row();
            $mar = $this->model->getReportDetail($hd->id, "Maret")->row();
            $apr = $this->model->getReportDetail($hd->id, "April")->row();
            $mei = $this->model->getReportDetail($hd->id, "Mei")->row();
            $jun = $this->model->getReportDetail($hd->id, "Juni")->row();
            $jul = $this->model->getReportDetail($hd->id, "Juli")->row();
            $agu = $this->model->getReportDetail($hd->id, "Agustus")->row();
            $sep = $this->model->getReportDetail($hd->id, "September")->row();
            $okt = $this->model->getReportDetail($hd->id, "Oktober")->row();
            $nov = $this->model->getReportDetail($hd->id, "November")->row();
            $des = $this->model->getReportDetail($hd->id, "Desember")->row();

            $sheet->setCellValue('G' . $p, $jan->kode_budget);
            $sheet->setCellValue('H' . $p, $jan->activity);
            $sheet->setCellValue('I' . $p, number_format($jan->nilai_budget, 0));
            $sheet->setCellValue('J' . $p, number_format($feb->nilai_budget, 0));
            $sheet->setCellValue('K' . $p, number_format($apr->nilai_budget, 0));
            $sheet->setCellValue('L' . $p, number_format($mar->nilai_budget, 0));
            $sheet->setCellValue('M' . $p, number_format($mei->nilai_budget, 0));
            $sheet->setCellValue('N' . $p, number_format($jun->nilai_budget, 0));
            $sheet->setCellValue('O' . $p, number_format($jul->nilai_budget, 0));
            $sheet->setCellValue('P' . $p, number_format($agu->nilai_budget, 0));
            $sheet->setCellValue('Q' . $p, number_format($sep->nilai_budget, 0));
            $sheet->setCellValue('R' . $p, number_format($okt->nilai_budget, 0));
            $sheet->setCellValue('S' . $p, number_format($nov->nilai_budget, 0));
            $sheet->setCellValue('T' . $p, number_format($des->nilai_budget, 0));

            // 
            $sheet->getStyle('G3:G' . $p)->applyFromArray($style_row);
            $sheet->getStyle('H3:H' . $p)->applyFromArray($style_row);
            $sheet->getStyle('I3:I' . $p)->applyFromArray($style_row);
            $sheet->getStyle('J3:J' . $p)->applyFromArray($style_row);
            $sheet->getStyle('K3:K' . $p)->applyFromArray($style_row);
            $sheet->getStyle('L3:L' . $p)->applyFromArray($style_row);
            $sheet->getStyle('M3:M' . $p)->applyFromArray($style_row);
            $sheet->getStyle('N3:N' . $p)->applyFromArray($style_row);
            $sheet->getStyle('O3:O' . $p)->applyFromArray($style_row);
            $sheet->getStyle('P3:P' . $p)->applyFromArray($style_row);
            $sheet->getStyle('Q3:Q' . $p)->applyFromArray($style_row);
            $sheet->getStyle('R3:R' . $p)->applyFromArray($style_row);
            $sheet->getStyle('S3:S' . $p)->applyFromArray($style_row);
            $sheet->getStyle('T3:T' . $p)->applyFromArray($style_row);
            $sheet->getStyle('I1:T' . $p)->applyFromArray($style_row);
            // 

            $p++;
            $l++;
        }

        $sheet->mergeCells('A' . $n . ':C' . $n);
        $sheet->setCellValue('A' . $n, "Sub Total");
        $sheet->setCellValue('D' . $n, number_format($subTotal, 0));

        $sheet->getStyle('A' . $n . ':C' . $n)->applyFromArray($styleSubTotal);
        $sheet->getStyle('D' . $n)->applyFromArray($styleSubTotal);
        for ($i = 'A'; $i !=  $spreadsheet->getActiveSheet()->getHighestColumn(); $i++) {
            $spreadsheet->getActiveSheet()->getColumnDimension($i)->setAutoSize(TRUE);
        }
        $sheet->getDefaultRowDimension()->setRowHeight(-1);
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        $sheet->setTitle("Laporan Data Budget");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Laporan Regular Cost.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }
}
