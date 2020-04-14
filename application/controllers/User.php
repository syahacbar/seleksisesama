<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class User extends MY_Controller {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model','user');
        $this->load->model('Fakultas_model','fakultas');
        $this->load->model('User_model','usermodel');
    }
 
    public function index()
    {
        $data = array(
            'view' => 'user/user_view',
            'dd_fakultas' => $this->fakultas->dd_fakultas(),
            'fakultas_selected' => $this->input->post('fakultas') ? $this->input->post('fakultas') : '',
        );
        $this->load->view('layout',$data);
    }
 
    public function ajax_list()
    {
        $list = $this->user->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $result) {
            
        $session_id = $this->usermodel->get_session_id($result->username);
        if($session_id != NULL){
            $status = "Online";
            $class = " ";
        } else {
            $status = "Offline";
            $class = " disabled";
        }
            $no++; 
            $row = array();
            $row[] = $no;
            $row[] = $result->username;
            $row[] = $result->email;
            $row[] = unix_to_human($result->last_login);
            $row[] = $result->ip_address;
            $row[] = $result->namafakultas;
            $row[] = $result->active=='1' ? 'Aktif' : 'Non Aktif';
            $row[] = $status;

            //add html for action
            $row[] = '
            <a class="btn btn-xs btn-warning '.$class.'" href="javascript:void(0)" title="Reset" onclick="reset_login('."'".$result->id."'".')"><i class="glyphicon glyphicon-off"></i> Reset</a>
            <a class="btn btn-xs btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_record('."'".$result->id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
            <a class="btn btn-xs btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_record('."'".$result->id."'".')"><i class="glyphicon glyphicon-trash"></i> Hapus</a>';
 
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->user->count_all(),
                        "recordsFiltered" => $this->user->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }

     
    public function ajax_edit($id)
    {
        $data = $this->user->get_user_by_id($id);
        echo json_encode($data);
    }
 
    public function ajax_add()
    {
        if ($this->input->post('first_name') == '') {
            $res['error']['firstname'] = 'Nama Depan tidak boleh kosong';
        }
        if ($this->input->post('last_name') == '') {
            $res['error']['lastname'] = 'Nama Belakang tidak boleh kosong';
        }
        if ($this->input->post('username') == '') {
            $res['error']['username'] = 'Username tidak boleh kosong';
        }
        if ($this->input->post('email') == '') {
            $res['error']['email'] = 'Email tidak boleh kosong';
        }
        if ($this->input->post('password') == '') {
            $res['error']['password'] = 'Password tidak boleh kosong';
        } 
        if ($this->input->post('password_confirm') == '') {
            $res['error']['confirmpassword'] = 'Konfirmasi Password tidak boleh kosong';
        }
        if ($this->input->post('idfakultas') == '') {
            $res['error']['idfakultas'] = 'Fakultas harus dipilih';
        } 
        if ($this->input->post('password') != $this->input->post('password_confirm')) {
            $res['error']['cekpassword'] = 'Konfirmasi Password harus sama dengan Password';
        } 
            
        if (empty($res['error'])) {

            $res['hasil'] = 'sukses';
            $res['status'] = TRUE;
			$email = $this->input->post('email');
			$username = $this->input->post('username');
            $password = $this->input->post('password');
            $last_userid = $this->db->select('id')->order_by('id',"desc")->limit(1)->get('users')->row()->id;
            $last_userid = $last_userid+1; 
            $additional_data = array(
                'id' => $last_userid,
				'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'ip_address' => $this->input->ip_address(),
                'company' => 'UNIPA',
                'phone' => '0',
            );
            
            $this->ion_auth->register($username, $password, $email, $additional_data);

            $dataf = array(
                'fakultas_id' => $this->input->post('idfakultas'),
                'user_id' => $last_userid,
            );
            $insertf = $this->user->saveusershasfakultas($dataf);
            
        } else {
            $res['hasil'] = 'gagal';
            $res['status'] = FALSE;
        }
        echo json_encode($res);
    }
  
    public function ajax_update()
    {
        if ($this->input->post('first_name') == '') {
            $res['error']['firstname'] = 'Nama Depan tidak boleh kosong';
        }
        if ($this->input->post('last_name') == '') {
            $res['error']['lastname'] = 'Nama Belakang tidak boleh kosong';
        }
        if ($this->input->post('username') == '') {
            $res['error']['username'] = 'Username tidak boleh kosong';
        }
        if ($this->input->post('email') == '') {
            $res['error']['email'] = 'Email tidak boleh kosong';
        }
        if ($this->input->post('idfakultas') == '') {
            $res['error']['idfakultas'] = 'Fakultas harus dipilih';
        } 
             
        if (empty($res['error'])) {

            $res['hasil'] = 'sukses';
            $res['status'] = TRUE;
            $user = $this->ion_auth->user($this->input->post('id'))->row();
            $datau = array(
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'username' => $this->input->post('username'),
                'email' => $this->input->post('email'),
            );

            $this->ion_auth->update($user->id, $datau);

            $datauf = array('fakultas_id' => $this->input->post('idfakultas'));
            $this->user->editusershasfakultas(array('user_id' => $this->input->post('id')), $datauf);

        } else {
            $res['hasil'] = 'gagal';
            $res['status'] = FALSE;
        }

        echo json_encode($res);
    }
 
    public function ajax_delete($id)
    {
        $this->user->delete_userfakultas_by_id($id);
        $this->user->delete_user_by_id($id);
        echo json_encode(array("status" => TRUE));
    }

    public function changepassword()
    {
        if ($this->input->post('old') == '') {
            $res['error']['old'] = 'Password lama tidak boleh kosong';
        } 
        if ($this->input->post('new') == '') {
            $res['error']['new'] = 'Password baru tidak boleh kosong';
        } 
        if ($this->input->post('new_confirm') == '') {
            $res['error']['new_confirm'] = 'Konfirmasi Password baru tidak boleh kosong';
        }
        if ($this->input->post('new') != $this->input->post('new_confirm')) {
            $res['error']['cekpass'] = 'Konfirmasi Password harus sama dengan Password';
        } 

        if (empty($res['error'])) {

            $res['hasil'] = 'sukses';
            $res['status'] = TRUE;
            $identity = $this->session->userdata('identity');

            //$this->ion_auth->update($user->id, $data);
            $change = $this->ion_auth->change_password($identity, $this->input->post('old'), $this->input->post('new'));

            if ($change)
			{
				//if the password was successfully changed
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				
			}
			else
			{
				$this->session->set_flashdata('message', $this->ion_auth->errors());
                $res['error']['old'] = 'Password Lama Salah';
                $res['hasil'] = 'gagal';
                $res['status'] = FALSE;
			}

        } else {
            $res['hasil'] = 'gagal';
            $res['status'] = FALSE;
        }

        echo json_encode($res);
    }

    public function reset_login($id)
    {

        $this->usermodel->update_session_id_by_admin(array('session_id'=> NULL),$id);
        echo json_encode(array("status" => TRUE));
    }

    
}