<a id="scrollUp" href="#top" style="position: fixed; z-index: 1001;"><i class="fa fa-angle-up"></i></a>
<?php if ($this->_var['title'] != '登录'): ?>
<div class="nex">
	<span></span>
</div>
<?php endif; ?>
<style>
#scrollUp {
	border-radius:100%;
	background-color: #777;
	color: #eee;
	font-size: 40px;
	line-height: 1;text-align: center;text-decoration: none;bottom: 2em;right: 10px;overflow: hidden;width: 46px;
	height: 46px;
	border: none;
	opacity: 0.6;
}
</style>
<script type="text/javascript" src="__TPL__/js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="__TPL__/js/swiper.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/jquery.json.js" ></script> 
<script type="text/javascript" src="__PUBLIC__/js/common.js"></script> 
<script type="text/javascript" src="__PUBLIC__/js/user.js"></script> 
<script type="text/javascript" src="__PUBLIC__/js/jquery.more.js" id="morejs"></script> 
<script type="text/javascript" src="__PUBLIC__/js/utils.js" ></script> 
<script src="__TPL__/js/TouchSlide.1.1.js"></script> 
<script src="__TPL__/js/ectouch.js"></script> 
<script src="__TPL__/js/simple-inheritance.min.js"></script> 
<script src="__TPL__/js/code-photoswipe-1.0.11.min.js"></script> 
<script src="__PUBLIC__/bootstrap/js/bootstrap.min.js"></script> 
<script src="__TPL__/js/jquery.scrollUp.min.js"></script> 
<script type="text/javascript" src="__PUBLIC__/js/validform.js" ></script> 
<script language="javascript">
	/*banner滚动图片*/
		TouchSlide({
			slideCell : "#focus",
			titCell : ".hd ul", // 开启自动分页 autoPage:true ，此时设置 titCell 为导航元素包裹层
			mainCell : ".bd ul",
			effect : "left",
			autoPlay : true, // 自动播放
			autoPage : true, // 自动分页
			delayTime: 200, // 毫秒；切换效果持续时间（执行一次效果用多少毫秒）
			interTime: 2500, // 毫秒；自动运行间隔（隔多少毫秒后执行下一个效果）
			switchLoad : "_src" // 切换加载，真实图片路径为"_src"
		});
	/*弹出评论层并隐藏其他层*/
	function openSearch(){
		if($(".con").is(":visible")){
			$(".con").hide();	
			$(".search").show();
		}
	}
	function closeSearch(){
		if($(".con").is(":hidden")){
			$(".con").show();	
			$(".search").hide();
		}
	}
</script> 
<script type="text/javascript">

	
	
//	function random(range){
//		var max = Math.max(range[0],range[1]);
//		var min = Math.min(range[0],range[1]);
//		var diff = max - min;
//		var number = Math.ceil( Math.random()*diff + min );
//		return number ;
//	}


$(function(){
	var a =["赵","孟","钱","孙","李","周","吴","郑","王","冯","陈","楮","卫","蒋","沈","韩","杨","朱","秦","尤"];
	var b=["潘","葛","奚","范","彭","郎","鲁","韦","昌","马","苗","凤","花","方","俞","任","袁","柳","酆","鲍","史","唐"];
	var c=["许","何","吕","施","张","孔","曹","严","华","金","魏","陶","姜","戚","谢","邹","喻","柏","水","窦","章","云","苏"];
	var d=['131','133','139','135','150','151','155','182','187','185','130','132','134','159','153','180','181'];
	var msg = ["注册普通会员成功","购买商品成功","充值金元宝成功","升级金钻成功"];

	function random(range){
		var max = Math.max(range[0],range[1]);
		var min = Math.min(range[0],range[1]);
		var diff = max - min;
		var number = Math.ceil( Math.random()*diff + min );
		return number ;
	}
	var i;
	var j=random([5,12])*1000;

	function ra(){
	 j=random([5,12])*1000;	
	 return j;
	 
	}
	function showTest(){
				
		$(".nex").find("span").remove();
		//Math.floor(Math.random() * msg.length)
		if ($(".nex").css("display") == 'none') {
			$("<span>"+a.concat(b,c,d)[Math.floor(Math.random() * a.concat(b,c,d).length)]+"**,"+msg[Math.floor(Math.random() * msg.length)]+"</span>").appendTo(".nex");
			$(".nex").fadeToggle("100");
		}
		setTimeout(function(){
			$(".nex").fadeToggle("100");

		},2000)	
		ra();
	
		i = setTimeout(showTest,j);
	}
	setTimeout(function(){

		showTest();

	},10000)
})	

	
</script>
