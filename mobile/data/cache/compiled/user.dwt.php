<?php echo $this->fetch('library/user_header.lbi'); ?>
<link rel="stylesheet" type="text/css" href="__TPL__/css/common.css"/>
<!--<div class="demo" id="demo2">alert</div>-->
<div  class="user-info <?php if ($this->_var['info']['user_type'] == '普通会员'): ?>pthy_bg<?php endif; ?>">
  <div class="user-img" >
  	<!--<i class="glyphicon glyphicon-user"></i>-->
  	<img src="<?php if ($this->_var['info']['user_img']): ?><?php echo $this->_var['info']['user_img']; ?><?php else: ?>__TPL__/images/tx.png<?php endif; ?>" alt="" width="130" height="130" style="position: relative;z-index: 1;border-radius: 50%;"/>
  	<dd> <?php echo $this->_var['info']['username']; ?></dd>
  	<dd> <a class="<?php if ($this->_var['info']['user_type'] == '金钻会员'): ?>jzhy<?php elseif ($this->_var['info']['user_type'] == '铂金会员'): ?>bjhy<?php endif; ?>">
  		
  		<?php echo $this->_var['info']['user_type']; ?>
  		<?php if ($this->_var['info']['user_type'] == '普通会员'): ?>
  		&nbsp;&nbsp;&nbsp;<a href="<?php echo url('user/account_jewel');?>" style="color: #e87e04;font-weight:0!important;">升级金钻
  		<?php endif; ?>
  		</a></dd>
  	 <dd> <a ><?php echo $this->_var['lang']['share_id']; ?>：<?php echo $this->_var['share_id']; ?></a></dd>
  </div>
  
  
		<!--<p class="yhm"><?php echo $this->_var['info']['username']; ?>&nbsp;&nbsp;&nbsp;<a href="<?php echo url('user/account_jewel');?>" style="color: #fff;font-weight:0!important;">立即升级</a></p>-->
   <h4 class="out"><a href="<?php echo url('user/logout');?>" class="ect-colorf"><img src="themes/default/images/out.png" alt="" width="35"/></a></h4>
  <!--<dl class="pull-left" style="width: 70%;">
    <dt>
      <h4><?php echo $this->_var['info']['username']; ?> | <a href="<?php echo url('user/logout');?>" class="ect-colorf"><?php echo $this->_var['lang']['label_logout']; ?></a></h4>
    </dt>
  </dl>-->
  
 	<div style="position: fixed;top: 60vw;right: 3vw;color: #fff;border-radius: 50%;background: rgba(0,0,0,.3);width: 46px;height: 46px;text-align: center;line-height: 46px;z-index: 999;" id="gg">公告</div>
	
	<div id="gg_box">
		<div style="display:none;position: fixed;top: 0;left: 0;width: 100%;height: 100%;background: rgba(0,0,0,.8);z-index: 9998;" id="gg_bg"></div>
		
		<div style="display:none;position: fixed;text-align: center;left: 0;top: 5vw;z-index: 9999;" id="gg_img">
			<img src="themes/default/images/jiayou_gg.jpg" alt="" width="100%"/>
				
			<?php if ($this->_var['info']['user_type'] == '金钻会员' || $this->_var['info']['user_type'] == '铂金会员'): ?>
			<img src="themes/default/images/gg.jpeg" alt="" width="100%" style="display: none;"/>
			<?php endif; ?>
			<img src="themes/default/images/gonggao1.jpg" alt="" width="100%" style="display: none;"/>
		</div>

		<div class="zdj" style="position: fixed ; left: 5vw; top: 45%;z-index: 9999;display:none;"><img src="themes/default/images/l_jt.png"/></div>
		<div class="ydj" style="position: fixed ; right: 5vw; top: 45%; z-index: 9999;display:none;"><img src="themes/default/images/r_jt.png"/></div>

	</div>
	
	<!--<div id="gg1_box">
		<div style="display:none;position: fixed;top: 0;left: 0;width: 100%;height: 100%;background: rgba(0,0,0,.8);z-index: 9998;" id="gg_bg"></div>
		<div style="display:none;position: fixed;text-align: center;left: 0;top: 5vw;z-index: 9999;" id="gg_img"><img src="themes/default/images/gonggao1.jpeg" alt="" width="100%"/></div>

	</div>-->
	


