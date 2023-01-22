<?php


class Input_Budget extends CI_Controller
{
    public function __construct(Type $var = null)
    {
        parent::__construct();
        $this->load->model('M_departement', 'model');
        $role = $this->session->userdata("level");
        date_default_timezone_set('Asia/Jakarta');
        if ($role != 'DPT') {
            redirect('Login');
        }
    }

    public function index()
    {

        $code_dept = $this->db->query("SELECT kode_departement as code FROM master_departement WHERE id='" . $this->session->userdata("departement_id") . "' ")->row();
        $data = [
            'uri'           => $this->uri->segment(2),
            'jenis'         => $this->model->getData("master_jenis_budget")->result(),
            'code_dept'     => $code_dept->code . '/REG' . rand(13, 15) . '/' . rand(10, 30),
            'sub_jenis'     => $this->model->getData("master_sub_jenis_budget")->result()

        ];
        $this->template->load('template_departement', 'input_budget', $data);
    }



    public function input_v1()
    {
        $tahun          = $this->input->post("tahun_budget");
        $kode           = $this->input->post("kode_budget");
        $jenis          = $this->input->post("jenis_budget");
        $kpi            = $this->input->post("kpi");
        $target_kpi     = $this->input->post("target_kpi");
        $pic            = $this->input->post("pic");
        $improvement    = $this->input->post("improvement");
        $budget         = $this->input->post("budget");
        $account_bame   = $this->input->post("account_bame");
        $description    = $this->input->post("description");
        $sub_jenis_budget    = $this->input->post("sub_jenis_budget");


        $data = [
            'tahun'                     => $tahun,
            'kode_budget'               => $kode,
            'master_jenis_budget_id'    => $jenis,
            'target_kpi'                => $target_kpi,
            'pic'                       => $pic,
            'kpi'                       => $kpi,
            'improvment'                => $improvement,
            'budget'                    => $budget,
            'description'               => $description,
            'account_bame'              => $account_bame,
            'created_at'                => date('Y-m-d H:i:s'),
            'departement_id'            => $this->session->userdata("departement_id"),
            'status'                    => 0,
            'ket'                        => 'menunggu approve manager',
            'master_sub_jenis_budget_id' => $sub_jenis_budget,
            'created_by'                => $this->session->userdata("nik"),
        ];


        $save =  $this->model->insert("master_budget", $data);
        if ($save) {
            $this->session->set_flashdata("ok", "Budget di ajukan , menunggu approval");
            redirect('departement/Input_Budget');
        } else {
            $this->session->set_flashdata("fail", "gagal input");
            redirect('departement/Input_Budget');
        }
    }

    public function input(Type $var = null)
    {
        $tahun               = $this->input->post("tahun_budget");
        $kode                = $this->input->post("kode_budget");
        $jenis               = $this->input->post("jenis_budget");
        $kpi                 = $this->input->post("kpi");
        $target_kpi          = $this->input->post("target_kpi");
        $pic                 = $this->input->post("pic");
        $improvement         = $this->input->post("improvement");
        $budget              = $this->input->post("budget");
        $account_bame        = $this->input->post("account_bame");
        $description         = $this->input->post("description");
        $sub_jenis_budget    = $this->input->post("sub_jenis_budget");
        $due_date            = $this->input->post("due_date");

        $data = [
            'tahun'                      => $tahun,
            'kode_budget'                => $kode,
            'master_jenis_budget_id'     => $jenis,
            'target_kpi'                 => $target_kpi,
            'pic'                        => $pic,
            'kpi'                        => $kpi,
            'improvment'                 => $improvement,
            'budget'                     => $budget,
            'description'                => $description,
            'account_bame'               => $account_bame,
            'created_at'                 => date('Y-m-d H:i:s'),
            'departement_id'             => $this->session->userdata("departement_id"),
            'status'                     => 0,
            'due_date'                   => $due_date,
            'ket'                        => 'menunggu approve supervisor',
            'master_sub_jenis_budget_id' => $sub_jenis_budget,
            'created_by'                 => $this->session->userdata("nik"),
        ];

        $search_kode = $this->db->get_where("master_budget", ['kode_budget' => $kode]);
        if ($search_kode->num_rows() > 0) {
            $this->session->set_flashdata("nok", "Gagal  , terjadi kesalahan,kode budget sudah digunakan");
            redirect('departement/Input_budget');
        } else {
            $this->db->insert("master_budget", $data);
            if ($this->db->affected_rows() > 0) {
                $this->db->trans_commit();
                $id = $this->db->insert_id();
                $listbulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                $bulan    = $this->input->post("bulan");
                $activity = $this->input->post("activity");
                $params = array();
                for ($i = 0; $i < count($bulan); $i++) {
                    $data2 = [
                        'bulan'                     => $listbulan[$i],
                        'nilai_budget'              => $bulan[$i],
                        'master_budget_id_budget'   => $id,
                        'activity'                  => $activity,
                        'status'                    => 0,
                        'created_at'                => date('Y-m-d H:i:s'),
                        'created_by'                => $this->session->userdata('nik')
                    ];
                    array_push($params, $data2);
                };
                $save = $this->model->multiInsert($params, "master_planning_budget");
                if ($save > 0) {
                    $this->session->set_flashdata("ok", "Planing budget di simpan");
                    redirect('departement/Input_Budget');
                } else {
                    $this->session->set_flashdata("nok", "Planing budget gagal simpan");
                    redirect('departement/Input_Budget');
                }
            } else {
                $this->db->trans_rollback();
                $this->session->set_flashdata("nok", "Gagal  , terjadi kesalahan");
                redirect('departement/Input_Budget');
            }
        }
    }
}
