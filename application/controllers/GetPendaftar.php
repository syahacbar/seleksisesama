<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class GetPendaftar extends MY_Controller {
 
    var $API ="";
    
    function __construct() {
        parent::__construct();
        $this->API="http://localhost/restapi";
        $this->load->library('curl');
        $this->load->model('Pendaftar_model','pendaftar');
    }
    
    // menampilkan data pendaftar
    function index() {
        $datapendaftar = json_decode($this->curl->simple_get($this->API.'/pendaftar'));
        echo "<b>".strtoupper("Inject data pendaftar dari Sistem PMB Sesama")."</b><br><br>";
        foreach ($datapendaftar AS $pendaftar) 
        {
            $data = array(
                'nopendaftar' => $pendaftar->username,
                'namapendaftar' => strtoupper($pendaftar->namalengkap),
                'tempatlahir' => strtoupper($pendaftar->lokasi_tempatlahir),
                'tanggallahir' => $pendaftar->tgl_lahir,
                'jeniskelamin' => strtoupper($pendaftar->jeniskelamin),
                'suku' => strtoupper($pendaftar->suku),
                'pilihan1' => strtoupper($pendaftar->pilihan1),
                'pilihan2' => strtoupper($pendaftar->pilihan2),
                'pilihan3' => strtoupper($pendaftar->pilihan3),
                'jenjangslta' => strtoupper($pendaftar->jenissmta),
                'jurusanslta' => strtoupper($pendaftar->jurusansmta),
                'tahunlulus' => $pendaftar->tahunlulus_smta,
                'asalslta' => strtoupper($pendaftar->namasmta),
                'nsem3' => $pendaftar->nrapor1,
                'nsem4' => $pendaftar->nrapor2,
                'nsem5' => $pendaftar->nrapor3,
                'status' => 'B',
                'tahunakademik' => $pendaftar->tahunakademik,
            );

            //cek apakah data sdh ada atau blm
            $cek = $this->db->query("SELECT * FROM pendaftar WHERE nopendaftar = $pendaftar->username")->num_rows();
            if ($cek >= 1)
            {
                echo $pendaftar->username." - ".strtoupper($pendaftar->namalengkap)." ............... <b>Failed! Data already exists.</b><br>";
            }
            else
            {
                if($pendaftar->tahunlulus_smta == NULL)
                {
                    echo $pendaftar->username." - ".strtoupper($pendaftar->namalengkap)." ............... <b><font color='red'>Failed! Tahun lulus cannot be Null</font></b><br>";
                }
                else
                {
                    $insert = $this->pendaftar->save($data);
                    echo $pendaftar->username." - ".strtoupper($pendaftar->namalengkap)." ............... <b>Success! New record added</b><br>";
                }
            }
            
        }
        // $data['datapendaftar'] = $datapendaftar;
        // $data['view'] = 'pendaftar/getPendaftar';
        // $this->load->view('layout',$data);
    }
}