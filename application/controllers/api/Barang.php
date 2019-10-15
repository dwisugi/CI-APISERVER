<?php

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

require APPPATH . 'libraries/Format.php';

class Barang extends REST_Controller{
    function __construct() { //$config = 'rest'
        parent::__construct(); //$config
        $this->load->library(['form_validation']);
        // $this->methods['index_get']['limit'] = 50;
    }

    public function index_get()
    {
        $id = $this->get('id');
        if($id === null){
            $mahasiswa = $this->db->get('mahasiswa')->result();
        }else{
             $this->db->where('id', $id);
             $mahasiswa = $this->db->get('mahasiswa')->result_array();
        }
        if($mahasiswa){
            $this->response([
                'status' => true,
                'data' => $mahasiswa
            ], REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'status' => false,
                'data' => 'Data tidak ditemukan'
            ], REST_Controller::HTTP_NOT_FOUND); 
        }
    }

    public function index_delete()
    {
        $id = $this->delete('id');
        if($id === null){
            $this->response([
                'status' => false,
                'message' => 'Tolong masukkan id'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }else{
            $this->db->where('id', $id);
            $this->db->delete('mahasiswa');
            $delete = $this->db->affected_rows();

            // $this->db->where('id', $id);
            //  $barang = $this->db->get('barang')->result();
            if($delete > 0){ //if($this->mahasiswa->deleteMahasiswa($id) > 0)
                $this->response([
                    'status' => true,
                    'id' => $id,
                    'message' => 'deleted'
                ], REST_Controller::HTTP_OK);
            }else{
                $this->response([
                    'status' => false,
                    'message' => 'Id not found'
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }

    public function index_post()
    {
        // $this->_validate();
        // $this->load->library('form_validation');
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('nrp', 'NRP', 'required|numeric');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');

        if ($this->form_validation->run() == false) {
            $this->response([
                'status' => false,
                'pesan' => validation_errors(),
                'message' => 'No data added'
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $id = $this->db->insert_id();
            $data = [
                        'id'              => $id,
                        'nama'     => $this->post('nama'),
                        'nrp'    => $this->post('nrp'),
                        'email'   => $this->post('email'),
                        'jurusan'   => $this->post('jurusan')
                            ];
            $this->db->insert('mahasiswa', $data);
            $add = $this->db->affected_rows();
            if($add > 0){
                $this->response([
                    'status' => true,
                    'message' => 'New data barang added'
                ], REST_Controller::HTTP_CREATED);
            }else{
                $this->response([
                    'status' => false,
                    'message' => 'No data added'
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }


    }

    public function index_put()
    {
        $id = $this->put('id');
        $data = [
            'id'              => $id,
            'nama'     => $this->put('nama'),
            'nrp'    => $this->put('nrp'),
            'email'   => $this->put('email'),
            'jurusan'   => $this->put('jurusan')
        ];
        $this->db->where('id', $id);
        $this->db->update('mahasiswa', $data);
        $update = $this->db->affected_rows();
        if($update > 0){
            $this->response([
                'status' => true,
                'message' => 'Data barang updated'
            ], REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'status' => true,
                'message' => 'No data updated'
            ], REST_Controller::HTTP_OK);
        }
    }

    private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
        $data['status'] = TRUE;

        
        var_dump($data['error_string']);
		if($this->post('nm_brg') == '')
		{
			$data['error_string'][] = 'Nama Barang Perlu Diisi';
			$data['status'] = FALSE;
		}

		if($this->post('jns_brg') == '')
		{
			$data['error_string'][] = 'Jenis Barang Perlu Diisi';
			$data['status'] = FALSE;
		}

		if($this->post('jml_brg') == '')
		{
			$data['error_string'][] = 'Jumlah Barang Perlu Diisi';
			$data['status'] = FALSE;
        }
        

		if($data['status'] === FALSE)
		{
            $this->response([
                'status' => false,
                'pesan' => $data['error_string'][0]
            ], REST_Controller::HTTP_BAD_REQUEST);
			exit();
        }
	}
}
        // ////////////////////////////////////////////////////////////////////////
        // $this->form_validation->set_rules('nm_brg','Nama Barang','required');
		// $this->form_validation->set_rules('jns_brg','Jenis Barang','required');
		// $this->form_validation->set_rules('jml_brg','Jumlah Barang','required');
        // $data12 = validation_errors();
        // // $data = array();
        // // $this->form_validation->set_data($data);

		// if($this->form_validation->run() === false){
		//      $this->response([
        //          'status' => false,
        //          'message' => $data12
        //      ], REST_Controller::HTTP_BAD_REQUEST);
        //      exit();
        //     }