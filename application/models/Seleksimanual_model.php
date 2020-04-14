<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Seleksimanual_model extends CI_Model {
    var $idtable = 'nopendaftar';
    var $table = 'v_seleksix';
    var $column_order = array('','nopendaftar','namapendaftar','','suku','jurusanslta','nsem3','nsem4','nsem5','ratarata','tahunlulus','status'); //set column field database for datatable orderable
    var $column_search = array('nopendaftar','namapendaftar');
    var $order = array('nopendaftar' => 'asc'); // default order 
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database(); 
        $this->load->model('Pengaturan_model','pengaturan');
    }
 
    private function _get_datatables_query($sesipilihan=NULL,$tahunakademik=NULL)
    {
        $this->db->select('*');
        $this->db->from('v_seleksix');
        $this->db->group_start();
        $this->db->where('tahunakademik',$tahunakademik);
        if(isset($_POST['is_prodi']) && $_POST['is_prodi'] != "0") 
        {
            if(isset($sesipilihan)){
                if($sesipilihan=='1'){
                    $this->db->where('pilihan1',$_POST['is_prodi']);
                } 
                elseif($sesipilihan=='2'){
                    $this->db->where('pilihan2',$_POST['is_prodi']);
                } 
                elseif($sesipilihan=='3'){
                    $this->db->where('pilihan3',$_POST['is_prodi']);
                }
                elseif($sesipilihan=='0'){
                    $this->db->group_start();
                    $this->db->where('pilihan1',$_POST['is_prodi']);
                    $this->db->or_where('pilihan2',$_POST['is_prodi']);
                    $this->db->or_where('pilihan3',$_POST['is_prodi']);
                    $this->db->group_end();
                }
            }
            else { 
                    $this->db->group_start();
                    $this->db->where('pilihan1',$_POST['is_prodi']);
                    $this->db->or_where('pilihan2',$_POST['is_prodi']);
                    $this->db->or_where('pilihan3',$_POST['is_prodi']);
                    $this->db->group_end();
                }
           
        } 

        if(isset($_POST['is_suku']) && $_POST['is_suku'] != '0') 
        {
            $this->db->where('suku',$_POST['is_suku']);
        }
        $this->db->group_end();
        $this->db->where('status','B');
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
 
    function get_datatables($sesi,$ta)
    {
        $this->_get_datatables_query($sesi,$ta);
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filtered($sesi,$ta)
    { 
        $this->_get_datatables_query($sesi,$ta);
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all($ta)
    {
        $this->db->from('v_seleksix');
        $this->db->where('status','B');
        $this->db->where('tahunakademik',$ta);
        return $this->db->count_all_results();
    }
 
    public function get_by_id($id)
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where($this->idtable,$id);
        $query = $this->db->get();
 
        return $query->row();
    }
    
    public function dd_prodi()
    {
        $dd['x'] = '--PILIH SALAH SATU--';
        if($this->ion_auth->is_admin()){
            $dd['0'] = 'SEMUA PROGRAM STUDI';
        } 
        else {
            $this->db->where('idfakultas',$this->ion_auth->get_fakultas()->idfakultas);
        }
            $this->db->order_by('namaprodi', 'asc');
            $result = $this->db->get('prodi');
            if ($result->num_rows() > 0) {
                foreach ($result->result() as $row) {
                    $dd[strtoupper($row->namaprodi)] = strtoupper($row->namaprodi);
                }
            }
        
		return $dd;
    }

    public function dd_suku()
    {
        $dd['0'] = '--SEMUA SUKU--';
        $dd['PAPUA'] = 'PAPUA';
        $dd['NON PAPUA'] = 'NON PAPUA';
        return $dd;
    }
    
    public function save($data)
    {
        $this->db->insert('penerimaan', $data);
        return $this->db->insert_id();
    }

    public function update($data,$where)
    {
        $this->db->update('pendaftar', $data, $where);
        return $this->db->affected_rows();
    }
 
}