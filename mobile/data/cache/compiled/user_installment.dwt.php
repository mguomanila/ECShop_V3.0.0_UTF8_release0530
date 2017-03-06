<?php echo $this->fetch('library/user_header.lbi'); ?>



  <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#dddddd" class="u-table">
    <tr align="center" class="first-tr">
      <td>订单编号</td>
      <td>商品名</td>
			<td>分期数</td>
			<td>操作</td>

    </tr>
    <?php if ($this->_var['list']): ?>
    <?php $_from = $this->_var['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('level', 'val');$this->_foreach['affdb'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['affdb']['total'] > 0):
    foreach ($_from AS $this->_var['level'] => $this->_var['val']):
        $this->_foreach['affdb']['iteration']++;
?>
    <tr align="center" onclick="select_earnings(<?php echo $this->_var['level']; ?>);" >
      <td><?php echo $this->_var['val']['order_sn']; ?></td>
      <td><?php echo $this->_var['val']['goods_name']; ?></td>
			<td><?php echo $this->_var['val']['num']; ?></td>
			<td>查看</td>
    </tr >
	    <?php $_from = $this->_var['val']['num_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('level_1', 'v');$this->_foreach['affdb'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['affdb']['total'] > 0):
    foreach ($_from AS $this->_var['level_1'] => $this->_var['v']):
        $this->_foreach['affdb']['iteration']++;
?>
	    <tr  class="arr<?php echo $this->_var['level']; ?>" style="display: none;background:  #F4F4F4; " align="center"  >
	      <td colspan="2">第<?php echo $this->_var['level_1']; ?>期</td>
	      <?php if ($this->_var['v']['status'] == 1 && $this->_var['v']['str']): ?>
	      <td  colspan="2" style="color: #888;">已领取</td>
	      <?php elseif ($this->_var['v']['status'] == 1 && $this->_var['v']['str'] == ''): ?>
	      <td  colspan="2" style="color: #EC971F;"onclick="apply(<?php echo $this->_var['level_1']; ?>,<?php echo $this->_var['val']['id']; ?>,<?php echo $this->_var['val']['order_id']; ?>,<?php echo $this->_var['val']['goods_id']; ?>);">可领取</td>
	      <?php elseif ($this->_var['v']['status'] == 9): ?>
	      <td  colspan="2">未领取</td>
	      <?php elseif ($this->_var['v']['status'] == 0): ?>
	      <td  colspan="2">领取中</td>
	      <?php elseif ($this->_var['v']['status'] == 2): ?>
	      <td  colspan="2">发货中</td>
	      <?php endif; ?>
    	</tr>
	    	
	    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    <?php else: ?>
    <tr align="center" onclick="select_earnings(this,<?php echo $this->_var['val']['user_id']; ?>,'<?php echo $this->_var['val']['user_name']; ?>');" >
    	<td colspan="4">暂无分期活动商品</td>
    </tr>
    
	<?php endif; ?>
</table>
  
</div>

<script type="text/javascript">
	function select_earnings(id){
//		console.log($(".arr"+id).)
		
		for (var as=0;as<<?php echo $this->_var['count']; ?>;as++) {
//			console.log($(".arr"+id));
			if(id == as){
				$(".arr"+id).toggle("show");
			}else{
				$(".arr"+as).css("display","none");
			}
		}
	}
	function apply(level,id,order_id,goods_id){
		$.ajax({
			type:"get",
			url:"<?php echo url('user/installment_account');?>",
			data:"level="+level+"&id="+id+"&order_id="+order_id+"&goods_id="+goods_id+"&type=1",
			dataType:"json",
			success:function(result,status){
				console.log(result);
			}
		});
	}
</script>
<script>
	window._bd_share_config = {
		common : {
			bdText : '<?php echo $this->_var['shopdesc']; ?>',
			bdUrl : '<?php echo $this->_var['shopurl']; ?>',
			bdPic : "<?php echo $this->_var['domain']; ?><?php echo url('user/create_qrcode', array('value'=>$this->_var['shopurl']));?>"
		},
		share : [{
			"bdSize" : 32
		}]
	}
	with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?cdnversion='+~(-new Date()/36e5)];
</script>
<?php echo $this->fetch('library/search.lbi'); ?>
<?php echo $this->fetch('library/page_footer.lbi'); ?>
<?php echo $this->fetch('library/nav.lbi'); ?>
	
