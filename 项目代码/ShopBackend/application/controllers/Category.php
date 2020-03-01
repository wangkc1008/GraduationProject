<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Category extends My_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Category_model');
        $this->load->model('Product_model');
    }

    public function categoryList(){
        $this->isLogin();
        $result = $this->Product_model->getMysqlBatchData('t_shop_category',' 1=1 ');
        $total['total'] = $this->Product_model->getMysqlBatchData('t_shop_category',' 1=1 ',true);
        $total['up'] = $this->Product_model->getMysqlBatchData('t_shop_category',' is_delete = 0 ',true);
        $total['down'] = $this->Product_model->getMysqlBatchData('t_shop_category',' is_delete = 1 ',true);
        foreach ($result as $key => $value) {
            $where = " id = {$value['topic_img_id']} ";
            $result[$key]['img_url'] = $this->config->config['img_prefix'].$this->Product_model->getMysqlSingleData('t_shop_image',$where)['url'];
            $where = " category_id = {$value['id']} and is_delete = 0 ";
            $result[$key]['num'] = $this->Category_model->getMysqlCount('t_shop_product',$where);
        }
        $data['base_url'] = $this->config->config['base_url'];
        $data['data'] = $result;
        $data['total'] = $total;
        $this->load->view('header',$data);
        $this->load->view('category/categoryList');
        $this->load->view('footer');
    }
    public function categoryEdit(){
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
            }
            $where = " id = $id ";
            $info = $this->Product_model->getMysqlSingleData('t_shop_category',$where);
        }
        if ($active == 2) {
            $id = $this->input->post('id',true);
            $category_name = $this->input->post('category_name',true);

            if (empty($id) || empty($category_name)) {
                echo json_encode(
                    array(
                        'data'=>'',
                        'desc'=>'参数错误',
                        'status'=>101
                    )
                );
            }
            $upt_array = array(
                array(
                    'id' => $id,
                    'name' => $category_name,
                )
            );
            $info = $this->Product_model->uptMysqlData('t_shop_category',$upt_array,'id');

            if (!$info) {
                $arr = array(
                    'data'=>'',
                    'desc'=>'操作失败',
                    'status'=>105
                );
                echo json_encode($arr);
            }
            $arr = array(
                "data" =>"",
                "desc"=>"操作成功",
                "status"=>200
            );
            echo json_encode($arr,JSON_UNESCAPED_UNICODE);
            return;
//            echo '<script language="JavaScript">alert("修改成功");</script>';
        }
        $data['base_url'] = $this->config->config['base_url'];
        $data['category_info'] = $info;
        $this->load->view('header',$data);
        $this->load->view('category/categoryEdit');
        $this->load->view('footer');
    }

    public function categoryDel(){
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
            }
            $upt_array = array(
                array(
                    'id' => $id,
                    'is_delete' => 1
                )
            );
            $info = $this->Product_model->uptMysqlData('t_shop_category',$upt_array,'id');
            if (!$info) {
                $arr = array(
                    'data'=>'',
                    'desc'=>'操作失败',
                    'status'=>105
                );
                echo json_encode($arr);
            }

            $upt_array_category = array(
                array(
                    'category_id' => $id,
                    'is_delete' => 1
                )
            );
            $info_category = $this->Product_model->uptMysqlData('t_shop_product',$upt_array_category,'category_id');

            if (!$info_category) {
                $arr = array(
                    'data'=>'',
                    'desc'=>'操作失败',
                    'status'=>105
                );
                echo json_encode($arr);
            }

            $arr = array(
                "data" =>"",
                "desc"=>"操作成功",
                "status"=>200
            );
            echo json_encode($arr,JSON_UNESCAPED_UNICODE);
        }
        return;
    }
    public function categoryUp(){
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
            }
            $upt_array = array(
                array(
                    'id' => $id,
                    'is_delete' => 0
                )
            );
            $info = $this->Product_model->uptMysqlData('t_shop_category',$upt_array,'id');
            if (!$info) {
                $arr = array(
                    'data'=>'',
                    'desc'=>'操作失败',
                    'status'=>105
                );
                echo json_encode($arr);
            }

            $upt_array_category = array(
                array(
                    'category_id' => $id,
                    'is_delete' => 0
                )
            );
            $info_category = $this->Product_model->uptMysqlData('t_shop_product',$upt_array_category,'category_id');

            if (!$info_category) {
                $arr = array(
                    'data'=>'',
                    'desc'=>'操作失败',
                    'status'=>105
                );
                echo json_encode($arr);
            }

            $arr = array(
                "data" =>"",
                "desc"=>"操作成功",
                "status"=>200
            );
            echo json_encode($arr,JSON_UNESCAPED_UNICODE);
        }
        return;
    }


    public function categoryAdd(){
        $active = $this->input->post('active',true);
        if ($active == 1) {
            $category_name = $this->input->post('category_name',true);
            if (empty($category_name)) {
                echo '<script language="JavaScript">alert("参数错误");window.location.href="./categoryAdd";</script>';
                return;
            }
//            $img_url = "";
//            if(is_uploaded_file($_FILES['img']['tmp_name']))
//            {
//                if(move_uploaded_file($_FILES['img']['tmp_name'], './public/ '))
//                {
//                    $img_url = $_FILES['img']['name'];
//                }
//            }
//            var_dump($img_url);
//            exit();
            $config['upload_path'] = 'D:Demo/wx_shop/public/images';   //注意：此路劲是相对于CI框架中的根目录下的目录
            $config['allowed_types'] = 'jpg|png';    //设置上传的图片格式
            $config['max_size'] = '10240';              //设置上传图片的文件最大值
            $config['max_width']  = '2000';            //设置图片的最大宽度
            $config['max_height']  = '2000';
            $this->load->library('upload', $config);   //加载CI中的图片上传类，并递交设置的各参数值
            if (!$this->upload->do_upload('img'))
            {
                echo '<script language="JavaScript">alert("图片上传失败");window.location.href="./categoryAdd";</script>';
                return;
            }

            $arr = $this->upload->data();     //此函数是返回图片上传成功后的信息
            $img_url = '/'.$arr['file_name'];
            $ins_array = array(
                array(
                    'url' => $img_url,
                    'is_delete' => 0
                )
            );
            $img_id = $this->Product_model->insMysqlData('t_shop_image',$ins_array);
            $ins_array = array(
                array(
                    'name' => $category_name,
                    'is_delete' => 0,
                    'topic_img_id' => $img_id
                )
            );
            $info = $this->Product_model->insMysqlData('t_shop_category',$ins_array);

            if (!$info) {
                echo '<script language="JavaScript">alert("添加失败");window.location.href="./categoryAdd";</script>';
                return;
            }
//            echo json_encode($arr,JSON_UNESCAPED_UNICODE);
            echo '<script language="JavaScript">alert("添加成功");window.location.href="./categoryAdd";</script>';
            return;
        }
        $data['base_url'] = $this->config->config['base_url'];
        $this->load->view('header',$data);
        $this->load->view('category/categoryAdd');
        $this->load->view('footer');
    }

}