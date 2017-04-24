<?php echo $this->fetch('library/user_header.lbi'); ?>
<ul class="nav nav-tabs" role="tablist">
    <li><a href="<?php echo url('User/account_detail');?>" ><?php echo $this->_var['lang']['add_surplus_log']; ?></a></li>
    <li><a href="<?php echo url('User/account_points');?>" ><?php echo $this->_var['lang']['view_points']; ?></a></li>
    
    <li><a href="<?php echo url('User/account_log');?>" ><?php echo $this->_var['lang']['view_application']; ?></a></li>

	<li><a href="<?php echo url('User/account_raply');?>" ><?php echo $this->_var['lang']['surplus_type_1']; ?></a></li>
	<li class="active"><a href="<?php echo url('User/account_change');?>" ><?php echo $this->_var['lang']['surplus_type_6']; ?></a></li>
	
	<!--<li><a href="<?php echo url('User/integral_raply');?>" ><?php echo $this->_var['lang']['surplus_type_99']; ?></a></li>-->
	<!--<li><a href="<?php echo url('User/account_deposit');?>" ><?php echo $this->_var['lang']['surplus_type_0']; ?></a></li>-->
	
	<?php if ($this->_var['user_type'] == 2 || $this->_var['user_type'] == 3 || $this->_var['info']['vip_type'] == 2): ?>
	<li><a href="<?php echo url('User/integral_deposit');?>" ><?php echo $this->_var['lang']['surplus_type_3']; ?></a></li>
	<?php endif; ?>
	<li><a href="<?php echo url('User/account_jewel');?>" ><?php echo $this->_var['lang']['surplus_type_4']; ?></a></li>
	<li><a href="<?php echo url('User/transfer');?>" ><?php echo $this->_var['lang']['surplus_type_5']; ?></a></li>
	
  </ul>
