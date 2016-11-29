<?php echo $this->fetch('library/user_header.lbi'); ?>
<link rel="stylesheet" href="__TPL__/css/sjxq.css">
<link rel="stylesheet" href="__TPL__/css/swiper.min.css">
<link rel="stylesheet" href="http://api.map.baidu.com/library/SearchInfoWindow/1.5/src/SearchInfoWindow_min.css" />

 
    <div class="section">
        <div class="shang_img swiper-container">
        	<ul class="swiper-wrapper">
        		<?php $_from = $this->_var['facade_img']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'path');if (count($_from)):
    foreach ($_from AS $this->_var['path']):
?>
	    		<?php if ($this->_var['path'] != ''): ?>
        		<li class="swiper-slide">
        			 <a href="javascript:">
			            <img src="../<?php echo $this->_var['path']; ?>" alt="" height="400">
			          </a>
        		</li>
        			<?php endif; ?>
		    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
	    		
        		
        	</ul>
         <div class="swiper-pagination"></div>
        </div>

        <div class="shang_xq">
          <a href="javascript:"><?php echo $this->_var['alliance_list']['trade_name']; ?></a>

          <p>联系人：<span><?php echo $this->_var['alliance_user_list']['101']; ?></span></p>

          <p>联系电话：<span><?php echo $this->_var['alliance_user_list']['mobile_phone']; ?></span></p>

          <p>店铺地址：<span><?php echo $this->_var['alliance_list']['suppliers_site']; ?></span></p>
          <p style="overflow: hidden;border-bottom: none 0;">
          	<?php if ($this->_var['alliance_list']['X_coord'] && $this->_var['alliance_list']['Y_coord']): ?>
			<a href="<?php echo url('alliance/quanjing');?>&x=<?php echo $this->_var['alliance_list']['X_coord']; ?>&y=<?php echo $this->_var['alliance_list']['Y_coord']; ?>" style="float: right;font-size: 18px;color:#e87e04;position: relative;top: 2px;"><img height="24px" src="__TPL__/images/camera.gif" alt="" style="position: relative;top: -3px;"/>&nbsp;&nbsp;进入全景</a>
          	<?php endif; ?>
          </p>

        </div>
    </div>


    <div id="map">
      
    </div>
 
  </div>
<?php echo $this->fetch('library/search.lbi'); ?>
<?php echo $this->fetch('library/page_footer.lbi'); ?>
</body>
</html>
<script type="text/javascript">



	var swiper = new Swiper('.swiper-container', {
        pagination: '.swiper-pagination',
        slidesPerView: 1,
        paginationClickable: true,
        spaceBetween: 0
    });



</script>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=WmxDiozVlw3RVIqn54PgoFSt8k1LYd14"></script>
<script type="text/javascript" src="http://api.map.baidu.com/library/SearchInfoWindow/1.5/src/SearchInfoWindow_min.js"></script>
<script>
   $(document).ready(function(){
    
      $("#map").css("width", $(window).width()) ;

      
    })

   
  var map = new BMap.Map('map');
    var poi = new BMap.Point(<?php echo $this->_var['alliance_list']['X_coord']; ?>,<?php echo $this->_var['alliance_list']['Y_coord']; ?>);

    map.centerAndZoom(poi, 16);
    map.enableScrollWheelZoom();

    var content = '<div style="margin:0;line-height:20px;padding:2px;">' +
                    '<img src="../<?php echo $this->_var['alliance_list']['facade_img']; ?>" alt="" style="float:right;zoom:1;overflow:hidden;width:100px;height:100px;margin-left:3px;"/>' +
                    '地址：<?php echo $this->_var['alliance_list']['suppliers_site']; ?><br/>电话：<?php echo $this->_var['alliance_user_list']['mobile_phone']; ?><br/>简介：<?php echo $this->_var['alliance_list']['suppliers_desc']; ?>' +
                  '</div>';

    //创建检索信息窗口对象
    var searchInfoWindow = null;
  searchInfoWindow = new BMapLib.SearchInfoWindow(map, content, {
      title  : "<?php echo $this->_var['alliance_list']['suppliers_site']; ?>",      //标题
      width  : 290,             //宽度
      height : 105,              //高度
      panel  : "panel",         //检索结果面板
      enableAutoPan : true,     //自动平移
      searchTypes   :[
        BMAPLIB_TAB_SEARCH,   //周边检索
        BMAPLIB_TAB_TO_HERE,  //到这里去
        BMAPLIB_TAB_FROM_HERE //从这里出发
      ]
    });
    var marker = new BMap.Marker(poi); //创建marker对象
//  marker.enableDragging(); //marker可拖拽
    marker.addEventListener("click", function(e){
      searchInfoWindow.open(marker);
    })
    map.addOverlay(marker); //在地图中添加marker


  
</script>