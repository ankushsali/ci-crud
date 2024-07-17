<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
	
	public function __construct() {
		parent::__construct();

		$this->load->helper(array('form', 'url'));

		$this->load->library('form_validation');

		$this->load->model('crud_model');
	}

	public function index()
	{
		$users = $this->crud_model->get_entries();
		$data['users'] = $users;

		$this->load->view('welcome_message', $data);
	}

	public function insert() {
		if ($this->input->is_ajax_request()) {
			$this->form_validation->set_rules('name', 'Name', 'required');
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email');

			if ($this->form_validation->run() == FALSE) {
				$data = array('response'=>'error', 'message'=>validation_errors());
			}else{
				$ajax_data = $this->input->post();
				if ($this->crud_model->insert_entry($ajax_data)) {
					$data = array('response'=>'success', 'message'=>'Data added successfully');
				}else{
					$data = array('response'=>'error', 'message'=>'failed');
				}
			}
		}else{
			echo "No direct script access allowed";
		}

		echo json_encode($data);
	}

	public function fetch() {
		if ($this->input->is_ajax_request()) {
			$data = $this->crud_model->get_entries();

			echo json_encode($data);
		}
	}

	public function delete() {
		if ($this->input->is_ajax_request()) {
			$id = $this->input->post('id');

			if ($this->crud_model->delete_entry($id)) {
				$data = array('response'=>'success');
			}else{
				$data = array('response'=>'error');
			}
			
			echo json_encode($data);
		}
	}

	public function edit() {
		if ($this->input->is_ajax_request()) {
			$id = $this->input->post('id');

			if ($user = $this->crud_model->single_entry($id)) {
				$data = array('response'=>'success', 'user'=>$user);
			}else{
				$data = array('response'=>'error', 'message'=>'failed');
			}
		}

		echo json_encode($data);
	}

	public function update() {
		if ($this->input->is_ajax_request()) {
			$this->form_validation->set_rules('name', 'Name', 'required');
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email');

			if ($this->form_validation->run() == FALSE) {
				$data = array('response'=>'error', 'message'=>validation_errors());
			}else{
				$data['id'] = $this->input->post('id');
				$data['name'] = $this->input->post('name');
				$data['email'] = $this->input->post('email');
				if ($this->crud_model->update_entry($data)) {
					$data = array('response'=>'success', 'message'=>'Data updated successfully');
				}else{
					$data = array('response'=>'error', 'message'=>'failed');
				}
			}
		}else{
			echo "No direct script access allowed";
		}

		echo json_encode($data);
	}
}
