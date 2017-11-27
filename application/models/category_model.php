<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//用户模型
class Category_model extends CI_Model{

  const TBL_CAT = "category";
  const TBL_ART = "article";

  # 数据库中获取所有分类
  public function all_category() {
    $query = $this->db->get(self::TBL_CAT);
    return $query->result_array();
  }

  # 数据库中获取一个分类下所有文章
  public function one_category($category_id){
    $condition['category_id']=$category_id;
    $query = $this->db->where($condition)->get(self::TBL_ART);
    return $query->result_array();
  }
      
  # 数据库中根据category_id获取该category名
  public function idget_category($category_id){
    $condition['category_id']=$category_id;
    $query = $this->db->where($condition)->get(self::TBL_CAT);
    return $query->row_array();
  }

}