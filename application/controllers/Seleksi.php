<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Seleksi extends MY_Controller {
    var $column_search = array('nopendaftar','namapendaftar','tempatlahir','tanggallahir','jeniskelamin','suku','jenjangslta','jurusanslta','tahunlulus','asalslta'); //set column field database for datatable searchable just firstname , lastname , address are searchable
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Penerimaan_model','penerimaan');
        $this->load->model('Seleksimanual_model','seleksimanual');
        $this->load->model('Prodi_model','prodi');
        $this->load->model('Pengaturan_model','pengaturan');
        $this->load->model('Laporan_model','laporan');
    }
 
    public function index()
    {
        $this->ion_auth->is_admin() ? $dd_prodi = $this->seleksimanual->dd_prodi() : $dd_prodi = $this->seleksimanual->dd_prodi();
        $data = array(
            'tahunakademik' => $this->pengaturan->gettahunakademik()->nilai,
			'view' => 'seleksimanual/seleksimanual_view',
			'dd_prodi' => $dd_prodi,
            'prodi_selected' => $this->input->post('pilihprodi') ? $this->input->post('pilihprodi') : '',
			'dd_suku' => $dd_prodi = $this->seleksimanual->dd_suku(),
            'suku_selected' => $this->input->post('pilihsuku') ? $this->input->post('pilihsuku') : '',
        );	
        $this->load->view('layout',$data);
    }

    public function ajax_list()
    {
        $sesipilihan = $this->pengaturan->getsesipilihan()->nilai;
        $tahunakademik = $this->pengaturan->gettahunakademik()->nilai;
        $list = $this->seleksimanual->get_datatables($sesipilihan,$tahunakademik);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $result) {
            $no++;
           
            $prodipilihan = "";
            if(isset($_POST['is_prodi'])){
                if($_POST['is_prodi']==$result->pilihan1){
                    $prodipilihan = "1 ";
                    if($_POST['is_prodi']==$result->pilihan2){
                        $prodipilihan .= "| 2 ";
                    }
                    if($_POST['is_prodi']==$result->pilihan3){
                        $prodipilihan .= "| 3 ";
                    }
                }
                
                elseif($_POST['is_prodi']==$result->pilihan2){
                    $prodipilihan = "2 ";
                    if($_POST['is_prodi']==$result->pilihan3){
                        $prodipilihan .= "| 3 ";
                    }
                }

                elseif($_POST['is_prodi']==$result->pilihan3){
                    $prodipilihan = "3";
                }
            }
            $row = array(); 
                $row[] = '';
                $row[] = $result->nopendaftar;
                $row[] = $result->namapendaftar;
                $row[] = $prodipilihan;
                $row[] = $result->suku;
                $row[] = $result->jurusanslta;
                $row[] = $result->nsem3;
                $row[] = $result->nsem4;
                $row[] = $result->nsem5;
                $row[] = $result->ratarata;
                $row[] = $result->tahunlulus;
            
            //add html for action
            $row[] = '<a class="btn btn-xs btn-info" href="javascript:void(0)" title="Detail" onclick="detail_record('."'".$result->nopendaftar."'".')"><i class="glyphicon glyphicon-search"></i> Detail</a>
                    <a class="btn btn-xs btn-primary" href="javascript:void(0)" title="Terima" onclick="terima('."'".$result->nopendaftar."'".')"><i class="glyphicon glyphicon-ok-circle"></i> Terima</a>';
 
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->seleksimanual->count_all($tahunakademik),
                        "recordsFiltered" => $this->seleksimanual->count_filtered($sesipilihan,$tahunakademik),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }

    public function terima($id)
    {
        $prodi = $this->input->post('pilihprodi');
        $dayatampung = $this->prodi->get_by_prodiname($prodi)->dayatampung;
        $sisakuota = $this->penerimaan->count_filter_prodi($prodi);

        $datainput = array(
            'nopendaftar' => $id,
            'idprodi' => $this->prodi->get_by_prodiname($prodi)->idprodi,
        );
        $dataupdate = array(
            'status' => $this->input->post('status'),
        );
         
        $data = array('dayatampung'=>$dayatampung, 'sisakuota'=>$sisakuota);

            if($sisakuota == $dayatampung){
                $data['statusterima'] = FALSE;            
            } else {
                $insert = $this->seleksimanual->save($datainput);
                $insert = $this->seleksimanual->update($dataupdate,array('nopendaftar'=>$id));
                $data['statusterima'] = TRUE;
            }
        echo json_encode($data);
        
    }

    public function terimakolektif()
    {
        $prodi = $this->input->post('pilihprodi');
        $dayatampung = $this->prodi->get_by_prodiname($prodi)->dayatampung;
        $jumlahditerimaprodi = $this->penerimaan->count_filter_prodi($prodi);
        $sisakuota = $dayatampung-$jumlahditerimaprodi;
        $data = [];
        $arrnopendaftar = explode(',',$this->input->post('nopendaftar'));

        foreach ($arrnopendaftar as $nopendaftar){
            $datainput = array(
                'idprodi' => $this->prodi->get_by_prodiname($prodi)->idprodi,
                'nopendaftar' => $nopendaftar,
            );
            $dataupdate = array(
                'status' => $this->input->post('status'),
            );

            if($sisakuota == 0){
                $data['statusterima'] = FALSE;            
            } else {
                $sisakuota--;
                $insert = $this->seleksimanual->save($datainput);
                $insert = $this->seleksimanual->update($dataupdate,array('nopendaftar'=>$nopendaftar));
                if($sisakuota == 0){
                    $data['statusterima'] = FALSE;  
                }
                $data['statusterima'] = TRUE;
            }
        } 
        $data['dayatampung'] = $dayatampung;
        $data['sisakuota'] = $sisakuota;
        echo json_encode($data);
    }
    
    public function getdayatampungprodi()
    {
        $prodiname = $this->input->post('pilihprodi');

        if(isset($_POST['pilihprodi'])){
            if($_POST['pilihprodi']=='0'){
                $data['sisakuota'] = $this->laporan->totaldayatampung()->dayatampung - $this->laporan->totalterima();
                $data['dayatampung'] = $this->laporan->totaldayatampung()->dayatampung;
            } elseif ($_POST['pilihprodi']=='x') {
                $data['sisakuota'] = '';
                $data['dayatampung'] = '';
            } else {
                $dayatampung = $this->prodi->get_by_prodiname($prodiname)->dayatampung;
                $sisakuota = $this->penerimaan->count_filter_prodi($prodiname);
                $data['dayatampung'] = $dayatampung;
                $data['sisakuota'] = $dayatampung-$sisakuota;
            }
        } else {
            $data['sisakuota'] = '';
            $data['dayatampung'] = '';
        } 
        
        echo json_encode($data);
    }
 
    
}