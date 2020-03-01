<?php
/**
 * Created by PhpStorm.
 * User: wangkc
 * Date: 2019/5/3
 * Time: 2:38
 */
class Product_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database('default',true);
    }

    public function getMysqlBatchData($table,$where,$count = false){
        $db = $this->load->database('default',true);
        $sql = " select count(*) as num from $table where $where ";
        if (!$count) {
            $sql = " select * from $table where $where ";
        }
        $result = $db->query($sql);
        if ($result && $db->affected_rows()) {
            if (!$count) {
                return $result->result_array();
            } else {
                return $result->row_array()['num'];
            }
        }
        return array();
    }

    public function getMysqlSingleData($table,$where){
        $db = $this->load->database('default',true);
        $sql = " select * from $table where $where ";
        $result = $db->query($sql);
        if ($result && $db->affected_rows()) {
            return $result->row_array();
        }
        return array();
    }
    public function uptMysqlData($table,$upt_array,$index){
        $db = $this->load->database('default',true);
        $db->update_batch($table,$upt_array,$index);
//        if ($db->affected_rows()) {
//            return true;
//        }
        return true;
    }
    public function insMysqlData($table,$ins_array){
        $db = $this->load->database('default',true);
        $info = $db->insert_batch($table,$ins_array);
        if ($info) {
            return $db->insert_id();
        }
        return false;
    }

}