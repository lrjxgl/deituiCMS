<!DOCTYPE >
<html>
<?php echo $this->fetch('head.html'); ?>
<body>
<?php echo $this->fetch('header.html'); ?>
<div class="main-body">
    <div style="width:600px; text-align:center; margin: 0 auto; background-color:#C4E6A2; margin-top:100px; height:400px; line-height:40px; ">
     
    
    <?php $_from = $this->_var['who']; if (!is_array($_from) && !is_object($_from)) { $_from=array();}; $this->push_vars('', 'w');if (count($_from)):
    foreach ($_from AS $this->_var['w']):
?>
    <?php echo $this->_var['w']; ?><br>
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    
    <?php echo $this->_var['hook_indata']; ?><br>
    <?php echo $this->_var['hook_redata']; ?><br>
    <?php echo $this->_var['skins']; ?>
    </div>

</div>
<?php echo $this->fetch('footer.html'); ?>
</body>

</html>