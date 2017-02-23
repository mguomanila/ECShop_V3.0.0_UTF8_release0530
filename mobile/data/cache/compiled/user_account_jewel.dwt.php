<?php echo $this->fetch('library/user_header.lbi'); ?>
<ul class="nav nav-tabs" role="tablist">
    <li><a href="<?php echo url('User/account_detail');?>" ><?php echo $this->_var['lang']['add_surplus_log']; ?></a></li>
    <li><a href="<?php echo url('User/account_points');?>" ><?php echo $this->_var['lang']['view_points']; ?></a></li>
    
    <li><a href="<?php echo url('User/account_log');?>" ><?php echo $this->_var['lang']['view_application']; ?></a></li>

	<li><a href="<?php echo url('User/account_raply');?>" ><?php echo $this->_var['lang']['surplus_type_1']; ?></a></li>
	<!--<li><a href="<?php echo url('User/integral_raply');?>" ><?php echo $this->_var['lang']['surplus_type_99']; ?></a></li>-->
	<li><a href="<?php echo url('User/account_change');?>" ><?php echo $this->_var['lang']['surplus_type_6']; ?></a></li>
	<!--<li class="active"><a href="<?php echo url('User/account_deposit');?>" ><?php echo $this->_var['lang']['surplus_type_0']; ?></a></li>-->
	
	<?php if ($this->_var['user_type'] == 2 || $this->_var['user_type'] == 3): ?>
	<li><a href="<?php echo url('User/integral_deposit');?>" ><?php echo $this->_var['lang']['surplus_type_3']; ?></a></li>
	<?php endif; ?>
	<li  class="active"><a href="<?php echo url('User/account_jewel');?>" ><?php echo $this->_var['lang']['surplus_type_4']; ?></a></li>
	<li><a href="<?php echo url('User/transfer');?>" ><?php echo $this->_var['lang']['surplus_type_5']; ?></a></li>
	
  </ul>
<form action="<?php echo url('user/act_account');?>" method="post" name="theForm" onSubmit="return submitSurplus()">
  <div class="ect-bg-colorf flow-consignee">
    <ul class="o-info">
    	<li>
        <div class="input-text">
        	<b class="pull-left">升级类型：</b>
        	<span>
        		&nbsp;&nbsp;
        		<input type="radio" class="jinzuan" checked="checked" name="sj_type" value="1" style="opacity: 0;"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
       			&nbsp;&nbsp;&nbsp;
       			<input type="radio" class="vip" name="sj_type" value="2" style="opacity: 0;"/>
        	</span>
          	
        </div>
        <div id="sjhy_box">
        	<span>
        		<a href="#" class="jinzuan_a">金钻</a>
        		<a href="#" class="vip_a">VIP</a>
        	</span>
        </div>
      </li>
      <li>
        <div class="input-text"><b class="pull-left">应付金额：</b><span>
          <p class="yfje">￥1280元</p>
          <input type="hidden" name="amount" value="1280" readonly  class="yfje_input"/>
          </span></div>
      </li>
     <li id="user_type" >
        <div class="input-text"><b class="pull-left">充值对象：</b><span>
          	<input type="radio" class="anniu" checked="checked" name="user_type" value="1"/>给自己充&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
       		<input type="radio" class="anniu" name="user_type" value="2"/>给好友充
          </span></div>
      </li>
      <li id="content_text" style="display:none ;">
       	<div class="input-text"><b class="pull-left">好友账户：</b><span>
       		<input type="text" placeholder="请输入好友账户的用户名" name="rest_user_name" value=""/>
       	</li>
       
      <li class="input-text"><b class="pull-left"><?php echo $this->_var['lang']['process_notic']; ?>：</b>
        <textarea name="user_note" placeholder="<?php echo $this->_var['lang']['process_notic']; ?>" type="text"><?php echo htmlspecialchars($this->_var['order']['user_note']); ?></textarea>
      </li>
    </ul>
  </div>
  <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#dddddd" class="table table-bordered">
            <tr align="center">
              <td bgcolor="#ffffff"  colspan="3" align="left"><?php echo $this->_var['lang']['payment']; ?>:</td>
            </tr>
            <tr align="center">
              <td bgcolor="#ffffff"><?php echo $this->_var['lang']['pay_name']; ?></td>
              <td bgcolor="#ffffff" width="60%"><?php echo $this->_var['lang']['pay_desc']; ?></td>
              <td bgcolor="#ffffff" width="17%"><?php echo $this->_var['lang']['pay_fee']; ?></td>
            </tr>
            <?php $_from = $this->_var['payment']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');if (count($_from)):
    foreach ($_from AS $this->_var['list']):
?>
            <tr>
              <td bgcolor="#ffffff" align="left">
			  <ul class="ect-radio">
            <li>
              <input name="payment_id" type="radio" id="zf<?php echo $this->_var['list']['pay_id']; ?>" value="<?php echo $this->_var['list']['pay_id']; ?>">
              <label for="zf<?php echo $this->_var['list']['pay_id']; ?>"><i></i></label><?php echo $this->_var['list']['pay_name']; ?>
            </li>
          </ul></td>
              <td bgcolor="#ffffff" align="left" for="zf<?php echo $this->_var['list']['pay_id']; ?>"><?php echo $this->_var['list']['pay_desc']; ?></td>
              <td bgcolor="#ffffff" align="center"><?php echo $this->_var['list']['pay_fee']; ?></td>
            </tr>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </table>
  <div class="two-btn ect-padding-tb ect-padding-lr ect-margin-tb text-center">
   <input type="hidden" name="surplus_type" value="4" class="surplus_type"/>
          <input type="hidden" name="rec_id" value="<?php echo $this->_var['order']['id']; ?>" />
          <input type="hidden" name="act" value="act_account" />
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

	var process_notic = frm.elements['user_note'].value;
	var payment_id = 0;
	var msg = '';

	if (surplus_amount.length == 0) {
		alert('请输入您要操作的金额数量');
		return false;
	} else {
		var reg = /^[\.0-9]+/;
		if (!reg.test(surplus_amount)) {
			msg += surplus_amount_error + '\n';
		}
	}
	

	if (process_notic.length == 0) {
		msg += process_desc + "\n";
	}

	if (msg.length > 0) {
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
	<script type="text/javascript">
       		$(".anniu").click(function(){

			if($(this).val() == 2){

				$("#content_text").css("display",'block')
			}else{

				$("#content_text").css("display",'none')
				
			}

		})
	 </script>
	    	
	   <script type="text/javascript">
	   		$(".jinzuan").on("click",function(){
	   			$(".jinzuan_a").css({"background":"#e87e04","color":"#fff"});
	   			$(".vip_a").css({"background":"none","color":"#000"});
	   			$(".yfje").html("￥1280元");
	   			$(".yfje_input").val("1280");
	   			$(".surplus_type").val("4")
//	   			$("#content_text").css("display",'block')
				$("#user_type").css("display",'block')
	   		})
	   		
	   		$(".vip").on("click",function(){
	   			$(".vip_a").css({"background":"#e87e04","color":"#fff"});
	   			$(".jinzuan_a").css({"background":"none","color":"#000"});
	   			$(".yfje").html("￥10元");
	   			$(".yfje_input").val("10");
				$("#content_text").css("display",'none')
				$("#user_type").css("display",'none')
	   			
	   			$(".surplus_type").val("7")
	   		})
	   </script>
<?php echo $this->fetch('library/nav.lbi'); ?>
</body></html>