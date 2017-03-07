<?php echo $this->fetch('library/user_header.lbi'); ?>
<ul class="nav nav-tabs" role="tablist">
    <li><a href="<?php echo url('User/account_detail');?>" ><?php echo $this->_var['lang']['add_surplus_log']; ?></a></li>
    <li><a href="<?php echo url('User/account_points');?>" ><?php echo $this->_var['lang']['view_points']; ?></a></li>
    
    <li><a href="<?php echo url('User/account_log');?>" ><?php echo $this->_var['lang']['view_application']; ?></a></li>

	<li><a href="<?php echo url('User/account_raply');?>" ><?php echo $this->_var['lang']['surplus_type_1']; ?></a></li>
	<!--<li><a href="<?php echo url('User/integral_raply');?>" ><?php echo $this->_var['lang']['surplus_type_99']; ?></a></li>-->
	<li><a href="<?php echo url('User/account_change');?>" ><?php echo $this->_var['lang']['surplus_type_6']; ?></a></li>
	<!--<li><a href="<?php echo url('User/account_deposit');?>" ><?php echo $this->_var['lang']['surplus_type_0']; ?></a></li>-->
	<?php if ($this->_var['user_type'] == 2 || $this->_var['user_type'] == 3): ?>
	<li class="active"><a href="<?php echo url('User/integral_deposit');?>" ><?php echo $this->_var['lang']['surplus_type_3']; ?></a></li>
	<?php endif; ?>
	<li><a href="<?php echo url('User/account_jewel');?>" ><?php echo $this->_var['lang']['surplus_type_4']; ?></a></li>
	<li><a href="<?php echo url('User/transfer');?>" ><?php echo $this->_var['lang']['surplus_type_5']; ?></a></li>
	
  </ul>
<form action="<?php echo url('user/act_account');?>" method="post" name="theForm"  enctype="multipart/form-data"  onSubmit="return submitSurplus()">
  <div class="ect-bg-colorf flow-consignee">
    <ul class="o-info">
      <li>
        <div class="input-text"><b class="pull-left">消费金额：</b><span>
          <input id="vr" name="amount_user"  placeholder="1元人民币等于100金元宝" type="text" class="inputBg_touch amount_user" value="<?php echo htmlspecialchars($this->_var['order']['amount']); ?>" />
          </span></div>
      </li>
      <li id="vr_user_tr" style="display: ;" >
              <div class="input-text"><b class="pull-left">实际金额：</b><span>
              <input id="vr_user" readonly name="amount" placeholder="实际金额" type="text" class="inputBg_touch amount" value="<?php echo htmlspecialchars($this->_var['order']['amount']); ?>" />
          </span></div>
      </li>
     <?php if ($this->_var['user_type'] == 2 || $this->_var['user_type'] == 3): ?>
     <!--<li>
        <div class="input-text"><b class="pull-left">充值对象：</b><span>
          	<input type="radio" id="anniu1" checked="checked" name="user_type" value="1"/>给自己充&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
       		<input type="radio" id="anniu2" name="user_type" value="2"/>给好友充
          </span></div>
      </li>-->
       <li id="content_text" style="display: ;">
       	<div class="input-text"><b class="pull-left">好友账户：</b><span>
       		<input type="text" placeholder="请输入好友账户的用户名" name="rest_user_name" value=""/>
            <input type="hidden"  name="user_type" value="2"/>
       		
       	</li>
      <?php else: ?>
            <input type="hidden"  name="user_type" value="1"/>
            <?php endif; ?>
      <li class="input-text" id="stub" style="display: none;position: relative;"><b class="pull-left" style="position: absolute;top: 63%;margin-top: -21px;">上传票据：</b>
      		<!--<input type="button" name="" value="点击上传图片" id="scdj"/>
			<input type="file" name="stub" id="scpj"  style="display:none"/>-->
			<div id="preview">
                <img id="imghead" border="0" src="themes/default/images/photo_icon.png" width="90" height="90" onclick="$('#previewImg').click();">
             </div>         
            <input type="file" name="stub" onchange="previewImage(this)" style="display: none;" id="previewImg">
      </li>
      <li id="content_text" style="display: ;">
       	<div class="input-text"><b class="pull-left">选择方案：</b><span>
       		<input type="radio" placeholder="" checked  name="precept" id="precept" class="precept" value="1"/>方案一
       		<input type="radio" placeholder=""   name="precept" class="precept" value="2"/>方案二
       		
       	</li>
       	<li style="text-align: center;background: #e1e1e1;padding:1em 4.6em;line-height: 26px;text-align: left;" id="ms">
       			1、前一天总营业额的12%作为次日消费奖励总额。</br>
				2、按剩余总额的万分之六左右每天全额奖励，后续消费叠加。</br>
				3、最终解释权归成都沃尔迅科技有限公司所有。
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
   <input type="hidden" name="surplus_type" value="3" />
          <input type="hidden" name="rec_id" value="<?php echo $this->_var['order']['id']; ?>" />
          <input type="hidden" name="act" value="act_account" />
    <input type="submit" name="submit"  class="btn btn-info"  value="<?php echo $this->_var['lang']['submit_request']; ?>"/>
    <input type="reset" name="submit"  class="btn btn-info ect-bg-colory"  value="<?php echo $this->_var['lang']['button_reset']; ?>"/>
  </div>
