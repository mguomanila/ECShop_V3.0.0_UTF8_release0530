<?php

/**
 * ECTouch Open Source Project
 * ============================================================================
 * Copyright (c) 2012-2014 http://ectouch.cn All rights reserved.
 * ----------------------------------------------------------------------------
 * 文件名称：BrandModel.class.php
 * ----------------------------------------------------------------------------
 * 功能描述：ECTOUCH 品牌模型
 * ----------------------------------------------------------------------------
 * Licensed ( http://www.ectouch.cn/docs/license.txt )
 * ----------------------------------------------------------------------------
 */
/* 访问控制 */
defined('IN_ECTOUCH') or die('Deny Access');


class AllianceModel extends BaseModel {

    /**
     * 获得品牌下的商品
     *
     * @access private
     * @param integer $brand_id 
     * @return array
     */
    function alliance_get_goods($brand_id, $cate, $sort, $order, $size, $page) {

        $cate_where = ($cate > 0) ? 'AND ' . get_children($cate) : '';

        $start = ($page - 1) * $size;
        /* 获得商品列表 */
        $sort = $sort == 'sales_volume' ? 'xl.sales_volume' : $sort;
        $sql = 'SELECT g.goods_id, g.goods_name,g.goods_number, g.market_price, g.shop_price AS org_price, ' . "IFNULL(mp.user_price, g.shop_price * '$_SESSION[discount]') AS shop_price, g.promote_price, " . 'g.promote_start_date, g.promote_end_date, g.goods_brief, g.goods_thumb , g.goods_img ' . 'FROM ' . $this->pre . 'goods AS g ' . 'LEFT JOIN ' . $this->pre . 'touch_goods AS xl ' . "ON g.goods_id=xl.goods_id " . 'LEFT JOIN ' . $this->pre . 'member_price AS mp ' . "ON mp.goods_id = g.goods_id AND mp.user_rank = '$_SESSION[user_rank]' " . "WHERE g.is_on_sale = 1 AND g.is_alone_sale = 1 AND g.is_delete = 0 AND g.suppliers_id > '$brand_id' $cate_where" . "ORDER BY $sort $order LIMIT $start , $size";
        
        $res = $this->query($sql);

        $arr = array();
        foreach ($res as $row) {
            if ($row['promote_price'] > 0) {
                $promote_price = bargain_price($row['promote_price'], $row['promote_start_date'], $row['promote_end_date']);
            } else {
                $promote_price = 0;
            }

            $arr[$row['goods_id']]['goods_id'] = $row['goods_id'];
            if ($GLOBALS['display'] == 'grid') {
                $arr[$row['goods_id']]['goods_name'] = C('goods_name_length') > 0 ? sub_str($row['goods_name'], C('goods_name_length')) : $row['goods_name'];
            } else {
                $arr[$row['goods_id']]['goods_name'] = $row['goods_name'];
            }
            $arr[$row['goods_id']]['discount'] = $row['market_price'] > 0 ? (round((($promote_price > 0 ? $promote_price : $row['shop_price']) / $row['market_price']) * 10)) : 0;
            $arr[$row['goods_id']]['goods_number'] = $row['goods_number'];
            $arr[$row['goods_id']]['market_price'] = price_format($row['market_price']);
            $arr[$row['goods_id']]['shop_price'] = price_format($row['shop_price']);
            $arr[$row['goods_id']]['promote_price'] = ($promote_price > 0) ? price_format($promote_price) : '';
            $arr[$row['goods_id']]['goods_brief'] = $row['goods_brief'];
            $arr[$row['goods_id']]['goods_thumb'] = get_image_path($row['goods_id'], $row['goods_thumb'], true);
            $arr[$row['goods_id']]['goods_img'] = get_image_path($row['goods_id'], $row['goods_img']);
            $arr[$row['goods_id']]['url'] = url('goods/index', array('id' => $row['goods_id']));
            $arr[$row['goods_id']]['sales_count'] = model('GoodsBase')->get_sales_count($row['goods_id']);
            $arr[$row['goods_id']]['sc'] = model('GoodsBase')->get_goods_collect($row['goods_id']);
            $arr[$row['goods_id']]['promotion'] = model('GoodsBase')->get_promotion_show($row['goods_id']);
            $arr[$row['goods_id']]['comment_count'] = model('Comment')->get_goods_comment($row['goods_id'], 0);  //商品总评论数量
            $arr[$row['goods_id']]['favorable_count'] = model('Comment')->favorable_comment($row['goods_id'], 0);  //获得商品好评数量
            $arr[$row['goods_id']]['mysc'] = 0;
            // 检查是否已经存在于用户的收藏夹
            if ($_SESSION['user_id']) {
                unset($where);
                // 用户自己有没有收藏过
                $where['goods_id'] = $row['goods_id'];
                $where['user_id'] = $_SESSION['user_id'];
                $rs = $this->model->table('collect_goods')
                        ->where($where)
                        ->count();
                $arr[$row['goods_id']]['mysc'] = $rs;
            }
        }

        return $arr;
    }
    
    
    
    
    
