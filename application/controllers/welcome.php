<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */

	# 创建一个继承自CI的构造函数
	public function __construct() {
		parent::__construct();
		# 加载模型
		header("Content-type:text/html;charset=utf-8");
		$this->load->model('user_model');
		$this->load->model('article_model');
		$this->load->model('category_model');
		$this->load->library('form_validation');
	}

    # 载入主页面
	public function index() {
        # 加载数据库文章并分配至主页
		$data['article'] = $this->article_model->all_article();
		$data['category'] = $this->category_model->all_category();
		$this->load->view('index.html',$data);
	}

    # 载入分类页面
	public function category($category_id) {
    # 加载数据库文章并分配至主页
        $data['category'] = $this->category_model->all_category();
		$data['category_article'] = $this->category_model->one_category($category_id);
        $data['one_category'] = $this->category_model->idget_category($category_id);
		$this->load->view('category.html',$data);
	}

    # 载入我的页面
	public function mine() {
		# 从session中获取用户信息
		$user = $this->session->userdata('user');
		if (empty($user['user_id'])) {
			# 用户信息不存在
			$data['message'] = '请先登录哦';
			$data['wait'] = 3;
			$data['url'] = site_url('welcome/index');
			$this->load->view('message_error.html',$data);
		} else {
            # 根据$user_id,加载数据库文章并分配至我的页面
		    $data['mine_article'] = $this->article_model->mine_article($user['user_id']);
		    $data['article'] = $this->article_model->all_article();
		    $data['category'] = $this->category_model->all_category();
			$this->load->view('mine.html',$data);
		}
	}

    # 载入发布页面
	public function publish() {
		# 从session中获取用户信息
		$user = $this->session->userdata('user');
		if (empty($user['user_id'])) {
			# 用户信息不存在
			$data['message'] = '请先登录哦';
		  $data['wait'] = 3;
		  $data['url'] = site_url('welcome/index');
		  $this->load->view('message_error.html',$data);
		} else {
			# 用户信息存在
	   		$this->load->view('publish.html');
	    }
	}

    # 载入浏览页面
	public function scan($article_id) {
		#获取文章id并根据id查找该文章内容
		$data['scan_article'] = $this->article_model->scan_article($article_id);
		$data['category'] = $this->category_model->all_category();
		#将该文章信息分配到视图中
		$this->load->view('scan.html',$data);
	}
    
    # 载入介绍页面
	public function about() {
        $this->load->view('about/index.html');
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
