<?php

class Actual_budget extends CI_Controller
{
    public function __construct(Type $var = null)
    {
        parent::__construct();
        $this->load->model('M_departement', 'model');
        $this->load->helper('convertbulan');
        date_default_timezone_set('Asia/Jakarta');

        $role = $this->session->userdata("level");
        if ($role != 'dpt') {
            redirect('Login');
        }
    }

    public function list_actual()
    {
        $data = [
            'uri'           => $this->uri->segment(2),
            'manager'       => $this->model->daftarActualActivity($this->session->userdata("departement_id"), "mgr"),
            'bc'            => $this->model->daftarActualActivity($this->session->userdata("departement_id"), "bc"),
            'gm'            => $this->model->daftarActualActivity($this->session->userdata("departement_id"), "gm"),
            'finance'       => $this->model->daftarActualActivity($this->session->userdata("departement_id"), "fin"),
        ];
        $this->template->load('template_departement', 'daftar_actual_budget_activity', $data);
    }

    public function form_input_actual()
    {
        $code_dept = $this->db->query(" SELECT kode_departement as code FROM master_departement WHERE id='" . $this->session->userdata("departement_id") . "' ")->row();
        $bk = $this->db->query("  SELECT ifnull(max(bk),0) as nilai_bk from  transaksi_jenis_pembayaran ")->row();

        $d = explode('/', $bk->nilai_bk);
        $data = [
            'uri'               => $this->uri->segment(2),
            'bk'                => $d[0] . '/' . $d[1] . '/' . $d[2] + 1,
            'bulan'             => convertbulan(date('m')),
            'jenis_transaksi'   => $this->model->getData("master_jenis_transaksi")->result(),
            'code_dept'         => $code_dept->code . 'REQ/RMBPNJ' . rand(13, 15) . '/' . rand(10, 30),
            'jenis'             => $this->model->getData("master_jenis_budget")->result(),
            'acc'               => $this->model->getData("master_acc")->result()
        ];
        $this->template->load('template_departement', 'input_actual_activity', $data);
    }

    public function getKodeBudget()
    {
        $where = [
            'tahun'                  => $this->input->get("tahun"),
            'departement_id'         => $this->session->userdata("departement_id"),
            'master_jenis_budget_id' => $this->input->get("jenis")
        ];

        $data =  $this->model->ambilData("master_budget", $where);
        echo json_encode($data->result());
    }

    public function getBudget()
    {
        $dept = $this->session->userdata("departement_id");
        $tahun = $this->input->get("tahun");
        $bulan = $this->input->get("bulan");
        $kode = $this->input->get("kode");
        $data = $this->model->PlantBudgetDepartementPerBulan($dept, $tahun, $bulan, $kode);
        if ($data->num_rows() > 0) {
            $budget_p = $data->row();
            $detail = $this->model->getActualPlantBudgetBulanan($budget_p->id_planing);
            if ($detail->budget_actual == "" || $detail->budget_actual == null) {
                echo json_encode($data->row());
            } else {
                echo json_encode($detail);
            }
        } else {
            echo 0;
        }
    }

    public function getCodeRequest()
    {
        $code = $this->input->get("type");
        $dept_id = $this->session->userdata("departement_id");
        $where = ['master_departement_id' => $dept_id, 'type' => $code];
        $cari_kode = $this->model->ambilData("transaksi_jenis_pembayaran", $where);
        if ($cari_kode->num_rows()) {
            echo json_encode($cari_kode->result());
        } else {
            echo "0";
        }
    }

    public function getNilaiTransaksi()
    {
        $code = $this->input->get("code");
        $data = $this->model->getTotalBelanjaRaimbusment($code);
        echo json_encode($data->row());
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
        $panjar_nilai   = $this->input->post("panjar");
        $particullars   = $this->input->post("particullar");
        $jenis          = $this->input->post("jenis_transaksi");
        $acc            = $this->input->post("acc");
        $part           = array();
        $cari_jenis = $this->db->query("SELECT jenis_transaksi FROM master_jenis_transaksi  WHERE id='" . $jenis . "' ")->row();

        $upload =  $this->upload_multiple($_FILES['lampiran'], date('ymd'));
        $field_img = [];
        $nom = 1;
        foreach ($upload as $key => $item_file) {
            $field_img['lampiran_' . $nom] = $item_file['file_name'];
            $nom++;
        }
        if ($upload) {
            $panjar_nilai = $this->input->post("panjar");
            $par  = array(
                'master_departement_id'          => $this->session->userdata("departement_id"),
                'master_jenis_transaksi_id'      => $jenis,
                'master_planning_budget_id_planing'  => $this->input->post("id_planning"),
                'master_acc_id'                  => $acc,
                'request_code'                   => $this->input->post("request_code"),
                'tanggal_request'                => $this->input->post("tanggal"),
                'remarks'                        => $this->input->post("remarks"),
                'status_approved'                => 0,
                'approve_mgr'                    => 0,
                'bk'                             => $this->input->post("bk"),
                'ket'                            => "menunggu approved dept head",
                'created_at'                     => date('Y-m-d H:i:s'),
                'created_by'                     => $this->session->userdata("nik"),
                'to'                             => $this->input->post("toPenerima"),
                'bank'                           => $this->input->post("bank"),
                'rekening'                       => $this->input->post("rekening"),
            );
            $res_field = array_merge($par, $field_img);
            $this->db->insert("transaksi_jenis_pembayaran", $res_field);
            if ($this->db->affected_rows() > 0) {
                $this->db->trans_commit();
                $id = $this->db->insert_id();

                if ($cari_jenis->jenis_transaksi == "PANJAR") {
                    for ($i = 0; $i < count($panjar_nilai); $i++) {
                        $arr = [
                            'ammount'                          => $panjar_nilai[$i],
                            'transaksi_jenis_pembayaran_id'    => $id
                        ];
                        array_push($part, $arr);
                    }
                } else {
                    for ($i = 0; $i < count($ammount); $i++) {
                        $arr = [
                            'ammount'                          => $ammount[$i],
                            'particullar'                      => $particullars[$i],
                            'transaksi_jenis_pembayaran_id'    => $id
                        ];
                        array_push($part, $arr);
                    }
                }
                $this->db->insert_batch("trans_detail_jenis_pembayaran", $part);
                $this->session->set_flashdata("ok", "berhasil di input");
                redirect('departement/Actual_budget/form_input_actual');
            } else {
                $this->db->trans_rollback();
                $this->session->set_flashdata("nok", "gagal di input");
                redirect('departement/Actual_budget/form_input_actual');
            }
        }
    }

    public function getNilaiBK()
    {
        $bk = $this->db->query("  SELECT ifnull(max(bk),0) as nilai_bk from  transaksi_jenis_pembayaran ")->row();
        $jenis = $this->input->post("jenis");
        if ($jenis == "PANJAR") {
            $jn = "PJ";
        } else {
            $jn = "PV";
        }
        $d = explode('/', $bk->nilai_bk);
        echo $d[0]  . '/' . $jn . '/' . $d[2] + 1;
    }
}
