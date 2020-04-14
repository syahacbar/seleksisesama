<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Grafik extends MY_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->library("Pdf");
        $this->load->model('Laporan_model','laporan');
        $this->load->model('Pengaturan_model','pengaturan');
        $this->load->model('Prodi_model','prodi');
        $this->load->model('User_model','user');
        $this->load->model('Pendaftar_model','pendaftar');
        $this->load->model('Grafik_model','grafik');
    }

	public function index()
	{
        
        $totalkosong = ((int)$this->laporan->totaldayatampung()->dayatampung)-((int)$this->laporan->totalterima());
		$totalterima = (int)$this->laporan->totalterima();
		$kuotapenerimaan = $this->laporan->totaldayatampung();
		$totalpendaftar = $this->pendaftar->count_all($this->pengaturan->gettahunakademik()->nilai);
		$list = $this->grafik->get_penerimaan();
		$jumlahsuku = $this->grafik->get_jumlah_suku();
		$jumlahtahunlulus = $this->grafik->get_jumlah_tahunlulus();
		$jumlahjenjangslta = $this->grafik->get_jumlah_jenjangslta();
		$jumlahjurusanslta = $this->grafik->get_jumlah_jurusanslta();
		
		$data = array(
			'view' => 'grafik/g_rekap',
			'totalkosong' => $totalkosong,
			'totalterima' => $totalterima,
			'kuotapenerimaan' => $kuotapenerimaan->dayatampung,
			'totalpendaftar' => $totalpendaftar,
			'list' => $list,
			'jumlahsuku' => $jumlahsuku,
			'jumlahtahunlulus' => $jumlahtahunlulus,
			'jumlahjenjangslta' => $jumlahjenjangslta,
			'jumlahjurusanslta' => $jumlahjurusanslta,
		);
        
        $this->load->view('layout',$data);
    }

}