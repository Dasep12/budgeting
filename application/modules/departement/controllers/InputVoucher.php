<?php

class InputVoucher extends CI_Controller
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

    public function form_input_voucher(Type $var = null)
    {
        $code_dept = $this->db->query(" SELECT kode_departement as code FROM master_departement WHERE id='" . $this->session->userdata("departement_id") . "' ")->row();
        $bk = $this->db->query(" SELECT ifnull(max(bk),0) as nilai_bk from  transaksi_jenis_pembayaran ")->row();

        if ($bk->nilai_bk == 0) {
            $d = explode('/', date('Y') . '/TRN/00');
        } else {
            $d = explode('/', $bk->nilai_bk);
        }
        $data = [
            'uri'           => $this->uri->segment(2),
            'bk'                => $d[0] . '/' . $d[1] . '/' . $d[2] + 1,
            'transaksi'     => $this->model->ambilData("master_jenis_transaksi", ['jenis_transaksi' => 'AP VOUCHER'])->row(),
            'code_dept'         => $code_dept->code . 'REQ/VCR' . rand(13, 15) . '/' . rand(10, 30),
            'acc'               => $this->model->getData("master_acc")->result(),
            'jenis'             => $this->model->getData("master_jenis_budget")->result(),
        ];
        $this->template->load('template_departement', 'input_apvoucher', $data);
    }
    private function upload_multiple($files, $title)
    {
        $config = array(
            'upload_path'   => './assets/lampiran/',
            'allowed_types' => 'jpg|png|jpeg',
            'overwrite'     => false,
        );

        $this->load->library('upload', $config);

        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, true);
        }

        $img = array();
        foreach ($files['name'] as $key => $image) {
            if (!empty($files['name'][$key])) {
                $_FILES['lampiran[]']['name'] = $files['name'][$key];
                $_FILES['lampiran[]']['type'] = $files['type'][$key];
                $_FILES['lampiran[]']['tmp_name'] = $files['tmp_name'][$key];
                $_FILES['lampiran[]']['error'] = $files['error'][$key];
                $_FILES['lampiran[]']['size'] = $files['size'][$key];

                // $fileName = $title .'_'. $image;
                $rand_number = rand(10000, 99999);
                // $fileName = $title.'_'.$rand_number;
                $config['file_name'] = $title . '_' . date('YmdHis') . '_' . $rand_number;
                // $dok[] = $fileName;

                $this->upload->initialize($config);

                if ($this->upload->do_upload('lampiran[]')) {
                    $file = $this->upload->data();
                    $res[] = $file;
                } else {
                    // $res = '01';
                    $res = array('error' => $this->upload->display_errors());
                }
            }
        }

        return $res;
    }
    public function input()
    {
        $ammount        = $this->input->post("ammount");
        $particullars   = $this->input->post("particullar");
        $jenis          = $this->input->post("jenis_transaksi");
        $acc            = $this->input->post("acc");
        $part           = array();
        $upload         =  $this->upload_multiple($_FILES['lampiran'], date('ymd'));
        $field_img      = [];
        $nom = 1;
        foreach ($upload as $key => $item_file) {
            $field_img['lampiran_' . $nom] = $item_file['file_name'];
            $nom++;
        }
        $par  = array(
            'master_departement_id'              => $this->session->userdata("departement_id"),
            'master_jenis_transaksi_id'          => $jenis,
            'master_planning_budget_id_planing'  => $this->input->post("id_planning"),
            'master_acc_id'                      => $acc,
            'request_code'                   => $this->input->post("request_code"),
            'tanggal_request'                => $this->input->post("tanggal"),
            'remarks'                        => $this->input->post("remarks"),
            'status_approved'                => 0,
            'approve_spv'                    => 0,
            'bk'                             => $this->input->post("bk"),
            'ket'                            => "menunggu approved supervisor",
            'created_at'                     => date('Y-m-d H:i:s'),
            'created_by'                     => $this->session->userdata("nik"),
            'to'                             => $this->input->post("toPenerima"),
            'bank'                           => $this->input->post("bank"),
            'rekening'                       => $this->input->post("rekening"),
        );

        $res_field = array_merge($par, $field_img);
        $save = $this->model->insert("transaksi_plant_voucher", $res_field);
        if ($save > 0) {
            $this->db->trans_commit();
            $id = $this->db->insert_id();
            for ($i = 0; $i < count($ammount); $i++) {
                $arr = [
                    'ammount'                          => preg_replace("/[^0-9]/", "", $ammount[$i]),
                    'ammount_plant'                    => preg_replace("/[^0-9]/", "", $ammount[$i]),
                    'particullar'                      => $particullars[$i],
                    'transaksi_plant_voucher_id'       => $id
                ];
                array_push($part, $arr);
            }
            // var_dump($part);
            $this->db->insert_batch("transaksi_detail_voucher", $part);
            $this->session->set_flashdata("ok", "berhasil di input");
            redirect('departement/InputVoucher/form_input_voucher');
        } else {
            $this->db->trans_rollback();
            $this->session->set_flashdata("nok", "gagal di input");
            redirect('departement/InputVoucher/form_input_voucher');
        }
        // }
    }
}
