<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Pendaftar extends MY_Controller {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Pendaftar_model','pendaftar');
        $this->load->model('Prodi_model','prodi');
        $this->load->model('Seleksimanual_model','seleksimanual');
        $this->load->model('Pengaturan_model','pengaturan'); 
    }
 
    public function index()
    {
        $this->ion_auth->is_admin() ? $dd_prodi = $this->seleksimanual->dd_prodi() : $dd_prodi = $this->seleksimanual->dd_prodi();
        $data = array(
            'view' => 'pendaftar/pendaftar_view',
            'dd_prodi' => $this->prodi->dd_prodi(),
            'dd_prodix' => $dd_prodi,
            'prodi_selected' => $this->input->post('pilihprodi') ? $this->input->post('pilihprodi') : '',
            'p1_selected' => $this->input->post('prodi1') ? $this->input->post('prodi1') : '',
            'p2_selected' => $this->input->post('prodi2') ? $this->input->post('prodi2') : '',
            'p3_selected' => $this->input->post('prodi3') ? $this->input->post('prodi3') : '',
            'tahunakademik' => $this->pengaturan->gettahunakademik()->nilai,
        );	
        $this->load->view('layout',$data);
    }
 
    public function ajax_list()
    {
        $tahunakademik = $this->pengaturan->gettahunakademik()->nilai;
        $list = $this->pendaftar->get_datatables($tahunakademik);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $result) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $result->nopendaftar;
            $row[] = $result->namapendaftar;
            $row[] = $result->pilihan1;
            $row[] = $result->pilihan2;
            $row[] = $result->pilihan3;
            $row[] = $result->tempatlahir;
            $row[] = $result->tanggallahir;
            $row[] = $result->jeniskelamin;
            $row[] = $result->suku;
            $row[] = $result->jenjangslta;
            $row[] = $result->asalslta;
            $row[] = strtoupper($result->jurusanslta);
            $row[] = $result->tahunlulus;
            //add html for action
            if($this->ion_auth->is_admin()){
            $row[] = '<a class="btn btn-xs btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_record('."'".$result->nopendaftar."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
                      <a class="btn btn-xs btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_record('."'".$result->nopendaftar."'".')"><i class="glyphicon glyphicon-trash"></i> Hapus</a>';
            }
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->pendaftar->count_all($tahunakademik),
                        "recordsFiltered" => $this->pendaftar->count_filtered($tahunakademik),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
 
    public function ajax_edit($id)
    {
        $data = $this->pendaftar->get_by_id($id);
        echo json_encode($data);
    }

    public function ajax_get()
    {
        $thn = date('Y');
        $thnx = date('Y')+1;
        $nopendaftar = $this->pendaftar->get_last_id()->nopendaftar; 
        echo json_encode(array(
                        'nopendaftar' => $nopendaftar+1,
                        'status' => 'B',
                        'tahunakademik' => $thn.'/'.$thnx,
                    )); 
    }
    public function ajax_add()
    {
        if ($this->input->post('namapendaftar') == '') {
            $res['error']['namapendaftar'] = '* Wajib Diisi';
        } 
        if ($this->input->post('tempatlahir') == '') {
            $res['error']['tempatlahir'] = '* Wajib Diisi';
        } 
        if ($this->input->post('tanggallahir') == '') {
            $res['error']['tanggallahir'] = '* Wajib Diisi';
        } 
        if ($this->input->post('jeniskelamin') == '') {
            $res['error']['jeniskelamin'] = '* Wajib Diisi';
        } 
        if ($this->input->post('suku') == '') {
            $res['error']['suku'] = '* Wajib Diisi';
        } 
        if ($this->input->post('pilihan1') == '') {
            $res['error']['pilihan1'] = '* Wajib Diisi';
        } 
        if ($this->input->post('pilihan2') == '') {
            $res['error']['pilihan2'] = '* Wajib Diisi';
        } 
        if ($this->input->post('pilihan3') == '') {
            $res['error']['pilihan3'] = '* Wajib Diisi';
        } 
        if ($this->input->post('jenjangslta') == '') {
            $res['error']['jenjangslta'] = '* Wajib Diisi';
        } 
        if ($this->input->post('jurusanslta') == '') {
            $res['error']['jurusanslta'] = '* Wajib Diisi';
        } 
        if ($this->input->post('asalslta') == '') {
            $res['error']['asalslta'] = '* Wajib Diisi';
        } 
        if ($this->input->post('tahunlulus') == '') {
            $res['error']['tahunlulus'] = '* Wajib Diisi';
        } 
        if ($this->input->post('nsem3') == '') {
            $res['error']['nsem3'] = '* Wajib Diisi';
        } 
        if ($this->input->post('nsem4') == '') {
            $res['error']['nsem4'] = '* Wajib Diisi';
        } 
        if ($this->input->post('nsem5') == '') {
            $res['error']['nsem5'] = '* Wajib Diisi';
        } 
            
        if (empty($res['error'])) {

            $res['hasil'] = 'sukses';
            $res['status'] = TRUE;

            $data = array(
                'nopendaftar' => $this->input->post('nopendaftar'),
                'namapendaftar' => strtoupper($this->input->post('namapendaftar')),
                'tempatlahir' => strtoupper($this->input->post('tempatlahir')),
                'tanggallahir' => $this->input->post('tanggallahir'),
                'jeniskelamin' => $this->input->post('jeniskelamin'),
                'suku' => $this->input->post('suku'),
                'pilihan1' => $this->input->post('pilihan1'),
                'pilihan2' => $this->input->post('pilihan2'),
                'pilihan3' => $this->input->post('pilihan3'),
                'jenjangslta' => $this->input->post('jenjangslta'),
                'jurusanslta' => $this->input->post('jurusanslta'),
                'tahunlulus' => $this->input->post('tahunlulus'),
                'asalslta' => strtoupper($this->input->post('asalslta')),
                'nsem3' => $this->input->post('nsem3'),
                'nsem4' => $this->input->post('nsem4'),
                'nsem5' => $this->input->post('nsem5'),
                'status' => $this->input->post('status'),
                'tahunakademik' => $this->input->post('tahunakademik'),
            );
            $insert = $this->pendaftar->save($data);
       
        } else {
            $res['hasil'] = 'gagal';
            $res['status'] = FALSE;
        }
        
        echo json_encode($res);
    }
 
    public function ajax_update()
    { 
        if ($this->input->post('namapendaftar') == '') {
            $res['error']['namapendaftar'] = '* Wajib Diisi';
        } 
        if ($this->input->post('tempatlahir') == '') {
            $res['error']['tempatlahir'] = '* Wajib Diisi';
        } 
        if ($this->input->post('tanggallahir') == '') {
            $res['error']['tanggallahir'] = '* Wajib Diisi';
        } 
        if ($this->input->post('jeniskelamin') == '') {
            $res['error']['jeniskelamin'] = '* Wajib Diisi';
        } 
        if ($this->input->post('suku') == '') {
            $res['error']['suku'] = '* Wajib Diisi';
        } 
        if ($this->input->post('pilihan1') == '') {
            $res['error']['pilihan1'] = '* Wajib Diisi';
        } 
        if ($this->input->post('pilihan2') == '') {
            $res['error']['pilihan2'] = '* Wajib Diisi';
        } 
        if ($this->input->post('pilihan3') == '') {
            $res['error']['pilihan3'] = '* Wajib Diisi';
        } 
        if ($this->input->post('jenjangslta') == '') {
            $res['error']['jenjangslta'] = '* Wajib Diisi';
        } 
        if ($this->input->post('jurusanslta') == '') {
            $res['error']['jurusanslta'] = '* Wajib Diisi';
        } 
        if ($this->input->post('asalslta') == '') {
            $res['error']['asalslta'] = '* Wajib Diisi';
        } 
        if ($this->input->post('tahunlulus') == '') {
            $res['error']['tahunlulus'] = '* Wajib Diisi';
        }  
        if ($this->input->post('nsem3') == '') {
            $res['error']['nsem3'] = '* Wajib Diisi';
        } 
        if ($this->input->post('nsem4') == '') {
            $res['error']['nsem4'] = '* Wajib Diisi';
        } 
        if ($this->input->post('nsem5') == '') {
            $res['error']['nsem5'] = '* Wajib Diisi';
        } 
            
        if (empty($res['error'])) {

            $res['hasil'] = 'sukses';
            $res['status'] = TRUE;
        
            $data = array(
                'nopendaftar' => $this->input->post('nopendaftar'),
                'namapendaftar' => strtoupper($this->input->post('namapendaftar')),
                'tempatlahir' => strtoupper($this->input->post('tempatlahir')),
                'tanggallahir' => $this->input->post('tanggallahir'),
                'jeniskelamin' => $this->input->post('jeniskelamin'),
                'suku' => $this->input->post('suku'),
                'pilihan1' => $this->input->post('pilihan1'),
                'pilihan2' => $this->input->post('pilihan2'),
                'pilihan3' => $this->input->post('pilihan3'),
                'jenjangslta' => $this->input->post('jenjangslta'),
                'jurusanslta' => $this->input->post('jurusanslta'),
                'tahunlulus' => $this->input->post('tahunlulus'),
                'asalslta' => strtoupper($this->input->post('asalslta')),
                'nsem3' => $this->input->post('nsem3'),
                'nsem4' => $this->input->post('nsem4'),
                'nsem5' => $this->input->post('nsem5'),
                'status' => $this->input->post('status'),
                'tahunakademik' => $this->input->post('tahunakademik'),
            );
            $this->pendaftar->update(array('nopendaftar' => $this->input->post('nopendaftar')), $data);
       
        } else {
            $res['hasil'] = 'gagal';
            $res['status'] = FALSE;
        }
        
        echo json_encode($res);
    }
 
    public function ajax_delete($id)
    {
        $this->pendaftar->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }

    public function jenjangslta()
    {
        $this->db->distinct();
        $this->db->select('jenjangslta');
        $query = $this->db->get('pendaftar')->result();
        echo json_encode($query);
    }

    public function jurusanslta()
    {
        $this->db->distinct();
        $this->db->select('jurusanslta');
        $query = $this->db->get('pendaftar')->result();
        echo json_encode($query);
    }

    public function asalslta()
    {
        $this->db->distinct();
        $this->db->select('asalslta');
        $query = $this->db->get('pendaftar')->result();
        echo json_encode($query);
    }


    public function importexcel()
    {
		$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));

        $fileName = time().$_FILES["datafile"]["name"];
         
        $config['upload_path'] = './assets/'; //buat folder dengan nama assets di root folder
        $config['file_name'] = $fileName;
        $config['allowed_types'] = 'xls|xlsx|csv';
        //$config['max_size'] = 10000;
         
        $this->load->library('upload');
        $this->upload->initialize($config);
         
        if(! $this->upload->do_upload('datafile') )
        $this->upload->display_errors();
             
        $media = $this->upload->data('');
        $inputFileName = 'assets/'.$media['file_name'];
         
        try {
                $inputFileType = IOFactory::identify($inputFileName);
                $objReader = IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
            } catch(Exception $e) {
                die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
            }
 
            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            $maxCell = $sheet->getHighestRowAndColumn();
             
            for ($row = 2; $row <= $highestRow; $row++){                  //  Read a row of data into an array                 
                $rowData = $sheet->rangeToArray('A' . $row . ':' .$maxCell['column'] . $maxCell['row'],
                                                NULL,
                                                TRUE,
												FALSE);
                
              

                 $data = array(
                    "nopendaftar"=> $rowData[0][0],
                    "namapendaftar"=> strtoupper($rowData[0][1]),
                    "tempatlahir"=> strtoupper($rowData[0][2]),
                    "tanggallahir"=> date("d-m-Y",($rowData[0][3]-25569) * 86400),
                    "jeniskelamin"=> strtoupper($rowData[0][4]),
                    "suku"=> $this->pendaftar->trimed(strtoupper($rowData[0][5])),
                    "pilihan1"=> strtoupper($rowData[0][6]),
                    "pilihan2"=> strtoupper($rowData[0][7]),
                    "pilihan3"=> strtoupper($rowData[0][8]),
                    "jenjangslta"=> strtoupper($rowData[0][9]),
                    "jurusanslta"=> strtoupper($rowData[0][10]),
                    "tahunlulus"=> $rowData[0][11],
                    "asalslta"=> strtoupper($rowData[0][12]),
                    "nsem3"=> $rowData[0][13],
                    "nsem4"=> $rowData[0][14],
                    "nsem5"=> $rowData[0][15],
                    "status"=> "B",
                    "tahunakademik"=> $rowData[0][16]
                );
                 
                //sesuaikan nama dengan nama tabel
                if($rowData[0][0]==NULL) {
                    $rowData[0][0]==0;
                } else {
                    $insert = $this->db->insert("pendaftar",$data);       
                }
            }
            echo json_encode(array('status'=>TRUE));
    }
 
}