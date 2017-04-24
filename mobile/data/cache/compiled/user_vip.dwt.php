<?php echo $this->fetch('library/user_header.lbi'); ?>



  <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#dddddd" class="u-table">
    <tr align="center" class="first-tr">
      <td><?php echo $this->_var['lang']['affiliate_lever']; ?></td>
      <td><?php echo $this->_var['lang']['label_username']; ?></td>
			<td>注册时间</td>
			<td>总收益</td>

    </tr>
    <?php if ($this->_var['aff_arr']): ?>
    <?php $_from = $this->_var['aff_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('level', 'val');$this->_foreach['affdb'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['affdb']['total'] > 0):
    foreach ($_from AS $this->_var['level'] => $this->_var['val']):
        $this->_foreach['affdb']['iteration']++;
?>
    <tr align="center" onclick="select_earnings(this,<?php echo $this->_var['val']['user_id']; ?>,'<?php echo $this->_var['val']['user_name']; ?>');" >
      <td><?php echo $this->_var['lang']['user_type_vip'][$this->_var['val']['user_type']]; ?></td>
      <td><?php echo $this->_var['val']['user_name']; ?></td>
			<td><?php echo $this->_var['val']['reg_time']; ?></td>
			<td><?php echo $this->_var['val']['integral_amount']; ?></td>

    </tr>
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    <?php else: ?>
    <tr align="center" onclick="select_earnings(this,<?php echo $this->_var['val']['user_id']; ?>,'<?php echo $this->_var['val']['user_name']; ?>');" >
    	<td colspan="4">暂无下级会员</td>
    </tr>
    
	<?php endif; ?>
</table>
  
</div>

<script type="text/javascript">
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
	
