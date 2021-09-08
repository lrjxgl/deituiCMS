<?php
class model{
	 
	public $db;
	public $table;
	public $table_all=NULL;
	public $tmpTable=false;  
	public $where="";
	public $fields=" * ";
	public $group="";
	public $order="";
	public $start=0;
	public $limit=0;
	function __construct()
	{
		
	}
	
	public function setDb($table=NULL){
		$this->db=setDb($table?$table:$this->table);
		 
	}
	
	public function setTable($table,$object_id=0,$table_num=10){
		$this->setDb($table);
		if($object_id){
			$this->tmpTable=$table."_".($object_id%$table_num);
		}else{
			$this->tmpTable=$table;
		}
		return $this;
	}
	public function clearTable(){
		$this->tmpTable=false;
	}
	public function table($table){
		$this->table=$table;
		return $this;
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
	/**
	*执行sql语句
	*/
	public function query($sql){
		 
		return $this->db->query($sql);
	}
	
	public function begin(){
		 
		return $this->db->query("BEGIN");
	}
	
	public function commit(){
		  
		return $this->db->query("COMMIT");
	}
	
	public function rollback(){
		 
		return $this->db->query("rollback");
	}
	
	/**
	 * 将结果集解析成数组
	 */
	public function fetch_array($result_type=MYSQL_ASSOC){
		return $this->db->fetch_array($result_type);	
	}
	
	/**
	 * 从结果集中取一行
	 */
	public function fetch_row($result_type=PDO::FETCH_ASSOC){
		return $this->db->fetch_row($result_type);	
	}
	
	/**
	*获取全部数据
	*/
	public function getAll($sql,...$params){
		return $this->db->getAll($sql);
	}
	/**
	*获取一个字段数据
	*/
	public function getOne($sql,...$params){
		return $this->db->getOne($sql);
	}
	/**
	*获取一列数据
	*/
	public function getCols($sql,...$params){
		return $this->db->getCOls($sql);
	}
	/**
	*获取一行数据
	*/
	public function getRow($sql,...$params){
		return $this->db->getRow($sql);
	}
	/**
	*获取全部数据
	* data array("table","where"=>array(),"order","start","pagesize","fields")
	*/
	public function select($option=array(),&$rscount=false){
		/*
		if(!isset($option['where'])){
			 
			exit('请确认sql select where条件'.$this->table);
		}
		*/
		$data=$this->db->select($this->tmpTable?$this->tmpTable:($this->table_all?$this->table_all:$this->table),$option,$rscount);
		$this->clearTable();
		return $data;
	}
	/**
	*获取一个字段
	*data array("table","where"=>array(),"order","start","pagesize","fields")
	*/
	public function selectOne($data=array()){
		$data=$this->db->selectOne($this->tmpTable?$this->tmpTable:($this->table_all?$this->table_all:$this->table),$data);
		$this->clearTable();
		return $data;
	}
	/**
	*获取一行信息
	*data array("table","where"=>array(),"order","start","pagesize","fields")
	*/
	public function selectRow($data=array()){
		if(!is_array($data)){
			$t=$data;
			$data=array();
			$data['where']=$t;
		}
		$data=$this->db->selectRow($this->tmpTable?$this->tmpTable:($this->table_all?$this->table_all:$this->table),$data);
		$this->clearTable();
		return $data;
	}
	/**
	*获取一列信息
	*data array("table","where"=>array(),"order","start","pagesize","fields")
	*/
	public function selectCols($data=array(),&$rscount=false){
		$data=$this->db->selectCols($this->tmpTable?$this->tmpTable:($this->table_all?$this->table_all:$this->table),$data,$rscount);
		$this->clearTable();
		return $data;
	}
	/*
	*获取记录总数
	*data array("table","where"=>array(),"order","start","pagesize","fields")
	*/
	public function getCount($w=array()){
		$data=$this->db->getCount($this->tmpTable?$this->tmpTable:($this->table_all?$this->table_all:$this->table),$w);
		$this->clearTable();
		return $data;
	}
	/**
	*插入数据
	*data array("title"=>'aaa');
	*/
	public function insert($data){
		$data=$this->db->insert($this->tmpTable?$this->tmpTable:($this->table_all?$this->table_all:$this->table),$data);
		$this->clearTable();
		return $data;
	}
	
	/**
	 * 批量插入数据***
	**/
	public function insertMore($data){
		$table=$this->tmpTable?$this->tmpTable:($this->table_all?$this->table_all:$this->table);
		
		if(!empty($data)){
			$i=0;
			$fields="";
			foreach($data[0] as $k=>$v){
				if($i>0){
					$fields.=",";
				}
				$fields.=$k;
				$i++;
			}
			$values="";
			foreach($data as $k=>$v){
				if($k>0){
					$values.=",";
				}
				$values.="("._implode($v).") ";
			}
		}
		$sql=" insert into ".TABLE_PRE.$table." ($fields) values $values ;";
		$this->db->query($sql);
		$this->clearTable();
		return $data;
	}
	/**
	*更新数据
	*data array("title"=>'aaa');
	*where array("id"=>1)
	*/
	public function update($data,$where=""){
		if(empty($where)){
			exit("UPDate 必须 含条件");
		}
		if(empty($data)) return false;
		$data=$this->db->update($this->tmpTable?$this->tmpTable:($this->table_all?$this->table_all:$this->table),$data,$where);
		$this->clearTable();
		return $data;
	}
	/*****
	 * 批量更新 insert into ...on duplicate key update
	 * $undata[]=array(
	 * 	"id"=>1,
	 * 	"orderindex"=>2
	 * );
	 * ****/
	
	public function updateMore($updata=array()){
		$table=$this->tmpTable?$this->tmpTable:($this->table_all?$this->table_all:$this->table);
		if(!empty($updata)){
			$sql=" insert into ".table($table)."(";
			$i=0;
			foreach($updata[0] as $k=>$v){
				if($i>0){
					$sql.=",";
				}
				$i++;
				$sql.=$k;
			}
			$sql.=") values ";
			
			foreach($updata as $k=>$v){
				if($k>0){
					$sql.=",";
				}
				$sql.="("._implode($v).") ";
			}
			$sql.="on duplicate key update ";
			$i=0;
			foreach($updata[0] as $k=>$v){
				if($i>0){
					$sql.=",";
				}
				$i++;
				$sql.=" $k=values($k) ";
			}
		 
			$res=$this->db->query($sql);
			$this->clearTable();
			return $res;
		} 
	}
	/**
	/*修改数字类型
	*/
	public function changenum($fields,$num,$w){
		if(empty($w)){
			exit("UPDate 必须 含条件");
		}
		$data=$this->db->query("UPDATE ".TABLE_PRE.($this->tmpTable?$this->tmpTable:($this->table_all?$this->table_all:$this->table))." SET $fields=$fields+{$num} WHERE $w ");
		$this->clearTable();
		return $data;
	}
	/**
	*删除数据
	*where array("id"=>1)
	*/
	public function delete($where=""){
		if(empty($where)){
			exit("Delete 必须 含条件");
		}
		$data=$this->db->delete($this->tmpTable?$this->tmpTable:($this->table_all?$this->table_all:$this->table),$where);
		$this->clearTable();
		return $data;
	}
	/*最近插入的id*/
	public function insert_id(){
		return $this->db->insert_id();
	}
	
	public function getFields(){
		$table=$this->tmpTable?$this->tmpTable:($this->table_all?$this->table_all:$this->table);
		return $this->db->getAll("show columns from ".TABLE_PRE.$table."");
	}
	public function postData($unPost=array()){
		$table=$this->tmpTable?$this->tmpTable:($this->table_all?$this->table_all:$this->table);
		$fields=$this->getFields();
		/*
		$noPost=["status","isnew",'isrecommend','isindex'];
		$unPost+=$noPost;
		*/
		if($fields){
			foreach($fields as $k=>$v){
				if($k==0) continue;
				if(in_array($v['Field'],$unPost)) continue;
				if(isset($_POST[$v['Field']])){
					$format="h";
					$len=0;
					if(preg_match("/int/i",$v['Type'])){
						$format="i";
					}elseif(preg_match("/char/i",$v['Type'])){
						$format="h";
					}elseif(preg_match("/text/i",$v['Type']) or preg_match("/blog/i",$v['Type']) ){
						$format="x";
					}elseif(preg_match("/decimal/i",$v['Type'])){
						$format="r";
						$len=7;
					}
					if($v['Field']=='starttime' or $v['Field']=='endtime'){
						$data[$v['Field']]=strtotime(post($v['Field']));
					}elseif($v['Field']=='dateline'){
						$data[$v['Field']]=time();
					}else{				
						$data[$v['Field']]=post($v['Field'],$format,$len);
					}
				}
			}
		}
		return $data;
	}
	/*关闭数据库*/
	public function close(){
		$this->db->close();
	}
	/**
	 *增加链式操作
	 */
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
		$sql=" select ".$this->fields." from ".table($this->table)." ";
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

?>