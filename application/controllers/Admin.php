<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function index()
	{
		$data = array('title' => 'Dashboard Admin',
                      'isi' => 'layout/index' );
        $this->load->view('layout/wrapper',$data, FALSE);
	}
}