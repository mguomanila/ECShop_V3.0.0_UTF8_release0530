<?php exit;?>a:3:{s:8:"template";a:2:{i:0;s:75:"D:\wamp64\www\ECShop_V3.0.0_UTF8_release0530\mobile/themes/default/ejfl.dwt";i:1;s:85:"D:\wamp64\www\ECShop_V3.0.0_UTF8_release0530\mobile/themes/default/library/search.lbi";}s:7:"expires";i:1479716873;s:8:"maketime";i:1479713273;}<!DOCTYPE html>
<html lang="en">
<head>
<meta name="Generator" content="ECTouch 1.0" />
	<meta charset="UTF-8">
	<title>详细分类</title>
	<meta name="viewport" content="initial-scale=1, user-scalable=0, minimal-ui">
	<link rel="stylesheet" media="screen and (max-width:750px)" href="__TPL__/css/mobile.css" type="text/css" />
	<link rel="stylesheet" href="__TPL__/css/mobile.css">
	<link rel="stylesheet" href="__PUBLIC__/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="__PUBLIC__/bootstrap/css/font-awesome.min.css">
<link rel="stylesheet" href="/ecshop_v3.0.0_utf8_release0530/mobile/themes/default/css/ectouch.css">
<link rel="stylesheet" href="__TPL__/css/photoswipe.css">
</head>
<body>
	<div class="max">
		<div class="header">
			<div class="mobile_top">
				<a href="javascript:history.go(-1);" class="back"></a>
				<span>家用电器</span>
				<a href="javascript:openSearch();" class="search1">
				</a>
			</div>
		</div>
		
		<div class="section">
					
					<div class="section_bot">
						<ul>
														<li>
								<a href="/ecshop_v3.0.0_utf8_release0530/mobile/index.php?m=default&c=category&a=index&id=27">
									<img src="/ecshop_v3.0.0_utf8_release0530/mobile/data/common/images/no_picture.gif" alt="" width="75"height="75"/>
									<p>大家电</p>
								</a>
							</li>
														<div class="cl"></div>
						</ul>
						
						
					</div>
		</div>
	</div>
	<div class="search" style="display:none;">
  <div class="ect-bg">
    <header class="ect-header ect-margin-tb ect-margin-lr text-center"><span>搜索</span><a href="javascript:;" onClick="closeSearch();"><i class="icon-close pull-right"></i></a></header>
  </div>
  <div class="ect-padding-lr">
     <form action="/ecshop_v3.0.0_utf8_release0530/mobile/index.php?m=default&c=category&a=index"  method="post" id="searchForm" name="searchForm">
      <div class="input-search"> <span>
        <input name="keywords" type="search" placeholder="请输入搜索关键词！" id="keywordBox">
        </span>
        <button type="submit" value="搜索" onclick="return check('keywordBox')"><i class="glyphicon glyphicon-search"></i></button>
      </div>
    </form>
     
  </div>
</div>
	
</body>
</html>
<script src="__TPL__/js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/jquery.min.js" ></script> 
<script type="text/javascript" src="__PUBLIC__/js/jquery.json.js" ></script> 
<script type="text/javascript" src="__PUBLIC__/js/common.js"></script> 
<script type="text/javascript" src="__PUBLIC__/js/jquery.more.js"></script> 
<script type="text/javascript" src="__PUBLIC__/js/utils.js" ></script> 
<script src="__TPL__/js/TouchSlide.1.1.js"></script> 
<script src="__TPL__/js/ectouch.js"></script> 
<script src="__TPL__/js/simple-inheritance.min.js"></script> 
<script src="__TPL__/js/code-photoswipe-1.0.11.min.js"></script> 
<script src="__PUBLIC__/bootstrap/js/bootstrap.min.js"></script> 
<script src="__TPL__/js/jquery.scrollUp.min.js"></script> 
<script type="text/javascript" src="__PUBLIC__/js/validform.js" ></script> 
<script type="text/javascript">
	function openSearch(){
		if($(".max").is(":visible")){
			$(".max").hide();	
			$(".search").show();
		}
	}
	function closeSearch(){
		if($(".max").is(":hidden")){
			$(".max").show();	
			$(".search").hide();
		}
	}
</script>