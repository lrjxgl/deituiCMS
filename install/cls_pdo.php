<?php

class mysql
{
	public $db;
	public	$dbconfig=array();//配置
	public	$charset="utf8";//编码
	public	$testmodel=false;//测试模式 开启后将会输出错误的sql语句 
	public $base;
	public $query=NULL;//最近操作的
	public $sql;
	/**
	*mysql初始化 
	*/
	 public function __construct($data=array("charset"=>"utf8")){
		 
		 if(!defined("TABLE_PRE")){
			 define("TABLE_PRE","");
		 }
		 $this->charset=$data['charset'];
		 if(defined("TESTMODEL") && TESTMODEL==true){
			 $this->testmodel=true;
		 }
		  
		 
	 }
	 
	  
	 /**
	  * 设置参数
	  * $config=array(
	  * 	"master"=>array("localhost","root","password","database"),//主数据库 必须的 以下从数据库非必须
	  * 	"slave"=>array(
	  * 				array("slave1","root","password","database"),
	  * 				array("slave2","root","password","database"),
	  * 			),
	  * )
	  */
	 public function set($config){
		 $this->dbconfig=$config;
	 }
	 /*
	  * 连接mysql
	  * */
	 public function connect($config=array()){
		if(!empty($config)){
			$master=$config;
		}else{
		$master=$this->dbconfig['master'];
		}
	 	$dsn = "mysql:host=".$master['host'].";dbname=".$master['database']."";
		
		try {
			 $this->db = new PDO($dsn, $master['user'], $master['pwd']);
			 $rs=$this->db->prepare("SET sql_mode=''");
			 $rs->execute();
			  $rs=$this->db->prepare("SET NAMES ".$this->charset);
			 $rs->execute();
		} catch ( PDOException $e ) {
			echo  'Connection failed: '  .  $e -> getMessage ();
		}
	 }
	 /**
	  * 执行sql语句
	  */
	 public function query($sql){
		 
		if($this->testmodel){
			$s=microtime(true);
			$GLOBALS['skysqlrun'] .="<br>".$sql;
			$GLOBALS['skysqlnum'] ++;
		}
		$this->sql=$sql;
		if(!$this->db){
			$this->connect();
		}
	 	$this->query=$rs = $this->db->prepare($sql);
		$rs->execute();
		if($this->testmodel){
			$GLOBALS['query_time']+=microtime(true)-$s;
		}
		if($this->errno() >0 ){
			$e=$this->error();
			if(TESTMODEL){
				showError("sql错误：".$sql." ".$e[2]);
				exit;
			}else{
				showError("sql错误");
				exit;
			}
		};
		return $rs;
	 }
	 

	 /**
	  * 返回结果集中的数目
	  */
	public function num_rows(){
		return $this->query-> columnCount ();
	}
	
	/**
	 * 将结果集解析成数组
	 */
	public function fetch_array($result_type=PDO::FETCH_ASSOC){
		$this->query-> setFetchMode ( $result_type );
		return $this->query->fetchAll();	
	}
	
	/**
	 * 从结果集中取一行
	 */
	public function fetch_row($result_type=PDO::FETCH_ASSOC){
		return $this->query->fetch($result_type);	
	}
	
	
	/**
	 * 取得结果集中字段的数目
	 */
	public function num_fields(){
		return $this->query->columnCount ();
	}
	
	/*
	 * 插入数据
	 * */
	public function insert($table,$data){
		$fields=$this->compile_array($data);
		$this->query("INSERT INTO ".TABLE_PRE.$table." SET $fields ", $this->db);
		return $this->insert_id();
	}
	/**
	 * 更新数据
	 */
	public function update($table,$data,$w=""){
		$fields=$this->compile_array($data);
		$where=$w?" WHERE ".$this->compile_array($w," AND"):"";
		$this->query("UPDATE ".TABLE_PRE.$table." SET {$fields} {$where} ", $this->db);
		return $this->affected_rows();
	}
	/**
	 * 删除数据
	 */
	public function delete($table,$w=''){
		$where=$w?" WHERE ".$this->compile_array($w," AND "):"";
		$this->query("DELETE FROM ".TABLE_PRE."$table {$where} ");
		return $this->affected_rows( $this->db);		
	} 
	