    function get_alliance_info($suppliers_id){
    	
    	$sql="SELECT * FROM ". $this->pre ."suppliers WHERE suppliers_id = $suppliers_id";

    	$res = $this->row($sql);
    	
    	return $res;
    }
    
    function get_alliance_user($user_name){
    
    	$sql="SELECT * FROM ". $this->pre ."users WHERE user_name = '$user_name' ";

    	$res = $this->row($sql);

    	$where = 'type < 2';
        $extend_info_list = $this->model->table('reg_fields')
                ->where($where)
                ->order('dis_order, id')
                ->select();
		$condition['user_id'] = $res['user_id'];
        $extend_info_arr = $this->model->table('reg_extend_info')
                ->field('reg_field_id, content')
                ->where($condition)
                ->select();

        foreach ($extend_info_arr as $key => $value) {
        	$res[$value['reg_field_id']]=$value['content'];
        }
    	return $res;
    }
    
    

    /**
     * 获得品牌列表
     *
     * @global type $page_libs
     * @staticvar null $static_page_libs
     * @param type $cat 
     * @param type $app 
     * @param type $size 
     * @param type $page 
     * @return type
     */
    function get_brands($app = 'brand', $size, $page,$cat_id=0) {

        $start = ($page - 1) * $size;
        $cat_str=get_children($cat_id);
        if($cat_id == 0){
        	$where = 1;
        }else{
        	$where = "g.cat_id LIKE '%|$cat_id|%'" ;
        }
        
        $sql = "SELECT g.* FROM " . $this->pre . "suppliers g  "  . "WHERE $where   GROUP BY g.suppliers_id  DESC LIMIT $start , $size";

        $res = $this->query($sql);
        
        $arr = array();
        
        foreach ($res as $row) {
            $arr[$row['suppliers_id']]['trade_name'] = $row['trade_name'];
            $arr[$row['suppliers_id']]['url'] = url('alliance/goods_list', array('id' => $row['suppliers_id']));
            $arr[$row['suppliers_id']]['suppliers_img'] =get_banner_path($row['suppliers_img']);
            $arr[$row['suppliers_id']]['facade_img'] = get_banner_path($row['facade_img']);
            $arr[$row['suppliers_id']]['suppliers_desc'] = $row['suppliers_desc'];
            $arr[$row['suppliers_id']]['suppliers_site'] = $row['suppliers_site'];
            $arr[$row['suppliers_id']]['suppliers_name'] = $row['suppliers_name'];
        }
        return $arr;
        
    }

    /**
     * 获得指定的品牌下的商品总数
     *
     * @access  private
     * @param   integer     $brand_id
     * @param   integer     $cate
     * @return  integer
     */
    function goods_count_by_brand($brand_id, $cate = 0) {
        $sql = 'SELECT COUNT(*) as count FROM ' . $this->pre . 'goods AS g ' .
                "WHERE suppliers_id > '$brand_id' AND g.is_on_sale = 1 AND g.is_alone_sale = 1 AND g.is_delete = 0 ";

        if ($cate > 0) {
            $sql .= " AND " . get_children($cate);
        }
        $res = $this->row($sql);
        return $res['count'];
    }
    
    /**
     * 获得品牌数量
     *
     */
    function get_brands_count() {
        $sql = "SELECT count(*) as num FROM " . $this->pre . "brand b LEFT JOIN  " . $this->pre . "touch_brand t ON t.brand_id = b.brand_id " . "WHERE is_show = 1 ";
        $res = $this->row($sql);
        $sales_count = $res['num'] ? $res['num'] : 0;
        return $sales_count;
    }

}
