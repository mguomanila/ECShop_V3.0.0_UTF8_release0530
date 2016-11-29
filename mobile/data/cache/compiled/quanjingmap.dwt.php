<!DOCTYPE html>
<html>
<head>
<meta name="Generator" content="ECTouch 1.0" />
	<title>普通地图&全景图</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes, minimal-ui" /> 
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=bOs3xxrjegpsKpNwHF0MZYTgdmw4Ag7U"></script>
	<style type="text/css">
		body, html{width: 100%;height: 100%;overflow: hidden;margin:0;font-family:"微软雅黑";}
		#panorama {height: 50%;overflow: hidden;}
		#normal_map {height:50%;overflow: hidden;}
		#panorama div:nth-child(4){
			display: none!important;		
			}
	</style>
</head>
<body>
	<div id="panorama"></div>
	<div id="normal_map"></div>
	<script type="text/javascript">
	//全景图展示
	var panorama = new BMap.Panorama('panorama');
	panorama.setPosition(new BMap.Point(<?php echo $this->_var['x']; ?>,<?php echo $this->_var['y']; ?>)); //根据经纬度坐标展示全景图
	panorama.setPov({heading: -40, pitch: 6});

	panorama.addEventListener('position_changed', function(e){ //全景图位置改变后，普通地图中心点也随之改变
		var pos = panorama.getPosition();
		map.setCenter(new BMap.Point(pos.lng, pos.lat));
		marker.setPosition(pos);
	});
	//普通地图展示
	var mapOption = {
			mapType: BMAP_NORMAL_MAP,
			maxZoom: 18,
			drawMargin:0,
			enableFulltimeSpotClick: true,
			enableHighResolution:true
		}
	var map = new BMap.Map("normal_map", mapOption);
	var testpoint = new BMap.Point(<?php echo $this->_var['x']; ?>,<?php echo $this->_var['y']; ?>);
	map.centerAndZoom(testpoint, 18);
	var marker=new BMap.Marker(testpoint);
	marker.enableDragging();
	map.addOverlay(marker);  
	marker.addEventListener('dragend',function(e){
		panorama.setPosition(e.point); //拖动marker后，全景图位置也随着改变
		panorama.setPov({heading: -40, pitch: 6});}
	);
	</script>
</body>
</html>