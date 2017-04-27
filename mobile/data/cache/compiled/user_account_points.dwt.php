<?php echo $this->fetch('library/user_header.lbi'); ?>
<ul class="nav nav-tabs" role="tablist">
    <li ><a href="<?php echo url('User/account_detail');?>" ><?php echo $this->_var['lang']['add_surplus_log']; ?></a></li>
    <li class="active"><a href="<?php echo url('User/account_points');?>" ><?php echo $this->_var['lang']['view_points']; ?></a></li>
    
    <li><a href="<?php echo url('User/account_log');?>" ><?php echo $this->_var['lang']['view_application']; ?></a></li>

	<li><a href="<?php echo url('User/account_raply');?>" ><?php echo $this->_var['lang']['surplus_type_1']; ?></a></li>
	<!--<li><a href="<?php echo url('User/integral_raply');?>" ><?php echo $this->_var['lang']['surplus_type_99']; ?></a></li>-->
	<li><a href="<?php echo url('User/account_change');?>" ><?php echo $this->_var['lang']['surplus_type_6']; ?></a></li>
	<!--<li><a href="<?php echo url('User/account_deposit');?>" ><?php echo $this->_var['lang']['surplus_type_0']; ?></a></li>-->
	
	<?php if ($this->_var['user_type'] == 2 || $this->_var['user_type'] == 3 || $this->_var['info']['vip_type'] == 2): ?>
	<li><a href="<?php echo url('User/integral_deposit');?>" ><?php echo $this->_var['lang']['surplus_type_3']; ?></a></li>
	<?php endif; ?>
	<li><a href="<?php echo url('User/account_jewel');?>" ><?php echo $this->_var['lang']['surplus_type_4']; ?></a></li>
	<li><a href="<?php echo url('User/transfer');?>" ><?php echo $this->_var['lang']['surplus_type_5']; ?></a></li>
	
  </ul>
  
 <div class="user-account-detail">
  	<ul class=" ect-bg-colorf">
     <?php $_from = $this->_var['account_log']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['item']):
?>
    	<li>
        	<p class="title"><span class="pull-left"><?php echo $this->_var['item']['change_time']; ?></span> <span class="pull-right"><?php if ($this->_var['item']['points'] != 0): ?><?php echo $this->_var['item']['points']; ?><?php elseif ($this->_var['item']['points_2'] != 0): ?><?php echo $this->_var['item']['points_2']; ?><?php elseif ($this->_var['item']['points_3'] != 0): ?><?php echo $this->_var['item']['points_3']; ?><?php else: ?><?php echo $this->_var['item']['points_4']; ?><?php endif; ?></span></p>
            <p class="content"><span class="remark pull-left"><?php echo $this->_var['item']['short_change_desc']; ?></span> <span class="pull-right text-right type"><?php echo $this->_var['item']['type']; ?></span></p>
        </li>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </ul>

  </div>
   <?php echo $this->fetch('library/page.lbi'); ?>
</div>
<?php echo $this->fetch('library/nav.lbi'); ?>
<?php echo $this->fetch('library/search.lbi'); ?>
<?php echo $this->fetch('library/page_footer.lbi'); ?>
</body>
</html>