
<?php if ($this->_var['hot_goods']): ?>
<a href="<?php echo $this->_var['hot_goods']['url']; ?>">

	<img src="<?php echo $this->_var['hot_goods']['goods_img']; ?>" alt=""  style="height: 150px;"/>
	<span><?php echo $this->_var['hot_goods']['name']; ?></span>
	<p><?php echo $this->_var['hot_goods']['shop_price']; ?><span class="shapbox_xl">销量：<?php echo $this->_var['hot_goods']['sales_count']; ?></span></p>
</a>
<?php endif; ?> 
 
