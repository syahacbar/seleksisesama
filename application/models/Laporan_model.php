<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Laporan_model extends CI_Model {
    var $column_order = array('','namaprodi','peminat','dayatampung','terima','kosong','persenkosong'); //set column field database for datatable orderable
    var $column_search = array('namaprodi'); //set column field database for datatable searchable just firstname , lastname , address are searchable
    var $order = array('idprodi' => 'asc'); // default order 

    function __construct()
    {
        parent::__construct();
        $this->load->model('Pengaturan_model','pengaturan');
    }

    function get_printall()
    {
        $this->db->select('*');
        $this->db->from('v_penerimaanx');
        $query = $this->db->get();
        return $query->result();
    }

    function skpdf($prodi)
    {
        $this->db->select('*');
        $this->db->from('v_penerimaanx');
        $this->db->where('namaprodi', $prodi);
        $query = $this->db->get();
        return $query->result();
    }

    function cetakpdf($prodi)
    {
        $this->db->select('*');
        $this->db->from('v_penerimaanx');
        $this->db->where('namaprodi', $prodi);
        $query = $this->db->get();
        return $query->result();
    }

    function prodi_array($idfakultas=NULL) 
    {
        $this->db->distinct();
        $this->db->select('namaprodi,namafakultas,jenjang');
        if($idfakultas!=NULL){
            $this->db->where('idfakultas',$idfakultas);
        }
        $this->db->from('v_penerimaanx');
        $this->db->order_by("namafakultas", "asc");
        $query = $this->db->get();
        return $query->result();
    }

    function fakultas_array() 
    {
        $this->db->distinct();
        $this->db->select('namafakultas,idfakultas');
        $this->db->from('v_penerimaanx');
        $this->db->order_by("namafakultas", "asc");
        $query = $this->db->get();
        return $query->result();
    }

    public function dd_prodi()
    { 
        $this->db->distinct();
        $this->db->select('namaprodi,namafakultas');
        $this->db->from('v_penerimaanx');
        $dd['x'] = '--PILIH SALAH SATU--';
        if($this->ion_auth->is_admin()){
            $dd['0'] = 'SEMUA PROGRAM STUDI';
        } 
        else {
            $this->db->where('idfakultas',$this->ion_auth->get_fakultas()->idfakultas);
        }
        $this->db->order_by("namafakultas", "asc");
            $result = $this->db->get();
            if ($result->num_rows() > 0) {
                foreach ($result->result() as $row) {
                    $dd[strtoupper($row->namaprodi)] = strtoupper($row->namaprodi);
                }
            }
        
		return $dd;
    }

    private function _get_datatables_query()
    {
         
        $this->db->select('*');
        $this->db->from('v_rekapx');
 
        $i = 0;
     
        foreach ($this->column_search as $item) // loop column 
        {
            if($_POST['search']['value']) // if datatable send POST for search
            {
                 
                if($i===0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
 
                if(count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
          
        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
 
    function get_datatables_rekap()
    {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all()
    {
        $this->db->from('prodi');
        return $this->db->count_all_results();
    }

    public function totalpeminat()
    {
        $this->db->where('tahunakademik',$this->pengaturan->gettahunakademik()->nilai);
        $this->db->from('pendaftar');
        return $this->db->count_all_results();
    }

    public function totaldayatampung()
    {
        $this->db->select_sum('dayatampung');
        return $this->db->get('prodi')->row();
    }

    public function totalterima()
    {
        $this->db->from('v_penerimaanx');
        return $this->db->count_all_results();
    }

    
    public function getrekapexcel()
    {
        $this->db->select('*');
        $this->db->from('v_rekapx');
        $query = $this->db->get();
        return $query->result();
    }
}
 