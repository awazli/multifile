<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class USer extends CI_Controller
{

    public function index()
    {
        $this->db->select("country.name as country,state.name as state,city.name as city,users.*");
        $this->db->from("users");
        $this->db->join("country", "users.country_id = country.id", 'left');
        $this->db->join("state", "users.state_id = state.id", 'left');
        $this->db->join("city", "users.city_id = city.id", 'left');
        $this->data['user'] = $this->db->get()->result();
        $this->load->view('list', $this->data);
    }

    public function add()
    {
        $this->data['country'] = $this->db->get("country")->result();
        $this->load->view('add', $this->data);
    }

    public function getCityState()
    {
        $id = $this->input->post('id');
        $table = $this->input->post('table');
        if ($table == "state") {
            $param = "country_id";
        } else if ($table == "city") {
            $param = "state_id";
        }
        $data = $this->db->get_where($table, array($param => $id))->result();
        $html = '<select class="form-control" name="state_id" id="state_id">
                    <option value="">Select ' . $table . '</option>';

        foreach ($data as $row) {
            $html .= '<option value="' . $row->id . '">' . $row->name . '</option>';

        }
        $html .= "</select>";
        echo $html;

    }

    public function save()
    {
        $dataArray = $this->input->post();
        $dataArray['password'] = md5($this->input->post('password'));
        $dataArray['created_at'] = date('Y-m-d H:i:s');
        $dataArray['birthdate'] = date('Y-m-d',strtotime($this->input->post('birthdate')));
        $this->db->insert("users", $dataArray);
        $id = $this->db->insert_id();
        $dataArray=array();

        if (!empty($_FILES['profile']['name'])) {
            $data = $this->do_upload();
            
            if(count($data)>0){
                for($i=0;$i<count($data);$i++){
                    $image = "";
                    $dataArray[]=array(
                        'user_id'=>$id,
                        'file_name'=>$data[$i]
                    );
                }
                $this->db->insert_batch('user_files',$dataArray);
            }

        }
        redirect("user");
    }

    public function do_upload()
    {
        $count = count($_FILES['profile']['name']);

        for ($i = 0; $i < $count - 1; $i++) {
            $_FILES['userfile']['name'] = $_FILES['profile']['name'][$i];
            $_FILES['userfile']['type'] = $_FILES['profile']['type'][$i];
            $_FILES['userfile']['tmp_name'] = $_FILES['profile']['tmp_name'][$i];
            $_FILES['userfile']['error'] = $_FILES['profile']['error'][$i];
            $_FILES['userfile']['size'] = $_FILES['profile']['size'][$i];

            $config['upload_path'] = "./uploads/";
            $config['allowed_types'] = "jpg|png|gif";
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('userfile')) {
                return "error";
                }
            else{
                $file = $this->upload->data();
                $data[] = $file['file_name'];
            }
        }
        return $data;
    }

    public function edit($id)
    {
        $this->data['data'] = $this->db->get_where("users", array('id' => $id))->row();
        $this->data['country'] = $this->db->get("country")->result();
        $this->data['state'] = $this->db->get_where("state", array('country_id' => $this->data['data']->country_id))->result();
        $this->data['city'] = $this->db->get_where("city", array('state_id' => $this->data['data']->state_id))->result();
        $this->load->view('edit', $this->data);
    }

    public function update($id)
    {
        $dataArray = $this->input->post();
        $dataArray['birthdate'] = date('Y-m-d', strtotime($this->input->post('birthdate')));
        $this->db->update("users", $dataArray, array('id' => $id));
        if (!empty($_FILES['profile']['name'])) {
            $data = $this->do_upload();

            if(count($data)>0){
                for($i=0;$i<count($data);$i++){
                    $image = "";
                    $dataArray[]=array(
                        'user_id'=>$id,
                        'file_name'=>$data[$i]
                    );
                }
                $this->db->insert_batch('user_files',$dataArray);
            }
        }
        redirect("user");
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete("users");
        redirect("user");
    }
}