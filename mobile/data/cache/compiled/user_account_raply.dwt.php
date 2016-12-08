<?php echo $this->fetch('library/user_header.lbi'); ?>
<ul class="nav nav-tabs" role="tablist">
    <li><a href="<?php echo url('User/account_detail');?>" ><?php echo $this->_var['lang']['add_surplus_log']; ?></a></li>
    <li><a href="<?php echo url('User/account_log');?>" ><?php echo $this->_var['lang']['view_application']; ?></a></li>

	<li class="active"><a href="<?php echo url('User/account_raply');?>" ><?php echo $this->_var['lang']['surplus_type_1']; ?></a></li>
	<li><a href="<?php echo url('User/integral_raply');?>" ><?php echo $this->_var['lang']['surplus_type_2']; ?></a></li>
	<!--<li><a href="<?php echo url('User/account_deposit');?>" ><?php echo $this->_var['lang']['surplus_type_0']; ?></a></li>-->
	
	<li><a href="<?php echo url('User/integral_deposit');?>" ><?php echo $this->_var['lang']['surplus_type_3']; ?></a></li>
	<li><a href="<?php echo url('User/account_jewel');?>" ><?php echo $this->_var['lang']['surplus_type_4']; ?></a></li>
	
  </ul>
<form action="<?php echo url('user/act_account');?>" method="post" name="theForm" onSubmit="return submitSurplus()">
  <div class="ect-bg-colorf flow-consignee">
    <ul class="o-info">
      <li>
        <div class="input-text"><b class="pull-left"><?php echo $this->_var['lang']['repay_money']; ?>：</b><span>
          <input name="amount" placeholder="<?php echo $this->_var['lang']['repay_money']; ?>" type="text" class="inputBg_touch" value="" />
          </span></div>
      </li>
      <li>
        <div class="input-text"><b class="pull-left"><?php echo $this->_var['lang']['user_bank']; ?>：</b><span>
          <input name="user_bank" placeholder="<?php echo $this->_var['lang']['user_bank']; ?>" type="text" class="inputBg_touch" value="" />
          </span></div>
      </li>
      <li>
        <div class="input-text"><b class="pull-left"><?php echo $this->_var['lang']['bank_name']; ?>：</b><span>
          <input name="bank_name" placeholder="<?php echo $this->_var['lang']['bank_name']; ?>" type="text" class="inputBg_touch" value="" />
          </span></div>
      </li>
      <li>
        <div class="input-text"><b class="pull-left"><?php echo $this->_var['lang']['user_bank_name']; ?>：</b><span>
          <input name="user_bank_name" placeholder="<?php echo $this->_var['lang']['user_bank_name']; ?>" type="text" class="inputBg_touch" value="" />
          </span></div>
      </li>
      
     
      <li class="input-text"><b class="pull-left"><?php echo $this->_var['lang']['process_notic']; ?>：</b>
        <textarea name="user_note" placeholder="" type="text"><?php echo htmlspecialchars($this->_var['order']['user_note']); ?></textarea>
      </li>
    </ul>
  </div>
  <div class="two-btn ect-padding-tb ect-padding-lr ect-margin-tb text-center">
  <input type="hidden" name="surplus_type" value="1" />
    <input type="submit" name="submit"  class="btn btn-info"  value="<?php echo $this->_var['lang']['submit_request']; ?>"/>
    <input type="reset" name="submit"  class="btn btn-info ect-bg-colory"  value="<?php echo $this->_var['lang']['button_reset']; ?>"/>
  </div>
</form>
<script type="text/javascript">
	        	/*******************************************************************************
 * 会员余额申请
 */
function submitSurplus() {

	var frm = document.forms['theForm'];
	var surplus_type = frm.elements['surplus_type'].value;
	var surplus_amount = frm.elements['amount'].value;
		var user_bank  = frm.elements['user_bank'].value;
  	var user_bank_name  = frm.elements['user_bank_name'].value;
	var process_notic = frm.elements['user_note'].value;
	var payment_id = 0;
	var msg = '';

	if (surplus_amount.length == 0||surplus_amount==0) {
		alert('请输入您要操作的金额数量');
		
		return false;
	} else {
		var reg = /^[\.0-9]+/;
		if (!reg.test(surplus_amount)) {
			msg += '请输入金额的正确格式' + '\n';
		}
	}
	if(user_bank.length == 0 )
	{
		msg += '请输入银行账户' +"\n";
	}
	if(user_bank_name.length == 0 )
	{
		msg += '请输入账户姓名' +"\n";
	}
	if(msg.length > 0)
	{
		alert(msg);
		return false;
	}
	return true;


}
</script>
</div>
<?php echo $this->fetch('library/search.lbi'); ?> <?php echo $this->fetch('library/page_footer.lbi'); ?> 
<script type="text/javascript" src="__PUBLIC__/js/region.js"></script> 
<script type="text/javascript" src="__PUBLIC__/js/shopping_flow.js"></script> 
<script type="text/javascript">
	region.isAdmin = false;
	<?php $_from = $this->_var['lang']['flow_js']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
	var <?php echo $this->_var['key']; ?> = "<?php echo $this->_var['item']; ?>";
	<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
	
	onload = function() {
	      if (!document.all)
	      {
	        document.forms['theForm'].reset();
	      }
	}
	
</script>
</body></html>