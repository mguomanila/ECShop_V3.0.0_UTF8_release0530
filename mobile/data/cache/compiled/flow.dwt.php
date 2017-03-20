<?php echo $this->fetch('library/page_header.lbi'); ?>
<?php if ($this->_var['step'] == "cart"): ?>
<?php echo $this->fetch('flow_cart.dwt'); ?>
<?php endif; ?>

<?php if ($this->_var['step'] == "label_favourable"): ?>
<?php echo $this->fetch('flow_label_favourable.dwt'); ?>
<?php endif; ?>

<?php if ($this->_var['step'] == "checkout"): ?>
<?php echo $this->fetch('flow_checkout.dwt'); ?>
<?php endif; ?>

<?php if ($this->_var['step'] == "done"): ?>
<?php echo $this->fetch('flow_done.dwt'); ?>
<?php endif; ?>

<?php if ($this->_var['step'] == "consignee"): ?>
<?php echo $this->fetch('flow_consignee.dwt'); ?>
<?php endif; ?> 
<?php echo $this->fetch('library/search.lbi'); ?> 
<?php echo $this->fetch('library/page_footer.lbi'); ?> 
<script type="text/javascript" src="__PUBLIC__/js/shopping_flow.js"></script>

<script>
function back_goods_number(id){
 var goods_number = document.getElementById('goods_number'+id).value;
  document.getElementById('back_number'+id).value = goods_number;
}
function change_goods_number(type, id)
{
  var goods_number = document.getElementById('goods_number'+id).value;
  if(type != 2){back_goods_number(id)}
  if(type == 1){goods_number--;}
  if(type == 3){goods_number++;}
  if(goods_number <=0 ){goods_number=1;}
  if(!/^[0-9]*$/.test(goods_number)){goods_number = document.getElementById('back_number'+id).value;}
  document.getElementById('goods_number'+id).value = goods_number;
	$.post('<?php echo url("flow/ajax_update_cart");?>', {
		rec_id : id,goods_number : goods_number
	}, function(data) {
		change_goods_number_response(data,id);
	}, 'json');  
} 
// 处理返回信息并显示
function change_goods_number_response(result,id)
{
	if (result.error == 0){
		var rec_id = result.rec_id;
		$("#goods_number_"+rec_id).val(result.goods_number);
		document.getElementById('total_number').innerHTML = result.total_number;//更新数量
		document.getElementById('goods_subtotal').innerHTML = result.total_desc;//更新小计
		if (document.getElementById('ECS_CARTINFO')){
			//更新购物车数量
			document.getElementById('ECS_CARTINFO').innerHTML = result.cart_info;
		}
	}else if (result.message != ''){
		alert(result.message);
		var goods_number = document.getElementById('back_number'+id).value;
 		document.getElementById('goods_number'+id).value = goods_number;
	}                
}

	/*点击下拉手风琴效果*/
	$('.collapse').collapse()
	$(".checkout-select a").click(function(){
		if(!$(this).hasClass("select")){
			$(this).addClass("select");
		}else{	
			$(this).removeClass("select");
		}
	});
	
</script>
 <script type="text/javascript">
      	$(".precept").click(function(){
$("#ect-colory").html("<?php echo $this->_var['total']['amount_formated']; ?>");
		if($(this).val() == 1){
			
			$("#ms").html(
				"1、前一天总营业额的12%作为次日消费奖励总额。"+"</br>"+
				"2、按剩余总额的万分之六左右每天全额奖励，后续消费叠加。"+"</br>"+
				"3、最终解释权归成都沃尔迅科技有限公司所有。"
			)
		}else{
			var sum="<?php echo $this->_var['total']['amount']; ?>"*1.05;
			sum=sum.toFixed(2);
			$("#ect-colory").html('￥'+sum);
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
		
	})
      </script>
</body>
</html>
