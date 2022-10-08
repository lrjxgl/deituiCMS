Vue.compents("tab-select",{
	props:{
		
	},
	data:function(){
		return {
			tabShow:false,
		}
	},
	created:function(){
		
	},
	methods:function(){
		
	},
	template:`
		<div>
			<div @click="tabShow=tabShow?false:true;tabShow=false;" class="flex flex-center">
				<span class="mgr-5">{{cat_label}}</span>
				<span class="iconfont f12 icon-godown"></span>
			</div>
			<div v-if="tabCatShow" class="tabs-absox">
				<div class="bd-mp-5" @click="setCat(0,'类别')" >全部类别</div>
				<div class="bd-mp-5" @click="setCat(item.catid,item.title)" v-for="(item,index) in catList" :key="index">
					{{item.title}}
				</div>
			</div>
		</div>
	`
})