<form action="<?php echo url('user/act_account');?>" method="post" name="theForm" onSubmit="return submitSurplus()">
  <div class="ect-bg-colorf flow-consignee">
    <ul class="o-info">
      <li>
        <div class="input-text" style="text-align: center;">
        	<b class="pull-left" style="line-height: 30px;margin-left: 15vw;">方案一金积分</b>
          	<div class="integral_2_fa" id="integral_one">选择</div>
        </div>
      </li>
      
       <li style="padding: 1em 0.6em 2.3em;" id="duihuan">
     	
     	<div class="input-text" style="height: 10vw;">
      	  <span  style="left: 15vw;">
      		<input name="integral_1" id="duihuan_ip"  placeholder="金积分" type="text" class="inputBg_touch" value="" style="width: 20%;border: 1px solid #ccc;padding: 5px;height: 8vw;margin-top: 3vw;"/>
          </span>
          <a style="display: inline-block;position:absolute ; left: 13%;top: 12vw;font-size: 12px;" class="integral_1_ye">总积分数：<?php echo $this->_var['info']['integral']; ?></a>
          <div style="display: inline-block;position:absolute ; right: 45%;"> <img src="themes/default/images/gt.png" alt="" />  </div>
          <div style="display: inline-block;position:absolute ; left: 63%;top: 4vw">余额:<a id="integral_1_ye" class="duihuan_ye"></a></div>
         
      	</div>
     	
     </li>
      <li>
        <div class="input-text" style="text-align: center;">
        	<b class="pull-left" style="line-height: 30px;margin-left: 15vw;">方案二金积分</b>
          	<div class="integral_2_fa"  id="integral_two">选择</div>
        </div>
      </li>
    
     
     <li style="padding: 1em 0.6em 2.3em;" id="duihuan1">
     	
     	<div class="input-text" style="height: 10vw;">
      	  <span style="left: 15vw;">
      		<input name="integral_2" id="duihuan1_ip"  placeholder="金积分" type="text" class="inputBg_touch" value="" style="width: 20%;border: 1px solid #ccc;height: 8vw;;padding: 5px;margin-top: 3vw;"/>
          </span>
          <a style="display: inline-block;position:absolute ; left: 13%;top:12vw;font-size: 12px;" class="integral_1_ye">总积分数：<?php echo $this->_var['info']['pay_points_2']; ?></a>
          <div style="display: inline-block;position:absolute ; right: 45%;"> <img src="themes/default/images/gt.png" alt="" />  </div>
          <div style="display: inline-block;position:absolute ; left: 63%;top: 4vw">余额:<a id="integral_1_ye" class="duihuan1_ye"></a></div>
         
      	</div>
     	
     </li>
     
      <li>
        <div class="input-text" style="text-align: center;">
        	<b class="pull-left" style="line-height: 30px;margin-left: 15vw;">方案三金积分</b>
          	<div class="integral_2_fa"  id="integral_sev">选择</div>
        </div>
      </li>
    
     
     <li style="padding: 1em 0.6em 2.3em;" id="duihuan2">
     	
     	<div class="input-text" style="height: 10vw;">
      	  <span style="left: 15vw;">
      		<input name="integral_3" id="duihuan2_ip"  placeholder="金积分" type="text" class="inputBg_touch" value="" style="width: 20%;border: 1px solid #ccc;height: 8vw;;padding: 5px;margin-top: 3vw;"/>
          </span>
          <a style="display: inline-block;position:absolute ; left: 13%;top:12vw;font-size: 12px;" class="integral_1_ye">总积分数：<?php if ($this->_var['info']['pay_points_3']): ?><?php echo $this->_var['info']['pay_points_3']; ?><?php else: ?>0<?php endif; ?></a>
          <div style="display: inline-block;position:absolute ; right: 45%;"> <img src="themes/default/images/gt.png" alt="" />  </div>
          <div style="display: inline-block;position:absolute ; left: 63%;top: 4vw">余额:<a id="integral_1_ye" class="duihuan2_ye"></a></div>
        
      	</div>
     	 <p style="text-align: center; color: red;font-size: 18px;font-weight: 700;display: none;">请输入550的倍数</p>
     </li>
      	
      
     
      
      <li class="input-text"><b class="pull-left"><?php echo $this->_var['lang']['process_notic']; ?>：</b>
        <textarea name="user_note" placeholder="" type="text"><?php echo htmlspecialchars($this->_var['order']['user_note']); ?></textarea>
      </li>
    </ul>
  </div>
  <div class="two-btn ect-padding-tb ect-padding-lr ect-margin-tb text-center">
  <input type="hidden" name="change_type" value="1" id="change_type"/>
 	
  <input type="hidden" name="surplus_type" value="6" />
    <input type="submit" name="submit"  class="btn btn-info"  value="确认兑换"/>
    <input type="reset" name="submit"  class="btn btn-info ect-bg-colory"  value="<?php echo $this->_var['lang']['button_reset']; ?>"/>
  </div>
</form>

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
//      	function zuidi(){
//      		var zdjf=$('#zuidijifen').val();
//      		var yu=zdjf%100;
//      		var msg='';
//      		if(zdjf<100){
//      			msg +=' - 提现金积分最低为100 \n';
//      		}
//      		if(yu!=0){
//      			msg +=' - 提现金积分必须为100的倍数 \n';
//      		}
//      		if(msg){
//      			$('#zuidijifen').val(0);
//      			alert(msg)
//      		}
//      	}
/*******************************************************************************
 * 会员余额申请
 */
