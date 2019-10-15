<?php

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

require APPPATH . 'libraries/Format.php'; 

class Mahasiswa extends REST_Controller{
    function __construct() { //$config = 'rest'
        parent::__construct(); //$config
        $this->load->model('Mahasiswa_model','mahasiswa');
        $this->load->library(['form_validation']);
        // $this->methods['index_get']['limit'] = 50;
    }

    public function index_get()
    {
        $id = $this->get('id');
        if($id === null){
            $mahasiswa = $this->db->get('mahasiswa')->result();
        }else{
             $mahasiswa = $this->db->get_where('mahasiswa', ['id' => $id])->result_array();
        }
        if($mahasiswa){
            $this->response(['status' => true, 'data' => $mahasiswa], 200);
        }else{
            $this->response(['status' => false,'data' => 'Data tidak ditemukan'], 404); 
        }
    }

    public function index_delete()
    {
        $id = $this->delete('id');
        if($id === null){
            $this->response(['status' => false,'message' => 'Tolong masukkan id'], 400);
        }else{
            $this->db->delete('mahasiswa', ['id' => $id]);
            $delete = $this->db->affected_rows();
            if($delete > 0){
                $this->response(['status' => true, 'id' => $id,'message' => 'deleted'], 200);
            }else{
                $this->response(['status' => false,'message' => 'Id not found'], 400);
            }
        }
    }

    public function index_post()
    {
        if ($this->mahasiswa->validation() == false) {
            $this->response(['status' => false,'pesan' => validation_errors(),'message' => 'No data added'], 400);
        } else {
            $data = [
                        'nama'     => $this->post('nama'),
                        'nrp'    => $this->post('nrp'),
                        'email'   => $this->post('email'),
                        'jurusan'   => $this->post('jurusan')
                            ];
            $this->db->insert('mahasiswa', $data);
            $add = $this->db->affected_rows();
            if($add > 0){
                $this->response(['status' => true,'message' => 'New data barang added' ], 201);
            }else{
                $this->response(['status' => false, 'message' => 'No data added'], 400);
            }
        }
    }

    public function index_put()
    {
        $id = $this->put('id');
        $data = [
            'id' => $id,
            'nama'     => $this->put('nama'),
            'nrp'    => $this->put('nrp'),
            'email'   => $this->put('email'),
            'jurusan'   => $this->put('jurusan')
        ];
        if ($this->mahasiswa->validation($data) == false) {
            $this->response(['status' => false,'pesan' => validation_errors(), 'message' => 'No data updated'], 400);
        } else {
            $this->db->update('mahasiswa', $data, ['id' => $id]);
            $update = $this->db->affected_rows();
            if($update > 0){
                $this->response(['status' => true,'message' => 'Data barang updated'], 200);
            }else{
                $this->response(['status' => true,'message' => 'No data updated'], 200);
            }
        }
    }
}