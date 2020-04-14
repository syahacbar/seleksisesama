<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Pendaftar_model extends CI_Model {
    var $idtable = 'nopendaftar';
    var $table = 'pendaftar';
    var $column_order = array('','nopendaftar','namapendaftar','pilihan1','pilihan2','pilihan3','tempatlahir','tanggallahir','jeniskelamin','suku','jenjangslta','asalslta','jurusanslta','tahunlulus'); //set column field database for datatable orderable
    var $column_search = array('nopendaftar','namapendaftar','tempatlahir','tanggallahir','jeniskelamin','suku','jenjangslta','jurusanslta','tahunlulus','asalslta'); //set column field database for datatable searchable just firstname , lastname , address are searchable
    var $order = array('nopendaftar' => 'asc'); // default order 
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
    private function _get_datatables_query($tahunakademik)
    {
         
        $this->db->select('*');
        $this->db->from($this->table); 
        $this->db->group_start();
        $this->db->where('tahunakademik',$tahunakademik);
 
        if(isset($_POST['is_prodi']) && $_POST['is_prodi'] != "0") 
        {
            $this->db->group_start();
            $this->db->where('pilihan1',$_POST['is_prodi']);
            $this->db->or_where('pilihan2',$_POST['is_prodi']);
            $this->db->or_where('pilihan3',$_POST['is_prodi']);
            $this->db->group_end(); 
        }
        
        $this->db->group_end();
        
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
 
    function get_datatables($ta)
    {
        $this->_get_datatables_query($ta);
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filtered($ta)
    {
        $this->_get_datatables_query($ta);
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all($ta)
    {
        $this->db->where('tahunakademik',$ta);
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
 
    public function get_by_id($id)
    {
        $this->db->select('*');
        $this->db->from('v_pendaftar');
        $this->db->where($this->idtable,$id);
        $query = $this->db->get();
 
        return $query->row();
    }
 
    public function save($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
 
    public function update($where, $data) 
    {
        $this->db->update($this->table, $data, $where);
        return $this->db->affected_rows();
    }
 
    public function delete_by_id($id)
    {
        $this->db->where($this->idtable, $id);
        $this->db->delete($this->table);
    }

    public function dd_prodi()
    {
		$this->db->order_by('namaprodi', 'asc');
		$result = $this->db->get($this->table);
			
		$dd[''] = '--PILIH SALAH SATU--';
		if ($result->num_rows() > 0) {
			foreach ($result->result() as $row) {
				$dd[strtoupper($row->namaprodi)] = strtoupper($row->namaprodi);
			}
		}
		return $dd;
    }

    public function get_last_id(){
        $last_row=$this->db->select('nopendaftar')->order_by('nopendaftar',"desc")->limit(1)->get($this->table)->row();
        return $last_row;
    }

    public function dd_sekolah()
    {
		$this->db->order_by('namasekolah', 'asc');
		$result = $this->db->get('sekolahslta');
			
		$dd[''] = '--PILIH SALAH SATU--';
		if ($result->num_rows() > 0) {
			foreach ($result->result() as $row) {
				$dd[strtoupper($row->namasekolah)] = strtoupper($row->namasekolah);
			}
		}
		return $dd;
    }

    function trimed($txt){
        $txt = trim($txt);
        while( strpos($txt, '  ') ){
        $txt = str_replace('  ', ' ', $txt);
        }
        return $txt;
    }
 
}