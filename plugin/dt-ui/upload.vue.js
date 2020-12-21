Vue.component('sky-upload',{
	props:{
		upname:"",
		filename:"",
		truefile:""
	},
	data:function(){
		return {
			ufilename:"",
			utruefile:""
		}
	},
	created:function(){
		
	},
	methods:{
		clickFile:function(upname){
			$("#"+upname).click();
		},
		upFile:function(e){
			var src, url = window.URL || window.webkitURL || window.mozURL,
				files = e.target.files;
				var that=this;
			for (var i = 0, len = files.length; i < len; ++i) {
				var file = files[i];
			
				if (url) {
					src = url.createObjectURL(file);
				} else {
					src = e.target.result;
				}
				lrz(file, {
						width: 1024
					}).then(function(rst) {
			
						$.post("/index.php?m=upload&a=base64", {
								content: rst.base64,
								tablename: "mod_shopmap",
								object_id: 0,
								inimgs: 0,
							},
							function(data) {
								console.log(data);
								that.utruefile=data.trueimgurl;
								that.ufilename=data.imgurl;
						 
							}, "json")
					})
					.catch(function(err) {
						console.log(err)
					})
			
			}
		}
	},
	template:`,
		<div class="upimg-box bg-fff">
			<div v-if="utruefile!=''" class="upimg-item">
				<img :src="utruefile" class="upimg-img" >								 
			</div>	
			<div @click="clickFile(upname)" class="upimg-btn">
				<i class="upimg-btn-icon"></i>
			</div>
			<input type="hidden" :value="ufilename" :name="upname" class="imgurl" />
			<input @change="upFile" style="display: none;" type="file" name="upimg" :id="upname" /> 
		</div> 
	`
})