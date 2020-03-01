<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends My_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Category_model');
        $this->load->model('Product_model');
    }

    public function userList(){
        $this->isLogin();
        $result = $this->Product_model->getMysqlBatchData('t_shop_user_address',' 1=1 ');
        $total = $this->Product_model->getMysqlBatchData('t_shop_user_address',' 1=1 ',true);
        foreach ($result as $key => $value) {
            $result[$key]['create_time'] = date('Y-m-d H:i:s',$value['create_time']);
            $result[$key]['update_time'] = date('Y-m-d H:i:s',$value['update_time']);
        }
        $data['base_url'] = $this->config->config['base_url'];
        $data['data'] = $result;
        $data['total'] = $total;
        $this->load->view('header',$data);
        $this->load->view('user/userList');
        $this->load->view('footer');
    }

}