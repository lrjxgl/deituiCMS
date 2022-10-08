Vue.component("user-login",{
	props:{
		showLogin:false
	},
	data:function(){
		return {
			telephone:"",
			nickname:"",
			password:"",
			password2:"",
			yzm:"",
			page:"login",
			reg_invitecode:"",
			invitecode:"",
			loginShow:false
		}
	},
	created:function(){
		this.loginShow=this.showLogin;
		this.getReg();
	},
	watch:{
		showLogin:function(n,o){
			this.loginShow=n;
			
		}
	},
	methods:{
		hideLogin:function(){
			this.loginShow=false;
			this.$emit("call-parent",false)
		},
		loginSuccess:function(){
			this.loginShow=false;
			this.$emit("login-success",true)
		},
		getReg:function(){
			var that=this;
			$.ajax({
				url:"/index.php?m=register&ajax=1",
				dataType:"json",
				success:function(res){
					that.reg_invitecode=res.data.reg_invitecode;
				}
			})
		},
		setPage:function(p){
			this.page=p;
		},
		loginSubmit:function(){
			var that=this;
			$.ajax({
				url:"/index.php?m=login&a=save&ajax=1",
				dataType:"json",
				type:"POST",
				data:{
					telephone:that.telephone,
					password:that.password
				},
				success:function(res){
					if(res.error){
						skyToast(res.message)
						return false;
					}
					that.loginSuccess()
				}
			})
		},
		regSubmit:function(){
			var that=this;
			$.ajax({
				url:"/index.php?m=register&a=regsave&ajax=1",
				dataType:"json",
				type:"POST",
				data:{
					telephone:that.telephone,
					password:that.password,
					password2:that.password2,
					yzm:that.yzm,
					nickname:that.nickname,
					invitecode:that.invitecode
				},
				success:function(res){
					if(res.error){
						skyToast(res.message)
						return false;
					}
					that.loginSuccess()
				}
			})
		},
		findPwdSubmit:function(){
			var that=this;
			$.ajax({
				url:"/index.php?m=login&a=FindPwdSave&ajax=1",
				dataType:"json",
				type:"POST",
				data:{
					telephone:that.telephone,
					password:that.password,
					password2:that.password2,
					yzm:that.yzm
				},
				success:function(res){
					if(res.error){
						skyToast(res.message)
						return false;
					}
					that.setPage('login')
				}
			})
		},
		sendPwdSms:function(){
			var that=this;
			$.ajax({
				url:"/index.php?m=login&a=sendSms&ajax=1",
				dataType:"json",
				data:{
					telephone:that.telephone
				},
				success:function(res){
					skyToast(res.message)
				}
			})
		},
		sendRegSms:function(){
			var that=this;
			$.ajax({
				url:"/index.php?m=register&a=sendSms&ajax=1",
				dataType:"json",
				data:{
					telephone:that.telephone
				},
				success:function(res){
					skyToast(res.message)
				}
			})
		}
	},
	template:`
	<div v-if="loginShow">
		<div v-if="page=='login'">
			<div class="">
				<div class="modal-mask"></div>
				<div class="modal" style="margin-top: -24rem;">
					<div class="modal-header">
						<div class="modal-title">用户登录</div>
						<div @click="hideLogin()" class="modal-close icon-close"></div>
					</div>
					<div>
						<div class="input-flex">
							<div class="input-flex-label">手机</div>
							<input type="text" class="input-flex-text" v-model="telephone" placeholder="请输入手机号码" />
						</div>
						<div class="input-flex">
							<div class="input-flex-label">密码</div>
							<input type="password" class="input-flex-text" v-model="password" type="text" placeholder="请输入密码"  />
						</div>
						<div class="row-box">
							<div class="btn-row-submit" @click="loginSubmit">登录</div>
							<div class="flex pdl-10 pdr-10">
								<a class="cl2 mgb-10" @click="setPage('findpwd')">找回密码</a>
								<div class="flex-1"></div>
								<a class="mgb-10 cl2"  @click="setPage('reg')">立即注册</a>
								
							</div>
						</div>
						 
						<div class=" mgb-20">
							<div class="bd-mp-10"></div>
							<div class="pdl-10">其它方式登录</div>
						</div>
						<div class="flex flex-center mgb-20">
							<div gourl="/index.php?m=open_weixin&a=Geturl&backurl={$backurl|urlencode}" class="btn btn-round bg-success iconfont icon-weixin"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div v-else-if="page=='reg'">
			<div class="modal-mask"></div>
			<div class="modal" style="margin-top: -28rem;">
				<div class="modal-header">
					<div @click="setPage('login')" class="modal-back icon-back"></div>
					<div class="modal-title">用户注册</div>
					<div @click="hideLogin()" class="modal-close icon-close"></div>
				</div>
				 
				<form id="regForm"  class="mgb-20">
				
				<div class="input-flex">
					<div class="input-flex-label">手机</div>
					<input class="input-flex-text" v-model="telephone" placeholder="请输入手机号码" />
				</div>
				<div class="input-flex">					
					<div class="input-flex-label">验证码</div>					 
					<input type="text" v-model="yzm" class="input-flex-text">				 
					<div class="input-flex-btn" @click="sendRegSms()">获取验证码</div>
				</div>
				<div class="input-flex">
					<div class="input-flex-label">昵称</div>
					<input class="input-flex-text" v-model="nickname" placeholder="请输入昵称" />
				</div>
				<div class="input-flex">
					<div class="input-flex-label">密码</div>
					<input class="input-flex-text" v-model="password" type="password" placeholder="请输入密码" type="password" />
				</div>
				<div class="input-flex">
					<div class="input-flex-label">重复密码</div>
					<input class="input-flex-text" v-model="password2" placeholder="请再次输入密码" type="password" />
				</div>
				 
				<div v-if="reg_invitecode!=''" class="input-flex">
					<div class="input-flex-label">邀请码</div>
					<input class="input-flex-text" v-model="invitecode" placeholder="请输入邀请码" />
				</div>
				 
				<div class="row-box">
					<button type="button" @click="regSubmit()" class="btn-row-submit">立即注册</button>
					<div class="flex-center">
						<a class="mgb-10 cl2" @click="setPage('login')" >已有账号？立即登录</a>
						
					</div>
				</div>
				</form>
			</div>	
		</div> 
		<div v-else>
			<div class="modal-mask"></div>
			<div class="modal" style="margin-top: -24rem;">
				<div class="modal-header">
					<div @click="setPage('login')" class="modal-back icon-back"></div>
					<div class="modal-title">找回密码</div>
					<div @click="hideLogin()" class="modal-close icon-close "></div>
				</div>
				 
				<form id="fdForm" class="mgb-20">
					<div class="input-flex">
						<div class="input-flex-label">手机</div>
						<input class="input-flex-text" v-model="telephone" placeholder="请输入手机号码" />
					</div>
					<div class="input-flex">					
						<div class="input-flex-label">验证码</div>					 
						<input type="text" v-model="yzm" class="input-flex-text">				 
						<div class="input-flex-btn" @click="sendPwdSms">获取验证码</div>
					</div>
				 
					<div class="input-flex">
						<div class="input-flex-label">密码</div>
						<input class="input-flex-text" v-model="password" type="password" placeholder="请输入密码" type="password" />
					</div>
					<div class="input-flex">
						<div class="input-flex-label">重复密码</div>
						<input class="input-flex-text" v-model="password2" placeholder="请再次输入密码" type="password" />
					</div>
					<div class="btn-row-submit" @click="findPwdSubmit()">确认修改</div>
				</form>
			</div>	
		</div>
	</div>
	`
})