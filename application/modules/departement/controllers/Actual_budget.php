<?php

class Actual_budget extends CI_Controller
{
    public function __construct(Type $var = null)
    {
        parent::__construct();
        $this->load->model('M_departement', 'model');
        $this->load->helper('convertbulan');
        date_default_timezone_set('Asia/Jakarta');
    }

    public function list_actual()
    {
        $data = [
            'uri'       => $this->uri->segment(2),
            'manager'    => $this->model->daftarActualActivity($this->session->userdata("departement_id"), "approve_mgr", 0),
            'bc'    => $this->model->daftarActualActivity($this->session->userdata("departement_id"), "approve_mgr", 1),
            'gm'    => $this->model->daftarActualActivity($this->session->userdata("departement_id"), "approve_acc", 1),
            'finance'    => $this->model->daftarActualActivity($this->session->userdata("departement_id"), "approve_acc", 1),
        ];
        $this->template->load('template_departement', 'daftar_actual_budget_activity', $data);
    }

    public function form_input_actual()
    {
        $code_dept = $this->db->query(" SELECT kode_departement as code FROM master_departement WHERE id='" . $this->session->userdata("departement_id") . "' ")->row();

        $data = [
            'uri'               => $this->uri->segment(2),
            'bulan'             => convertbulan(date('m')),
            'jenis_transaksi'   => $this->model->getData("master_jenis_transaksi")->result(),
            'code_dept'         => $code_dept->code . 'REQ/RMBPNJ' . rand(13, 15) . '/' . rand(10, 30),
            'jenis'             => $this->model->getData("master_jenis_budget")->result()
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

    public function input()
    {
        $ammount        = $this->input->post("ammount");
        $particullars   = $this->input->post("particullar");
        $jenis          = $this->input->post("jenis_transaksi");
        $part           = array();
        $config['upload_path']          = './assets/lampiran/';
        $config['allowed_types']        = 'gif|jpg|png';
        $config['file_name']            = str_replace('.', '', $this->session->userdata("nik") . rand(98, 98));
        $this->load->library('upload', $config);
        $cari_jenis = $this->db->query("SELECT jenis_transaksi FROM master_jenis_transaksi  WHERE id='" . $jenis . "' ")->row();

        if ($cari_jenis->jenis_transaksi == "PANJAR") {
            if (!$this->upload->do_upload('lampiran')) {
                $data['error'] = $this->upload->display_errors();
                echo $this->upload->display_errors();
            } else {
                $panjar_nilai = $this->input->post("panjar");
                $data = [
                    'master_departement_id'          => $this->session->userdata("departement_id"),
                    'master_jenis_transaksi_id'      => $jenis,
                    'master_planning_budget_id_planing'  => $this->input->post("id_planning"),
                    'request_code'                   => $this->input->post("request_code"),
                    'tanggal_request'                => $this->input->post("tanggal"),
                    'remarks'                        => $this->input->post("remarks"),
                    'status_approved'                => 0,
                    'lampiran'                       => $this->upload->data('file_name'),
                    'approve_mgr'                    => 0,
                    'ket'                            => "menunggu approved dept head",
                    'created_at'                     => date('Y-m-d H:i:s'),
                    'created_by'                     => $this->session->userdata("nik"),
                    'to'                             => $this->input->post("toPenerima"),
                    'bank'                           => $this->input->post("bank"),
                    'rekening'                       => $this->input->post("rekening"),
                ];
                $this->db->insert("transaksi_jenis_pembayaran", $data);
                if ($this->db->affected_rows() > 0) {
                    $this->db->trans_commit();
                    $id = $this->db->insert_id();
                    for ($i = 0; $i < count($panjar_nilai); $i++) {
                        $arr = [
                            'ammount'                          => $panjar_nilai[$i],
                            'transaksi_jenis_pembayaran_id'    => $id
                        ];
                        array_push($part, $arr);
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
        } else {

            if (!$this->upload->do_upload('lampiran')) {
                $data['error'] = $this->upload->display_errors();
                echo $this->upload->display_errors();
            } else {
                $data = [
                    'master_departement_id'          => $this->session->userdata("departement_id"),
                    'master_jenis_transaksi_id'      => $jenis,
                    'master_planning_budget_id_planing'  => $this->input->post("id_planning"),
                    'request_code'                   => $this->input->post("request_code"),
                    'tanggal_request'                => $this->input->post("tanggal"),
                    'remarks'                        => $this->input->post("remarks"),
                    'status_approved'                => 0,
                    'lampiran'                       => $this->upload->data('file_name'),
                    'approve_mgr'                    => 0,
                    'ket'                            => "menunggu approved manager",
                    'created_at'                     => date('Y-m-d H:i:s'),
                    'created_by'                     => $this->session->userdata("nik"),
                    'to'                             => $this->input->post("toPenerima"),
                    'bank'                           => $this->input->post("bank"),
                    'rekening'                       => $this->input->post("rekening"),
                ];
                $this->db->insert("transaksi_jenis_pembayaran", $data);
                if ($this->db->affected_rows() > 0) {
                    $this->db->trans_commit();
                    $id = $this->db->insert_id();
                    for ($i = 0; $i < count($ammount); $i++) {
                        $arr = [
                            'ammount'                          => $ammount[$i],
                            'particullar'                      => $particullars[$i],
                            'transaksi_jenis_pembayaran_id'    => $id
                        ];
                        array_push($part, $arr);
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
    }
}
