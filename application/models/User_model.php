<?php
class User_model extends CI_Model{
    
    var $column_order = array('','username','email','created_on','last_login'); //set column field database for datatable orderable
    var $column_search = array('username','email'); //set column field database for datatable searchable just firstname , lastname , address are searchable
    var $order = array('u.id' => 'desc'); // default order 

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
    private function _get_datatables_query() 
    {
        $this->db->select('u.*, uf.id AS ufid, f.*') ;
        $this->db->from('users u');
        $this->db->join('users_has_fakultas uf','uf.user_id=u.id');
        $this->db->join('fakultas f','f.idfakultas=uf.fakultas_id');

 
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
        $this->db->from('users');
		$this->db->where_not_in('company', 'ADMIN');
        return $this->db->count_all_results();
    }
	public function add_user($data){
		$this->db->insert('users', $data);
		return true; 
	}
	public function get_all_users(){
		$this->db->where_not_in('company', 'ADMIN');
		$query = $this->db->get('users');
		return $result = $query->result();
	}
	public function get_user_by_id($id){
		//$query = $this->db->get_where('users', array('id' => $id));
        $this->db->select('u.*, uf.id AS ufid, f.*') ;
        $this->db->from('users u');
        $this->db->join('users_has_fakultas uf','uf.user_id=u.id');
        $this->db->join('fakultas f','f.idfakultas=uf.fakultas_id');
		$this->db->where('u.id', $id);
        $query = $this->db->get();
        return $result = $query->row_array();
	}

    public function edit_user($where, $data)
    {
        $this->db->update('users', $data, $where);
        return $this->db->affected_rows();
    }

    public function saveusershasfakultas($data)
    {
        $this->db->insert('users_has_fakultas', $data);
        return $this->db->insert_id();
    } 

    public function editusershasfakultas($where, $data)
    {
        $this->db->update('users_has_fakultas', $data, $where);
        return $this->db->affected_rows();
    }

    public function delete_userfakultas_by_id($id)
    {
        $this->db->where('user_id', $id);
        $this->db->delete('users_has_fakultas');
    }

    public function delete_user_by_id($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('users');
    }

    public function update_session_id($data)
    {
        $this->db->update('users_has_fakultas', $data, array('user_id'=>$this->ion_auth->user()->row()->id));
        return $this->db->affected_rows();
    }

    public function update_session_id_by_admin($data,$userid)
    {
        $this->db->update('users_has_fakultas', $data, array('user_id'=>$userid));
        return $this->db->affected_rows();
    }

    public function get_session_id($username)
    {
        if($username!='admin'){
            $this->db->select('uf.session_id') ;
            $this->db->from('users_has_fakultas uf');
            $this->db->join('users u','uf.user_id=u.id');
            $this->db->where('u.username', $username);
            $query = $this->db->get();
            return $query->row()->session_id;
        }
    }

    public function edit_statususer($where, $data)
    {
        $this->db->update('users', $data, $where);
        return $this->db->affected_rows();
    }

}
?>