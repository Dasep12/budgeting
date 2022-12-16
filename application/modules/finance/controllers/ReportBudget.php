<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ReportBudget extends CI_Controller
{
    public function __construct(Type $var = null)
    {
        parent::__construct();
        $this->load->model('M_finance', 'model');
        date_default_timezone_set('Asia/Jakarta');
    }

    public function index()
    {
        $data = [
            'uri'           => $this->uri->segment(2),
            'jenis'         => $this->model->getData("master_jenis_budget")
        ];
        $this->template->load('template_fin', 'form_report_budget', $data);
    }


    public function download()
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
        $sheet->setCellValue('A1', "PERSPECTIVE");
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
        $data = $this->model->getReportBudgetPlant(date('Y'))->result();
        foreach ($data as $hd) {
            $sheet->setCellValue('A' . $i, "PERSPECTIVE");
            $sheet->setCellValue('B' . $i, $hd->kpi);
            $sheet->setCellValue('C' . $i, $hd->target_kpi);
            $sheet->setCellValue('D' . $i, $hd->improvment);
            $sheet->setCellValue('E' . $i, $hd->created_at);
            $sheet->setCellValue('F' . $i, $hd->pic);
            $sheet->setCellValue('G' . $i, (int)$hd->budget);

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
            $sheet->setCellValue('K' . $p, $jan->nilai_budget);
            $sheet->setCellValue('L' . $p, $feb->nilai_budget);
            $sheet->setCellValue('M' . $p, $apr->nilai_budget);
            $sheet->setCellValue('N' . $p, $mar->nilai_budget);
            $sheet->setCellValue('O' . $p, $mei->nilai_budget);
            $sheet->setCellValue('P' . $p, $jun->nilai_budget);
            $sheet->setCellValue('Q' . $p, $jul->nilai_budget);
            $sheet->setCellValue('R' . $p, $agu->nilai_budget);
            $sheet->setCellValue('S' . $p, $sep->nilai_budget);
            $sheet->setCellValue('T' . $p, $okt->nilai_budget);
            $sheet->setCellValue('U' . $p, $nov->nilai_budget);
            $sheet->setCellValue('V' . $p, $des->nilai_budget);
            $p++;

            $i++;
        }


        $sheet->mergeCells('A' . $n . ':F' . $n);
        $sheet->setCellValue('A' . $n, "Sub Total");
        $sheet->getStyle('A' . $n . ':G' . $n)->applyFromArray($style_row);
        $sheet->getStyle('G' . $n)->applyFromArray($style_row);

        $sheet->getDefaultRowDimension()->setRowHeight(-1);
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        $sheet->setTitle("Laporan Data Budget");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Data Budget.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }
}
