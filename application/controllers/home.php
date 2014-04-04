<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
	}
	
	function index() 
	{
		$this->load->library('session');
		$this->load->model('db_news');
		if ($this->session->userdata('uid'))
		{
			//echo "该用户已经登陆";
			
			$data['uname'] = $this->session->userdata('uname');
			if($this->input->get('newsname',TRUE))
			{			
				$data['newsname'] = $this->input->get('newsname',TRUE);
				$num = $this->db_news->news_sele_num($data['newsname']);
				$config['base_url'] = '/php/CIphp/index.php/home/index?newsname='.$data['newsname'];
				
			}
			else 
			{
				$config['base_url'] = '/php/CIphp/index.php/home/index?';
				$num = $this->db_news->news_num();
			}
			
			$pagesize=5;
			$offset = $this->input->get('per_page',TRUE);
			if ($this->input->get('newsname',TRUE))
			{
				
				$newsname = $_GET['newsname'];
				$arr = $this->db_news->news_select($newsname,$pagesize,$offset);
			}
			else 
			{
				$arr = $this->db_news->news_select_all($pagesize,$offset);
			}
			$data['arr'] = $arr;
			
			$this->load->library('pagination');
			//$config['base_url'] = '/php/CIphp/index.php/home/index/';
			$config['page_query_string'] = TRUE;
			$config['total_rows'] = $num;
			$config['per_page'] = $pagesize; 
			$config['num_links'] = 2;
			$config['prev_tag_open'] = '<span>';
			$config['prev_link'] = '上一页';
			$config['prev_tag_close'] = '</span>';
			$config['next_tag_open'] = '<span>';
			$config['next_link'] = '下一页';			
			$config['next_tag_close'] = '</span>';
			$config['first_link'] = '首页';
			$config['last_link'] = '尾页';
			$this->pagination->initialize($config); 
			$data['key2'] = $this->pagination->create_links();

			$this->load->view('index',$data);
			
		}
		else 
		{
			//echo "该用户未登陆";
			$this->load->view('login');
		}
	}
	
	function login()
	{
		$this->load->model('db_news');
		$user = $this->db_news->user_select($this->input->post('uname',TRUE));
		if ($user)
		{
			if ($user[0]->upass==$this->input->post('upass',TRUE))
			{
				$this->load->library('session');
				$arr = array('uid'=>$user[0]->uid,'uname'=>$user[0]->uname);
				$this->session->set_userdata($arr);
				$data['uname'] = $this->session->userdata('uname');
				 redirect('/home/index', 'refresh');
			}
			else
			{
				echo "密码错误";
			}
		}
		else 
		{
			echo "用户名不存在";
		}
	}
	
	function loginout() 
	{
		$this->load->library('session');
		$this->session->unset_userdata('uid');
		echo "用户已注销！";
		echo "<a href= \"/php/CIphp/index.php/home\">登录</a>";
	}
	
	function add() 
	{
		$this->load->view('addnews');
	}
	
	function insert_news() 
	{
		$this->load->model('db_news');
		date_default_timezone_set('Etc/GMT-8');
		$datetime = date("y/m/d \a\\t h:i a");
		if (!($this->input->post('subject')))
		{
			echo "<script>alert('请输入新闻标题!');history.back();</script>";
		}
		elseif (!($this->input->post('news')))
		{
			echo "<script>alert('请输入新闻内容!');history.back();</script>";
		}
		elseif (!($this->input->post('author')))
		{
			echo "<script>alert('请输入作者姓名!');history.back();</script>";
		}
		else 
		{
			$arr = array('subject'=>$this->input->post('subject'),'news'=>$this->input->post('news'),'author'=>$this->input->post('author'),'datetime'=>$datetime);
			$this->db_news->news_insert($arr);
			echo '添加新闻成功!';
			echo "<a href= \"/php/CIphp/index.php/home/index\">返回首页</a>";
			echo "<a href= \"add\">继续添加</a>";
		}
	}
	
	function present_news() 
	{
		$id = $this->input->get('id');
		$this->load->model('db_news');
		$arr = $this->db_news->news_edit_select($id);
		foreach ($arr as $x)
		{
			$data['id'] = $x->id;
			$data['subject'] = $x->subject;
			$data['news'] = $x->news;
			$data['author'] = $x->author;
			$data['datetime'] = $x->datetime;			
		}
		$this->load->view('presentnews',$data);
	}
	
	function edit_news() 
	{
		$id = $this->input->get('id');
		$this->load->model('db_news');
		$arr = $this->db_news->news_edit_select($id);
		foreach ($arr as $x)
		{
			$data['id'] = $x->id;
			$data['subject'] = $x->subject;
			$data['news'] = $x->news;
			$data['author'] = $x->author;
			$data['datetime'] = $x->datetime;			
		}
		$this->load->view('editnews',$data);
	}
	
	function update_news()
	{
		if($this->input->post('edit'))
		{
		$id = $this->input->get('id');
		date_default_timezone_set('Etc/GMT-8');
		$datetime = date("y/m/d \a\\t h:i a");
		$arr = array('subject'=>$this->input->post('subject'),'news'=>$this->input->post('news'),'author'=>$this->input->post('author'),'datetime'=>$datetime);
		$this->load->model('db_news');
		$this->db_news->news_update($id,$arr);
		}
		redirect('home/index');
	}
	
	function dele_news() 
	{
		$id = $this->input->get('id');
		$this->load->model('db_news');
		$this->db_news->news_del($id);
		redirect('/home/index');
	}
}