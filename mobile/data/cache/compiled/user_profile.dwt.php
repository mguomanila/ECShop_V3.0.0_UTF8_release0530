<?php echo $this->fetch('library/user_header.lbi'); ?> 
<script type="text/javascript">
	  <?php $_from = $this->_var['lang']['profile_js']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
		var <?php echo $this->_var['key']; ?> = "<?php echo $this->_var['item']; ?>";
	  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
	  
	</script>
<form name="formEdit"  id="myform" action="<?php echo url('user/profile');?>" method="post" enctype="multipart/form-data" onSubmit="return userEdit();">
	<div class="grbox">
		<div class="grzl grjh">
			<a>个人资料</a>
		</div>
		<div class="yhk">
			<a>银行账户</a>
		</div>
	</div>
  <section class="flow-consignee ect-bg-colorf" style="display: ;">
    <ul class="grul grblock">
      <li>
        <div class="input-text"><b class="pull-left" ><?php echo $this->_var['lang']['email']; ?>：</b><span>
          <input name="email" type="text" placeholder="<?php echo $this->_var['lang']['no_emaill']; ?>"  value="<?php echo $this->_var['profile']['email']; ?>">
          </span></div>
      </li>
      <li>
        <div class="input-text"><b class="pull-left" ><?php echo $this->_var['lang']['sex']; ?>：</b><span>
        	<input type="radio" name="sex" value="0" <?php if ($this->_var['profile']['sex'] == 0): ?>checked="checked"<?php endif; ?> />
        	 <?php echo $this->_var['lang']['secrecy']; ?>&nbsp;&nbsp;
          <input type="radio" name="sex" value="1" <?php if ($this->_var['profile']['sex'] == 1): ?>checked="checked"<?php endif; ?> />
          <?php echo $this->_var['lang']['male']; ?>&nbsp;&nbsp;
          <input type="radio" name="sex" value="2" <?php if ($this->_var['profile']['sex'] == 2): ?>checked="checked"<?php endif; ?> />
        <?php echo $this->_var['lang']['female']; ?>&nbsp;&nbsp;  
        </span></div>
      </li>
      
      <?php $_from = $this->_var['extend_info_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'field');if (count($_from)):
    foreach ($_from AS $this->_var['field']):
?> 
      <?php if ($this->_var['field']['id'] == 6): ?>
      <!--<li>
        <div class="form-select"> <i class="fa fa-sort"></i>
          <select name="sel_question">
            <option value='0'><?php echo $this->_var['lang']['sel_question']; ?></option>
            
            <?php echo $this->html_options(array('options'=>$this->_var['passwd_questions'],'selected'=>$this->_var['profile']['passwd_question'])); ?>
          
          </select>
        </div>
      </li>
      <li>
        <div class="input-text"><b class="pull-left"  <?php if ($this->_var['field']['is_need']): ?> id="extend_field<?php echo $this->_var['field']['id']; ?>i"<?php endif; ?>><?php echo $this->_var['lang']['passwd_answer']; ?>:</b> <span>
          <input placeholder="<?php echo $this->_var['lang']['passwd_answer']; ?>" name="passwd_answer" type="text" value="<?php echo $this->_var['profile']['passwd_answer']; ?>" />
          </span></div>
      </li>-->
      <?php elseif ($this->_var['field']['id'] == 103 || $this->_var['field']['id'] == 104 || $this->_var['field']['id'] == 105): ?>
      <?php elseif ($this->_var['field']['id'] == 106): ?>
    
		<li style="height: 95px">
        <div class="input-text">
        	<b class="pull-left" <?php if ($this->_var['field']['is_need']): ?>id="extend_field<?php echo $this->_var['field']['id']; ?>i"<?php endif; ?>><?php echo $this->_var['field']['reg_field_name']; ?>:</b>
        	<span id="preview" class="preview">

         
                <img id="imghead" border="0" src="themes/default/images/photo_icon.png" width="90" height="90" style="margin-left: 0;" onclick="$('#previewImg').click();">
                    

        </span>
            <input type="file" name="extend_field<?php echo $this->_var['field']['id']; ?>" onchange="previewImage(this)" style="display: none;" id="previewImg">
        </div>
     </li>
     <script type="text/javascript" src="__TPL__/js/img_pre.js" ></script> 
      <?php else: ?>
      <li>
        <div class="input-text"><b class="pull-left" <?php if ($this->_var['field']['is_need']): ?>id="extend_field<?php echo $this->_var['field']['id']; ?>i"<?php endif; ?>><?php echo $this->_var['field']['reg_field_name']; ?>:</b><span>
          <input name="extend_field<?php echo $this->_var['field']['id']; ?>" type="text" <?php if ($this->_var['field']['id'] == 5): ?>readonly id="mobile" class="mobile ccc"<?php endif; ?> value="<?php echo $this->_var['field']['content']; ?>" placeholder="<?php echo $this->_var['field']['reg_field_name']; ?>">

        </span>
        <?php if ($this->_var['field']['id'] == 5): ?> <p style="float: right;position: relative;z-index: 100;" class="exph">更换手机</p><?php endif; ?>
        </div>
      </li>

 			
 		
			
 			 
 			
      <?php endif; ?> 
      <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
      
      
      <li style="overflow: inherit;">
          <div class="input-text"><b class="pull-left" >所在地区：</b>
          	<span style="position: relative;display: block;left: 1em;">
	          	<select name="province" id="province" onchange="show_sub(this.options[this.options.selectedIndex].value)" style="float: left;margin-right: .5em;margin-bottom: .3em;">
								<option value="0">请选择省</option>
								<?php $_from = $this->_var['province']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'vo');if (count($_from)):
    foreach ($_from AS $this->_var['vo']):
