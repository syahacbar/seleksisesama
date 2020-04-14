<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Prodi_model extends CI_Model {
    var $idtable = 'idprodi';
    var $table = 'prodi';
    var $column_order = array('','namaprodi','jenjang','dayatampung','namafakultas'); //set column field database for datatable orderable
    var $column_search = array('namaprodi','dayatampung','namafakultas'); //set column field database for datatable searchable just firstname , lastname , address are searchable
    var $order = array('idprodi' => 'asc'); // default order 
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    } 
 
    private function _get_datatables_query()
    {
         
        $this->db->select('prodi.idprodi,prodi.namaprodi,prodi.jenjang,prodi.dayatampung,fakultas.idfakultas, fakultas.namafakultas');
        $this->db->from($this->table);
        $this->db->join('fakultas','fakultas.idfakultas=prodi.idfakultas');
 
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
 
    function get_datatables()
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
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
 
    public function get_by_id($id)
    {
        $this->db->select('prodi.idprodi,prodi.namaprodi,prodi.jenjang,prodi.dayatampung,fakultas.idfakultas, fakultas.namafakultas');
        $this->db->from($this->table);
        $this->db->join('fakultas','fakultas.idfakultas=prodi.idfakultas');
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
		$result = $this->db->get('prodi');
			
		$dd['0'] = '--PILIH SALAH SATU--';
		if ($result->num_rows() > 0) {
			foreach ($result->result() as $row) {
				$dd[strtoupper($row->namaprodi)] = strtoupper($row->namaprodi);
			}
		}
		return $dd;
    }
    
    public function get_by_prodiname($prodiname)
    {
        $this->db->where('namaprodi',$prodiname);
        $query = $this->db->get('prodi');
 
        return $query->row();
    }

    public function get_prodi()
    {
        $query = $this->db->get('prodi');
 
        return $query->result();
    }

    public function get_fakultasname_by_prodiname($prodiname)
    {
        $this->db->select('prodi.idprodi,prodi.namaprodi,prodi.jenjang,prodi.dayatampung,fakultas.idfakultas, fakultas.namafakultas, fakultas.namadekan');
        $this->db->from($this->table);
        $this->db->join('fakultas','fakultas.idfakultas=prodi.idfakultas');
        $this->db->where('namaprodi',$prodiname);
        $query = $this->db->get();
 
        return $query->row();
    }

   
 
}