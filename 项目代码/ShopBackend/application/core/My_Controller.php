<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class My_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        $this->load->library('session');
        $this->load->helper('url');
    }

    public function isLogin(){
        if (!$_SESSION['user_name']){
            redirect($this->config->config['base_url'].'/login/loginIn');
        }
    }

}