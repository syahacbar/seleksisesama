<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Grafik_model extends CI_Model {
    function __construct()
    {
        parent::__construct();
        $this->load->model('Pengaturan_model','pengaturan');
    }

    public function get_penerimaan()
    {
         
        $this->db->select('*');
        $this->db->from('v_rekapx');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_jumlah_suku()
    {
        $query = $this->db->get('v_jumlahsuku');
        return $query->result();
    }

    public function get_jumlah_tahunlulus()
    {
        $query = $this->db->get('v_jumlahtahunlulus');
        return $query->result();
    }

    public function get_jumlah_jenjangslta()
    {
        $query = $this->db->get('v_jumlahjenjangslta');
        return $query->result();
    }

    public function get_jumlah_jurusanslta()
    {
        $query = $this->db->get('v_jumlahjurusanslta');
        return $query->result();
    }
}