	/**
	 * 获取全部数据
	 *array("table","where"=>array(),"order","start","pagesize","fields")
	*/
	public function SELECT($table,$data=array(),&$rscount=false){		
		$start=isset($data['start'])?$data['start']:0;
		$pagesize=isset($data['limit'])?$data['limit']:1000;
		$fields=isset($data['fields'])?$data['fields']:" * ";
		$where=(!isset($data['where']) or empty($data['where']))?"":" where ".$this->compile_array($data['where']," AND ");
		$order=isset($data['order']) && !empty($data['order'])?" ORDER BY ".$data['order']:"";
		if($rscount){
			$rscount=$this->getCount($table,isset($data['where'])?$data['where']:'');
		}
		return $this->getAll("SELECT {$fields} FROM ".TABLE_PRE."{$table}  $where {$order} LIMIT $start,$pagesize ");
		
	}
	/**
	 * 获取一个数据
	 *array("table","where","order","start","pagesize","fields")
	*/
	public function selectOne($table,$data=array()){
		$start=isset($data['start'])?$data['start']:0;
		$pagesize=isset($data['limit'])?$data['limit']:1;
		$fields=isset($data['fields'])?$data['fields']:" * ";
		$where=(!isset($data['where']) or empty($data['where']))?"":" where ".$this->compile_array($data['where']," AND ");
		$order=isset($data['order']) && !empty($data['order'])?" ORDER BY ".$data['order']:"";
		return $this->getOne("SELECT {$fields} FROM ".TABLE_PRE."{$table}  {$where} {$order} LIMIT 1 ");
	}
	/**
	 * 获取一行数据
	 *array("table","where","order","start","pagesize","fields")
	*/
	public function selectRow($table,$data=array()){
		$start=isset($data['start'])?$data['start']:0;
		$pagesize=isset($data['limit'])?$data['limit']:1;
		$fields=isset($data['fields'])?$data['fields']:" * ";
		$where=(!isset($data['where']) or empty($data['where']))?"":" where ".$this->compile_array($data['where']," AND ");
		$order=isset($data['order']) && !empty($data['order'])?" ORDER BY ".$data['order']:"";
		return $this->getRow("SELECT {$fields} FROM ".TABLE_PRE."{$table}  {$where} {$order} LIMIT 1 ");
	}
	/**
	 * 获取一列数据
	 *array("table","where","order","start","pagesize","fields")
	*/	
	public function selectCols($table,$data=array(),&$rscount=false){
		$start=isset($data['start'])?$data['start']:0;
		$pagesize=isset($data['limit'])?$data['limit']:1000;
		$fields=isset($data['fields'])?$data['fields']:" * ";
		$where=(!isset($data['where']) or empty($data['where']))?"":" where ".$this->compile_array($data['where']," AND ");
		$order=isset($data['order']) && !empty($data['order'])?" ORDER BY ".$data['order']:"";
		if($rscount){
			$rscount=$this->getCount($table,isset($data['where'])?$data['where']:'');
		}
		return $this->getCols("SELECT {$fields} FROM ".TABLE_PRE."{$table}  {$where} {$order} LIMIT $start,$pagesize ");
	}
	
	
	
	/**
	 * 获取统计数据
	 */	
	public function getCount($table,$w=array()){
		
		$where=empty($w)?"":" where ".$this->compile_array($w," AND ");
		return $this->getOne("SELECT COUNT(1) FROM ".TABLE_PRE.$table." $where ");
	}
	/**
	 * 获取全部数据
	 */
	public function getAll($sql){
		$res=$this->query($sql);
		if($res!==false)
		{
			$res-> setFetchMode ( PDO :: FETCH_ASSOC );
			$arr=$res->fetchAll();
			return $arr;
		}else
		 {
			return false;
			
		}
	}

	/**
	 * 获取一个字段
	 */
	public function getOne($sql){
		$res=$this->query($sql);
		if($res !==false){
			$rs=$res->fetch();
			if($rs!==false){
				return $rs[0];
			}else{
				return '';
			}
		}
		else {
			return false;
		}
		
	}
		
	/*获取一行*/
	 public function getRow($sql){
        $res = $this->query($sql);
        if ($res !== false){
			$res-> setFetchMode ( PDO :: FETCH_ASSOC );
			$arr=$res->fetch();
            return $arr;
        }else{
            return false;
        }
    }
    /*获取一列*/
    public function getCols($sql)
	{
		$res=$this->query($sql);
		if($res!==false){
			$res-> setFetchMode ( PDO :: FETCH_NUM );

			$data=$res->fetchAll();
			$arr=array();
			if(!empty($data)){
				foreach($data as $v){
					$arr[]=$v[0];
				}
			}
			return $arr;
		}else{
			return false;
		}
	}
	
	/**
	 * 获取影响的行数
	 */
	public function affected_rows(){
	 
		return  $this->query -> rowCount ();
	}
	/*
	 * 最新插入的函数
	 * */
	public function insert_id( ){
        return $this->db->lastInsertId();
    }
	
	/*复制表*/
	public function copy_table($table,$newtable){
		
		$rs=$this->getRow("show create table ".TABLE_PRE."$table ");
		 
		$sql=preg_replace("/CREATE TABLE/i","CREATE TABLE IF NOT EXISTS",$rs['Create Table'],1);
		$sql=str_replace(TABLE_PRE.$table,TABLE_PRE.$newtable,$sql);
		$this->query($sql);
		return true;
	}
	
    /*
     * 获取错误信息
     * */
    public function error($link=null){
        return $this->query->errorInfo();
    }
	/*
	 * 获取错误代号
	 * */
    public function errno($link=null){
        return $this->query->errorCode();
    }
	
	
	 /*
	  * 判断是否查询语句
	  * */
	 public function isselect($sql){ 		
		preg_match("/^[ ]*(select).*/i",$sql,$a);
		if($a)
		{
			return true;
		}else{
			return false;
		}
 
	 }
	/*字符串转义*/ 
	public function newaddslashes($value){
		if(empty($value)){
			return $value;
		}else{
			if(is_array($value)){
				 return array_map('newaddslashes', $value);
			}else{				
				$value=stripslashes($value);
				$value=str_replace("\'","'",$value);  
				$value=str_replace('\"','"',$value);
				$value=addslashes(trim($value));				
				return $value;	
			}
		}	 
	}
	
	public function compile_array($data,$d=","){
		
		$dot=$fields="";
		$i=0;
		if(is_array($data)){ 
			foreach($data as $k=>$v){
				if($i>0) $dot=$d;
				if(preg_match("/[<|>]/",$k)){
					$fields.="$dot {$k}'".$this->newaddslashes($v)."' ";
				}else{
					$fields.="$dot $k='".$this->newaddslashes($v)."' ";
				}
				$i++;	
			}
			return $fields;
		}else{
			return $data;
		}
	}
	
	public function __destruct(){
		 $this->close();
	}
	
	public function close(){
		//$this->db=NULL;
	}
	/*生成md5缓存的key*/
	public function md5key($sql){
		$sql=strtolower($sql);
		$key=md5($sql);
		preg_match("/from (.*) [where]?/is",$sql,$data);
		$table=trim($data[1]);
		return "sql".$table."_".$key;
	}
	 

}	



