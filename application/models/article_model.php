<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//用户模型
class Article_model extends CI_Model{

  const TBL_ART = "article";

  # 数据库中完成发布文章
  public function publish_article($data) {
    return $this->db->insert(self::TBL_ART,$data);
  }

  # 数据库中获得所有文章
  public function all_article() {
    $query = $this->db->order_by('article_id','desc')->get(self::TBL_ART);
    return $query->result_array();
  }

  # 数据库中搜索文章
  public function search_article($ask){
    $condition['title'] = $ask;
    $query = $this->db->where($condition)->get(self::TBL_ART);
    if ($query && $this->db->affected_rows() > 0) {
      return $query->row_array();;
    } else {
       return false;
    }
  }

  # 数据库中获得需要浏览的文章
  public function scan_article($article_id){
    $condition['article_id']=$article_id;
    $query = $this->db->where($condition)->get(self::TBL_ART);
    return $query->row_array();
  }

  # 数据库中获得一个用户的文章
  public function mine_article($user_id){
    $condition['user_id']=$user_id;
    $query = $this->db->where($condition)->get(self::TBL_ART);
    return $query->result_array();
  }

  # 数据库中删除一个文章
  public function delete_article($article_id){
    $condition['article_id'] = $article_id;
    $query = $this->db->where($condition)->delete(self::TBL_ART);
    if ($query && $this->db->affected_rows() > 0) {
      return true;
    } else {
       return false;
    }
  }

}
