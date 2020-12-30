<?php
	/**
	*Author 雷日锦 362606856@qq.com 
	*控制器自动生成
	*/
	if(!defined("ROOT_PATH")) exit("die Access ");
	class b2c_pintuanControl extends skymvc{
		
		public function __construct(){
			parent::__construct();
			 
		}
		
		public function onDefault(){
			$where=" pt_open=1 AND status=1 ";
			$url="/module.php?m=b2c_product&a=default";
			$limit=20;
			$start=get("per_page","i");
			$catid=get("catid","i");
			if($catid){
				$cids=MM("b2c","b2c_category")->id_family($catid);
				$where.=" AND catid in("._implode($cids).") ";
			}else{
				$where.=" AND isrecommend=1 ";
			}
			$option=array(
				"start"=>$start,
				"limit"=>$limit,
				"order"=>" id DESC",
				"where"=>$where
			);
			$rscount=true;
			$data=M("mod_b2c_product")->select($option,$rscount);
			//分类
			$catList=MM("b2c","b2c_category")->children(0);
			//判断产品是否在购物车
			$userid=M("login")->userid;
			$cartPros=MM("b2c","b2c_cart")->getProductAmount("userid=".$userid." AND ksid=0");
			if($data){
				foreach($data as $k=>$v){
					$v["incart"]=0;
					$v["cart_amount"]=0;
					$v["imgurl"]=images_site($v["imgurl"]);
					if($cartPros && isset($cartPros[$v["id"]])){
						$v["incart"]=1;
						$v["cart_amount"]=$cartPros[$v['id']];
					} 
					$data[$k]=$v;
				}
			}
			$per_page=$start+$limit;
			$per_page=$per_page>$rscount?0:$per_page;
			$pagelist=$this->pagelist($rscount,$limit,$url);
			$this->smarty->goassign(
				array(
					"list"=>$data,
					"per_page"=>$per_page,
					"pagelist"=>$pagelist,
					"catList"=>$catList,
					"rscount"=>$rscount,
					"url"=>$url
				)
			);
			$this->smarty->display("b2c_pintuan/index.html");
			
			
		}
		
		public function onList(){
			$where=" status in(0,1,2)";
			$url="/module.php?m=b2c_product&a=default";
			$limit=20;
			$start=get("per_page","i");
			$catid=get("catid","i");
			if($catid){
				$cids=MM("b2c","b2c_category")->id_family($catid);
				$where.=" AND catid in("._implode($cids).") ";
			}
			
			
			$option=array(
				"start"=>$start,
				"limit"=>$limit,
				"order"=>" id DESC",
				"where"=>$where
			);
			$rscount=true;
			$data=M("mod_b2c_product")->select($option,$rscount);
			//分类
			$cat=MM("b2c","b2c_category")->selectRow(array(
				"where"=>"catid=".$catid,
				"fields"=>"catid,title,pid"
			));
			$catList=MM("b2c","b2c_category")->children($catid);
			
			 
			
			//判断产品是否在购物车
			$userid=M("login")->userid;
			$cartPros=MM("b2c","b2c_cart")->getProductAmount("userid=".$userid." AND ksid=0");
			if($data){
				foreach($data as $k=>$v){
					$v["incart"]=0;
					$v["cart_amount"]=0;
					$v["imgurl"]=images_site($v["imgurl"]);
					if($cartPros && isset($cartPros[$v["id"]])){
						$v["incart"]=1;
						$v["cart_amount"]=$cartPros[$v['id']];
					} 
					$data[$k]=$v;
				}
			}
			$per_page=$start+$limit;
			$per_page=$per_page>$rscount?0:$per_page;
			$pagelist=$this->pagelist($rscount,$limit,$url);
			$this->smarty->goassign(
				array(
					"cat"=>$cat,
					"catList"=>$catList,
					"list"=>$data,
					"per_page"=>$per_page,
					"pagelist"=>$pagelist,
					"rscount"=>$rscount,
					"url"=>$url
				)
			);
			$this->smarty->display("b2c_pintuan/list.html");
		}
		
		public function onShow(){
			$id=get_post("id","i");
			$data=MM("b2c","b2c_product")->selectRow(array("where"=>"id=".$id));
			$data["imgurl"]=images_site($data["imgurl"]);
			$data["content"]=M("mod_b2c_product_data")->selectOne(array(
				"where"=>"id=".$id,
				"fields"=>"content"
			));
			//款式
			$ksid=0;
			
			$ksList=MM("b2c","b2c_product_ks")->getListByTitle($id);
			if($ksList){
				$ks=$ksList[0];
				$ksid=$ks["id"];
				$ksList2=MM("b2c","b2c_product_ks")->select(array(
					"where"=>" productid=".$ks['productid']." AND title='".$ks['title']."' "
				));
				$data["price"]=$ks["price"];
			}
			$cart_amount=0;
			$userid=M("login")->userid;
			$cart=MM("b2c","b2c_cart")->selectRow("userid=".$userid." AND productid=".$id." AND ksid=".$ksid);
			if($cart){
				$cart_amount=$cart["amount"];
			}
			$url=HTTP_HOST."/module.php?m=b2c_product&a=show&id=".$id;
			$sharePic=HTTP_HOST."/index.php?m=gd&a=ShareProduct&imgurl=".$data["imgurl"]."&title=".urlencode($data["title"])."&price=".$data["price"]."&url=".urlencode($url);
			//拼团订单相关
			$orderid=get_post("orderid","i");
			$order=M("mod_b2c_order")->selectRow(array(
				"where"=>"orderid=".$orderid
			));
			
			$this->smarty->goassign(array(
				"data"=>$data,
				"ksid"=>$ksid,
				"sharePic"=>$sharePic,
				"cart_amount"=>$cart_amount,
				"ksList"=>$ksList,
				"ksList2"=>$ksList2,
				"order"=>$order
			));
			$tpl=M("pagetpl")->get("b2c_pintuan","show");
			$this->smarty->display($tpl);
		}
		
		public function onInvite(){
			$orderid=get("orderid","i");
			$order=MM("b2c","b2c_order")->selectRow("orderid=".$orderid);
			//获取拼团人数
			$need_num=0;
			$pt_ewm="";
			if($order["ispin"]){
				$product=MM("b2c","b2c_product")->selectRow(array(
					"where"=>"id=".$order["productid"],
					"fields"=>"pt_open,pt_min"
				));
				if($order["pin_orderid"]){
					$ptorderid=$order["pin_orderid"];
					$ptorder=MM("b2c","b2c_order")->selectRow("orderid=".$order["pin_orderid"]);
					$need_num=$product["pt_min"]-$ptorder["pin_num"];
				}else{
					$need_num=$product["pt_min"]-$order["pin_num"];
					$ptorderid=$orderid;
				}
				
				$pturl=HTTP_HOST."/module.php?m=b2c_product&a=show&id=".$order["productid"]."&orderid=".$ptorderid;
				$pt_ewm=HTTP_HOST."/index.php?m=qrcode&content=".urlencode($pturl)."&title=".urlencode("快来和我一起拼团吧");
			}
			
			$this->smarty->goAssign(array(
				"need_num"=>$need_num,
				"order"=>$order,
				"pt_ewm"=>$pt_ewm
			));
			$this->smarty->display("b2c_pintuan/invite.html");
		}
	}

?>