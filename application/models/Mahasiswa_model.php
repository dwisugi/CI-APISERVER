<?php

class Mahasiswa_model extends CI_Model
{
    public function getMahasiswa($id = null)
    {
        if($id === null){
            return $this->db->get('barang')->result_array();
        }else{
            return $this->db->get_where('barang',['id' => $id])->result_array();
        } 
    } 

    public function validation($data)
    {
        if(!empty($data)){
            $this->form_validation->set_data($data);
            $this->form_validation->set_rules('id', 'ID', 'required');
            $this->form_validation->set_rules('nama', 'Nama', 'required');
            $this->form_validation->set_rules('nrp', 'NRP', 'required|numeric');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('jurusan', 'Jurusan', 'required');
            return $this->form_validation->run();
        }else{
            $this->form_validation->set_rules('nama', 'Nama', 'required');
            $this->form_validation->set_rules('nrp', 'NRP', 'required|numeric');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('jurusan', 'Jurusan', 'required|valid_email');
            return $this->form_validation->run();
        }

    }

    public function deleteMahasiswa($id)
    {
        $this->db->delete('barang',['id' => $id]);
        return $this->db->affected_rows();
    }

    public function createMahasiswa($data)
    {
        $this->db->insert('barang', $data );
        return $this->db->affected_rows();
    }

    public function updateMahasiswa($data, $id)
    {
        $this->db->update('barang', $data, ['id' => $id] );
        return $this->db->affected_rows();
    }
}