<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Article extends CI_Controller {

	# 创建一个继承自CI的构造函数
	public function __construct() {
		parent::__construct();
		# 设置页面内容是html编码格式是utf-8
		header("Content-type:text/html;charset=utf-8");
		# 加载模型
		$this->load->model('user_model');
		$this->load->model('article_model');
		$this->load->model('category_model');
		# 加载验证规则
		$this->load->library('form_validation');
	}

    # 完成搜索功能
	public function search() {
		# 设置验证规则，搜索请求必填
		$this->form_validation->set_rules('ask','搜索请求','required');
		if ($this->form_validation->run() == false) {
			# 未通过验证，经错误提示返回首页
			$data['message'] = validation_errors();
			$data['wait'] = 3;
			$data['url'] = site_url('welcome/index');
			$this->load->view('message_error.html',$data);
		} else {
			# 通过验证，获取数据
			$ask = $this->input->post('ask');
			if ($this->article_model->search_article($ask)) {
				# 搜索成功，获取搜索文章内容
				$data['search_article'] = $this->article_model->search_article($ask);
				# 获取文章分类内容
				$data['category'] = $this->category_model->all_category();
				$data['ask'] = $ask;
				# 将数据分配至搜索结果页面
				$this->load->view('search.html',$data);
			} else {
				# 搜索失败，经错误提示返回首页
				$data['message'] = '抱歉，搜索不到该文章';
			    $data['wait'] = 3;
			    $data['url'] = site_url('welcome/index');
			    $this->load->view('message_error.html',$data);
		    }
		}
	}

    # 完成发布动作
	public function publish() {
		# 设置验证规则，文章标题、文章简介、文章内容必填
		$this->form_validation->set_rules('title','文章标题','required');
		$this->form_validation->set_rules('brief','文章简介','required');
		$this->form_validation->set_rules('content','文章内容','required');
		if ($this->form_validation->run() == false) {
			# 未通过验证，经错误提示返回发布页面
			$data['message'] = validation_errors();
			$data['wait'] = 3;
			$data['url'] = site_url('welcome/publish');
			$this->load->view('message_error.html',$data);
		} else {
			# 通过验证，获取表单内容
			$data['title'] = $this->input->post('title',true);
		    $data['brief'] = $this->input->post('brief',true);
		    $data['content'] = $this->input->post('content',true);
		    $data['user_id'] = $this->input->post('user_id',true);

			if ($this->article_model->publish_article($data)) {
				# 发表文章成功
				$data['message'] = '发表文章成功';
				$data['url'] = site_url('welcome/mine');
				$data['wait'] = 3;
				$this->load->view('message_succeed.html',$data);
			} else {
				# 发表文章失败，经错误提示返回发布页面
				$data['message'] = '发表文章失败';
				$data['url'] = site_url('welcome/publish');
				$data['wait'] = 3;
				$this->load->view('message_error.html',$data);
			}
		}
	}

    # 完成删除文章动作
	public function delete($article_id) {
		if ($this->article_model->delete_article($article_id)) {
			# 删除成功
			$data['message'] = '删除成功';
			$data['wait'] = 3;
			$data['url'] = site_url('welcome/mine');
			$this->load->view('message_succeed.html',$data);
		} else {
			# 删除文章失败，经错误提示返回我的页面
			$data['message'] = '删除失败';
			$data['wait'] = 3;
			$data['url'] = site_url('welcome/mine');
			$this->load->view('message_error.html',$data);
		}
    }

}