?>
								<option value="<?php echo $this->_var['vo']['provinceID']; ?>"} <?php if ($this->_var['vo']['provinceID'] == $this->_var['profile']['province']): ?>selected = "selected"<?php endif; ?> <?php if ($this->_var['address_info']['province'] != '' && $this->_var['vo']['provinceID'] == $this->_var['address_info']['province']): ?> selected <?php else: ?>  <?php endif; ?>><?php echo $this->_var['vo']['province']; ?></option>
								<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
							</select>
							
							<select name="city" id="city" onchange="show_area(this.options[this.options.selectedIndex].value)" style="float: left;margin-right: .5em;margin-bottom: .3em;">
								<option value="0">请选择市</option>
								<?php $_from = $this->_var['city']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'vo');if (count($_from)):
    foreach ($_from AS $this->_var['vo']):
?>
								<option value="<?php echo $this->_var['vo']['cityID']; ?>" <?php if ($this->_var['vo']['cityID'] == $this->_var['profile']['city']): ?>selected = "selected"<?php endif; ?> <?php if ($this->_var['address_info']['city'] != '' && $this->_var['vo']['cityID'] == $this->_var['address_info']['city']): ?> selected <?php else: ?>  <?php endif; ?>><?php echo $this->_var['vo']['city']; ?></option>
								<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
							</select>
					
							<select name="area" id="area" style="float: left;margin-bottom: .3em;">
								<option value="0">请选择区/县</option>
								<?php $_from = $this->_var['area']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'vo');if (count($_from)):
    foreach ($_from AS $this->_var['vo']):
?>
								<option value="<?php echo $this->_var['vo']['areaID']; ?>" <?php if ($this->_var['vo']['areaID'] == $this->_var['profile']['area']): ?>selected = "selected"<?php endif; ?> <?php if ($this->_var['address_info']['area'] != '' && $this->_var['vo']['areaID'] == $this->_var['address_info']['area']): ?> selected <?php else: ?>  <?php endif; ?>><?php echo $this->_var['vo']['area']; ?></option>
								<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
							</select>
							<div style="clear:both"></div>
            </span>
          </div>
      </li>
      
      <!--<label for=""><span></span>所在地区：</label>
		<select name="province" id="province" onchange="show_sub(this.options[this.options.selectedIndex].value)" style="width: 130px;padding-right: 0.4em;">
			<option value="0">请选择</option>
			<?php $_from = $this->_var['province']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'vo');if (count($_from)):
    foreach ($_from AS $this->_var['vo']):
