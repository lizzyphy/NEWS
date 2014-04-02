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
			if(isset($_GET['newsname']))
			{
				$data['newsname'] = $_GET['newsname'];
				$num = $this->db_news->news_sele_num($data['newsname']);
				
			}
			else 
			{
				$num = $this->db_news->news_num();
			}
			$pagesize=5;
			$pages=intval($num/$pagesize);                                    //计算总页数
			if ($num%$pagesize)
				$pages++;
			if (isset($_GET['page']))                                         //获取当前页
			{
				$page=intval($_GET['page']);
			} 
			else
			{
				$page=1; 
			} 
			$offset=$pagesize*($page - 1); 
			if (isset($_GET['newsname']))
			{
				$newsname = $_GET['newsname'];
				$arr = $this->db_news->news_select($newsname,$pagesize,$offset);
			}
			else 
			{
				$arr = $this->db_news->news_select_all($pagesize,$offset);
			}
			
			$first=1; 
			$prev=$page-1; 
			$next=$page+1; 
			$last=$pages; 
			$data['first'] = $first;
			$data['prev'] = $prev;
			$data['next'] = $next;
			$data['last'] = $last;
			$data['page'] = $page;
			$data['pages'] = $pages;
			$data['arr'] = $arr;
			if (!isset($key))
			{
				$key = '';
			}
			if(isset($data['newsname']))
			{
				if ($page > 1) 
				{
					$key.= "<a href='/php/CIphp/index.php/home/index?page=".$first."&newsname=".$newsname."'>首页</a> "; 
					$key.= "<a href='/php/CIphp/index.php/home/index?page=".$prev."&newsname=".$newsname."'>上一页</a>"; 
				} 
				for ($i = 1;$i < $page;$i++) 
				$key.= "<a href='/php/CIphp/index.php/home/index?page=".$i."&newsname=".$newsname."'>[".$i."]</a>"; 
				$key.= "[".$page."]"; 
				for ($i = $page+1;$i <= $pages;$i++) 
				$key.= "<a href='/php/CIphp/index.php/home/index?page=".$i."&newsname=".$newsname."'>[".$i ."]</a>"; 
				if ($page < $pages)
				{
					$key.= "<a href='/php/CIphp/index.php/home/index?page=".$next."&newsname=".$newsname."'>下一页</a>";
					$key.= "<a href='/php/CIphp/index.php/home/index?page=".$last."&newsname=".$newsname."'>尾页</a>";
				}
			}
			else
			{
				if ($page > 1) 
				{
					$key.= "<a href='/php/CIphp/index.php/home/index?page=".$first."'>首页</a> "; 
					$key.= "<a href='/php/CIphp/index.php/home/index?page=".$prev."'>上一页</a>"; 
				} 
				for ($i = 1;$i < $page;$i++) 
				$key.= "<a href='/php/CIphp/index.php/home/index?page=".$i."'>[".$i."]</a>"; 
				$key.= "[".$page."]"; 
				for ($i = $page+1;$i <= $pages;$i++) 
				$key.= "<a href='/php/CIphp/index.php/home/index?page=".$i."'>[".$i ."]</a>"; 
				if ($page < $pages)
				{
					$key.= "<a href='/php/CIphp/index.php/home/index?page=".$next."'>下一页</a>";
					$key.= "<a href='/php/CIphp/index.php/home/index?page=".$last."'>尾页</a>";
				}
			}
			$data['key'] = $key;
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
		$this->load->model('test_m');
		$user = $this->test_m->user_select($_POST['uname']);
		if ($user)
		{
			if ($user[0]->upass==$_POST['upass'])
			{
				$this->load->library('session');
				$arr = array('uid'=>$user[0]->uid,'uname'=>$user[0]->uname);
				$this->session->set_userdata($arr);
				//echo $this->session->userdata('uid');
				$data['uname'] = $this->session->userdata('uname');
				//$this->load->view('index',$data);
				header("location: /php/CIphp/index.php/home/index");
				exit;
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
		if (empty($_POST['subject']))
		{
			echo "<script>alert('请输入新闻标题!');history.back();</script>";
		}
		elseif (empty($_POST['news']))
		{
			echo "<script>alert('请输入新闻内容!');history.back();</script>";
		}
		elseif (empty($_POST['author']))
		{
			echo "<script>alert('请输入作者姓名!');history.back();</script>";
		}
		else 
		{
			$arr = array('subject'=>$_POST['subject'],'news'=>$_POST['news'],'author'=>$_POST['author'],'datetime'=>$datetime);
			$this->db_news->news_insert($arr);
			echo '添加新闻成功!';
			echo "<a href= \"/php/CIphp/index.php/home/index\">返回首页</a>";
			echo "<a href= \"add\">继续添加</a>";
		}
	}
	
	function present_news() 
	{
		$id = $_GET['id'];
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
		$id = $_GET['id'];
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
		if(isset($_POST['edit']))
		{
		$id = $_GET['id'];
		date_default_timezone_set('Etc/GMT-8');
		$datetime = date("y/m/d \a\\t h:i a");
		$arr = array('subject'=>$_POST['subject'],'news'=>$_POST['news'],'author'=>$_POST['author'],'datetime'=>$datetime);
		$this->load->model('db_news');
		$this->db_news->news_update($id,$arr);
		}
		header("location: /php/CIphp/index.php/home/index");
	}
	
	function dele_news() 
	{
		$id = $_GET['id'];
		$this->load->model('db_news');
		$this->db_news->news_del($id);
		header("location: /php/CIphp/index.php/home/index");
	}
}