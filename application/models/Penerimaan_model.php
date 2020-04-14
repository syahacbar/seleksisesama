<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Penerimaan_model extends CI_Model {
    var $table = 'v_penerimaanx';
    var $column_order = array('','nopendaftar','namapendaftar','namaprodi','jenjang','namafakultas','tahunlulus'); //set column field database for datatable orderable
    var $column_search = array('nopendaftar','namapendaftar','namaprodi','namafakultas'); //set column field database for datatable searchable just firstname , lastname , address are searchable
    var $order = array('nopendaftar' => 'asc'); // default order 
    
    function __construct()
    {
        parent::__construct();
    }

    private function _get_datatables_query()
    {
         
        $this->db->select('*');
        $this->db->from($this->table);
 
        if(isset($_POST['is_prodi']) && $_POST['is_prodi'] != "0") 
        {
            $this->db->group_start();
            $this->db->where('namaprodi',$_POST['is_prodi']);
            $this->db->group_end(); 
        }
        
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

    function count_filter_prodi($prodi)
    {
        $this->db->from($this->table);
        $this->db->where('namaprodi', $prodi);
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    public function update($data,$where)
    {
        $this->db->update('pendaftar', $data, $where);
        return $this->db->affected_rows();
    }

    public function delete($id)
    {
        $this->db->where('nopendaftar', $id);
        $this->db->delete('penerimaan');
    }

    public function deleteall()
    {
        $query = $this->db->query('DELETE FROM penerimaan');
        return $query;
    }

    
}