<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

	# 创建一个继承自CI的构造函数
	public function __construct() {
		parent::__construct();
		# 加载模型和验证规则
		header("Content-type:text/html;charset=utf-8");
		$this->load->model('user_model');
		$this->load->library('form_validation');
	}

	# 处理注册信息
	public function do_register(){
		# 设置验证规则
		# 用户名必填
		$this->form_validation->set_rules('username','登录邮箱','required|valid_email');
		# 登陆密码必填，最终经过md5加密
		$this->form_validation->set_rules('password','登录密码','required|min_length[6]|max_length[16]|md5');
		# 重复登陆密码必填，必须与密码一致
		$this->form_validation->set_rules('repassword','重复密码','required|matches[password]');

		if ($this->form_validation->run() == false) {
			# 未通过验证
			$data['message'] = validation_errors();
			$data['wait'] = 3;
			$data['url'] = site_url('welcome/index');
			$this->load->view('message_error.html',$data);
		} else {
			# 通过验证,开始注册
			$data['username'] = $this->input->post('username',true);
			$data['password'] = $this->input->post('password',true);
			if ($this->user_model->is_repeat_user($data['username']) == true){
				# 用户名不曾存在，完成注册并显示结果
				if ($this->user_model->register_user($data)) {
					# 注册成功
					# 存在匹配，登陆成功,获取该用户信息
					$userinfo = $this->user_model->username_get_oneuser($data['username']);
					# 将用户信息保存至session
					$user = array(
				      'username'  => $data['username'],
				      'user_id'  => $userinfo['user_id']
					);
					$this->session->set_userdata('user',$user);
					# 进入提示页面
					$data['message'] = '恭喜您，注册成功，努力加载中~~';
			    	$data['wait'] = 3;
				    $data['url'] = site_url('welcome/mine').'/'.$user['user_id'];
				    $this->load->view('message_succeed.html',$data);
				} else {
					# 注册失败
					$data['message'] = '抱歉啦，注册失败，请重新尝试~';
		    	    $data['wait'] = 3;
			        $data['url'] = site_url('welcome/index');
			        $this->load->view('message_error.html',$data);
				}
			} else {
				# 该账号已经存在于数据库中，跳回注册界面
				$data['message'] = '该账号已经存在，请重新填写~';
		    	$data['wait'] = 3;
			    $data['url'] = site_url('welcome/index');
			    $this->load->view('message_error.html',$data);
			}
		}
	}

	# 完成登陆动作
	public function login() {
		# 设置验证规则
		# 用户名必填
		$this->form_validation->set_rules('username','登录邮箱','required');
		# 登陆密码必填
		$this->form_validation->set_rules('password','登录密码','required');

		# 获取登录信息
		$username = $this->input->post('username');
		$password = $this->input->post('password');

		if ($this->form_validation->run() == false) {
			# 未通过验证
			$data['message'] = validation_errors();
		    $data['wait'] = 3;
			$data['url'] = site_url('welcome/index');
			$this->load->view('message_error.html',$data);
		} else {
			# 检验登录信息与数据库中用户的是否存在匹配
			if ($user = $this->user_model->is_exist_user($username,$password)) {
				# 存在匹配，登陆成功,获取该用户信息
				$userinfo = $this->user_model->username_get_oneuser($username);
				# 将用户信息保存至session
				$user = array(
			      'username'  => $username,
			      'user_id'  => $userinfo['user_id']
				);
				$this->session->set_userdata('user',$user);
				# 进入提示页面
				$data['message'] = '登陆成功，努力加载中~';
		    	$data['wait'] = 3;
			    $data['url'] = site_url('welcome/mine').'/'.$user['user_id'];
			    $this->load->view('message_succeed.html',$data);

			} else {
				# 不存在匹配，跳回主页
				$data['message'] = '登录信息填写错误，请重新填写~';
				$data['wait'] = 3;
				$data['url'] = site_url('welcome/index');
				$this->load->view('message_error.html',$data);
			}
		}
	}

	# 完成注销动作
	public function logout() {
		$this->session->unset_userdata('user');
		redirect();
	}

}