</div>


<ul class="money">
    	<li ><span><?php echo $this->_var['info']['surplus']; ?></span><p>余额</p><li>
	    <li class="fl" id="jybmx"><span><?php echo $this->_var['info']['vr_go']; ?></span><p>金元宝(总) </p></li>
	    <li><span><?php echo $this->_var['info']['love']; ?></span><p><?php echo $this->_var['lang']['love']; ?></p></li>
    </ul>
    
 <div id="jybfa">
			<li><span><?php echo $this->_var['info']['vr_points']; ?></span><p>方案一金元宝</p></li>
			<li><span><?php echo $this->_var['info']['gold']; ?></span><p>方案二金元宝</p></li>
			<li><span><?php if ($this->_var['info']['fangan3']): ?><?php echo $this->_var['info']['fangan3']; ?><?php else: ?>0<?php endif; ?></span><p>方案三金元宝</p></li>
			<li style="border-top: 1px solid #ccc;"><span><?php echo $this->_var['info']['integral']; ?></span><p>方案一金积分</p></li>
			<li style="border-top: 1px solid #ccc;"><span><?php echo $this->_var['info']['pay_points_2']; ?></span><p>方案二金积分</p></li>
			<li style="border-top: 1px solid #ccc;"><span><?php if ($this->_var['info']['pay_points_3']): ?><?php echo $this->_var['info']['pay_points_3']; ?><?php else: ?>0<?php endif; ?></span><p>方案三金积分</p></li>
 </div>   
<!--  
  <div id="jjffa">
			<li><span><?php echo $this->_var['info']['integral']; ?></span><p>方案一金积分</p></li>
			<li><span><?php echo $this->_var['info']['pay_points_2']; ?></span><p>方案二金积分</p></li>
 </div>   -->
<section class="container-fluid user-nav">
  <ul class="row ect-row-nav text-center">
    <!--<a href="<?php echo url('user/not_pay_order_list');?>">
    <li class="col-sm-3 col-xs-3"><img src="__TPL__/images/not_pay_list.png" style="height: 54px;width: 54px;">
      <p class="text-center"><?php echo $this->_var['lang']['not_pay_list']; ?></p>
    </li>
    </a>-->
    <a href="<?php echo url('user/order_list');?>">
    <li class="col-sm-3 col-xs-3"><img src="__TPL__/images/order_list_lnk.png" style="height: 54px;width: 54px;">
      <p class="text-center"><?php echo $this->_var['lang']['order_list_lnk']; ?></p>
    </li>
    </a> 
    <a href="<?php echo url('user/user_installment');?>">
    <li class="col-sm-3 col-xs-3"><img src="__TPL__/images/label_installment.png" style="height: 54px;width: 54px;">
      <p class="text-center">分期活动</p>
    </li>
    </a>
    
    
    <!--<a href="<?php echo url('user/address_list');?>">
    <li class="col-sm-3 col-xs-3"><img src="__TPL__/images/label_address.png" style="height: 54px;width: 54px;">
      <p class="text-center"><?php echo $this->_var['lang']['label_address']; ?></p>
    </li>
    </a> -->
    <a href="<?php echo url('user/account_detail');?>">
    <li class="col-sm-3 col-xs-3"><img src="__TPL__/images/label_user_surplus.png" style="height: 54px;width: 54px;">
      <p class="text-center"><?php echo $this->_var['lang']['label_user_surplus']; ?></p>
    </li>
    </a> <a href="<?php echo url('user/profile');?>">
    <li class="col-sm-3 col-xs-3"><img src="__TPL__/images/profile.png" style="height: 54px;width: 54px;">
      <p class="text-center"><?php echo $this->_var['lang']['profile']; ?></p>
    </li>
    </a> <a href="<?php echo url('user/edit_password');?>">
    <li class="col-sm-3 col-xs-3"><img src="__TPL__/images/edit_password.png" style="height: 54px;width: 54px;">
      <p class="text-center"><?php echo $this->_var['lang']['edit_password']; ?></p>
    </li>
    </a> 
    <!--<a href="<?php echo url('user/service');?>">
    <li class="col-sm-3 col-xs-3"><i><img src="__TPL__/images/u-kefu.png"  style="height: 69px;width: 59px;"></i>
      <p class="text-center"><?php echo $this->_var['lang']['user_service']; ?></p>
    </li>
    </a>-->
    <a href="<?php echo url('user/share');?>">
    <li class="col-sm-3 col-xs-3"><img src="__TPL__/images/label_share.png" style="height: 54px;width: 54px;">
      <p class="text-center"><?php echo $this->_var['lang']['label_share']; ?></p>
    </li>
    </a>
     <a href="<?php echo url('user/my_vip');?>">
    <li class="col-sm-3 col-xs-3"><img src="__TPL__/images/my_vip.png" style="height: 54px;width: 54px;">
      <p class="text-center">我的会员</p>
    </li>
    </a>
    <a href="<?php echo url('user/benefit_desc');?>">
    <li class="col-sm-3 col-xs-3"><img src="__TPL__/images/benefit_desc.png" style="height: 54px;width: 54px;">
      <p class="text-center">公益基金</p>
    </li>
    </a>
    <!--<a href="<?php echo url('user/bonus');?>">
    <li class="col-sm-3 col-xs-3"><i class="glyphicon glyphicon-gift"></i>
      <p class="text-center"><?php echo $this->_var['lang']['label_bonus']; ?></p>
    </li>
    </a>
     <a href="<?php echo url('user/booking_list');?>">
    <li class="col-sm-3 col-xs-3"><i class="glyphicon glyphicon-link"></i>
      <p class="text-center"><?php echo $this->_var['lang']['label_booking']; ?></p>
    </li>
    </a>
    <a href="<?php echo url('user/msg_list');?>">
    <li class="col-sm-3 col-xs-3"><i ><img src="__TPL__/images/xiaoxi.png" style="height: 69px;width: 59px;"></i>
      <p class="text-center">我的消息</p>-->
    <!--</li>
    </a>-->
	
  </ul>
