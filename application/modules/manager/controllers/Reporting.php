<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Reporting extends CI_Controller
{

    public function index(Type $var = null)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $style_col = [
            'font' => [
                'bold' => true,
                'color' => [
                    'rgb' => '000'
                ],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ],
            'borders' => array(
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
            ),
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => '#FFF'
                ]
            ],
        ];

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





        $sheet->getStyle('B2:K2')->applyFromArray($style_col);
        $sheet->getStyle('B3:K3')->applyFromArray($style_col);
        $sheet->getStyle('B4:K4')->applyFromArray($style_col);
        $sheet->getStyle('B5:K5')->applyFromArray($style_col);
        $sheet->getStyle('B6:K6')->applyFromArray($style_col);
        $sheet->getStyle('B6:B7')->applyFromArray($style_col);
        $sheet->getStyle('C6:C7')->applyFromArray($style_col);
        $sheet->getStyle('D6:D7')->applyFromArray($style_col);
        $sheet->getStyle('E6:E7')->applyFromArray($style_col);
        $sheet->getStyle('F6:F7')->applyFromArray($style_col);
        $sheet->getStyle('G6:G7')->applyFromArray($style_col);
        $sheet->getStyle('H6:H7')->applyFromArray($style_col);
        $sheet->getStyle('I6:I7')->applyFromArray($style_col);
        $sheet->getStyle('J6:J7')->applyFromArray($style_col);
        $sheet->getStyle('K6:K7')->applyFromArray($style_col);
        $sheet->mergeCells('B2:K2');
        $sheet->mergeCells('B3:K3');
        $sheet->mergeCells('B4:K4');
        $sheet->mergeCells('B5:K5');
        $sheet->mergeCells('B6:B7');
        $sheet->mergeCells('C6:C7');
        $sheet->mergeCells('D6:D7');
        $sheet->mergeCells('D6:D7');
        $sheet->mergeCells('E6:E7');
        $sheet->mergeCells('F6:H6');
        $sheet->setCellValue('B2', "PT BONECOM TRICOM");
        $sheet->setCellValue('B3', "LAPORAN PERBANDINGAN PROYEKSI DAN REALISASI BUDGET");
        $sheet->setCellValue('B4', "PERIODE 2023");
        $sheet->setCellValue('B6', "DEPT");
        $sheet->setCellValue('C6', "KODE BUDGET");
        $sheet->setCellValue('D6', "NAMA AKUN");
        $sheet->setCellValue('E6', "DESKRIPSI");
        $sheet->setCellValue('F6', "BULAN");
        $sheet->setCellValue('F7', "PROYEKSI");
        $sheet->setCellValue('G7', "REALISASI");
        $sheet->setCellValue('H7', "SELISIH");
        $sheet->setCellValue('I6', "BULAN");
        $sheet->setCellValue('I7', "PROYEK");
        $sheet->setCellValue('J7', "REALISASI");
        $sheet->setCellValue('K7', "SELISIH");


        $query = $this->db->query("SELECT md.nama_departement as dept , mb.kode_budget as kode  ,	 mb.account_bame as acc  , mb.description  as desk , 
        CAST(mb.budget as unsigned) as proyeksi ,
        (select sum(tdjp.ammount) from master_planning_budget mpb 
        inner join transaksi_jenis_pembayaran tjp ON tjp.master_planning_budget_id_planing = mpb.master_budget_id_budget 
        inner join trans_detail_jenis_pembayaran tdjp on tdjp.transaksi_jenis_pembayaran_id  = tjp.id 
        where mpb.master_budget_id_budget  = mb.id_budget 
        )as realisasi ,
        (select(mb.budget  - realisasi)) as selisih 
        from master_budget mb 
        inner join master_departement md ON md.id  = mb.departement_id 
        where mb.approve_fin  = 1 ")->result();


        $n = 8;
        foreach ($query as $lp) {
            $sheet->setCellValue('B' . $n, $lp->dept);
            $sheet->setCellValue('C' . $n, $lp->kode);
            $sheet->setCellValue('D' . $n, $lp->acc);
            $sheet->setCellValue('E' . $n, $lp->desk);
            $sheet->setCellValue('F' . $n, number_format($lp->proyeksi, 0));
            $sheet->setCellValue('G' . $n,  number_format($lp->realisasi, 0));
            $sheet->setCellValue('H' . $n,  number_format($lp->selisih, 0));

            $sheet->getStyle('B' . $n)->applyFromArray($style_row);
            $sheet->getStyle('C' . $n)->applyFromArray($style_row);
            $sheet->getStyle('D' . $n)->applyFromArray($style_row);
            $sheet->getStyle('E' . $n)->applyFromArray($style_row);
            $sheet->getStyle('F' . $n)->applyFromArray($style_row);
            $sheet->getStyle('G' . $n)->applyFromArray($style_row);
            $sheet->getStyle('H' . $n)->applyFromArray($style_row);
            $sheet->getStyle('I' . $n)->applyFromArray($style_row);
            $sheet->getStyle('J' . $n)->applyFromArray($style_row);
            $sheet->getStyle('K' . $n)->applyFromArray($style_row);

            $n++;
        }

        for ($i = 'A'; $i !=  $spreadsheet->getActiveSheet()->getHighestColumn(); $i++) {
            $spreadsheet->getActiveSheet()->getColumnDimension($i)->setAutoSize(TRUE);
        }
        $sheet->setTitle("Laporan Budget");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Laporan Budget.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }
}
