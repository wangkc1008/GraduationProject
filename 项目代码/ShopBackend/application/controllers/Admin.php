<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends My_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Category_model');
        $this->load->model('Product_model');
    }

    public function adminList(){
        $this->isLogin();
        $result = $this->Product_model->getMysqlBatchData('t_shop_backend_user',' 1=1 ');
        $total['total'] = $this->Product_model->getMysqlBatchData('t_shop_backend_user',' 1=1 ',true);
        $total['up'] = $this->Product_model->getMysqlBatchData('t_shop_backend_user',' is_delete = 0 ',true);
        $total['down'] = $this->Product_model->getMysqlBatchData('t_shop_backend_user',' is_delete = 1 ',true);
        foreach ($result as $key => $value) {
            $result[$key]['login_time'] = date('Y-m-d H:i:s',$value['login_time']);
            $result[$key]['create_time'] = date('Y-m-d H:i:s',$value['create_time']);
        }
        $data['base_url'] = $this->config->config['base_url'];
        $data['data'] = $result;
        $data['total'] = $total;
        $this->load->view('header',$data);
        $this->load->view('admin/adminList');
        $this->load->view('footer');
    }

    public function adminEdit(){
        $active = $this->input->get('active',true);
        if (!$active) {
            $active = $this->input->post('active',true);
        }
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
                return;
            }
            $where = " id = $id ";
            $info = $this->Product_model->getMysqlSingleData('t_shop_backend_user',$where);
        }
        if ($active == 2) {
            $id = $this->input->post('id',true);
            $admin_name = $this->input->post('admin_name',true);

            if (empty($id) || empty($admin_name)) {
                echo json_encode(
                    array(
                        'data'=>'',
                        'desc'=>'参数错误',
                        'status'=>101
                    )
                );
                return;
            }
            $upt_array = array(
                array(
                    'id' => $id,
                    'user_name' => $admin_name,
                )
            );
            $info = $this->Product_model->uptMysqlData('t_shop_backend_user',$upt_array,'id');

            if (!$info) {
                $arr = array(
                    'data'=>'',
                    'desc'=>'修改失败',
                    'status'=>105
                );
                echo json_encode($arr);
                return;
            }
            $arr = array(
                "data" =>"",
                "desc"=>"修改成功",
                "status"=>200
            );
            echo json_encode($arr,JSON_UNESCAPED_UNICODE);
            return;
        }
        $data['base_url'] = $this->config->config['base_url'];
        $data['admin_info'] = $info;
        $this->load->view('header',$data);
        $this->load->view('admin/adminEdit');
        $this->load->view('footer');
    }

    public function adminDel(){
        $active = $this->input->post('active',true);
        if ($active == 1) {
            $id = $this->input->post('id',true);
            if (empty($id)) {
                echo json_encode(
                    array(
                        'data'=>'',
                        'desc'=>'参数错误',
                        'status'=>101
                    )
                );
                return;
            }
            $upt_array = array(
                array(
                    'id' => $id,
                    'is_delete' => 1
                )
            );
            $info = $this->Product_model->uptMysqlData('t_shop_backend_user',$upt_array,'id');

            if (!$info) {
                $arr = array(
                    'data'=>'',
                    'desc'=>'操作失败',
                    'status'=>105
                );
                echo json_encode($arr);
                return;
            }
            $arr = array(
                "data" =>"",
                "desc"=>"操作成功",
                "status"=>200
            );
            echo json_encode($arr,JSON_UNESCAPED_UNICODE);
            return;
        }
        return;
    }

    public function adminUp(){
        $active = $this->input->post('active',true);
        if ($active == 1) {
            $id = $this->input->post('id',true);
            if (empty($id)) {
                echo json_encode(
                    array(
                        'data'=>'',
                        'desc'=>'参数错误',
                        'status'=>101
                    )
                );
                return;
            }
            $upt_array = array(
                array(
                    'id' => $id,
                    'is_delete' => 0
                )
            );
            $info = $this->Product_model->uptMysqlData('t_shop_backend_user',$upt_array,'id');

            if (!$info) {
                $arr = array(
                    'data'=>'',
                    'desc'=>'操作失败',
                    'status'=>105
                );
                echo json_encode($arr);
                return;
            }
            $arr = array(
                "data" =>"",
                "desc"=>"操作成功",
                "status"=>200
            );
            echo json_encode($arr,JSON_UNESCAPED_UNICODE);
            return;
        }
        return;
    }

    public function adminAdd(){
        $active = $this->input->post('active',true);
        if ($active == 1) {
            $admin_name = $this->input->post('admin_name',true);
            $admin_pwd = $this->input->post('admin_pwd',true);
            if (empty($admin_name) || empty($admin_pwd)) {
                echo json_encode(
                    array(
                        'data'=>'',
                        'desc'=>'参数错误',
                        'status'=>101
                    )
                );
                return;
            }
            $ins_array = array(
                array(
                    'user_name' => $admin_name,
                    'user_pwd' => md5($admin_pwd),
                    'create_time' => time()
                )
            );
            $info = $this->Product_model->insMysqlData('t_shop_backend_user',$ins_array);
            if (!$info) {
                $arr = array(
                    'data'=>'',
                    'desc'=>'操作失败',
                    'status'=>105
                );
                echo json_encode($arr);
                return;
            }
            $arr = array(
                "data" =>"",
                "desc"=>"操作成功",
                "status"=>200
            );
            echo json_encode($arr,JSON_UNESCAPED_UNICODE);
            return;
        }
        $data['base_url'] = $this->config->config['base_url'];
        $this->load->view('header',$data);
        $this->load->view('admin/adminAdd');
        $this->load->view('footer');
    }

}