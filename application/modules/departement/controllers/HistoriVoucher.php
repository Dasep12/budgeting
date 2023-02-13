<?php

class HistoriVoucher extends CI_Controller
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

    public function list_plantVoucher()
    {
        $data = [
            'uri'       => $this->uri->segment(2),
            'plant'     => $this->model->daftarPlantVoucher($this->session->userdata("departement_id"))
        ];
        $this->template->load('template_departement', 'daftar_plant_voucher', $data);
    }



    public function viewDetailPlant()
    {
        $id = $this->input->post("id");
        $id    = $this->input->post("id");
        $file1 = $this->input->post("file1");
        $file2 = $this->input->post("file2");
        $file3 = $this->input->post("file3");
        $nama  = $this->input->post("nama");
        $remarks  = $this->input->post("remarks");
        $jenis  = $this->input->post("jenis");
        $data = [
            'data'   => $this->model->ambilData('transaksi_detail_voucher', ['transaksi_plant_voucher_id' => $id]),
            'file1'      => $file1,
            'file2'      => $file2,
            'file3'      => $file3,
            'nama'       => $nama,
            'remarks'    => $remarks,
            'jenis'       => $jenis,
        ];
        $this->load->view("detail_plant_voucher", $data);
    }

    public function viewDetailApprove()
    {
        $id = $this->input->post("id");
        $data = [
            'data'  => $this->model->ambilData("transaksi_plant_voucher", ['id' => $id])->row()
        ];
        $this->load->view("timeline_voucher_plant", $data);
    }

    public function delete()
    {
        $id = $this->input->get("id");
        $del = $this->model->delete(['transaksi_plant_voucher_id' => $id], "transaksi_detail_voucher");
        if ($del > 0) {
            $this->db->trans_commit();
            $this->model->delete(['id' => $id], "transaksi_plant_voucher");
            $this->session->set_flashdata("ok", 'transaksi di hapus');
            redirect('departement/HistoriVoucher/list_plantVoucher');
        } else {
            $this->db->trans_rollback();
            $this->session->set_flashdata("nok", "terjadi kesalahan");
            redirect('departement/HistoriVoucher/list_plantVoucher');
        }
    }

    public function form_edit_voucher()
    {
        $id = $this->input->get("id");
        $data = [
            'uri'       => $this->uri->segment(2),
            'header'    => $this->db->query("SELECT tpv.id , remarks    from transaksi_plant_voucher tpv where tpv.id = $id ")->row(),
            'detail'    => $this->model->ambilData("transaksi_detail_voucher", ['transaksi_plant_voucher_id' => $id])->result()

        ];
        $this->template->load('template_departement', 'edit_plant_voucher', $data);
    }

    public function update()
    {
        $id = $this->input->post("id");
        $ammount        = $this->input->post("ammount");
        $remarks        = $this->input->post("remarks");
        $particullars   = $this->input->post("particullar");
        $part           = array();
        $del = $this->model->delete(['transaksi_plant_voucher_id'  => $id], "transaksi_detail_voucher");
        if ($del > 0) {
            $this->db->trans_commit();
            for ($i = 0; $i < count($ammount); $i++) {
                $arr = [
                    'ammount'                          => preg_replace("/[^0-9]/", "", $ammount[$i]),
                    'ammount_plant'                    => preg_replace("/[^0-9]/", "", $ammount[$i]),
                    'particullar'                      => $particullars[$i],
                    'transaksi_plant_voucher_id'       => $id
                ];
                array_push($part, $arr);
            }
            $this->model->updateData(['remarks' => $remarks], 'transaksi_plant_voucher', ['id' => $id]);
            $this->db->insert_batch("transaksi_detail_voucher", $part);
            $this->session->set_flashdata("ok", "berhasil di update");
            redirect('departement/HistoriVoucher/list_plantVoucher');
        } else {
            $this->db->trans_rollback();
            $this->session->set_flashdata("nok", "gagal di update");
            redirect('departement/HistoriVoucher/list_plantVoucher');
        }
    }
}
