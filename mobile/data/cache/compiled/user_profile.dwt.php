<?php echo $this->fetch('library/user_header.lbi'); ?> 
<script type="text/javascript">
	  <?php $_from = $this->_var['lang']['profile_js']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
		var <?php echo $this->_var['key']; ?> = "<?php echo $this->_var['item']; ?>";
	  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
	  
	</script>
<form name="formEdit" action="<?php echo url('user/profile');?>" method="post" onSubmit="return userEdit();">
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
      <?php else: ?>
      <li>
        <div class="input-text"><b class="pull-left" <?php if ($this->_var['field']['is_need']): ?>id="extend_field<?php echo $this->_var['field']['id']; ?>i"<?php endif; ?>><?php echo $this->_var['field']['reg_field_name']; ?>:</b><span>
          <input name="extend_field<?php echo $this->_var['field']['id']; ?>" type="text" <?php if ($this->_var['field']['id'] == 5): ?>readonly id="mobile" class="ccc"<?php endif; ?> value="<?php echo $this->_var['field']['content']; ?>" placeholder="<?php echo $this->_var['field']['reg_field_name']; ?>">
          </span>
        <?php if ($this->_var['field']['id'] == 5): ?> <p style="float: right;position: relative;z-index: 100;" class="exph">更换手机</p><?php endif; ?>
        </div>
      </li>
 			<?php if ($this->_var['field']['id'] == 5): ?>
			<li style="text-align: center;background: #e1e1e1;" class="none">
				验证手机：<?php echo $this->_var['profile']['mobile_phone']; ?>
			</li>
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
 			<li class="none">
 				<div class="input-text">
 					<b class="pull-left">验证码:</b>
 					<span>
 <input name="session1" type="hidden" value="mobile_code" />
 						
           <input type="text" placeholder="" name="mobile_code"  id="" value="" style="width: 50%;"/>
          </span>
          <?php if ($this->_var['field']['id'] == 5): ?> <p class="yazm" style="float: right;position: relative;z-index: 100;" onclick="dianji('mobile_code')">获取验证码</p><?php endif; ?>
         
 				</div>
 			</li>
 			 
 			<?php endif; ?>
      <?php endif; ?> 
      <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </ul>
    <ul class="yhkul">
      <?php $_from = $this->_var['arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'field');if (count($_from)):
    foreach ($_from AS $this->_var['field']):
?> 
    	
    	<li>
        <div class="input-text"><b class="pull-left" ><?php echo $this->_var['field']['reg_field_name']; ?>：</b><span>
          <input name="extend_field<?php echo $this->_var['field']['id']; ?>" class="bank ccc" readonly type="text" placeholder="<?php echo $this->_var['field']['reg_field_name']; ?>"  value="<?php echo $this->_var['field']['content']; ?>">
         </span></div>
      </li>
      <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
      <p style="position: relative;z-index: 100;display: block;width: 100%;text-align: right;float: left;margin-top: 15px;" class="exph2"> 修改银行信息</p>

      
      <!--<input type="" name="bank_code" id="bank_code" value="" />-->
      <li style="text-align: center;background: #e1e1e1;"  class="none2">
				验证手机：<?php echo $this->_var['profile']['mobile_phone']; ?>
			</li>
			<li class="none2">
 				<div class="input-text">
 					<b class="pull-left" >验证码:</b>
 					<span>
 <input name="session2" type="hidden" value="bank_code" />
 						
           <input type="text" placeholder="" name="bank_code"  id="" value="" style="width: 50%;"/>
          </span>
         <p class="yazm2" style="float: right;position: relative;z-index: 100;" onclick="dianji2('bank_code')">获取验证码</p>
         
 				</div>
 			</li>
 				
    </ul>
  </section>

 
 

  
  <input name="act" type="hidden" value="profile" />
  <div class="two-btn ect-padding-tb ect-padding-lr ect-margin-tb text-center">
    <input name="submit" type="submit" value="<?php echo $this->_var['lang']['confirm_edit']; ?>" class="btn btn-info" />
  </div>
</form>
</div>
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
		
		
//		$("#mobile").val("");
//		$("#mobile").attr("placeholder","请填写新绑定手机号");
		
		if($(".none").css("display") == "block"){
			$("#mobile").attr("readonly","");
			$(".none").css("display","none");
			$("#mobile").addClass("ccc");
		}else{
			$(".none").css("display","block");
			$("#mobile").removeAttr("readonly");
			$("#mobile").removeClass("ccc");
		}
	})
	$(".exph2").on("click",function(){

		if($(".none2").css("display") == "block"){
			$(".bank").attr("readonly","");
			$(".none2").css("display","none");
			$(".bank").addClass("ccc");
		}else{
			$(".none2").css("display","block");
		  $(".bank").removeAttr("readonly");
		  $(".bank").removeClass("ccc");
		}

	})

</script>
<?php echo $this->fetch('library/search.lbi'); ?> <?php echo $this->fetch('library/page_footer.lbi'); ?>
<?php echo $this->fetch('library/nav.lbi'); ?>
</body></html>