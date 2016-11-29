<?php echo $this->fetch('library/user_header.lbi'); ?>
<?php if ($this->_var['share']['on'] == 1): ?> 
<?php if (! $this->_var['goodsid'] || $this->_var['goodsid'] == 0): ?>



<table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#dddddd" class="u-table">
    <tr>
      <td style="text-align:center;"><?php echo $this->_var['shopurl']; ?><br><img src="<?php echo $this->_var['domain']; ?><?php echo url('user/create_qrcode', array('value'=>$this->_var['shopurl']));?>"></td>
    </tr>
    <tr>
        <td >
        	<div class="bdsharebuttonbox" data-tag="share_1" style="width:12em;margin:0 auto;">
				<a class="bds_qzone" data-cmd="qzone" href="#"></a>
				<a class="bds_tsina" data-cmd="tsina"></a>
				<a class="bds_bdhome" data-cmd="bdhome"></a>
				<a class="bds_renren" data-cmd="renren"></a>
				
			</div>
        </td>
    </tr>
  </table>




<?php if ($this->_var['share']['config']['separate_by'] == 0): ?>
  <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#dddddd" class="u-table">
    <tr align="center" class="first-tr">
      <td><?php echo $this->_var['lang']['affiliate_lever']; ?></td>
      <td><?php echo $this->_var['lang']['label_username']; ?></td>
			<td>注册时间</td>

    </tr>
    <?php $_from = $this->_var['aff_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('level', 'val');$this->_foreach['affdb'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['affdb']['total'] > 0):
    foreach ($_from AS $this->_var['level'] => $this->_var['val']):
        $this->_foreach['affdb']['iteration']++;
?>
    <tr align="center" onclick="select_earnings(this,<?php echo $this->_var['val']['user_id']; ?>,'<?php echo $this->_var['val']['user_name']; ?>');" >
      <td><?php echo $this->_var['lang']['user_type'][$this->_var['val']['user_type']]; ?></td>
      <td><?php echo $this->_var['val']['user_name']; ?></td>
			<td><?php echo $this->_var['val']['reg_time']; ?></td>

    </tr>
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

  <?php endif; ?>











  
</div>
<?php endif; ?> 
<?php endif; ?>
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
						$(obj).after("<tr align='center' class='earnings' id='s"+user_id+"'><td>"+user_name+"今日充值</td><td colspan='2'>"+result['recharge']+"金元宝</td></tr><tr align='center' class='earnings' id='s"+user_id+"'><td>您今日的收益</td><td colspan='2'>"+result['earnings']+"金元宝</td></tr>");		
						
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