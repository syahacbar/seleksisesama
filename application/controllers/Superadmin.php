<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Superadmin extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
    }


    public function reset_pass_admin($pass)
    {
        $new_pass = $this->ion_auth->hash_password($pass);
        $query = $this->db->query("UPDATE users u SET u.password='$new_pass' WHERE u.username='admin'");


        if ($query)
        {
            $res['hasil'] = 'sukses';
            $res['status'] = TRUE;
            $res['password'] = $pass;
            $res['hash'] = $new_pass;
        }
        else
        {
            $res['hasil'] = 'gagal';
            $res['status'] = FALSE;
        }
        echo json_encode($res);
    }
}
