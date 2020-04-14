<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends MY_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->library("Pdf");
        $this->load->model('Laporan_model','laporan');
        $this->load->model('Pengaturan_model','pengaturan');
        $this->load->model('Prodi_model','prodi');
    }

    public function laporanexcel()
	{
        $tahunakademik = $this->pengaturan->gettahunakademik()->nilai;
        $tahun = substr($tahunakademik,0,4);
        $title = 'PESERTA LULUS SELEKSI JALUR SESAMA UNIPA TAHUN '.$tahun;
		$data = array(
            'list' => $this->laporan->get_printall(),
            'tahunakademik' => $this->pengaturan->gettahunakademik()->nilai,
            'title' => $title,
            'tahun' => $tahun,
        );
		$this->load->view('laporan/laporanexcel',$data);
		
    }
    
    public function pdfsk()
    {
        $tahunakademik = $this->pengaturan->gettahunakademik()->nilai;
        $tahun = substr($tahunakademik,0,4);
        $data =array(
            'fakultas' => $this->laporan->fakultas_array(),
            'lampiransk' => $this->pengaturan->getlampiransk()->nilai,
            'nomorsk' => $this->pengaturan->getnomorsk()->nilai,
            'tentangsk' => $this->pengaturan->gettentangsk()->nilai,
        );
		$this->load->view('laporan/skpdf', $data);
    }

    public function pdfcetak()
    { 
        $tahunakademik = $this->pengaturan->gettahunakademik()->nilai;
        $tahun = substr($tahunakademik,0,4);
        $data =array(
            'prodi' => $this->laporan->prodi_array(),
            'tentangsk' => $this->pengaturan->gettentangsk()->nilai,
        );
		$this->load->view('laporan/cetakpdf', $data);
    }

    public function rekapitulasi()
    {
        $tahunakademik = $this->pengaturan->gettahunakademik()->nilai;
        $tahun = substr($tahunakademik,0,4);
        $data =array(
            'prodi' => $this->prodi->get_prodi(),
            'view' => 'laporan/rekapitulasi',
            'tahun' => $tahun,
        );
        $this->load->view('layout',$data);
        //echo json_encode($data);
    }

    public function rekapexcel()
    {
        $tahunakademik = $this->pengaturan->gettahunakademik()->nilai;
        $tahun = substr($tahunakademik,0,4);
        $totalkosong = ((int)$this->laporan->totaldayatampung()->dayatampung)-((int)$this->laporan->totalterima());
        $dayatampung = (int)$this->laporan->totaldayatampung()->dayatampung;
        $persenkosong = round((($totalkosong/$dayatampung)*100),2);
        $data =array(
            'prodi' => $this->prodi->get_prodi(),
            'list'=> $this->laporan->getrekapexcel(),
            'title' => 'Rekapitulasi Penerimaan Seleksi Jalur Lokal Universitas Papua 2018',
            'totalpeminat'=> $this->laporan->totalpeminat(), 
            'totaldayatampung'=> $dayatampung,
            'totalterima'=>$this->laporan->totalterima(),
            'totalkosong'=>$totalkosong,
            'persenkosong'=>$persenkosong,
            'tahun' => $tahun,
        );
        $this->load->view('laporan/rekapexcel',$data);
        //echo json_encode($data);
    }

    public function rekapitulasi_list()
    {
        $list = $this->laporan->get_datatables_rekap();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $result) {
            $persenkosong = $result->persenkosong*100;
            $persen = " %";
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $result->namaprodi;
            $row[] = $result->peminat;
            $row[] = $result->dayatampung;
            $row[] = $result->terima;
            $row[] = $result->kosong;
            $row[] = $persenkosong.$persen;
 
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->prodi->count_all(),
                        "recordsFiltered" => $this->laporan->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }

    public function gettotal()
    {
        $totalkosong = ((int)$this->laporan->totaldayatampung()->dayatampung)-((int)$this->laporan->totalterima());
        $dayatampung = (int)$this->laporan->totaldayatampung()->dayatampung;
        $persenkosong = round((($totalkosong/$dayatampung)*100),2);
        $data = array(
            'totalpeminat'=> $this->laporan->totalpeminat(), 
            'totaldayatampung'=> $dayatampung,
            'totalterima'=>$this->laporan->totalterima(),
            'totalkosong'=>$totalkosong,
            'persenkosong'=>$persenkosong,
        );
        echo json_encode($data);
    }
	
}
