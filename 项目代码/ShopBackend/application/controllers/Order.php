<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order extends My_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Category_model');
        $this->load->model('Product_model');
    }

    public function orderList(){
        $this->isLogin();
        $result = $this->Product_model->getMysqlBatchData('t_shop_order',' 1=1 and is_delete = 0 ');
        $total['total'] = $this->Product_model->getMysqlBatchData('t_shop_order',' 1=1 ',true);
        $total['down'] = $this->Product_model->getMysqlBatchData('t_shop_order',' status = 1 ',true);
        $total['up'] = $this->Product_model->getMysqlBatchData('t_shop_order',' status != 1',true);
        $pay_array = array(
            1 => '未支付',
            2 => '已支付'
        );
        foreach ($result as $key => $value) {
            $result[$key]['snap_img'] = $this->config->config['img_prefix'].$value['snap_img'];
            $result[$key]['create_time'] = date('Y-m-d H:i:s',$value['create_time']);
            $result[$key]['update_time'] = date('Y-m-d H:i:s',$value['update_time']);
            $result[$key]['status_desc'] = isset($pay_array[$value['status']]) ? $pay_array[$value['status']] : $value['status'];
            $where  = " user_id = {$value['user_id']} ";
            $result[$key]['user_name'] = $this->Product_model->getMysqlSingleData('t_shop_user_address',$where)['name'];
        }
        $data['base_url'] = $this->config->config['base_url'];
        $data['data'] = $result;
        $data['total'] = $total;
        $this->load->view('header',$data);
        $this->load->view('order/orderList');
        $this->load->view('footer');
    }

    public function orderSee(){
        $active = $this->input->get('active',true);
        $info = array();
        if ($active == 1) {
            $id = $this->input->get('id',true);
            if (empty($id)) {
                echo json_encode(
                    array(
                        'data'=>'',
                        'desc'=>'参数错误',
                        'status'=>101
                    )
                );
            }

            $where = " id = $id ";
            $info = json_decode($this->Product_model->getMysqlSingleData('t_shop_order',$where)['snap_items'],true);
            foreach ($info as $key => $value) {
                $info[$key]['haveStock_desc'] = $value['haveStock'] ? '有库存' : '无库存';
                $info[$key]['main_img_url'] = $this->config->config['img_prefix'].$value['main_img_url'];
            }
        }
        $data['base_url'] = $this->config->config['base_url'];
        $data['data'] = $info;
        $this->load->view('header',$data);
        $this->load->view('order/orderSee');
        $this->load->view('footer');
    }

    public function orderSeeUser(){
        $active = $this->input->get('active',true);
        $info = array();
        if ($active == 1) {
            $id = $this->input->get('id',true);
            if (empty($id)) {
                echo json_encode(
                    array(
                        'data'=>'',
                        'desc'=>'参数错误',
                        'status'=>101
                    )
                );
            }

            $where = " id = $id ";
            $info = json_decode($this->Product_model->getMysqlSingleData('t_shop_order',$where)['snap_address'],true);
        }
        $data['base_url'] = $this->config->config['base_url'];
        $data['data'] = $info;
        $this->load->view('header',$data);
        $this->load->view('order/orderSeeUser');
        $this->load->view('footer');
    }


}
