<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Penerimaan extends MY_Controller {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Pendaftar_model','pendaftar');
        $this->load->model('Penerimaan_model','penerimaan');
        $this->load->model('Prodi_model','prodi');
        $this->load->model('Fakultas_model','fakultas');
        $this->load->model('Seleksimanual_model','seleksimanual');
        $this->load->model('Pengaturan_model','pengaturan');
        $this->load->model('Laporan_model','laporan');
    }
 
    public function index()
    {
        $this->ion_auth->is_admin() ? $dd_prodi = $this->laporan->dd_prodi() : $dd_prodi = $this->laporan->dd_prodi();
        $tahunakademik = $this->pengaturan->gettahunakademik()->nilai;
        $tahun = substr($tahunakademik,0,4);
        $data = array(
            'view' => 'penerimaan/penerimaan_view',
			'dd_prodi' => $dd_prodi,
            'prodi_selected' => $this->input->post('pilihprodi') ? $this->input->post('pilihprodi') : '',
            'tahunakademik' => $tahunakademik,
            'tahun' => $tahun,
            
        );	
        $this->load->view('layout',$data);
    }
 
    public function ajax_list()
    {
        $list = $this->penerimaan->get_datatables(); 
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $result) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $result->nopendaftar; 
            $row[] = $result->namapendaftar;
            $row[] = $result->namaprodi;
            $row[] = $result->jenjang;
            $row[] = strtoupper($result->namafakultas);
            $row[] = $result->tahunlulus;
            $row[] = '<a class="btn btn-xs btn-danger" href="javascript:void(0)" title="Batalkan" onclick="batalkan('."'".$result->nopendaftar."'".')"><i class="glyphicon glyphicon-trash"></i> Batalkan</a>';
           
            $data[] = $row;
        }
  
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->penerimaan->count_all(),
                        "recordsFiltered" => $this->penerimaan->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }

    public function batalkan($id)
    {
        $dataupdate = array(
            "status" => $this->input->post('status'),
        );
        $this->penerimaan->update($dataupdate,array("nopendaftar"=>$id));
        $this->penerimaan->delete($id);
        $output = array(
            "status" => $this->input->post('status'),
            "nopendaftar" => $id,
        );
        //output to json format
        echo json_encode($output);
    }

    public function batalkansemua()
    {
        $dataupdate = array(
            "status" => $this->input->post('status'),
        );
        $this->penerimaan->update(array("status"=>"B"),array("status"=>"T"));
        $this->penerimaan->deleteall();
        echo json_encode($dataupdate);
        //redirect('penerimaan');
    }
}