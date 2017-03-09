<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta name="Generator" content="ECTouch 1.0" />
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<meta name="Keywords" content="<?php echo $this->_var['meta_keywords']; ?>" />
<meta name="Description" content="<?php echo $this->_var['meta_description']; ?>" />
<title><?php echo $this->_var['page_title']; ?></title>
<link rel="stylesheet" href="__PUBLIC__/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="__PUBLIC__/bootstrap/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo $this->_var['ectouch_css_path']; ?>">
<link rel="stylesheet" href="__TPL__/css/user.css">
<link rel="stylesheet" href="__TPL__/css/photoswipe.css">

</head>

<body>
<div class="con" >

<style>
	#b span{
			width: 10.1%;
			height: 25px;
			display: inline-block;
			background: url(themes/default/images/axgy_2.png) no-repeat;
			text-indent: -9999px;
			margin-left: 1.13%;		
		}
		#b span:first-child{
			margin-left: .2px;
		}
		#a{
			background: url(themes/default/images/axgy.jpg) no-repeat ;
			background-size: cover;
			max-width: 640px;
			height: 455px;
		}
		#b{
			position: relative;
			top: 9%;
			padding:0 25% 0 25.1%;
			box-sizing: border-box;
			width: 100%;
			font-size: 0;
		}
</style>


<div id="a">
	<div id="b">
		<span></span>
		<span></span>
		<span></span>
		<span></span>
		<span></span>
		<span></span>
		<span></span>
		<span></span>
		<span></span>
	</div>
</div>

  
</div>

<!--<script type="text/javascript">
	function select_earnings(obj,user_id,user_name){

		$.ajax({
			type:"get",
			url:"<?php echo url('user/select_earnings');?>",
			data:"user_id="+user_id+"&user_type="+"<?php echo $this->_var['info']['user_type']; ?>",
			dataType:"json",
			success:function(result,status){					
				if(status){
					var arrayObj = new Array();
					arrayObj=result;
					if($('.earnings').attr('id')=='s'+user_id){
						$(".earnings").remove()
					}else{
						$(".earnings").remove()
						$(obj).after("<tr align='center' class='earnings' id='s"+user_id+"'><td>"+user_name+"今日消费</td><td colspan='3'>"+result['recharge']+"金元宝</td></tr><tr align='center' class='earnings' id='s"+user_id+"'><td>您今日的收益</td><td colspan='3'>"+result['earnings']+"金元宝</td></tr>");		
						
					}
				}
			}
		});
	}
	
</script>-->

<?php echo $this->fetch('library/search.lbi'); ?>
<?php echo $this->fetch('library/page_footer.lbi'); ?>
<?php echo $this->fetch('library/nav.lbi'); ?>
	
<script type="text/javascript">
$(function () {
	
		function run(index,i,a,b){
			if (index <= -312) {//63
				index = 0;
			}
			if (i>=a) {
				return false;
			}
			if (a == 63+9*7) {
				$("#b span").eq(b).css({"backgroundPosition":"center " +  (index-1)+"px"})
			}else{
				$("#b span").eq(b).css({"backgroundPosition":"center " +  (index+4)+"px"})
			}
			
			setTimeout(function(){run(index,i,a,b)} , 5);
			index =index-5;
			
			i++;
			
		}
		var c = "<?php echo $this->_var['love']; ?>";
		
		for(var k=0;k<$("#b span").length;k++){
			
//			
			
			if (c[k] == 9) {
				run(0,0,63+c[k]*7,k);
			}else{
				run(0,0,64+c[k]*7,k);
			}
			

		};
	 var h = document.documentElement.clientHeight;
	 
	 $("#a").css("height",h)

})
</script>