function submitSurplus() {

	var frm = document.forms['theForm'];
	
	var surplus_type = frm.elements['surplus_type'].value;
	var user_bank  = frm.elements['user_bank'].value;
  	var user_bank_name  = frm.elements['user_bank_name'].value;
  	var bank_name  = frm.elements['bank_name'].value;
  	
	var surplus_integral = frm.elements['integral'].value;
	var process_notic = frm.elements['user_note'].value;
	var payment_id = 0;
	var msg = '';

	
	if (surplus_integral.length == 0) {
		alert('请输入您要操作的金额数量');
		return false;
	} else {
		var reg = /^[\.0-9]+/;
		if (!reg.test(surplus_integral)) {
			msg += '请输入金额的正确格式' + '\n';
		}
	}
	
	if(surplus_integral<=0){
		msg += '请输入正确金额' + '\n';
	}
	
	if(user_bank.length == 0 )
	{
		msg += ' - 请输入银行账户' +"\n";
	}
	if(bank_name.length == 0 )
	{
		msg += ' - 请输入开户银行' +"\n";
	}
	if(user_bank_name.length == 0 )
	{
		msg += ' - 请输入账户姓名' +"\n";
	}

	if("<?php echo $this->_var['user_bank']['content']; ?>" == false||"<?php echo $this->_var['bank_name']['content']; ?>"== false||"<?php echo $this->_var['user_bank_name']['content']; ?>" == false){
		msg += ' - 请在个人资料中绑定银行账户' +"\n";
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

<script type="text/javascript">
	$("#integral_one").on("click",function(){
		$(this).toggleClass("integral_1_fa");	
		if($("#duihuan").css("display") == "none"){
			$("#duihuan").slideToggle("show");	
			$("#duihuan1").slideUp("show");
			$("#duihuan2").slideUp("show");
			$("#integral_two").removeClass("integral_1_fa");
			$("#integral_sev").removeClass("integral_1_fa");
		}
		$("#duihuan1_ip").val("");
		$(".duihuan1_ye").html("");
		$("#duihuan2_ip").val("");
		$(".duihuan2_ye").html("");
		
		$("#change_type").val(1)
	})
	
	$("#integral_two").on("click",function(){
		$(this).toggleClass("integral_1_fa");
		
		if($("#duihuan1").css("display") == "none"){
			$("#duihuan1").slideToggle("show");	
			$("#duihuan").slideUp("show");
			$("#duihuan2").slideUp("show");
			$("#integral_one").removeClass("integral_1_fa");
			$("#integral_sev").removeClass("integral_1_fa");
		}
		
		$("#duihuan_ip").val("");
		$(".duihuan_ye").html("");
		$("#duihuan2_ip").val("");
		$(".duihuan2_ye").html("");
		
		$("#change_type").val(2)
	})
	
	$("#integral_sev").on("click",function(){
		$(this).toggleClass("integral_1_fa");
		
		if($("#duihuan2").css("display") == "none"){
			$("#duihuan2").slideToggle("show");	
			$("#duihuan1").slideUp("show");
			$("#duihuan").slideUp("show");
			$("#integral_one").removeClass("integral_1_fa");
			$("#integral_two").removeClass("integral_1_fa");
		}
		$("#duihuan_ip").val("");
		$(".duihuan_ye").html("");
		$("#duihuan1_ip").val("");
		$(".duihuan1_ye").html("");
		
		$("#change_type").val(3)
	})
	
	
	$("#duihuan_ip").keyup(function(){
		
		var a = $("#duihuan_ip").val()*.94;
		var b=a.toFixed(2);
		$(".duihuan_ye").html(b)
		var r = /^\+?[1-9][0-9]*$/;
		if(r.test($("#duihuan_ip").val())){
			if($("#duihuan_ip").val() > <?php echo $this->_var['info']['integral']; ?>){
				$("#duihuan_ip").val("");
				$(".duihuan_ye").html("");
				alert("输入积分大于剩余积分")
			}
		}else{
			$("#duihuan_ip").val("");
			$(".duihuan_ye").html("");
			alert("请输入整数")
		}
	});
	
	$("#duihuan1_ip").keyup(function(){
		
		var a = $("#duihuan1_ip").val()*.87;
		var b=a.toFixed(2);
		$(".duihuan1_ye").html(b)
		var r = /^\+?[1-9][0-9]*$/;
		if(r.test($("#duihuan1_ip").val())){
			 if($("#duihuan1_ip").val() > <?php echo $this->_var['info']['pay_points_2']; ?>){
			 	$("#duihuan1_ip").val("");
			 	$(".duihuan1_ye").html("");
				alert("输入积分大于剩余积分")
			}
			
		}else{
			$("#duihuan1_ip").val("");
			$(".duihuan1_ye").html("");
			alert("请输入整数")
		}
	});
	
	$("#duihuan2_ip").keyup(function(){
		
		var a = $("#duihuan2_ip").val()*.87;
		var b=a.toFixed(2);
		$(".duihuan2_ye").html(b)
		var r = /^\+?[1-9][0-9]*$/;
		if(r.test($("#duihuan2_ip").val())){
			 if($("#duihuan2_ip").val() > <?php echo $this->_var['info']['pay_points_3']; ?>){
			 	$("#duihuan2_ip").val("");
			 	$(".duihuan2_ye").html("");
				alert("输入积分大于剩余积分")
			}
			
		}else{
			$("#duihuan2_ip").val("");
			$(".duihuan2_ye").html("");
			alert("请输入整数")
		}
		
	});
	
	
</script>