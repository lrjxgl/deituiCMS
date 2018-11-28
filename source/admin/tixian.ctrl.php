<?php
class tixianControl extends skymvc{
	public $sw=" 1 ";
 	private $admin;
	public function __construct(){
		parent::__construct();	
		 
	
	}
	public function onInit(){
		$this->admin=M("login")->getAdmin();
	}
	
	public function onDefault(){
		$limit=20;
		$where= $this->sw;
		$url=APPADMIN."?m=tixian";
		$start=get('per_page','i');
		$type=get("type","h");
		switch($type){
			case "finish":
				$where=" status=3 ";
				break;
			case "confirm":
				$where=" status=1";
				break;
			case "all":
				$where=" status<11";
				break;
			default:
				$where=" status=0 ";
				break;
		}
		$stime= get("stime",'h');
		if($stime){
			$stime=strtotime($stime." 00:00:01");
			$where.=" AND dateline>='{$stime}' ";
		}
		$etime=get('etime','h');
		if($etime){
			$etime=strtotime($etime." 00:00:01");
			$where.=" AND dateline<='{$etime}'";
		}
		$yhk_huming=get("yhk_huming",'h');
		if($yhk_huming){
			$where.=" AND yhk_huming='$yhk_huming' ";
		}
		$option=array(
			"start"=>$start,
			"limit"=>$limit,
			"order"=>"id DESC",
			"where"=>$where,
		);
		$rscount=true;
		$data=M("tixian")->select($option,$rscount);
		$statuslist=M("tixian")->status_list();
		if($data){
			foreach($data as $k=>$v){
				$v['status_name']=$statuslist[$v['status']];
				
				$data[$k]=$v;
			}
		}
		$pagelist=$this->pagelist($rscount,$limit,$url);
		 
		$this->smarty->assign(array(
			"data"=>$data,
		 
		));
		$this->smarty->display("tixian/index.html");
	}
	
	
	public function onShow(){
		$id=get('id','i');
		$data=M("tixian")->selectRow("id=".$id); 
		$statuslist=M("tixian")->status_list();
		$data['status_name']=$statuslist[$data['status']];
		$this->smarty->assign(array(
			"data"=>$data
		));
		$this->smarty->display("tixian/show.html");
	}
	
	/**
	*订单确认
	*/
	public function onConfirm(){
		$id=get_post('id','i');
		$data=M("tixian")->selectRow(array("where"=>"id=".$id));
		if(empty($data)) $this->goall("参数出错",1);
		M("tixian")->update(array("status"=>1),"id=".$id);
		$content=post('content');
		M('tixian_log')->insert(array(
			"dateline"=>time(),
			"admin_id"=>$this->admin['id'],
			"order_id"=>$id,
			"content"=>$content,
		));
		 
		$this->goall("确认成功");
	}
	 
	/**
	*订单发送
	*/
	public function onSend(){
		$id=get_post('id','i');
		$data=M("tixian")->selectRow(array("where"=>"id=".$id));
		if(empty($data)) $this->goall("参数出错",1);
		if($data['status']<2){
			M("tixian")->update(array("status"=>2),"id=".$id);
		}
		$content=post('content');
		M('tixian_log')->insert(array(
			"dateline"=>time(),
			"admin_id"=>$this->admin['id'],
			"order_id"=>$id,
			"content"=>$content,
		));
		$this->goall("支付成功");
	}
	
	/**
	*订单完成
	*/
	public function onFinish(){
		$id=get_post('id','i');
		$data=M("tixian")->selectRow(array("where"=>"id=".$id));
		if(empty($data)) $this->goall("参数出错",1);
		M("tixian")->update(array("status"=>3),"id=".$id);
		$content=post('content');
		M('tixian_log')->insert(array(
			"dateline"=>time(),
			"admin_id"=>$this->admin['id'],
			"order_id"=>$id,
			"content"=>$content,
		));
		
		$this->goall("订单完成");
	}
	
	/**
	*取消订单
	*/
	 	
	public function onCancel(){
		$id=get_post('id','i');
		$data=M("tixian")->selectRow(array("where"=>"id=".$id));
		if(empty($data)) $this->goall("参数出错",1);
		if($data['status']>=3) $this->goall("操作失败",1);
		M("tixian")->update(array("status"=>10),"id=".$id);
		$content=post('content');
		$message=post('message','h');
		M('tixian_log')->insert(array(
			"dateline"=>time(),
			"admin_id"=>$this->admin['id'],
			"order_id"=>$id,
			"content"=>$content."，原因：".$message,
		));
		
		$this->goall("取消成功");
	}

	public function onDelete(){
		$id=get_post('id','i');
		$data=M("tixian")->selectRow(array("where"=>"id=".$id));
		if(empty($data)) $this->goall("参数出错",1);
		if($data['status']!=0 && $data['status']!=10 ) $this->goall("操作失败",1);
		M("tixian")->update(array("status"=>99),"id=".$id);
		$content=post('content');
		$message=post('message','h');
		M('tixian_log')->insert(array(
			"dateline"=>time(),
			"admin_id"=>$this->admin['id'],
			"order_id"=>$id,
			"content"=>$content."，原因：".$message,
		));
		$this->goall("订单删除");
	}	
	
	public function onExcel(){
		require "PHPExcel/Classes/PHPExcel.php";
		$where="1";
		$type=get("type","h");
		switch($type){
			case "finish":
				$where=" status=3 ";
				break;
			case "confirm":
				$where=" status=1";
				break;
			case "all":
				$where=" status<11";
				break;
			default:
				$where=" status=0 ";
				break;
		}
		$stime= get("stime",'h');
		if($stime){
			$stime=strtotime($stime." 00:00:01");
			$where.=" AND dateline>='{$stime}' ";
		}
		$etime=get('etime','h');
		if($etime){
			$etime=strtotime($etime." 00:00:01");
			$where.=" AND dateline<='{$etime}'";
		}
		$yhk_huming=get("yhk_huming",'h');
		if($yhk_huming){
			$where.=" AND yhk_huming='$yhk_huming' ";
		}
		$data=M("tixian")->select(array(
			"where"=>$where,
			"fields"=>"*",
			"order"=>" id ASC"
		));
		if(empty($data)){
			$this->goAll("数据为空",1);
		}
		$objPHPExcel = new PHPExcel();
		/*
		 * excel导出结构
		 * yhk_huming，yhk_name,yhk_haoma,yhk_address，telephone，money,status
		 */
		$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', '账户名称')
            ->setCellValue('B1', '银行名称')
            ->setCellValue('C1', '银行号码')
            ->setCellValue('D1', '开户地址')
            ->setCellValue('E1', '联系电话')
            ->setCellValue('F1', '提现金额')
            ->setCellValue('G1', '状态');
            $statuslist=M("tixian")->status_list();
            foreach($data as $k=>$v){
            	$key=$k+2;
            	$status_name=$statuslist[$v['status']];
            	$objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A'.$key, $v['yhk_huming'])
	            ->setCellValue('B'.$key, $v['yhk_name'])
	            ->setCellValue('C'.$key, $v['yhk_haoma'])
	            ->setCellValue('D'.$key, $v['yhk_address'])
	            ->setCellValue('E'.$key, $v['telephone'])
	            ->setCellValue('F'.$key, "￥".$v['money'])
	            ->setCellValue('G'.$key, $status_name)
	            ; 
            }
         
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		$file=date("ymdHis");
		header('Content-Disposition: attachment;filename="'.$file.'.xlsx"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');
		
		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0
		 
		$objWriter->save('php://output');     
	}
	 
}

?>