</section>
<section class="user-tab ect-margin-tb ect-margin-bottom0"> 
  
  <ul class="nav nav-tabs text-center">
    <li class="col-xs-4 active"><a href="#one" role="tab" data-toggle="tab"><?php echo $this->_var['lang']['label_collection']; ?></a></li>
    <li class="col-xs-4"><a href="#two" role="tab" data-toggle="tab"><?php echo $this->_var['lang']['label_comment']; ?></a></li>
    <li class="col-xs-4"><a href="#three" role="tab" data-toggle="tab"><?php echo $this->_var['lang']['user_history']; ?></a></li>
  </ul>
  
  <div class="tab-content" id="gwc-tab-xq-bd">
    <div class="tab-pane active ect-pro-list" id="one"> 
      <?php if ($this->_var['goods_list']): ?>
      <ul>
        <?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'val');if (count($_from)):
    foreach ($_from AS $this->_var['val']):
?>
        <li><a href="<?php echo url('goods/index', array('id'=>$this->_var[val]['goods_id']));?>"><img src="<?php echo $this->_var['val']['goods_thumb']; ?>"></a>
          <dl>
            <dt>
              <h4 class="title"><a href="<?php echo url('goods/index', array('id'=>$this->_var[val]['goods_id']));?>"><?php echo $this->_var['val']['goods_name']; ?></a></h4>
            </dt>
            <dd class="dd-price"><span class="pull-left"><strong><?php echo $this->_var['lang']['sort_price']; ?>：<b class="ect-colory"><?php echo $this->_var['val']['shop_price']; ?></b></strong><small class="ect-margin-lr"><del><?php echo $this->_var['val']['market_price']; ?></del></small></span></dd>
          </dl>
          <a href="<?php echo url('user/delete_collection', array('rec_id'=>$this->_var['val']['rec_id']));?>" class="pull-right del"><i class="glyphicon glyphicon-trash"></i></a></li>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
         <a href="<?php echo url('collection_list');?>" class="more"><?php echo $this->_var['lang']['view_more']; ?></a>
      </ul>
     
      <?php else: ?>
      <p class="text-center ect-margin-tb ect-padding-tb"><?php echo $this->_var['lang']['no_data']; ?></p>
      <?php endif; ?> 
    </div>
    <div class="tab-pane ect-pro-list pinglun-list" id="two"> 
      <?php if ($this->_var['comment_list']): ?>
      <ul>
        <?php $_from = $this->_var['comment_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'val');if (count($_from)):
    foreach ($_from AS $this->_var['val']):
?>
        <li>
          <dl>
            <dt>
              <h4 class="title"><a href="<?php echo url('goods/index', array('id'=>$this->_var[val]['id_value']));?>"><?php if ($this->_var['val']['comment_type'] == 0): ?> <?php echo $this->_var['lang']['goods_comment']; ?><?php else: ?><?php echo $this->_var['lang']['article_comment']; ?><?php endif; ?>：<?php echo $this->_var['val']['cmt_name']; ?></a></h4>
            </dt>
            <dd class="date ect-color999"><?php echo $this->_var['val']['formated_add_time']; ?></dd>
            <dd><?php echo $this->_var['val']['content']; ?></dd>
            <?php if ($this->_var['val']['reply_content']): ?>
            <dd><?php echo $this->_var['lang']['reply_comment']; ?>：<?php echo $this->_var['val']['reply_content']; ?></dd>
            <?php endif; ?>
            <dd><a href="<?php echo url('user/delete_comment',array('id'=>$this->_var[val][comment_id]));?>" class="pull-right del"><i class="glyphicon glyphicon-trash"></i></a></dd>
          </dl>
        </li>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        <a href="<?php echo url('comment_list');?>" class="more"><?php echo $this->_var['lang']['view_more']; ?></a>
      </ul>
      <?php else: ?>
      <p class="text-center ect-margin-tb ect-padding-tb"><?php echo $this->_var['lang']['no_data']; ?></p>
      <?php endif; ?> 
    </div>
    <div class="tab-pane ect-pro-list" id="three"> 
      <?php if ($this->_var['history']): ?> 
      <span class="pull-right ect-padding-lr ect-margin-tb ect-margin-bottom0">
      <a href="<?php echo url('user/clear_history');?>" class="history_clear del"><i class="glyphicon glyphicon-trash"></i> <?php echo $this->_var['lang']['clear_history']; ?></a></span>
      <ul>
        <?php $_from = $this->_var['history']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'val');if (count($_from)):
    foreach ($_from AS $this->_var['val']):
