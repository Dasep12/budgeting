<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Reporting extends CI_Controller
{

    public function __construct(Type $var = null)
    {
        parent::__construct();
        $this->load->model('M_departement', 'model');
        date_default_timezone_set('Asia/Jakarta');
        $role = $this->session->userdata("level");
        if ($role != 'DPT') {
            redirect('Login');
        }
    }

    public function index()
    {
        $data = [
            'uri'           => $this->uri->segment(2),
            'departement'   => $this->model->ambilData("master_departement", ['id' => $this->session->userdata("departement_id")]),
        ];
        $this->template->load('template_departement', 'reportKodeBudget', $data);
    }

    public function perKodeBudget()
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

        $style_col2 = [
            'font' => [
                'bold' => true,
                'color' => [
                    'rgb' => '000'
                ],
            ],
            // 'alignment' => [
            //     'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::ALIGN_LEFT,
            //     'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::LEFT
            // ],
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

        $kode_budget = $this->input->post("kode_budget");
        $tahun       = $this->input->post("tahun");
        $dept       = $this->input->post("departement");


        $s  = $this->db->query("SELECT id_budget , date_format(mb.date_approved_finance,'%Y-%m-%d')   as tgl , 
        (select sum(mpb.nilai_budget) as nilai 
        from master_planning_budget mpb where mb.id_budget = mpb.master_budget_id_budget  ) as nilai
        from 
        master_budget mb 
        where mb.kode_budget = '" . $kode_budget . "'")->row();

        $sheet->getStyle('B2')->applyFromArray($style_col2);
        $sheet->getStyle('B3')->applyFromArray($style_col2);
        $sheet->getStyle('B4')->applyFromArray($style_col2);
        $sheet->getStyle('B5')->applyFromArray($style_col2);
        $sheet->getStyle('B7')->applyFromArray($style_col);
        $sheet->getStyle('C7')->applyFromArray($style_col);
        $sheet->getStyle('D7')->applyFromArray($style_col);
        $sheet->getStyle('E7')->applyFromArray($style_col);
        $sheet->getStyle('F7')->applyFromArray($style_col);

        $sheet->setCellValue('B2', "FORMAT PENGELUARAN PERKODE BUDGET");
        $sheet->mergeCells('B2:C2');
        $sheet->setCellValue('B3', "DEPT NAME : " . $dept);
        $sheet->mergeCells('B3:C3');
        $sheet->setCellValue('B4', "KODE BUDGET : " . $kode_budget);
        $sheet->mergeCells('B4:C4');
        $sheet->setCellValue('B5', "SALDO BUDGET " . $tahun . ": Rp." . number_format($s->nilai, 0));
        $sheet->mergeCells('B5:C5');

        $sheet->setCellValue('B7', "Tanggal");
        $sheet->setCellValue('C7', "Deskripsi");
        $sheet->setCellValue('D7', "Nama Akun");
        $sheet->setCellValue('E7', "Jumlah");
        $sheet->setCellValue('F7', "Saldo Budget");


        $sheet->setCellValue('B8', $s->tgl);
        $sheet->setCellValue('C8', "Saldo Awal Budget");
        $sheet->setCellValue('D8', "-");
        $sheet->setCellValue('E8', number_format($s->nilai, 0));
        $sheet->setCellValue('F8', number_format($s->nilai, 0));
        $sheet->getStyle('B8')->applyFromArray($style_row);
        $sheet->getStyle('C8')->applyFromArray($style_row);
        $sheet->getStyle('D8')->applyFromArray($style_row);
        $sheet->getStyle('E8')->applyFromArray($style_row);
        $sheet->getStyle('F8')->applyFromArray($style_row);



        $query = $this->db->query("SELECT tjp.id , mb.kode_budget , ma.acc_name  , tjp.remarks  , tjp.tanggal_request  as tgl ,
        (select sum(ammount) as total from trans_detail_jenis_pembayaran tdjp where tdjp.transaksi_jenis_pembayaran_id  = tjp.id )
        as jumlah 
        from transaksi_jenis_pembayaran tjp 
        inner join master_planning_budget mpb ON tjp.master_planning_budget_id_planing  = mpb.id_planing 
        inner join master_budget mb on mb.id_budget = mpb.master_budget_id_budget 
        inner join master_acc ma on ma.id = tjp.master_acc_id 
        where tjp.approve_fin  = 1  and mb.kode_budget = '" . $kode_budget . "'");


        $n = 9;
        $budget = $s->nilai;
        foreach ($query->result() as $l) {
            $budget -= $l->jumlah;
            $sheet->setCellValue('B' . $n, $l->tgl);
            $sheet->setCellValue('C' . $n, $l->remarks);
            $sheet->setCellValue('D' . $n, $l->acc_name);
            $sheet->setCellValue('E' . $n, number_format($l->jumlah, 0));
            $sheet->setCellValue('F' . $n, number_format($budget, 0));

            $sheet->getStyle('B' . $n)->applyFromArray($style_row);
            $sheet->getStyle('C' . $n)->applyFromArray($style_row);
            $sheet->getStyle('D' . $n)->applyFromArray($style_row);
            $sheet->getStyle('E' . $n)->applyFromArray($style_row);
            $sheet->getStyle('F' . $n)->applyFromArray($style_row);
            $n++;
        }

        for ($i = 'A'; $i !=  $spreadsheet->getActiveSheet()->getHighestColumn(); $i++) {
            $spreadsheet->getActiveSheet()->getColumnDimension($i)->setAutoSize(TRUE);
        }
        $sheet->setTitle("Laporan Budget Per Kode Budget");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Laporan Budget Per Kode Budget.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }

    public function allKodeBudget()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $tahun       = $this->input->post("tahun_");
        $dept       = $this->input->post("departement_");

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

        $style_col2 = [
            'font' => [
                'bold' => true,
                'color' => [
                    'rgb' => '000'
                ],
            ],
            // 'alignment' => [
            //     'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::ALIGN_LEFT,
            //     'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::LEFT
            // ],
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

        $dtl = $this->db->query("SELECT md.nama_departement as dept ,  cast(sum(mb.budget) as unsigned ) as nilai 
        from master_budget mb 
        inner join master_departement md on md.id  = mb.departement_id  
        where md.id  = '" . $dept . "' and mb.tahun = '" . $tahun . "' and mb.approve_fin  = 1 ")->row();

        $sheet->getStyle('B2')->applyFromArray($style_col2);
        $sheet->getStyle('B3')->applyFromArray($style_col2);
        $sheet->getStyle('B4')->applyFromArray($style_col2);
        $sheet->getStyle('B5')->applyFromArray($style_col2);


        $sheet->setCellValue('B2', "FORMAT PENGELUARAN ALLKODE BUDGET");
        $sheet->mergeCells('B2:C2');
        $sheet->setCellValue('B3', "DEPT NAME : " . $dtl->dept);
        $sheet->mergeCells('B3:C3');
        // $sheet->setCellValue('B4', "KODE BUDGET : FNC/REG01/01");
        // $sheet->mergeCells('B4:C4');
        $sheet->setCellValue('B4', "SALDO BUDGET " . $tahun . " : Rp." . number_format($dtl->nilai, 0));
        $sheet->mergeCells('B4:C4');


        $sheet->setCellValue('B8', "DEPARTEMENT");
        $sheet->getStyle('B8:B9')->applyFromArray($style_col);
        $sheet->mergeCells('B8:B9');
        $sheet->setCellValue('C8', "KODE");
        $sheet->getStyle('C8:C9')->applyFromArray($style_col);
        $sheet->mergeCells('C8:C9');
        $sheet->setCellValue('D8', "AKT");
        $sheet->getStyle('D8:D9')->applyFromArray($style_col);
        $sheet->mergeCells('D8:D9');
        $sheet->setCellValue('E8', "BUDGET SETAHUN");
        $sheet->getStyle('E8')->applyFromArray($style_col);
        $sheet->setCellValue('E9', "2023");
        $sheet->getStyle('E9')->applyFromArray($style_col);
        $sheet->setCellValue('F8', "PEMAKAIAN BUDGET");
        $sheet->getStyle('F8:Q8')->applyFromArray($style_col);
        $sheet->mergeCells('F8:Q8');
        $sheet->setCellValue('F9', "JANUARI");
        $sheet->getStyle('F9')->applyFromArray($style_col);
        $sheet->setCellValue('G9', "FEBRUARI");
        $sheet->getStyle('G9')->applyFromArray($style_col);
        $sheet->setCellValue('H9', "MARET");
        $sheet->getStyle('H9')->applyFromArray($style_col);
        $sheet->setCellValue('I9', "APRIL");
        $sheet->getStyle('I9')->applyFromArray($style_col);
        $sheet->setCellValue('J9', "MEI");
        $sheet->getStyle('J9')->applyFromArray($style_col);
        $sheet->setCellValue('K9', "JUNI");
        $sheet->getStyle('K9')->applyFromArray($style_col);
        $sheet->setCellValue('L9', "JULI");
        $sheet->getStyle('L9')->applyFromArray($style_col);
        $sheet->setCellValue('M9', "AGUSTUS");
        $sheet->getStyle('M9')->applyFromArray($style_col);
        $sheet->setCellValue('N9', "SEPTEMBER");
        $sheet->getStyle('N9')->applyFromArray($style_col);
        $sheet->setCellValue('O9', "OKTOBER");
        $sheet->getStyle('O9')->applyFromArray($style_col);
        $sheet->setCellValue('P9', "NOVEMBER");
        $sheet->getStyle('P9')->applyFromArray($style_col);
        $sheet->setCellValue('Q9', "DESEMBER");
        $sheet->getStyle('Q9')->applyFromArray($style_col);
        $sheet->setCellValue('R8', "SALDO BUDGET");
        $sheet->getStyle('R8')->applyFromArray($style_col);
        $sheet->setCellValue('R9', $tahun);
        $sheet->getStyle('R9')->applyFromArray($style_col);


        $query = $this->db->query("SELECT mb.id_budget as id  ,mb.account_bame as acc, md.nama_departement as dept  , mb.kode_budget  as kode  , mb.description as akt , mb.tahun ,  
        CAST((select sum(mpb.nilai_budget) as nilai 
        from master_planning_budget mpb where mb.id_budget = mpb.master_budget_id_budget  ) as unsigned ) as nilai
        from master_budget mb 
        inner join master_departement md on md.id  = mb.departement_id  
        where mb.approve_fin  = 1 and md.id  = '" . $dept . "' and mb.tahun  = '" . $tahun . "' ");


        $n = 10;
        foreach ($query->result() as $t) {
            $sldo = $t->nilai - $this->model->sisaBudgetTahunan($t->kode);
            $sheet->setCellValue('B' . $n, $t->dept);
            $sheet->setCellValue('C' . $n, $t->kode);
            $sheet->setCellValue('D' . $n, $t->acc);
            $sheet->setCellValue('E' . $n, number_format($t->nilai));
            $sheet->setCellValue('F' . $n, number_format($this->model->pemakaianBulanan($t->id, "01")));
            $sheet->setCellValue('G' . $n, number_format($this->model->pemakaianBulanan($t->id, "02")));
            $sheet->setCellValue('H' . $n, number_format($this->model->pemakaianBulanan($t->id, "03")));
            $sheet->setCellValue('I' . $n, number_format($this->model->pemakaianBulanan($t->id, "04")));
            $sheet->setCellValue('J' . $n, number_format($this->model->pemakaianBulanan($t->id, "05")));
            $sheet->setCellValue('K' . $n, number_format($this->model->pemakaianBulanan($t->id, "06")));
            $sheet->setCellValue('L' . $n, number_format($this->model->pemakaianBulanan($t->id, "07")));
            $sheet->setCellValue('M' . $n, number_format($this->model->pemakaianBulanan($t->id, "08")));
            $sheet->setCellValue('N' . $n, number_format($this->model->pemakaianBulanan($t->id, "09")));
            $sheet->setCellValue('O' . $n, number_format($this->model->pemakaianBulanan($t->id, "10")));
            $sheet->setCellValue('P' . $n, number_format($this->model->pemakaianBulanan($t->id, "11")));
            $sheet->setCellValue('Q' . $n, number_format($this->model->pemakaianBulanan($t->id, "12")));
            $sheet->setCellValue('R' . $n, number_format($sldo));



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
            $sheet->getStyle('L' . $n)->applyFromArray($style_row);
            $sheet->getStyle('M' . $n)->applyFromArray($style_row);
            $sheet->getStyle('N' . $n)->applyFromArray($style_row);
            $sheet->getStyle('O' . $n)->applyFromArray($style_row);
            $sheet->getStyle('P' . $n)->applyFromArray($style_row);
            $sheet->getStyle('Q' . $n)->applyFromArray($style_row);
            $sheet->getStyle('R' . $n)->applyFromArray($style_row);

            $n++;
        }

        for ($i = 'A'; $i !=  $spreadsheet->getActiveSheet()->getHighestColumn(); $i++) {
            $spreadsheet->getActiveSheet()->getColumnDimension($i)->setAutoSize(TRUE);
        }


        $sheet->setTitle("Laporan Budget All Kode Budget");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Laporan All Kode Budget.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }

    public function getKode()
    {
        $where = [
            'tahun'                  => $this->input->post("tahun"),
            'departement_id'         => $this->session->userdata("departement_id"),
            'approve_fin'            => 1
        ];

        $data =  $this->model->ambilData("master_budget", $where);
        echo json_encode($data->result());
    }
    // public function tes(Type $var = null)
    // {
    //     $d = $this->model->sisaBudgetTahunan("QA/REG01/01");
    //     echo "<pre>";
    //     var_dump($d);
    // }
}