?>
			<option value="<?php echo $this->_var['vo']['provinceID']; ?>"} <?php if ($this->_var['address_info']['province'] != '' && $this->_var['vo']['provinceID'] == $this->_var['address_info']['province']): ?> selected <?php else: ?>  <?php endif; ?>><?php echo $this->_var['vo']['province']; ?></option>
			<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
		</select>

		<select name="city" id="city" onchange="show_area(this.options[this.options.selectedIndex].value)">
			<option value="0">请选择</option>
			<?php $_from = $this->_var['city']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'vo');if (count($_from)):
    foreach ($_from AS $this->_var['vo']):
?>
			<option value="<?php echo $this->_var['vo']['cityID']; ?>" <?php if ($this->_var['address_info']['city'] != '' && $this->_var['vo']['cityID'] == $this->_var['address_info']['city']): ?> selected <?php else: ?>  <?php endif; ?>><?php echo $this->_var['vo']['city']; ?></option>
			<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
		</select>

		<select name="area" id="area">
			<option value="0">请选择</option>
			<?php $_from = $this->_var['area']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'vo');if (count($_from)):
    foreach ($_from AS $this->_var['vo']):
?>
			<option value="<?php echo $this->_var['vo']['areaID']; ?>" <?php if ($this->_var['address_info']['area'] != '' && $this->_var['vo']['areaID'] == $this->_var['address_info']['area']): ?> selected <?php else: ?>  <?php endif; ?>><?php echo $this->_var['vo']['area']; ?></option>
			<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
		</select>-->
		
		
		<script type="text/javascript">

		
			function show_sub(){
		var province = $('#province').val();

		$.ajax({
				type:"get",
				url:"<?php echo url('user/agent_select');?>",
				data:'province='+province,
				dataType:"json",
				success:function(temp,status){
//					alert(temp)
					$("#city").html("<option value=''>请选择市</option>");  
					$.each(temp, function(i, item) {
						$("#city").append("<option value='" + item.cityID + "'>" + item.city + "</option>");  
					});
				},
				async:true
			});
//		Ajax.call("<?php echo url('user/agent_select');?>",'province='+province,stylesheetFun,'GET','json',true,true);
//		function stylesheetFun(temp){
//			$("#city").html("<option value=''>请选择</option>");  
//			$.each(temp, function(i, item) {
//				$("#city").append("<option value='" + item.cityID + "'>" + item.city + "</option>");  
//			});
//		}
	}
    function show_area(){
		var city = $('#city').val();
		
		$.ajax({
				type:"get",
				url:"<?php echo url('user/area_select');?>",
				data:'city='+city,
				dataType:"json",
				success:function(data,status){
//					alert(data)
					$("#area").html("<option value=''>请选择区/县</option>");  
					$.each(data, function(i, item) {
						$("#area").append("<option value='" + item.areaID + "'>" + item.area + "</option>");  
					});
				},
				async:true
			});
		
//		Ajax.call("<?php echo url('user/area_select');?>",'city='+city,registed_status,'GET','json',true,true);
//		function registed_status(data){
//			$("#area").html("<option value=''>请选择</option>");  
//			$.each(data, function(i, item) {
//				$("#area").append("<option value='" + item.areaID + "'>" + item.area + "</option>");  
//			});
//		}
	}
		</script>
      
      
      
      
      </li>
 				<li>
        <div class="input-text"><b class="pull-left" >收货地址：</b><span>
          <a href="<?php echo url('user/address_list');?>">更换收货地址</a>
         </span></div>
      </li>
    </ul>
    <ul class="yhkul">
      <?php $_from = $this->_var['arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'field');if (count($_from)):
    foreach ($_from AS $this->_var['field']):
?> 
    	
    	<li>
        <div class="input-text"><b class="pull-left" ><?php echo $this->_var['field']['reg_field_name']; ?>：</b><span>
          <input name="extend_field<?php echo $this->_var['field']['id']; ?>" id="extend_field<?php echo $this->_var['field']['id']; ?>" class="bank "  type="text" placeholder="<?php echo $this->_var['field']['reg_field_name']; ?>"  value="<?php echo $this->_var['field']['content']; ?>">
         </span></div>
      </li>
      <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
      <!--<p style="position: relative;z-index: 100;display: block;width: 100%;text-align: right;float: left;margin-top: 15px;" class="exph2">绑定银行账户</p>-->

      
      <!--<input type="" name="bank_code" id="bank_code" value="" />-->
      <li style="text-align: center;background: #e1e1e1;"  class="none2">
				验证手机：<?php echo $this->_var['profile']['mobile_phone']; ?>
			</li>
			<li class="none2">
 				<div class="input-text">
 					<b class="pull-left" >验证码:</b>
 					<span>

 						
           <input type="text" placeholder="" name="bank_code"  id="" value="" style="width: 50%;"/>
          </span>
         <p class="yazm2" style="float: right;position: relative;z-index: 100;" onclick="dianji2('bank_code')">获取验证码</p>
         
 				</div>
 			
    </ul>
  </section>

 
 

  
  <input name="act" type="hidden" value="profile" />
  <div class="two-btn ect-padding-tb ect-padding-lr ect-margin-tb text-center">
 <input name="session" type="hidden" value="mobile_code" />
  	
    <input name="submit" type="submit" value="<?php echo $this->_var['lang']['confirm_edit']; ?>" class="btn btn-info sss" />
  </div>
</form>
<style type="text/css">
						.none{
							display: none;
						}
						.none2{
							display: none;
						}
						#mobile{
							width: 50%;
						}
