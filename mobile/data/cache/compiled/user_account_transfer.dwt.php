<?php echo $this->fetch('library/user_header.lbi'); ?>
<ul class="nav nav-tabs" role="tablist">
    <li><a href="<?php echo url('User/account_detail');?>" ><?php echo $this->_var['lang']['add_surplus_log']; ?></a></li>
    <li><a href="<?php echo url('User/account_log');?>" ><?php echo $this->_var['lang']['view_application']; ?></a></li>
    <li><a href="<?php echo url('User/account_points');?>" ><?php echo $this->_var['lang']['view_points']; ?></a></li>
	<li><a href="<?php echo url('User/account_raply');?>" ><?php echo $this->_var['lang']['surplus_type_1']; ?></a></li>
	<li><a href="<?php echo url('User/integral_raply');?>" ><?php echo $this->_var['lang']['surplus_type_99']; ?></a></li>
	<!--<li><a href="<?php echo url('User/account_deposit');?>" ><?php echo $this->_var['lang']['surplus_type_0']; ?></a></li>-->
	<?php if ($this->_var['user_type'] == 2 || $this->_var['user_type'] == 3): ?>
	<li ><a href="<?php echo url('User/integral_deposit');?>" ><?php echo $this->_var['lang']['surplus_type_3']; ?></a></li>
	<?php endif; ?>
	<li><a href="<?php echo url('User/account_jewel');?>" ><?php echo $this->_var['lang']['surplus_type_4']; ?></a></li>
	<li class="active"><a href="<?php echo url('User/transfer');?>" ><?php echo $this->_var['lang']['surplus_type_5']; ?></a></li>
  </ul>
<form action="<?php echo url('user/act_account');?>" method="post" name="theForm"  enctype="multipart/form-data"  onSubmit="return submitSurplus()">
  <div class="ect-bg-colorf flow-consignee">
    <ul class="o-info">
      <li>
        <div class="input-text"><b class="pull-left">转账积分：</b><span>
          <input id="vr" name="amount"  placeholder="1元人民币等于100金元宝" type="text" class="inputBg_touch amount" value="<?php echo htmlspecialchars($this->_var['order']['amount']); ?>" />
          </span></div>
      </li>

       <li id="content_text" style="display: ;">
       	<div class="input-text"><b class="pull-left">好友账户：</b><span>
       		<input type="text" placeholder="请输入好友账户的用户名"  name="rest_user_name" value=""/>
            <input type="hidden"  name="user_type" value="2"/>
       		
       	</li>
       	 <li id="content_text" style="display: ;">
       	<div class="input-text"><b class="pull-left">验证手机：</b><span>
       		<input type="text" readonly  name="mobile_phone" value="<?php echo $this->_var['info']['mobile_phone']; ?>"/><a class="yazm" onclick="dianji2('tra_code')" style="float: right;position: relative;top: -25px;border: 1px solid #e1e1e1;padding: 3px;">获取验证码</a>
       	</li>
       	<li id="content_text" style="display: ;">
       	<div class="input-text"><b class="pull-left">验&nbsp;&nbsp;证&nbsp;&nbsp;码：</b><span>
       		<input type="text"   name="mobile_code" value=""/>
       	</li>

   
      <li class="input-text"><b class="pull-left"><?php echo $this->_var['lang']['process_notic']; ?>：</b>
        <textarea name="user_note" placeholder="<?php echo $this->_var['lang']['process_notic']; ?>" type="text"><?php echo htmlspecialchars($this->_var['order']['user_note']); ?></textarea>
      </li>
    </ul>
  </div>
  
  <div class="two-btn ect-padding-tb ect-padding-lr ect-margin-tb text-center">
   <input type="hidden" name="surplus_type" value="5" />
          <input type="hidden" name="rec_id" value="<?php echo $this->_var['order']['id']; ?>" />
          <input type="hidden" name="act" value="act_account" />
          <input type="hidden" name="session" value="tra_code" />
          
    <input type="submit" name="submit"  class="btn btn-info"  value="确认转账"/>
    <input type="reset" name="submit"  class="btn btn-info ect-bg-colory"  value="<?php echo $this->_var['lang']['button_reset']; ?>"/>
  </div>
</form>
<script type="text/javascript" src="__PUBLIC__/js/jquery.min.js" ></script> 

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
<script type="text/javascript">
 		var k = true;
	  	var seconds = 60;
	    function getdate(){
	    	k= false;
	        seconds--;
	         $(".yazm").text(seconds+"s后重新发送");
	         $(".yazm").css({"background":"#ccc"});
	    }
	
	   function sss(){
	      if(seconds<=1){
	      	k=true;
	         $(".yazm").text("重新发送");
	         $(".yazm").css({"background":"#fff"});
	        return;
	      }
	     getdate();
	     var set = setTimeout(sss,1000); 
	   }
	   function dianji2(session){

	  	if(k==true){
	  		$.ajax({
	  			type:"post",
				url:"<?php echo url('user/get_code');?>",
				data:'mobile_phone='+<?php echo $this->_var['info']['mobile_phone']; ?>+'&session='+session,
				dataType:"text",
				async:true
	  		});
	  		seconds =60;
	  		sss(); 		
	  	}else{  		
	  		return;
	  	}
	  	 	
	  }
		        	/*******************************************************************************
 * 会员余额申请
 */
function submitSurplus() {
	var frm = document.forms['theForm'];
	var surplus_type = frm.elements['surplus_type'].value;
	var surplus_amount = frm.elements['amount'].value;
	var rest_user_name = frm.elements['rest_user_name'].value;
	var mobile_code = frm.elements['mobile_code'].value;
	
	var process_notic = frm.elements['user_note'].value;
	var payment_id = 0;
	var msg = '';

	if (surplus_amount.length == 0) {
		alert('请输入您要操作的积分数量');
		return false;
	} else {
		var reg = /^[\.0-9]+/;
		if (!reg.test(surplus_amount)) {
			msg += surplus_amount_error + '\n';
		}
	}
if(surplus_amount<=0){
	alert('积分必须大于零');
		return false;
}
	if(rest_user_name.length == 0){
		alert('请输入您转账对象的用户名');
		return false;
	}
	if(mobile_code.length == 0){
		alert('请输入验证码');
		return false;
	}


	if (msg.length > 0) {
		alert(msg);
		return false;
	}

	return true;
}
</script>
<?php echo $this->fetch('library/nav.lbi'); ?>
</body></html>