<div class="pd-10">扩展属性</div>
				 <?php $_from = $this->_var['fieldsList']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
				 <?php if ($this->_var['c']['fieldtype'] == 'text'): ?>
				 <div class="input-flex">
				 	<div class="input-flex-label"><?php echo $this->_var['c']['title']; ?></div>
				 	<input class="input-flex-text" type="text" name="tablefield[<?php echo $this->_var['c']['fieldname']; ?>]" value="<?php echo $this->_var['c']['value']; ?>" />
				 </div>
				 <?php elseif ($this->_var['c']['fieldtype'] == 'textarea'): ?>
				 <div class="textarea-flex">
				 	<div class="textarea-flex-label"><?php echo $this->_var['c']['title']; ?></div>
				 	<textarea name="tablefield[<?php echo $this->_var['c']['fieldname']; ?>]" class="textarea-flex-text h60"><?php echo $this->_var['c']['value']; ?></textarea>
				 </div>
				 <?php elseif ($this->_var['c']['fieldtype'] == 'html'): ?>
				 <div class="textarea-flex">
				 	<div class="textarea-flex-label"><?php echo $this->_var['c']['title']; ?></div>
				 	<div class="js-html-item">
				 		<textarea name="tablefield[<?php echo $this->_var['c']['fieldname']; ?>]" class="none js-html-textarea"><?php echo $this->_var['c']['value']; ?></textarea>
				 		<div contenteditable="true" class="sky-editor-content textarea-flex-text "><?php echo $this->_var['c']['value']; ?></div>
				 	</div>
				 </div>
				 <?php elseif ($this->_var['c']['fieldtype'] == 'img'): ?>
				 <div class="input-flex">
				 	<div class="input-flex-label"><?php echo $this->_var['c']['title']; ?></div>
				 	<div class="flex-1">
				 		<div class="js-upload-item">
				 			<input type="file" id="tablefield<?php echo $this->_var['c']['id']; ?>" class="js-upload-file" style="display: none;" />
				 			<div class="upimg-btn js-upload-btn">+</div>
				 			<input type="hidden" name="tablefield[<?php echo $this->_var['c']['fieldname']; ?>]" class="js-imgurl" value="<?php echo $this->_var['c']['value']; ?>" />
				 			<div class="js-imgbox">
				 				<?php if ($this->_var['c']['value']): ?>
				 				<img src="<?php echo images_site($this->_var['c']['value']); ?>.100x100.jpg" class="w60" />
				 				<?php endif; ?>
				 			</div>
				 		</div>
				 	</div>
				 </div>
				 <?php elseif ($this->_var['c']['fieldtype'] == 'map'): ?>
				 <div class="bg-white">
				 	<div class="pd-10"><?php echo $this->_var['c']['title']; ?></div>
				 	<div class="js-map">
				 		<input type="hidden" class="map-value"  name="tablefield[<?php echo $this->_var['c']['fieldname']; ?>]"  value="<?php echo $this->_var['c']['value']; ?>" />
				 		<div class="flex mgb-5 pdl-10">
				 			<input type="text" id="mapWord" />
				 			<div id="mapSearch" class="input-flex-btn">搜一下</div>
				 		</div>
				 		<div class="map" id="map" style="width: 100%; height: 300px;"></div>
				 	</div>
				 </div> 
				 <?php endif; ?>
				 <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>