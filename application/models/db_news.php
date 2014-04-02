<?php
/**
 * 
 */
class DB_news extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	function news_insert($arr) 
	{
		$this->db->insert('news', $arr);
	}
	
	function news_num() 
	{
		$this->db->from('news');
		$num = $this->db->count_all_results();
		return $num;
		
	}
	
	function news_sele_num($newsname) 
	{
		$this->db->like("subject",$newsname);
		$this->db->from('news');
		$sel_num = $this->db->count_all_results();
		return $sel_num;
		
	}
	
	function news_update($id,$arr) 
	{
		$this->db->where('id',$id);
		$this->db->update('news',$arr);
	}
	
	function news_del($id) 
	{
		$this->db->where('id',$id);
		$this->db->delete('news');
	}
	
	function news_select_all($pagesize,$offset) 
	{
		$this->db->select('*');
		$this->db->order_by("id","desc");
		$this->db->limit($pagesize , $offset);
		$query = $this->db->get('news');
		return $query->result();
	}
	
	function news_select($newsname,$pagesize,$offset) 
	{
		$this->db->select('*');
		$this->db->like("subject",$newsname);
		$this->db->order_by("id","desc");
		$this->db->limit($pagesize , $offset);
		$query = $this->db->get('news');
		return $query->result();
	}
	
	function news_edit_select($id) 
	{
		$this->db->select('*');
		$this->db->where('id',$id);
		$query = $this->db->get('news');
		return $query->result();
	}
}