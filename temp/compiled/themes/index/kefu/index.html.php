<!DOCTYPE html>
<html>
	<?php echo $this->fetch('head.html'); ?>
	<style>
		.w200{
			max-width: 200px;
		}
		.kf-content{
			border:1px solid #eee;
			padding: 5px 8px;
			border-radius: 10px;
			font-size: 14px;
			color: #646464;
			background-color: #fff;
			max-width: 80%;
		}
	</style>
	<body>
		<div class="header">
			<div class="header-back"></div>
			<div class="header-title">客服咨询</div>
		</div>
		<div class="header-row"></div>
		<div class="main-body">
			<div v-if="pageLoad" class="list" id="app">
				 
				<div v-for="(item,index) in pageData.list" :key="index" class="pd-10">
					 
					<div  v-if="item.tablename=='user'">
						<div class="flex">
							<div class="flex-1"></div>
							<div class="cl2">我</div>
						</div>
						<div class="flex">
							<div class="flex-1"></div>
							<div class="kf-content mgr-20">{{item.content}}</div>
						</div>
					</div>
					<div  v-else>
						<div class="cl2 mgb-5">
							
							客服
						</div>
						<div class="kf-content mgl-20">{{item.content}}</div>
				
				 
					</div>
				</div>
	 
			</div>
			<div class="footer-row"></div>
			<div style="position: fixed;bottom: 0;left: 0;right: 0;">
				<div class="input-flex">
					<input type="text" id="content" class="input-flex-text" />
					<div class="input-flex-btn" id="submit">发送</div>
				</div>
			</div>
		</div>
		<?php echo $this->fetch('footer.html'); ?>
		<script src="/plugin/vue/vue.min.js"></script>
		<script>
		 
			var app=new Vue({
				el:"#app",
				data:function(){
					return {
						pageLoad:false,
						pageData:[]
					}
				},
				created:function(){
					this.getPage();
				},
				methods:{
					getPage:function(){
						var that=this;
						$.ajax({
							url:"/index.php?m=kefu&a=data&ajax=1",
							
							dataType:"json",
							success:function(res){
								that.pageLoad=true;
								that.pageData=res.data
								console.log(res.data);
							}
						})
					},
					submit:function(){
						
					}
				}
			})
			$(function(){
				setInterval(function(){
					app.getPage();
				},20000)
				$(document).on("click","#submit",function(){
					var content=$("#content").val();
					$.post("/index.php?m=kefu&a=save&ajax=1",{
						content:content,
					},function(res){
						app.getPage();
						$("#content").val("");
					},"json")
				})
			})
		</script>
	</body>
</html>