?>
        <li><a href="<?php echo url('goods/index', array('id'=>$this->_var[val]['goods_id']));?>"><img src="<?php echo $this->_var['val']['goods_thumb']; ?>"></a>
          <dl>
            <dt>
              <h4 class="title"><a href="<?php echo url('goods/index', array('id'=>$this->_var[val]['goods_id']));?>"><?php echo $this->_var['val']['goods_name']; ?></a></h4>
            </dt>
            <dd class="dd-price"><span class="pull-left"><strong><?php echo $this->_var['lang']['sort_price']; ?>：<b class="ect-colory"><?php echo $this->_var['val']['shop_price']; ?></b></strong><small class="ect-margin-lr"><del><?php echo $this->_var['val']['market_price']; ?></del></small></span></dd>
          </dl>
        </li>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
      </ul>
      <?php else: ?>
      <p class="text-center  ect-margin-tb ect-padding-tb"><?php echo $this->_var['lang']['not_history']; ?><a href="<?php echo url('category/index');?>" class="ect-color ect-margin-lr" style="font-size:1.3em;"><?php echo $this->_var['lang']['enter']; ?></a><?php echo $this->_var['lang']['scan_goods']; ?></p>
      <?php endif; ?> 
    </div>
  </div>
</section>
</div>


<?php echo $this->fetch('library/search.lbi'); ?>
<?php echo $this->fetch('library/nav.lbi'); ?>
	
