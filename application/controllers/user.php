<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class User extends MY_Controller
{
  public function __construct()
  {
    parent::__construct();
    if ($this->is_admin() === FALSE)
    {
      redirect('album');
    }
    else
    {
      $this->load->model('user_model', 'User_Model');
    }
  }
  
  public function index()
  {
    $data['users'] = $this->User_Model->fetch_all();
    $this->load->view('user/index', $data);
  }

  public function create()
  {
    $this->load->helper('form');
    $this->load->view('user/create');
  }
  
  public function add()
  {
    // Validate form.
    $this->load->helper('form');
    $this->load->library('form_validation');
    $this->form_validation->set_rules('email_address', 'Email Address', 'trim|required|valid_email|is_unique[user.email_address]|xss_clean');
    $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[5]|sha1');
    if ($this->form_validation->run() == FALSE)
    {
      // Form didn't validate
      $this->load->view('user/create');
    }
    else
    {
      // Success, create user & redirect
      $now = date('Y-m-d H:i:s');
      $user_data = array(
                   'email_address' => $this->input->post('email_address'), 
                   'password' => $this->input->post('password'),
                   'is_active' => $this->input->post('is_active'),
                   'is_admin' => $this->input->post('is_admin'),
                   'created_at' => $now,
                   'updated_at' => $now);
      $this->User_Model->create($user_data);
      redirect('user/index');
    }
  }

  public function edit($user_id)
  {
    $this->load->helper('form');
    $data['user'] = $this->User_Model->find_by_id($user_id);
    $this->load->view('user/edit', $data);
  }
  
  public function update($user_id)
  {
    // Validate form.
    $this->load->helper('form');
    $data['user'] = $this->User_Model->find_by_id($user_id);
    $this->load->library('form_validation');
    // TODO Can set a new email address or keep the same.
    $this->form_validation->set_rules('email_address', 'Email Address', 'trim|required|valid_email|is_unique[user.email_address]|xss_clean');
    $this->form_validation->set_rules('password', 'Password', 'trim|min_length[5]|sha1');
    if ($this->form_validation->run() == FALSE)
    {
      // Form didn't validate
      $this->load->view('user/edit', $data);
    }
    else
    {
      // Success, create user & redirect
      $now = date('Y-m-d H:i:s');
      $user_data = array(
                   'email_address' => $this->input->post('email_address'), 
                   'is_active' => $this->input->post('is_active'),
                   'is_admin' => $this->input->post('is_admin'),
                   'created_at' => $now,
                   'updated_at' => $now);
      // Password can be optionally changed.
      $password = $this->input->post('password');
      if (isset($password) && strlen($password) > 0)
      {
        $user_data['password'] = $password;
      }
      $this->User_Model->update($user_data, $user_id);
      // TODO Set flash data
      redirect("user");
    }
  }

  public function deactivate($user_id)
  {
    // TODO Implement functionality.
    $this->User_Model->update(array('is_active' => 0), $user_id);
    redirect("user");
  }
  
  public function remove($user_id)
  {
    // TODO Implement functionality.
    $this->User_Model->delete($user_id);
    redirect("user");
  }
  
  public function change_email($email_address)
  {
    // TODO Implement functionality.
  }
  
}