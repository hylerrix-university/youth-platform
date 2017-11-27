<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//用户模型
class User_model extends CI_Model{

  const TBL_USER = "user";

  # 数据库中注册用户
  public function register_user($data) {
    return $this->db->insert(self::TBL_USER,$data);
  }

  # 验证账号是否重复
  public function is_repeat_user($username) {
    $condition['username'] = $username;
    $query = $this->db->where($condition)->get(self::TBL_USER);
    if ($query->row_array() == NULL) {
      return true;
    } else {
      return false;
    }
  }

  # 登陆时检验用户登录信息是否存在
  public function is_exist_user($username,$password) {
    $condition['username'] = $username;
    $condition['password'] = md5($password);
    $query = $this->db->where($condition)->get(self::TBL_USER);
    return $query->row_array();
  }

  # 根据用户username获取一个用户信息
  public function username_get_oneuser($username) {
    $condition['username'] = $username;
    $query = $this->db->where($condition)->get(self::TBL_USER);
    return $query->row_array();
  }

  # 根据用户user_id获取一个username
  public function userid_get_username($user_id) {
    $condition['user_id'] = $user_id;
    $query = $this->db->where($condition)->get(self::TBL_USER);
    $v = $query->row_array();
    var_dump($v['username']);exit;
    return $query->row_array();
  }

}