</style>

	<div class="code_tc" style="display: none;background: #fff;">
 				<li style="text-align: center;padding-top: 5%;" class="">
					验证手机：<?php echo $this->_var['profile']['mobile_phone']; ?>
				</li>
				
	 			<li class="code_tc_yz">
	 				<div class="input-text">
	 					<b class="pull-left">验证码:</b>
	 					<span>

	 						
	           <input type="text" placeholder="" name="mobile_code"  id="mobile_code" value="" style="width: 48%;"/>
	          </span>
	          <p class="yazm" style="float: right;position: relative;z-index: 100;font-size: 14px;" onclick="dianji('mobile_code')">获取验证码</p>
	         
	 				</div>
	 			</li>
	 			<p style="text-align: center;color: red;line-height: 35px;font-size: 14px;display: none;" id="code_tc_ts">ssss</p>
	 			<li style="text-align: center;">
	 				<a onclick="" id="code_tc_fa">返回</a>
	 				<a onclick="verify_code('mobile_code','bank')" id="code_tc_tr1" style="display: none;">确定</a>
	 				<a onclick="verify_code('mobile_code','mobile')" id="code_tc_tr" style="display: none;">确定</a>
	 			</li>
 			</div>
</div>
<div class="ect_bg"></div>
<script type="text/javascript" src="__TPL__/js/jquery-1.9.1.min.js"></script>
<script type="text/javascript">
	$(".grzl").on("click",function(){
		$(".grzl").addClass("grjh");
		$(".yhk").removeClass("grjh");
		$(".grul").addClass("grblock");
		$(".yhkul").removeClass("grblock");
	})
	$(".yhk").on("click",function(){
		$(".yhk").addClass("grjh");
		$(".grzl").removeClass("grjh");
		$(".yhkul").addClass("grblock");
		$(".grul").removeClass("grblock");
	})
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
	   function dianji(session){

	  	if(k==true){
	  		
	  		$.ajax({
				type:"post",
				url:"<?php echo url('user/get_code');?>",
				data:'mobile_phone='+<?php echo $this->_var['profile']['mobile_phone']; ?>+'&session='+session,
				dataType:"text",
				async:true
			});
	  		seconds =60;
	  		sss(); 		
	  	}else{  		
	  		return;
	  	}
	  	 	
	  }
	   
	  

	  	function verify_code(session,ipt){
	  		
	  
	  	 $.ajax({
	  	 	type:"post",
	  	 	url:"<?php echo url('user/verify_code');?>",
				data:'mobile_phone='+<?php echo $this->_var['profile']['mobile_phone']; ?>+'&session='+session+'&verify_code='+$("#mobile_code").val(),
	  	 	dataType:"text",
				success:function(result,status){	
					var result=JSON.parse(result)
					if(result[0]!=0){
						
						$("#code_tc_ts").css("display","block").text(result[1]);
					}else{
						$("#code_tc_ts").css("display","block").text(result[1]+",1s后跳转");
						setTimeout(function(){
							$("#myform").css("display","block");
							$(".code_tc").css("display","none");
							var put="."+ipt
							$(put).css("color","#333").removeAttr("readonly");
							$(".ect_bg").css("display","none")
							if(ipt=="mobile"){
								$(".exph").css("display","none")
							}else{
								$(".exph2").css("display","none")
							}
						},1500)
					
					}
				},
	  	 	async:true
	  	 });
	  	}

	   
	   
	   
	   
	   
	   var f = true;
	   var seconds2 = 60;
	    function getdate2(){
	    	f= false;
	        seconds2--;
	         $(".yazm2").text(seconds2+"s后重新发送");
	         $(".yazm2").css({"background":"#ccc"});
	    }
	
	   function sss2(){
	      if(seconds2<=1){
	      	f=true;
	         $(".yazm2").text("重新发送");
	         $(".yazm2").css({"background":"#fff"});
	        return;
	      }
	     getdate2();
	     var set2 = setTimeout(sss2,1000); 
	   }
	   function dianji2(session){

	  	if(f==true){
	  		
	  		$.ajax({
				type:"post",
				url:"<?php echo url('user/get_code');?>",
				data:'mobile_phone='+<?php echo $this->_var['profile']['mobile_phone']; ?>+'&session='+session,
				dataType:"text",
				async:true
			});
	  		seconds2 =60;
	  		sss2(); 		
	  	}else{  		
	  		return;
	  	}
	  	 	
	  }
	   
	 


	
	$(".exph").on("click",function(){
		
		$("#myform").css("display","none");
		$(".code_tc").css("display","block");
		$("#code_tc_tr").css("display","inline-block");
		$("#code_tc_tr1").css("display","none");
		var ws = document.documentElement.clientHeight;
		$(".ect_bg").css({"height":ws,"display":"block"});
		$("#code_tc_ts").css("display","none");
		
		
	});
	
	$("#code_tc_fa").on("click",function(){
		$("#myform").css("display","block");
		$(".code_tc").css("display","none");
		$(".ect_bg").css("display","none")
	})
	
	
	
	
	
	
	$(".exph2").on("click",function(){

		$("#myform").css("display","none");
		$(".code_tc").css("display","block");
		$("#code_tc_tr1").css("display","inline-block");
		$("#code_tc_tr").css("display","none");
		var ws = document.documentElement.clientHeight;
		$(".ect_bg").css({"height":ws,"display":"block"});
		$("#code_tc_ts").css("display","none");
		
	})





      var scw = document.documentElement.clientWidth;
      var sch = document.documentElement.clientHeight;
      	$("#sctx").on("click",function(){		
      		$(".container").css({"width":scw,"height":sch,"position":"fixed","background":"rgba(0,0,0,0.2)","top": 0,"left": 0,"zIndex":1001})
      	})
     	$(".ok").on("click",function(){
     		$(".container").css({"zIndex":0,"width":"200px","height":"200px"})
     		
     		return false
     	})
</script>
<?php echo $this->fetch('library/search.lbi'); ?> <?php echo $this->fetch('library/page_footer.lbi'); ?>
<?php echo $this->fetch('library/nav.lbi'); ?>
</body></html>