</form>
<script type="text/javascript" src="__PUBLIC__/js/jquery.min.js" ></script> 
<script type="text/javascript" src="__TPL__/js/img_pre.js" ></script> 
<script type="text/javascript">

		   
	$("#vr").keyup(function(){
//		alert($(".precept").val())
		if($("#precept").is(":checked")){
			var a= $("#vr").val()*0.15;
			
		}else{
			var a= $("#vr").val()*0.21;
			
		}
		var b=a.toFixed(2);
		$("#vr_user").val(b)
	});
	
	$(".precept").click(function(){

		if($(this).val() == 1){
			var a= $("#vr").val()*0.15;
			$("#ms").html(
				"1、前一天总营业额的12%作为次日消费奖励总额。"+"</br>"+
				"2、按剩余总额的万分之六左右每天全额奖励，后续消费叠加。"+"</br>"+
				"3、最终解释权归成都沃尔迅科技有限公司所有。"
			)
		}else{
			var a= $("#vr").val()*0.21;
			$("#ms").html(
				"1、前一天总营业额的12%作为次日消费奖励总额。"+"</br>"+
				"2、800天左右全额奖励(单笔消费)。"+"<br />"+
//				"3、客户累计消费额400元以上方可参与活动(不含400元)。"+"<br />"+
//				"4、消费者向平台缴纳5%的平台服务费，参与(800天改变生活)活动，享受消费额全额奖励(5%平台服务费不参与全额奖励)。"+"<br />"+
//				"5、参与活动商家向平台缴纳16%的返还押金，按系统规则给予全额奖励。"+"<br />"+
//				"6、原定金钻会员的推荐奖励按原规则减半进行奖励。"+"<br />"+
//				"7、原定普通会员的推荐奖励全部取消。"+"<br />"+
				"3、最终解释权归成都沃尔迅科技有限公司所有。"
			)
		}
		var b=a.toFixed(2);
		$("#vr_user").val(b)
	})
	
	$("#vr").on('keyup',function(){
		if($(".amount").val()>=1500){
			$("#stub").css('display','block')
		}else{
			$("#stub").css('display','none')
		}
	})
	
	
	$("#scdj").on("click",function(){
		$("#scpj").click();
	})
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
		        	/*******************************************************************************
 * 会员余额申请
 */
function submitSurplus() {
	var frm = document.forms['theForm'];
	var surplus_type = frm.elements['surplus_type'].value;
	var surplus_amount = frm.elements['amount'].value;
	var surplus_stub = frm.elements['stub'].value;
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

	if(surplus_amount>=1500){
		if(surplus_stub==false){
			msg +='- 请上传票据 \n';
			msg +='- 充值金额大于1500RMB时请上传票据 \n';
		}
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