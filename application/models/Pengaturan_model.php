<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Pengaturan_model extends CI_Model {
   
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
    public function dd_tahunakademik()
    {
        $this->db->distinct();
        $this->db->select('tahunakademik');
        $this->db->order_by('tahunakademik', 'DESC');
        $result = $this->db->get('pendaftar');
			
		if ($result->num_rows() > 0) {
			foreach ($result->result() as $row) {
				$dd[strtoupper($row->tahunakademik)] = strtoupper($row->tahunakademik);
			}
		}
		return $dd;
    } 

    public function dd_sesipilihan()
    {
        $dd  = array('0' => 'Semua Prodi', '1' => 'Prodi Pilihan 1','2' => 'Prodi Pilihan 2','3' => 'Prodi Pilihan 3');        
		return $dd;
    }

    public function dd_statususer()
    {
        $dd  = array('1' => 'Aktifkan Semua User', '0' => 'Non Aktifkan Semua User');        
		return $dd;
    }

    public function getsesipilihan()
    {
        $this->db->select('nilai');
        $this->db->where('parameter', 'sesipilihan');
        $query = $this->db->get('pengaturan');
        return $query->row();
    }

    public function gettahunakademik()
    {
        $this->db->select('nilai');
        $this->db->where('parameter', 'tahunakademik'); 
        $query = $this->db->get('pengaturan');
        return $query->row();
    }

    public function getnamarektor()
    {
        $this->db->select('nilai');
        $this->db->where('parameter', 'namarektor');
        $query = $this->db->get('pengaturan');
        return $query->row();
    }

    public function getniprektor()
    {
        $this->db->select('nilai');
        $this->db->where('parameter', 'niprektor');
        $query = $this->db->get('pengaturan');
        return $query->row();
    }

    public function updatepengaturan($data,$where)
    {
        $this->db->update('pengaturan', $data, $where);
        return $this->db->affected_rows();
    }

    public function getstatususer()
    {
        $this->db->select('nilai');
        $this->db->where('parameter', 'statususer');
        $query = $this->db->get('pengaturan');
        return $query->row();
    }  

    public function getlampiransk()
    {
        $this->db->select('nilai');
        $this->db->where('parameter', 'lampiransk');
        $query = $this->db->get('pengaturan');
        return $query->row();
    }

    public function getnomorsk()
    {
        $this->db->select('nilai');
        $this->db->where('parameter', 'nomorsk');
        $query = $this->db->get('pengaturan');
        return $query->row();
    }

    public function gettentangsk()
    {
        $this->db->select('nilai');
        $this->db->where('parameter', 'tentangsk');
        $query = $this->db->get('pengaturan');
        return $query->row();
    }

}