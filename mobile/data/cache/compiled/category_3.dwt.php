<!DOCTYPE html>
<html lang="en">

	<head>
<meta name="Generator" content="ECTouch 1.0" />
		<meta charset="UTF-8">
		<title>分类</title>
		<meta name="viewport" content="initial-scale=1, user-scalable=0, minimal-ui">
		<link rel="stylesheet" media="screen and (max-width:750px)" href="__TPL__/css/mobile.css" type="text/css" />
		<link rel="stylesheet" href="__TPL__/css/mobile.css">
		<link rel="stylesheet" href="__PUBLIC__/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="__PUBLIC__/bootstrap/css/font-awesome.min.css">
		<link rel="stylesheet" href="<?php echo $this->_var['ectouch_css_path']; ?>">
		<link rel="stylesheet" href="__TPL__/css/photoswipe.css">

		<link rel="stylesheet" href="__TPL__/css/qbfl.css">
	</head>

	<body>
		<div class="max">

			<div class="header">
				<div class="mobile_top">
					<a href="javascript:history.go(-1);" class="back"></a>

					<span><?php echo $this->_var['title']; ?></span>
					<a href="javascript:openSearch();" class="search1"></a>
				</div>
			</div>

			<div class="fdbox">
				<div class=" fl fdl">
					<ul>
						<?php $_from = $this->_var['category']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cat');$this->_foreach['no'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['no']['total'] > 0):
    foreach ($_from AS $this->_var['cat']):
        $this->_foreach['no']['iteration']++;
?>
						<li>
							<a href="javascript:select_ej(<?php echo $this->_var['cat']['id']; ?>);">
								<img src="<?php echo $this->_var['cat']['cat_image']; ?>" alt="" width="25" height="25" />
								<p><?php echo htmlspecialchars($this->_var['cat']['name']); ?></p>
							</a>
						</li>
						<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
						
						<div style="height: 25px;"></div>
					</ul>
				</div>
				<div class="ejfl fr">
					<ul class="ejfl_li">
						<?php $_from = $this->_var['cat_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cat');$this->_foreach['no'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['no']['total'] > 0):
    foreach ($_from AS $this->_var['cat']):
        $this->_foreach['no']['iteration']++;
?>
						<li>
							<a href="<?php echo $this->_var['cat']['url']; ?>">
								<?php echo htmlspecialchars($this->_var['cat']['name']); ?>
							</a>
						</li>
						<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
					</ul>

				</div>
			</div>
		</div>
		<?php echo $this->fetch('library/search.lbi'); ?>

	</body>

</html>
<script src="__TPL__/js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/jquery.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/jquery.json.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/common.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/jquery.more.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/utils.js"></script>
<script src="__TPL__/js/TouchSlide.1.1.js"></script>
<script src="__TPL__/js/ectouch.js"></script>
<script src="__TPL__/js/simple-inheritance.min.js"></script>
<script src="__TPL__/js/code-photoswipe-1.0.11.min.js"></script>
<script src="__PUBLIC__/bootstrap/js/bootstrap.min.js"></script>
<script src="__TPL__/js/jquery.scrollUp.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/validform.js"></script>
<script src="__TPL__/js/swiper.min.js"></script>
<script type="text/javascript">
	function openSearch() {
		if($(".max").is(":visible")) {
			$(".max").hide();
			$(".search").show();
		}
	}

	function closeSearch() {
		if($(".max").is(":hidden")) {
			$(".max").show();
			$(".search").hide();
		}
	}
</script>

<script>
	var h = document.documentElement.clientHeight;
	var w = document.documentElement.clientWidth;
	var b = w - $(".fdl").width();
	var a = h - $(".header").height();
	$(".fdl_li").height(a);
//	$(".fdl").css({
//			"maxHeight": a
//		})
		$(".ejfl").height(a);
//	$(".ejfl").css({
//		"maxHeight": a
//	})
	$(".ejfl").width(b-10);
	$(".fdbox").width(w);
	$(".max").height(h);
	$(".fdl li").on("click", $(".fdl li a"), function() {

		$(".fdl li a").removeClass("syfl_activate");

		$(this).find("a").addClass("syfl_activate");
	})
</script>
<script type="text/javascript">
	function select_ej(id) {
		$.ajax({
			type: "get",
			url: "<?php echo url('category/all');?>",
			async: true,
			data: "id=" + id + "&ajax=ajax",
			dataType: "Json",
			success: function(result, status) {
				if(status) {
					$(".ejfl_li li").remove();
				 for(var o in result){   
					$(".ejfl_li").append("<li><a href='"+result[o]['url']+"'>"+result[o]['name']+"</a></li>")
			      }  
				}
				
			}
		});
	}
</script>