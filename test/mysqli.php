<?php
class Modelx{
	public $db;
	public $table;
	public $table_all="";
	public $tmpTable="";
	public $where="";
	public $fields=" * ";
	public $group="";
	public $order="";
	public $start=0;
	public $limit=0;
	
	public function setDB($db){
		$this->db=$db;
	}
	public function initParam(){
		$this->table="";
		$this->where="";
		$this->fields="";
		$this->group="";
		$this->order="";
		$this->start=0;
		$this->limit=0;
	}
	public function setTable(){
		$this->tmpTable=$table;
	}
	public function table($table){
		$this->table=$table;
		return $this;
	}
	public function field($field){
		$this->fields=$field;
		return $this;
	}
	public function Where($w){
		$this->where=$w;
		return $this;
	}
	public function group($s){
		$this->group=$s;
		return $this;
	}
	public function Order($s){
		$this->order=$s;
		return $this;
	}
	public function limit($a=0,$b=0){
		if($b==0){
			$this->start=0;
			$this->limit=$a;
		}else{
			$this->start=$a;
			$this->limit=$b;
		}
		return $this;
	}
	public function initSql(){
		//"select * from table where 1 group a order by x limit 1,2"
		$sql=" select ".$this->fields." from ".$this->table." ";
		if($this->where!=""){
			$sql.=" where ".$this->where;
		}
		if($this->group!=""){
			$sql.=" group by ".$this->group;
		}
		if($this->order!=""){
			$sql.=" order by ".$this->order;
		}
		if($this->limit!=0){
			$sql.=" limit ".$this->start.",".$this->limit;
		}
		$this->initParam();
		return $sql;
	}
	public function preQuery($sql,...$params){
		return $this->db->preQuery($sql,...$params);
	}
	public function all(...$params){
		$sql=$this->initSql();
		$res=$this->preQuery($sql,...$params);
		$data=array();
		if($res!==false){
			while($rs=$this->db->fetch_array($res,"str")){
				$data[]=$rs;
			}			 
			return $data;
		}else{
			return false;	
		}
	}
	public function cols(...$params){
		$sql=$this->initSql();
		$res=$this->preQuery($sql,...$params);
		$data=array();
		if($res!==false){
			while($rs=$this->db->fetch_array($res,"num")){
				$data[]=$rs[0];
			}			 
			return $data;
		}else{
			return false;	
		}
	}
	public function row(...$params){
		$this->limit=1;
		$sql=$this->initSql();
		$res=$this->preQuery($sql,...$params);
		if($res!=false){
			$row=$this->db->fetch_array($res,"str");
			return $row;
		}else{
			return false;
		}
	}
	public function one(...$params){
		$this->limit=1;
		$sql=$this->initSql();
		$res=$this->preQuery($sql,...$params);
		if($res!=false){
			$row=$this->db->fetch_array($res,"num");
			return $row[0];
		}else{
			return false;
		}
	}
	
	public function count(...$params){
		$this->fields=" count(*) ";
		$sql=$this->initSql();
		 
		$res=$this->preQuery($sql,...$params);
		if($res!=false){
			$row=$this->db->fetch_array($res,"num");
			return $row[0];
		}else{
			return false;
		}
	}

} 
require "../skymvc/class/cls_pdo.php";
require "../skymvc/class/cls_model.php";
$config=[
	"host"=>"localhost",
	"user"=>"root",
	"pwd"=>"root",
	"database"=>"deituicmsbase"
];
$db = new mysql();
$db->connect($config);
 
$m=new Model();
$m->setDB($db);
$res=$m->table("sky_ad")->field("id,title,tag_id")->order("id ASC")->where(" tag_id=? ")->cols(1);
print_r($res);
exit;
  
?> 