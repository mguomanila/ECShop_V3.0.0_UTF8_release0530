<?php

/**
 * ECTouch Open Source Project
 * ============================================================================
 * Copyright (c) 2012-2014 http://ectouch.cn All rights reserved.
 * ----------------------------------------------------------------------------
 * 文件名称：IndexController.class.php
 * ----------------------------------------------------------------------------
 * 功能描述：ECTouch首页控制器
 * ----------------------------------------------------------------------------
 * Licensed ( http://www.ectouch.cn/docs/license.txt )
 * ----------------------------------------------------------------------------
 */
/* 访问控制 */
defined('IN_ECTOUCH') or die('Deny Access');

class IndexController extends CommonController {

    /**
     * 首页信息
     */
    public function index() {
        // 自定义导航栏
        $navigator = model('Common')->get_navigator();

        $this->assign('navigator', $navigator['middle']);
        $this->assign('best_goods', model('Index')->goods_list('best', C('page_size')));
        $this->assign('new_goods', model('Index')->goods_list('new', 1000));
        $this->assign('hot_goods', model('Index')->goods_list('hot', 1000));
		$cat_arr=model('CategoryBase')->get_categories_tree();


/**
 *	分类下的推荐商品 
 */
//      foreach ($cat_arr as $key => $value) {
//      	$best_list=model('Category')->get_category_recommend_goods('best',get_children($value['id']),0,0,0,'',4);
//      	$new_list=model('Category')->get_category_recommend_goods('new',get_children($value['id']),0,0,0,'',4);
//      	
//      	if(!empty($best_list)){
//	        	$reclist['best'][$key]['name']=$value['name'];
//	        	$reclist['best'][$key]['list']=$best_list;
//      	}
//      	if(!empty($new_list)){
//	        	$reclist['new'][$key]['name']=$value['name'];
//	        	$reclist['new'][$key]['list']=$new_list;
//      	}
//      }
//      $this->assign('cat_best', $reclist['best']);
//      $this->assign('cat_new', $reclist['new']);
        

        //首页推荐分类
        $cat_rec = model('Index')->get_recommend_res();
        $this->assign('cat_best', $cat_rec[1]);
        $this->assign('cat_new', $cat_rec[2]);
        $this->assign('cat_hot', $cat_rec[3]);
        // 促销活动
        $this->assign('promotion_info', model('GoodsBase')->get_promotion_info());
        // 团购商品
        $this->assign('group_buy_goods', model('Groupbuy')->group_buy_list(C('page_size'),1,'goods_id','ASC'));
        // 获取分类
        $this->assign('categories', model('CategoryBase')->get_categories_tree());
        // 获取品牌
        $this->assign('brand_list', model('Brand')->get_brands($app = 'brand', C('page_size'), 1));
        $this->display('index.dwt');
    }

    /**
     * ajax获取商品
     */
    public function ajax_goods() {
        if (IS_AJAX) {
            $type = I('get.type');
            $start = $_POST['last'];
            $limit = $_GET['amount'];
//print_r($limit);
            $hot_goods = model('Index')->goods_list($type, $limit, $start);

            
            $list = array();
            // 热卖商品
            if ($hot_goods) {
                foreach ($hot_goods as $key => $value) {
                    $this->assign('hot_goods', $value);
                    $list [] = array(
                        'single_item' => ECTouch::view()->fetch('library/asynclist_index.lbi')
                    );
                }
            }
//          print_r($list);
            echo json_encode($list);
            exit();
        } else {
            $this->redirect(url('index'));
        }
    }
    
    public function download_app() {
        $this->assign('app_url', 'http://www.oryigo.com/app/oryigo.apk');
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
		if (strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone')) {
			
        	$this->assign('app_act', '2');	
		} else if(strpos($user_agent, 'MicroMessenger') === false){
			/**非微信浏览**/
        	$this->assign('app_act', '1');
		}
		else{
        	$this->assign('app_act', '0');
		}
        $this->assign('title', 'app下载');
        $this->display('download_app.dwt');
    }

}
