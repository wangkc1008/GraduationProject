<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends My_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Category_model');
        $this->load->model('Product_model');
        $this->load->helper('url');
        $this->load->library('session');
    }

    public function loginIn(){
        $data['base_url'] = $this->config->config['base_url'];
        $this->load->view('header',$data);
        $this->load->view('login/loginIn');
        $this->load->view('footer');
    }

    public function checkLogin(){
        $active = $this->input->post('active',true);
        if ($active == 1) {
            $username = $this->input->post('username',true);
            $password = $this->input->post('password',true);
            if (empty($username) || empty($password)){
                echo '<script language="JavaScript">alert("用户名和密码不能为空");window.location.href="./loginIn";</script>';
                return;
            }
            $where = " user_name = '$username' ";
            $user_info = $this->Product_model->getMysqlSingleData('t_shop_backend_user',$where);
            if (!$user_info) {
                echo '<script language="JavaScript">alert("该用户不存在");window.location.href="./loginIn";</script>';
                return;
            }
            $user_pwd = $user_info['user_pwd'];
            if (md5($password) == $user_pwd) {
                $upt_array = array(
                    array(
                        'id' => $user_info['id'],
                        'login_count' => $user_info['login_count'] + 1,
                        'login_time' => time()
                    )
                );
                $info = $this->Product_model->uptMysqlData('t_shop_backend_user',$upt_array,'id');

                if (!$info) {
                    echo '<script language="JavaScript">alert("操作失败");window.location.href="./loginIn";</script>';
                    return;
                }
                $_SESSION['user_name'] = $user_info['user_name'];
                redirect($this->config->config['base_url'].'/product/productList');
            } else {
                echo '<script language="JavaScript">alert("密码输入错误");window.location.href="./loginIn";</script>';
                return;
            }
            redirect($this->config->config['base_url'].'/login/loginIn');
        }
        echo '<script language="JavaScript">alert("用户名和密码不能为空");window.location.href="./loginIn";</script>';
        return;
    }

    public function logout(){
        unset($_SESSION['user_name']);
        redirect($this->config->config['base_url'].'/login/loginIn');
    }

}