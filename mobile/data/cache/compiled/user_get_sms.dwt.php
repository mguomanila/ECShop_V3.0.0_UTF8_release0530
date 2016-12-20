<?php echo $this->fetch('library/user_header.lbi'); ?>
<p class="ect-padding-lr ect-margin-tb ect-margin-bottom0">
	<?php if ($this->_var['sms'] == 0): ?>
 <div>
<form action="<?php echo url('user/get_password_sms');?>" method="post" name="getPassword" onsubmit="return submitPwdInfo();">
  <div class="flow-consignee ect-bg-colorf" id="tabBox1-bd">
    <ul>
      <li>
        <div class="input-text"><b><?php echo $this->_var['lang']['username']; ?>：</b> <span>
          <input placeholder="<?php echo $this->_var['lang']['username']; ?>" class="inputBg" name="user_name" type="text" />
          </span></div>
      </li>
     
  <div class="ect-padding-lr ect-padding-tb">
  	<input type="hidden" name="step" value="0" />
    <input name="Submit" type="submit" value="<?php echo $this->_var['lang']['submit']; ?>" class="btn btn-info ect-btn-info ect-colorf ect-bg" />
  </div>
</form>
</div>
<?php elseif ($this->_var['sms'] == 1): ?>
<div>
<form action="<?php echo url('user/get_password_sms');?>" method="post" name="getPassword" onsubmit="return submitPwdInfo();">
  <div class="flow-consignee ect-bg-colorf" id="tabBox1-bd">
    <ul>
    	<li>
        <div class="input-text"><b><?php echo $this->_var['lang']['mobile']; ?>：</b> <span>
          <input placeholder="<?php echo $this->_var['lang']['mobile']; ?>" class="zhma_input" name="mobile" readonly value="<?php echo $this->_var['user_info']['mobile_phone']; ?>" type="text" />
        <a href="javascript:" class="yazm">发送验证码</a>  
        </span>
        
        </div>
      </li>
      <li>
        <div class="input-text"><b><?php echo $this->_var['lang']['code']; ?>：</b> <span>
          <input placeholder="<?php echo $this->_var['lang']['code']; ?>" class="inputBg" name="mobile_code" type="text" value=""/>
          </span></div>
      </li>
     
  <div class="ect-padding-lr ect-padding-tb">
  	<input type="hidden" name="step" value="1" />
  	<input type="hidden" name="mobile_phone" value="<?php echo $this->_var['user_info']['mobile_phone']; ?>" />
  	<input type="hidden" name="session" value="pwd" />
  	
  	<input type="hidden" name="user_name" value="<?php echo $this->_var['user_name']; ?>" />
    <input name="Submit" type="submit" value="<?php echo $this->_var['lang']['submit']; ?>" class="btn btn-info ect-btn-info ect-colorf ect-bg" />
  </div>
</form>
</div>

<?php endif; ?>
<?php echo $this->fetch('library/search.lbi'); ?>

<?php echo $this->fetch('library/page_footer.lbi'); ?> 

    <?php echo $this->fetch('library/nav.lbi'); ?>
<script type="text/javascript">
	
	$(function (){
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
	  $(".yazm").on("click",function (){
	  	if(k==true){
	  		$.ajax({
				type:"post",
				url:"<?php echo url('user/get_code');?>",
				data:'mobile_phone='+<?php echo $this->_var['user_info']['mobile_phone']; ?>+'&session=pwd',
				dataType:"text",
				async:true
			});
	  		seconds =60;
	  		sss(); 		
	  	}else{  		
	  		return;
	  	}
	  	 	
	  })
	})
</script>
    
</baby>
</html>