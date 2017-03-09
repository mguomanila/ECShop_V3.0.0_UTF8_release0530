<?php echo $this->fetch('library/user_header.lbi'); ?>
<?php if ($this->_var['share']['on'] == 1): ?> 
<?php if (! $this->_var['goodsid'] || $this->_var['goodsid'] == 0): ?>



<!--<table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#dddddd" class="u-table" id="u-table">
	<div class="info_name"><?php echo $this->_var['info']['username']; ?></div>
    <tr>
      <td style="text-align:center;"><img src="<?php echo $this->_var['domain']; ?><?php echo url('user/create_qrcode', array('value'=>$this->_var['shopurl']));?>"></td>
    </tr>
    <tr>
        <td >
        	<div class="bdsharebuttonbox" data-tag="share_1" style="width:15em;margin:0 auto;">
				<a class="bds_weixin" data-cmd="weixin"></a>
        		
				<a class="bds_qzone" data-cmd="qzone" href="#"></a>
				<a class="bds_tsina" data-cmd="tsina"></a>
				<a class="bds_bdhome" data-cmd="bdhome"></a>
				<a class="bds_renren" data-cmd="renren"></a>

				
				
			</div>
        </td>
    </tr>
 </table>-->
 
 <div  id="u-table">
 	<div class="info_name_top"></div>
	<div class="info_name"><?php echo $this->_var['info']['username']; ?></div>
	<div class="tab_etop"></div>
    <div class="tab_ewm">
      <img src="<?php echo $this->_var['domain']; ?><?php echo url('user/create_qrcode', array('value'=>$this->_var['shopurl']));?>">
    </div>
    <div class="tab_fx_top"></div>
    <div class="tab_fx">
       
        	<div class="bdsharebuttonbox" data-tag="share_1" style="width:15em;margin:0 auto;">
				<a class="bds_weixin" data-cmd="weixin"></a>
        		
				<a class="bds_qzone" data-cmd="qzone" href="#"></a>
				<a class="bds_tsina" data-cmd="tsina"></a>
				<a class="bds_bdhome" data-cmd="bdhome"></a>
				<a class="bds_renren" data-cmd="renren"></a>
			</div>
       
    </div>
 </div>
  
</div>
<?php endif; ?> 
<?php endif; ?>


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
<script type="text/javascript">
	var table = $(window).height();
	$("#u-table").height(table+80);
</script>

	
