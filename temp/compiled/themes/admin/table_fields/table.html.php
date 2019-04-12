<!DOCTYPE html>
<html>
	<?php echo $this->fetch('head.html'); ?>
	<body>
		<div class="tabs-border">
			<div><?php echo $this->_var['table']['title']; ?>:<?php echo $this->_var['table']['tablename']; ?></div>
			<a href="?m=table_data&tableid=<?php echo $this->_var['table']['tableid']; ?>" class="item">数据列表</a>
			 
			<a href="?m=table_data&a=add&tableid=<?php echo $this->_var['table']['tableid']; ?>" class="item">发布</a>
			<a href="?m=table_fields&a=table&tableid=<?php echo $this->_var['table']['tableid']; ?>" class="item active">表设计</a>
		</div>
		<div class="main-body" style="background-color: #efefef;" id="app">
			<form id="addForm" class="mgb-5">
				<input type="hidden" name="tableid" value="<?php echo $this->_var['table']['tableid']; ?>" />
				<div class="input-flex flex-ai-center">
					<div class="input-flex-label">列名称</div>
					<input class="input-flex-text" type="text" name="title" />
					<div class=""></div>
					<div class="pd-5">列字段</div>
					<input class="w100"  type="text" name="fieldname" />
				 
					<div class="pd-5">类型</div>
					<select name="fieldtype" class="input-flex-select">
						<option v-for="(tt,ttIndex) in pageData.fieldtypeList" :value="ttIndex" :key="ttIndex">{{tt}}</option>
					</select>
					
					<div class="pd-5">排序</div>
					<input class="w60"  type="text" name="orderindex" />
					<div class="pd-5">列表</div>
					<input type="checkbox" name="islist" value="1" />
					<div>属性值</div>
				<div class="btn" @click="save('#addForm')">添加</div>
				</div>
			</form>
			<div class="list">
				<form :id="'addForm'+item.id" v-for="(item,index) in pageData.list" :key="index">
					<input type="hidden" name="tableid" value="<?php echo $this->_var['table']['tableid']; ?>" />
					<input type="hidden" name="id" :value="item.id" />
					<div class="input-flex">
						<div class="input-flex-label">列名称</div>
						<input class="input-flex-text" type="text" :value="item.title" name="title" />
						<div class=""></div>
						<div class="pd-5">列字段</div>
						<input class="w100"  type="text" :value="item.fieldname" name="fieldname" />
					 
						<div class="pd-5">类型</div>
						<select v-model="item.fieldtype" name="fieldtype" class="input-flex-select">
							<option value="">请选择</option>
							<option v-for="(tt,ttIndex) in pageData.fieldtypeList" :value="ttIndex" :key="ttIndex">{{tt}}</option>
						</select>
					 <div class="pd-5">排序</div>
					 <input class="w60"  type="text" :value="item.orderindex" name="orderindex" />
					 <div class="pd-5">列表</div>
					 <input v-model="item.islist" type="checkbox" name="islist" value="1" true-value="1"
  false-value="0" />
					<div class="btn" @click="save('#addForm'+item.id)">保存</div>
					</div>
				</form>
			</div>
			
		</div>
		<?php echo $this->fetch('footer.html'); ?>
		<script>
			var tableid="<?php echo $this->_var['table']['tableid']; ?>";
		</script>
		<script src="/plugin/vue/vue.min.js"></script>
		<script src="<?php echo $this->_var['skins']; ?>table_fields/table.js"></script>
	</body>
</html>
