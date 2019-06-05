<!DOCTYPE html>
<html>
	<?php echo $this->fetch('head.html'); ?>
	<body>
		<div class="header">
			<div class="header-back"></div>
			<div class="header-title">我的收藏</div>
		</div>
		<div class="header-row"></div>
		<div class="main-body">
			<div id="app">
				<div v-if="pageLoad">
					<div class="sglist">
						<div :gourl="'/module.php?m=forum&a=show&id='+item.id" class="sglist-item" v-for="(item,index) in pageData.list" :key="index">
							<div class="sglist-title">{{item.title}}</div>
							<div class="sglist-desc">
							{{item.description}}
							
							</div>
							<div class="sglist-imglist">
								 
								<img v-for="(img,imgindex) in item.imgslist" :key="imgindex" :src="img+'.100x100.jpg'" class="sglist-imglist-img" />
								 
							</div> 
							 
						</div>
					</div>
					<div @click="loadMore" class="loadMore">点我加载更多...</div>
				</div>
			</div>
			 
		</div>
		<?php echo $this->fetch('footer.html'); ?>
		<script>
			var tablename="mod_forum";
			var per_page=0;
			var isFirst=false;
			var Vm=new Vue({
				el:"#app",
				data:function(){
					return {
						pageLoad:false,
						pageData:{}
					}
				},
				created:function(){
					this.getList();
				},
				methods:{
					getList:function(){
						var that=this;
						$.ajax({
							url:"/module.php?m=forum_fav&a=mylist&tablename="+tablename+"&ajax=1",
							dataType:"json",
							success:function(res){
								that.pageLoad=true;
								that.pageData=res.data;
								per_page=res.data.per_page;
								isFirst=false;
							}
						})
						 
					},
					loadMore:function(){
						var that=this;
						if(!isFirst && per_page==0) return false;
						$.ajax({
							url:"/module.php?m=forum_fav&a=mylist&tablename="+tablename+"&ajax=1",
							data:{
								per_page:per_page
							},
							dataType:"json",
							success:function(res){
								var pageData=that.pageData;
								var list=pageData.list;
								for(var i in res.data.list){
									list.push(res.data.list[i]);
								}
								that.pageData=pageData;
							}
						})
					 
					},
					del:function(id){
						var that=this; 
						var id=id;
						$.ajax({
							url:"/module.php?m=forum_fav&a=delete&tablename="+tablename+"&ajax=1&id="+id,
							dataType:"json",
							success:function(res){
								var list=that.pageData.list;
								var nlist=[];
								for(var i=0;i<list.length;i++){
									if(list[i].id!=id){
										nlist.push(list[i]);
									}
								}
								console.log(list.length);
								var pageData=that.pageData;
								pageData.list=nlist;
								that.pageData=pageData;
							}
						})
						
					}
				}
			});
			
			 
		</script>
	</body>
</html>