<?php echo $this->fetch('library/page_footer.lbi'); ?> 
<script type="text/javascript">
    $(function(){
        $(".del").click(function(){
            if(!confirm('您确定要删除吗？')){
                return false;
            }
            var obj = $(this);
            var url = obj.attr("href");
            $.get(url, '', function(data){
                if(1 == data.status){
                    if(obj.hasClass("history_clear")){
                        obj.closest(".ect-pro-list").html("<p class='text-center  ect-margin-tb ect-padding-tb'>暂无浏览记录，点击<a href=<?php echo url('category/index');?> class='ect-color ect-margin-lr' style='font-size:1.3em;'>进入</a>浏览商品</p>");
                        obj.parent().siblings("ul").remove();
                    } 
                    else{
                        if(obj.closest("li").siblings("li").length == 0){
                            obj.closest("ul").html("<p class='text-center  ect-margin-tb ect-padding-tb'><?php echo $this->_var['lang']['no_data']; ?></p>");
                        }
                        obj.closest("li").remove();
                    }
                }
                else{
                    alert("删除失败");
                }
            }, 'json');
            return false;
   		});
    })
    
    
    
    $("#jybmx").on("click",function(){
    	$("#jybfa").slideToggle();
    	$("#jybmx p").toggleClass("jybmp");
    	if($("#jjffa").css("display") != "none"){
    		$("#jjffa").slideToggle();
    		$("#jjfmx p").toggleClass("jybmp");
    	}
    })
    
    $("#jjfmx").on("click",function(){
    	$("#jjffa").slideToggle();
    	$("#jjfmx p").toggleClass("jybmp");
    	if($("#jybfa").css("display") != "none"){
    		$("#jybfa").slideToggle();
    		$("#jybmx p").toggleClass("jybmp");
    	}
    })
</script>
<script type="text/javascript" src="themes/default/js/alertPopShow.js"></script>
<!--<script type="text/javascript">
//	$(function(){
//		$('#demo2').on('click', function(){
			var neirong='欢迎登陆沃尔迅积分奖励系统，在本商城消费的商品都将以金元宝的形式回赠到您的个人账户</br>系统规则：</br>1：购买多少金额的商品系统即回赠相应比例的金元宝到您的个人账户</br>2：用户获得的金元宝将每天按照万分之六左右的比例兑换成金积分，1金积分=1元</br>3：金积分可用于商城购买商品消费</br>4：提现会扣除相应金额的6%【税收及相关:手续费】</br>5：用户购买商品回赠的金元宝都将扣除千分之五作为爱心公益基金捐助';
			var fangjia='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;亲爱的会员们,你们好,由于我司春节期间员工放假时间为2017年01月21日至2017年02月05日,在此期间您的提现申请暂停操作,至2017年02月06日起恢复正常提现操作。</br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	若您近期有提现需求,请在本周五（1月20日）中午12:00前提交申请,当日可完成提现交易,逾期则要顺延到年后处理。</br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;期间给您带来的不便,敬请谅解!沃尔迅易购领导携全体员工祝您节日快乐,身体健康!<p style="text-align: right;"></br>成都沃尔迅科技有限公司</br>2017年01月18日</p>	';

			popTipShow.alert('关于春节假日期间会员提现操作暂停公告',fangjia, ['知道了'],
				function(e){
				  //callback 处理按钮事件		  
				  var button = $(e.target).attr('class');
				  if(button == 'ok'){
					//按下确定按钮执行的操作
					//todo ....
					this.hide();
					$("body").css({"overflow":"auto","position":"static"});
				  }	
				}
			);
			$("body").css({"overflow":"hidden","position":"fixed","top":"0"})
			
//	   });
//	})
</script>-->


<script type="text/javascript">
	$("#gg").on("click",function(){
		$("#gg_img").show("show");
		$("#gg_bg").show("show");
		$(".zdj").show("show");
		$(".ydj").show("show");
		$("body").css({"overflow":"hidden","position":"fixed","top":"0"})
	});
	
	$("#gg_img").on("click",function(){
		$("#gg_img").hide("show");
		$("#gg_bg").hide("show");
		$(".zdj").css("display","none");
		$(".ydj").css("display","none");
		$("body").css({"overflow":"auto","position":"static"});
		
	})
	var k = 0;
	
	$(".zdj").on("click",function(){
		
		var i = $("#gg_img img").length;
		
		if($("#gg_img img").eq(0).css("display") == "block"){
			
			$("#gg_img img").eq(0).css("display","none");
			$("#gg_img img").eq(i-1).css("display","block");
			
		}else{
			$("#gg_img img").eq(k).css("display","none");
			$("#gg_img img").eq(k-1).css("display","block");
		}
	
		k--;
		if(k <= -i){
			k=0
		}
		
		
	})
	
	$(".ydj").on("click",function(){
		
		var i = $("#gg_img img").length;
		
		$("#gg_img img").eq(k).css("display","none");
		
		$("#gg_img img").eq(k+1).css("display","block");
			
		k++;
		
		if(k >= i-1){
			
			k = -1;
			
		}
		
		
		
	})
</script>
</body>
</html>
