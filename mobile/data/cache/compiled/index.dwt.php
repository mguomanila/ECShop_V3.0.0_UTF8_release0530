<?php echo $this->fetch('library/page_header.lbi'); ?>
<link rel="stylesheet" type="text/css" href="__TPL__/css/lrtk.css" />

<div class="con">
	<div class="Upper">
	<header class="ect-header ect-margin-tb ect-margin-lr">
		<a href="<?php echo url('category/top_all');?>" class="pull-left ect-icon ect-icon1 ect-icon-cate1"></a>
		<div class="ect-header-div">
			<button class="btn btn-default ect-text-left ect-btn-search" onClick="javascript:openSearch();"><i class="fa fa-search"></i>&nbsp;平安车险正式上线</button>
		</div>
	</header>
	<!--<header class="ect-header "> 
  	<img src="themes/default/images/title_img.jpg" style="width: 100%;"/>
  </header>-->
	
	<div id="focus" class="focus ect-margin-tb">
		<div class="hd">
			<ul>
			</ul>
		</div>
		<div class="bd">
			<?php 
$k = array (
  'name' => 'ads',
  'id' => '1',
  'num' => '5',
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?>
		</div>
	</div>
	<!--<div style="text-align: center;padding: 5px 0 18px;"><img src="__TPL__/images/logo.png" style="width:100%" /></div>-->
	
	<nav class="container-fluid">
		<ul class="row ect-row-nav">
			<?php $_from = $this->_var['navigator']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'nav');if (count($_from)):
    foreach ($_from AS $this->_var['nav']):
?>
			<a href="<?php echo $this->_var['nav']['url']; ?>">
				<li class="col-sm-3 col-xs-3"><i><img src="<?php echo $this->_var['nav']['pic']; ?>" ></i>
					<p class="text-center"><?php echo $this->_var['nav']['name']; ?></p>
				</li>
			</a>
			<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
		</ul>
	</nav>
	
	
	<div>
		<div class="tjcp_name">
			<img src="themes/default/images/new.jpg" alt="" style="width: 100%;"/>
		</div>
		<ul class="shapbox">
			<?php $_from = $this->_var['new_goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'lis');if (count($_from)):
    foreach ($_from AS $this->_var['lis']):
?>
			<li>
				<a href="<?php echo $this->_var['lis']['url']; ?>">
					<div class="jingp xinp">
						<img src="themes/default/images/new_img2.png" alt="" />
					</div>
					<img src="<?php echo $this->_var['lis']['goods_img']; ?>" alt="" />
					<span><?php echo $this->_var['lis']['name']; ?></span>
					<p><?php echo $this->_var['lis']['shop_price']; ?><span class="shapbox_xl">销量：<?php echo $this->_var['lis']['sales_count']; ?></span></p>
				</a>
			</li>
			<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

		</ul>
	</div>
	
	
	
	
	
	
<div id="">
		<div class="tjcp_name">
			<img src="themes/default/images/best.jpg" alt="" style="width: 100%;"/>
		</div>
		<div class="tjsp swiper-container">

			<ul class="swiper-wrapper">
				<?php $_from = $this->_var['best_goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');if (count($_from)):
    foreach ($_from AS $this->_var['list']):
?>
				<li class="swiper-slide">
					<a href="<?php echo $this->_var['list']['url']; ?>">
						<div class="tjspbox">
							<img src="<?php echo $this->_var['list']['goods_img']; ?>" alt="" />

						</div>
						<span><?php echo $this->_var['list']['name']; ?></span>
					</a>
				</li>
				<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
			</ul>

		</div>

	</div>

		<div class="ect-margin-tb shapbox ect-margin-bottom0" style="border-bottom:none;" >
		<div class="tjcp_name">
			<img src="themes/default/images/hot.jpg" alt="" style="width: 100%;"/>
		</div>
		
		
		<ul id="J_ItemList">
		  	<li class="single_item">
		    </li>
		     <a href="javascript:;" style="text-align:center" class="get_more"></a>
		  </ul>
		
		
		<ul class="shapbox">
			<?php $_from = $this->_var['hot_goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'lis');if (count($_from)):
    foreach ($_from AS $this->_var['lis']):
?>
			<li>
				<a href="<?php echo $this->_var['lis']['url']; ?>">
					<div class="jingp">
						
					</div>
					<img src="<?php echo $this->_var['lis']['goods_img']; ?>" alt="" />
					<span><?php echo $this->_var['lis']['name']; ?></span>
					<p><?php echo $this->_var['lis']['shop_price']; ?><span class="shapbox_xl">销量：<?php echo $this->_var['lis']['sales_count']; ?></span></p>
				</a>
			</li>
			<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

		</ul>
		
		
		
	</div>




	<footer>
		<nav class="ect-nav">
			<?php echo $this->fetch('library/page_menu.lbi'); ?>
		</nav>
	</footer>
	<div style="padding-bottom:4.2em;"></div>
	
	</div>
</div>
<script type="text/javascript" src="__TPL__/js/jquery_money.js"></script>

<script type="text/javascript">
$.AutomLeafStart({
	leafsfolder:"__TPL__/money/",
	howmanyimgsare:3,
	initialleafs: 20,
	maxYposition:-500,
	multiplyclick:false,
	multiplynumber:3,
	infinite:false,
	fallingsequence:-100
});

	$.AutomLeafAdd({leafsfolder:"__TPL__/money/",add:10,});

//$("#botAgregar").on("click",function(){$.AutomLeafAdd({leafsfolder:"images/",add:8,})});
</script>
<?php echo $this->fetch('library/search.lbi'); ?>
<?php echo $this->fetch('library/page_footer.lbi'); ?>


<!--<div class="hbbox">
	<div class="hongbao">
		<a href="javascript:djhb()">
			<img src="themes/default/images/hb.png" alt="" width="70%">
			<div class="hongbaoc">
				<p>您手速慢了，没有抢到哦</p>
			</div>
		</a>
		
	</div>
	
</div>-->

<script type="text/javascript">
	var swiper = new Swiper('.tjsp', {
		//      pagination: '.swiper-pagination',
		slidesPerView: 3,
		paginationClickable: true,
		spaceBetween: 1,
		setWrapperSize: false,
		autoplay: 2000,
        autoplayDisableOnInteraction : false
	});
	get_asynclist("<?php echo url('index/ajax_goods', array('type'=>'1'));?>" , '__TPL__/images/loader.gif');
</script>
<script type="text/javascript" src="themes/default/js/b.js"></script>

<!--<script>
  function djhb(){
  	
  	if ($("div").hasClass("block")) {
  		$(".hongbao").css({"display":"none"});
  		$(".hbbox").removeClass("hbanme");
  	}
  	$(".hongbaoc").addClass("block");
	$(".hongbao img").attr({"src":"themes/default/images/hb1.png"});
  	var set = setInterval(mov,3000);
  	function mov(){
  		$(".hongbao").css({"display":"none"});
  	    $(".hbbox").removeClass("hbanme");
  	}
  }

	$(".hbbox").css({"marginLeft":"-105px"});
</script>-->

</body>

</html>