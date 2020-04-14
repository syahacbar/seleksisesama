<?php
defined('BASEPATH') OR exit('No direct script access allowed');
  
class Pengaturan extends MY_Controller {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Pengaturan_model','pengaturan');
        $this->load->model('User_model','usermodel');
    }
  
    public function index() 
    {
        $data = array( 
            'view' => 'pengaturan/pengaturan_view',
            'dd_sesipilihan' =>  $this->pengaturan->dd_sesipilihan(),
            'sesipilihan_selected' => $this->input->post('sesipilihan') ? $this->input->post('sesipilihan') : $this->pengaturan->getsesipilihan()->nilai,
            'dd_tahunakademik' =>  $this->pengaturan->dd_tahunakademik(),
            'tahunakademik_selected' => $this->input->post('tahunakademik') ? $this->input->post('tahunakademik') : $this->pengaturan->gettahunakademik()->nilai,
            'dd_statususer' =>  $this->pengaturan->dd_statususer(),
            'statususer_selected' => $this->input->post('statususer') ? $this->input->post('statususer') : $this->pengaturan->getstatususer()->nilai,
            'namarektor' => $this->pengaturan->getnamarektor()->nilai,
            'niprektor' => $this->pengaturan->getniprektor()->nilai,
        );
        $this->load->view('layout',$data);
    }

    public function pengaturan_list() 
    {
        $data = array( 
            'view' => 'pengaturan/pengaturan_view',
            'dd_sesipilihan' =>  $this->pengaturan->dd_sesipilihan(),
            'sesipilihan_selected' => $this->input->post('sesipilihan') ? $this->input->post('sesipilihan') : $this->pengaturan->getsesipilihan()->nilai,
            'dd_tahunakademik' =>  $this->pengaturan->dd_tahunakademik(),
            'tahunakademik_selected' => $this->input->post('tahunakademik') ? $this->input->post('tahunakademik') : $this->pengaturan->gettahunakademik()->nilai,
            'namarektor' => $this->pengaturan->getnamarektor()->nilai,
            'niprektor' => $this->pengaturan->getniprektor()->nilai,
            'lampiransk' => $this->pengaturan->getlampiransk()->nilai,
            'nomorsk' => $this->pengaturan->getnomorsk()->nilai,
            'tentangsk' => $this->pengaturan->gettentangsk()->nilai,
        );
        echo json_encode($data);
    }

    public function simpansesipilihan()
    {
        $data = array(
            'hasil' => 'sukses',
            'status' => TRUE,
        );
        $this->pengaturan->updatepengaturan(array('nilai'=>$_POST['sesipilihan']),array('parameter'=>'sesipilihan'));
        echo json_encode($data);
    }

    public function simpantahunakademik()
    {
        $data = array(
            'hasil' => 'sukses',
            'status' => TRUE,
        );
        $this->pengaturan->updatepengaturan(array('nilai'=>$_POST['tahunakademik']),array('parameter'=>'tahunakademik'));
        echo json_encode($data);
    }

    public function simpannamarektor()
    {
        $data = array(
            'hasil' => 'sukses',
            'status' => TRUE,
        );
        $this->pengaturan->updatepengaturan(array('nilai'=>$_POST['namarektor']),array('parameter'=>'namarektor'));
        echo json_encode($data);
    }

    public function simpanniprektor()
    {
        $data = array(
            'hasil' => 'sukses',
            'status' => TRUE,
        );
        $this->pengaturan->updatepengaturan(array('nilai'=>$_POST['niprektor']),array('parameter'=>'niprektor'));
        echo json_encode($data);
    }

    public function simpanstatususer()
    {
        $data = array(
            'hasil' => 'sukses',
            'status' => TRUE,
        );
        
        $datau = $this->usermodel->get_all_users();
        if($this->input->post('statususer')=='0'){
            foreach ($datau as $iduser)
            {
                $this->ion_auth->deactivate($iduser->id);
            }
        } else {
            foreach ($datau as $iduser)
            {
                $this->ion_auth->activate($iduser->id);
            }
        }

        $this->pengaturan->updatepengaturan(array('nilai'=>$_POST['statususer']),array('parameter'=>'statususer'));
        
        echo json_encode($data);
    }

    public function simpanlampiransk()
    {
        $data = array(
            'hasil' => 'sukses',
            'status' => TRUE,
        );
        $this->pengaturan->updatepengaturan(array('nilai'=>$_POST['lampiransk']),array('parameter'=>'lampiransk'));
        echo json_encode($data);
    }


    public function simpannomorsk()
    {
        $data = array(
            'hasil' => 'sukses',
            'status' => TRUE,
        );
        $this->pengaturan->updatepengaturan(array('nilai'=>$_POST['nomorsk']),array('parameter'=>'nomorsk'));
        echo json_encode($data);
    }

    
    public function simpantentangsk()
    {
        $data = array(
            'hasil' => 'sukses',
            'status' => TRUE,
        );
        $this->pengaturan->updatepengaturan(array('nilai'=>$_POST['tentangsk']),array('parameter'=>'tentangsk'));
        echo json_encode($data);
    }
}
 