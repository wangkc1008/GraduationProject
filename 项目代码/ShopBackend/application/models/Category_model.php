<?php
/**
 * Created by PhpStorm.
 * User: wangkc
 * Date: 2019/5/3
 * Time: 19:12
 */
class Category_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database('default',true);
    }

    public function getMysqlCount($table, $where){
        $db = $this->load->database('default',true);
        $sql = " select count(id) as num from $table where $where ";
        $result = $db->query($sql);
        if ($result && $db->affected_rows()) {
            return $result->row_array()['num'];
        }
        return 0;
    }


}