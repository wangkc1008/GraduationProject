<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product extends My_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->model('Product_model');
    }

    public function productList(){
        $this->isLogin();
        $result = $this->Product_model->getMysqlBatchData('t_shop_product',' 1=1 ');
        $total['total'] = $this->Product_model->getMysqlBatchData('t_shop_product',' 1=1 ',true);
        $total['up'] = $this->Product_model->getMysqlBatchData('t_shop_product',' is_delete = 0 ',true);
        $total['down'] = $this->Product_model->getMysqlBatchData('t_shop_product',' is_delete = 1 ',true);
        foreach ($result as $key => $value) {
            $result[$key]['img_url'] = $this->config->config['img_prefix'].$value['main_img_url'];
            $where = " id = {$value['category_id']} ";
            $result[$key]['category_name'] = $this->Product_model->getMysqlSingleData('t_shop_category',$where)['name'];
        }
        $data['base_url'] = $this->config->config['base_url'];
        $data['data'] = $result;
        $data['total'] = $total;
        $this->load->view('header',$data);
        $this->load->view('product/productList');
        $this->load->view('footer');
    }

    public function productEdit(){
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
            $info = $this->Product_model->getMysqlSingleData('t_shop_product',$where);
        }
        if ($active == 2) {
            $id = $this->input->post('id',true);
            $product_name = $this->input->post('product_name',true);
            $product_price = $this->input->post('product_price',true);
            $product_stock = $this->input->post('product_stock',true);
            $product_category = $this->input->post('product_category',true);

            if (empty($id) || empty($product_name) || empty($product_price) || empty($product_stock) || empty($product_category)) {
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
                    'name' => $product_name,
                    'price' => $product_price,
                    'stock' => $product_stock,
                    'category_id' => $product_category
                )
            );
            $info = $this->Product_model->uptMysqlData('t_shop_product',$upt_array,'id');

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
        $category = $this->Product_model->getMysqlBatchData('t_shop_category',' 1=1 ');
        $data['base_url'] = $this->config->config['base_url'];
        $data['product_info'] = $info;
        $data['category'] = $category;
        $this->load->view('header',$data);
        $this->load->view('product/productEdit');
        $this->load->view('footer');
        return;
    }

    public function productDel(){
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
            $info = $this->Product_model->uptMysqlData('t_shop_product',$upt_array,'id');

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
        }
        return;
    }

    public function productUp(){
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
            $info = $this->Product_model->uptMysqlData('t_shop_product',$upt_array,'id');

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
        }
        return;
    }

    public function productAdd(){
        $active = $this->input->post('active',true);
        if ($active == 1) {
            $product_name = $this->input->post('product_name',true);
            $product_price = $this->input->post('product_price',true);
            $product_stock = $this->input->post('product_stock',true);
            $product_category = $this->input->post('product_category',true);
            if (empty($product_name) || empty($product_price) || empty($product_stock) || empty($product_category)) {
                echo '<script language="JavaScript">alert("参数错误");window.location.href="./productAdd";</script>';
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
                echo '<script language="JavaScript">alert("图片上传失败");window.location.href="./productAdd";</script>';
                return;
            }

            $arr = $this->upload->data();     //此函数是返回图片上传成功后的信息
            $img_url = '/'.$arr['file_name'];
            $ins_array = array(
                array(
                    'url' => $img_url,
                    'is_delete' => 0,
                )
            );
            $img_id = $this->Product_model->insMysqlData('t_shop_image',$ins_array);
            $ins_array = array(
                array(
                    'name' => $product_name,
                    'price' => $product_price,
                    'stock' => $product_stock,
                    'category_id' => $product_category,
                    'main_img_url' => $img_url,
                    'is_delete' => 0,
                    'img_id' => $img_id
                )
            );
            $pro_id = $this->Product_model->insMysqlData('t_shop_product',$ins_array);
            if (!$pro_id) {
                echo '<script language="JavaScript">alert("添加失败");window.location.href="./productAdd";</script>';
                return;
            }
            echo '<script language="JavaScript">alert("添加成功");window.location.href="./productAdd";</script>';
            return;
        }
        $category = $this->Product_model->getMysqlBatchData('t_shop_category',' 1=1 ');
        $data['base_url'] = $this->config->config['base_url'];
        $data['category'] = $category;
        $this->load->view('header',$data);
        $this->load->view('product/productAdd');
        $this->load->view('footer');
    }
}