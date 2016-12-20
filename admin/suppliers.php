<?php

/**
 * ECSHOP 管理中心供货商管理
 * ============================================================================
 * * 版权所有 2005-2012 上海商派网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: wanglei $
 * $Id: suppliers.php 15013 2009-05-13 09:31:42Z wanglei $
 */

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');
include_once(ROOT_PATH . '/includes/cls_image.php');
$image = new cls_image($_CFG['bgcolor']);
define('SUPPLIERS_ACTION_LIST', 'delivery_view,back_view');
/*------------------------------------------------------ */
//-- 供货商列表
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'list')
{
     /* 检查权限 */
     admin_priv('suppliers_manage');

    /* 查询 */
    $result = suppliers_list();

    /* 模板赋值 */
    $smarty->assign('ur_here', $_LANG['suppliers_list']); // 当前导航
    $smarty->assign('action_link', array('href' => 'suppliers.php?act=add', 'text' => $_LANG['add_suppliers']));

    $smarty->assign('full_page',        1); // 翻页参数

    $smarty->assign('suppliers_list',    $result['result']);
    $smarty->assign('filter',       $result['filter']);
    $smarty->assign('record_count', $result['record_count']);
    $smarty->assign('page_count',   $result['page_count']);
    $smarty->assign('sort_suppliers_id', '<img src="images/sort_desc.gif">');

    /* 显示模板 */
    assign_query_info();
    $smarty->display('suppliers_list.htm');
}

/*------------------------------------------------------ */
//-- 排序、分页、查询
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'query')
{
    check_authz_json('suppliers_manage');

    $result = suppliers_list();

    $smarty->assign('suppliers_list',    $result['result']);
    $smarty->assign('filter',       $result['filter']);
    $smarty->assign('record_count', $result['record_count']);
    $smarty->assign('page_count',   $result['page_count']);

    /* 排序标记 */
    $sort_flag  = sort_flag($result['filter']);
    $smarty->assign($sort_flag['tag'], $sort_flag['img']);

    make_json_result($smarty->fetch('suppliers_list.htm'), '',
        array('filter' => $result['filter'], 'page_count' => $result['page_count']));
}

/*------------------------------------------------------ */
//-- 列表页编辑名称
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'edit_suppliers_name')
{
    check_authz_json('suppliers_manage');

    $id     = intval($_POST['id']);
    $name   = json_str_iconv(trim($_POST['val']));

    /* 判断名称是否重复 */
    $sql = "SELECT suppliers_id
            FROM " . $ecs->table('suppliers') . "
            WHERE suppliers_name = '$name'
            AND suppliers_id <> '$id' ";
    if ($db->getOne($sql))
    {
        make_json_error(sprintf($_LANG['suppliers_name_exist'], $name));
    }
    else
    {
        /* 保存供货商信息 */
        $sql = "UPDATE " . $ecs->table('suppliers') . "
                SET suppliers_name = '$name'
                WHERE suppliers_id = '$id'";
        if ($result = $db->query($sql))
        {
            /* 记日志 */
            admin_log($name, 'edit', 'suppliers');

            clear_cache_files();

            make_json_result(stripslashes($name));
        }
        else
        {
            make_json_result(sprintf($_LANG['agency_edit_fail'], $name));
        }
    }
}


/*------------------------------------------------------ */
//-- 删除供货商店招图片
/*------------------------------------------------------ */
elseif($_REQUEST['act'] == 'del_img'){

    $suppliers_id = intval($_REQUEST['suppliers_id']);
	$suppliers_img_path=empty($_REQUEST['img_path'])?'':$_REQUEST['img_path'];
	if(!empty($suppliers_id) && !empty($suppliers_img_path)){
        @unlink('../' . $suppliers_img_path);
        $sql = "SELECT suppliers_img, facade_img " .
                    " FROM " . $ecs->table('suppliers') .
                    " WHERE suppliers_id = '$suppliers_id'";
        $row = $db->getRow($sql);
        if(empty($row['facade_img'])){
        	$new_facade_img=str_replace($suppliers_img_path,'',$row['facade_img']);
        	
        }else{
        	$new_facade_img=str_replace($suppliers_img_path.'|','',$row['facade_img']);
        	
        }

        if(empty($new_facade_img)){
        	$new_facade_img=null;
        }
        $sql="UPDATE " . $ecs->table('suppliers') . " SET facade_img = '$new_facade_img' WHERE suppliers_id = '$suppliers_id'";
		if($db->query($sql)){
			echo true;
		}else{
			echo false;
		}
	}
}


/*------------------------------------------------------ */
//-- 删除供货商
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'remove')
{
    check_authz_json('suppliers_manage');
//	echo $_REQUEST['id'];
    $id = intval($_REQUEST['id']);
    $sql = "SELECT *
            FROM " . $ecs->table('suppliers') . "
            WHERE suppliers_id = '$id'";
    $suppliers = $db->getRow($sql, TRUE);

    if ($suppliers['suppliers_id'])
    {
        /* 判断供货商是否存在订单 */
        $sql = "SELECT COUNT(*)
                FROM " . $ecs->table('order_info') . "AS O, " . $ecs->table('order_goods') . " AS OG, " . $ecs->table('goods') . " AS G
                WHERE O.order_id = OG.order_id
                AND OG.goods_id = G.goods_id
                AND G.suppliers_id = '$id'";
        $order_exists = $db->getOne($sql, TRUE);
        if ($order_exists > 0)
        {
            $url = 'suppliers.php?act=query&' . str_replace('act=remove', '', $_SERVER['QUERY_STRING']);
            ecs_header("Location: $url\n");
            exit;
        }

        /* 判断供货商是否存在商品 */
        $sql = "SELECT COUNT(*)
                FROM " . $ecs->table('goods') . "AS G
                WHERE G.suppliers_id = '$id'";
        $goods_exists = $db->getOne($sql, TRUE);
        if ($goods_exists > 0)
        {
            $url = 'suppliers.php?act=query&' . str_replace('act=remove', '', $_SERVER['QUERY_STRING']);
            ecs_header("Location: $url\n");
            exit;
        }

        $sql = "DELETE FROM " . $ecs->table('suppliers') . "
            WHERE suppliers_id = '$id'";
        $db->query($sql);

        /* 删除管理员、发货单关联、退货单关联和订单关联的供货商 */
        $table_array = array('admin_user', 'delivery_order', 'back_order');
        foreach ($table_array as $value)
        {
            $sql = "DELETE FROM " . $ecs->table($value) . " WHERE suppliers_id = '$id'";
            $db->query($sql, 'SILENT');
        }

        /* 记日志 */
        admin_log($suppliers['suppliers_name'], 'remove', 'suppliers');

        /* 清除缓存 */
        clear_cache_files();
    }

    $url = 'suppliers.php?act=query&' . str_replace('act=remove', '', $_SERVER['QUERY_STRING']);
    ecs_header("Location: $url\n");

    exit;
}

/*------------------------------------------------------ */
//-- 修改供货商状态
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'is_check')
{
    check_authz_json('suppliers_manage');

    $id = intval($_REQUEST['id']);
    $sql = "SELECT suppliers_id, is_check
            FROM " . $ecs->table('suppliers') . "
            WHERE suppliers_id = '$id'";
    $suppliers = $db->getRow($sql, TRUE);

    if ($suppliers['suppliers_id'])
    {
        $_suppliers['is_check'] = empty($suppliers['is_check']) ? 1 : 0;
        $db->autoExecute($ecs->table('suppliers'), $_suppliers, '', "suppliers_id = '$id'");
        clear_cache_files();
        make_json_result($_suppliers['is_check']);
    }

    exit;
}

/*------------------------------------------------------ */
//-- 批量操作
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'batch')
{
    /* 取得要操作的记录编号 */
    if (empty($_POST['checkboxes']))
    {
        sys_msg($_LANG['no_record_selected']);
    }
    else
    {
        /* 检查权限 */
        admin_priv('suppliers_manage');

        $ids = $_POST['checkboxes'];

        if (isset($_POST['remove']))
        {
            $sql = "SELECT *
                    FROM " . $ecs->table('suppliers') . "
                    WHERE suppliers_id " . db_create_in($ids);
            $suppliers = $db->getAll($sql);

            foreach ($suppliers as $key => $value)
            {
                /* 判断供货商是否存在订单 */
                $sql = "SELECT COUNT(*)
                        FROM " . $ecs->table('order_info') . "AS O, " . $ecs->table('order_goods') . " AS OG, " . $ecs->table('goods') . " AS G
                        WHERE O.order_id = OG.order_id
                        AND OG.goods_id = G.goods_id
                        AND G.suppliers_id = '" . $value['suppliers_id'] . "'";
                $order_exists = $db->getOne($sql, TRUE);
                if ($order_exists > 0)
                {
                    unset($suppliers[$key]);
                }

                /* 判断供货商是否存在商品 */
                $sql = "SELECT COUNT(*)
                        FROM " . $ecs->table('goods') . "AS G
                        WHERE G.suppliers_id = '" . $value['suppliers_id'] . "'";
                $goods_exists = $db->getOne($sql, TRUE);
                if ($goods_exists > 0)
                {
                    unset($suppliers[$key]);
                }
            }
            if (empty($suppliers))
            {
                sys_msg($_LANG['batch_drop_no']);
            }


            $sql = "DELETE FROM " . $ecs->table('suppliers') . "
                WHERE suppliers_id " . db_create_in($ids);
            $db->query($sql);

            /* 更新管理员、发货单关联、退货单关联和订单关联的供货商 */
            $table_array = array('admin_user', 'delivery_order', 'back_order');
            foreach ($table_array as $value)
            {
                $sql = "DELETE FROM " . $ecs->table($value) . " WHERE suppliers_id " . db_create_in($ids) . " ";
                $db->query($sql, 'SILENT');
            }

            /* 记日志 */
            $suppliers_names = '';
            foreach ($suppliers as $value)
            {
                $suppliers_names .= $value['suppliers_name'] . '|';
            }
            admin_log($suppliers_names, 'remove', 'suppliers');

            /* 清除缓存 */
            clear_cache_files();

            sys_msg($_LANG['batch_drop_ok']);
        }
    }
}

/*------------------------------------------------------ */
//-- 添加、编辑供货商
/*------------------------------------------------------ */
elseif (in_array($_REQUEST['act'], array('add', 'edit')))
{

    /* 检查权限 */
    admin_priv('suppliers_manage');
	$sql = 'SELECT user_name,user_id FROM '. $ecs->table('users') . " WHERE suppliers_type > 1";
	$re=$db->query($sql);
	while($row=$db->FetchRow($re))
	{
		$user_list[$row['user_id']]=$row['user_name'];
	}

    if ($_REQUEST['act'] == 'add')
    {
        $suppliers = array();

        /* 取得所有管理员，*/
        /* 标注哪些是该供货商的('this')，哪些是空闲的('free')，哪些是别的供货商的('other') */
        /* 排除是办事处的管理员 */
        $sql = "SELECT user_id, user_name, CASE
                WHEN suppliers_id = 0 THEN 'free'
                ELSE 'other' END AS type
                FROM " . $ecs->table('admin_user') . "
                WHERE agency_id = 0
                AND action_list <> 'all'";
        $suppliers['admin_list'] = $db->getAll($sql);
$suppliers['cat_id']=explode('|',$suppliers['cat_id']);
        $smarty->assign('supp_cat', $suppliers['cat_id']);
        $smarty->assign('ur_here', $_LANG['add_suppliers']);
        $smarty->assign('action_link', array('href' => 'suppliers.php?act=list', 'text' => $_LANG['suppliers_list']));
		$smarty->assign('user_list',$user_list);
        $smarty->assign('form_action', 'insert');
        $smarty->assign('suppliers', $suppliers);
    $smarty->assign('cat_list', cat_list(0, $suppliers['cat_id'],false,1));
        assign_query_info();

        $smarty->display('suppliers_info.htm');

    }
    elseif ($_REQUEST['act'] == 'edit')
    {
        $suppliers = array();

        /* 取得供货商信息 */
        $id = $_REQUEST['id'];
        $sql = "SELECT * FROM " . $ecs->table('suppliers') . " WHERE suppliers_id = '$id'";
        $suppliers = $db->getRow($sql);
        if (count($suppliers) <= 0)
        {
            sys_msg('suppliers does not exist');
        }
        $facade_img=explode('|',$suppliers['facade_img']);
        $smarty->assign('facade_img', $facade_img);
        
       
//		print_r($suppliers);
        /* 取得所有管理员，*/
        /* 标注哪些是该供货商的('this')，哪些是空闲的('free')，哪些是别的供货商的('other') */
        /* 排除是办事处的管理员 */
        $sql = "SELECT user_id, user_name, CASE
                WHEN suppliers_id = '$id' THEN 'this'
                WHEN suppliers_id = 0 THEN 'free'
                ELSE 'other' END AS type
                FROM " . $ecs->table('admin_user') . "
                WHERE agency_id = 0
                AND action_list <> 'all'";
        $suppliers['admin_list'] = $db->getAll($sql);

        $smarty->assign('ur_here', $_LANG['edit_suppliers']);
        $smarty->assign('action_link', array('href' => 'suppliers.php?act=list', 'text' => $_LANG['suppliers_list']));
		$smarty->assign('user_list',$user_list);
        $smarty->assign('form_action', 'update');
        $smarty->assign('suppliers', $suppliers);
 	$suppliers['cat_id']=explode('|',$suppliers['cat_id']);

        $smarty->assign('supp_cat', $suppliers['cat_id']);
		$cat_list=cat_list(0, $suppliers['cat_id'],false,1);


		foreach ($cat_list as $key => $value) {
				if(in_array($value['cat_id'],$suppliers['cat_id'])){
			$cat_list[$key]['checked']=1;

				}else{
			$cat_list[$key]['checked']=0;
					
				}
			

		}

    $smarty->assign('cat_list',$cat_list);
        assign_query_info();

        $smarty->display('suppliers_info.htm');
    }

}

/*------------------------------------------------------ */
//-- 提交添加、编辑供货商
/*------------------------------------------------------ */
elseif (in_array($_REQUEST['act'], array('insert', 'update')))
{
    /* 检查权限 */
    admin_priv('suppliers_manage');
    if ($_REQUEST['act'] == 'insert')
    {
    	$supp_cat_id=$_POST['supp_cat_id']?'|'.implode('|',$_POST['supp_cat_id']).'|':'';

        /* 提交值 */
        $suppliers = array('suppliers_name'   => trim($_POST['suppliers_name']),
        					'trade_name'   => trim($_POST['trade_name']),
        					'suppliers_site'   => trim($_POST['suppliers_site']),
        					'X_coord'   => trim($_POST['X_coord']),
        					'Y_coord'   => trim($_POST['Y_coord']),
                           'suppliers_desc'   => trim($_POST['suppliers_desc']),
                           'cat_id'   => trim($supp_cat_id),
                           'parent_id'        => 0
                           );

        /* 判断名称是否重复 */
        $sql = "SELECT suppliers_id
                FROM " . $ecs->table('suppliers') . "
                WHERE suppliers_name = '" . $suppliers['suppliers_name'] . "' ";
        if ($db->getOne($sql))
        {
            sys_msg($_LANG['suppliers_name_exist']);
        }
		if (isset($_FILES['suppliers_img']['error']) || isset($_FILES['facade_img']['error']))
		{
			// 最大上传文件大小
	        $php_maxsize = ini_get('upload_max_filesize');
	        $htm_maxsize = '2M';
	        // 商品图片
	        if ($_FILES['suppliers_img']['error'] == 0)
	        {
	            if (!$image->check_img_type($_FILES['suppliers_img']['type']))
	            {
	                sys_msg($_LANG['invalid_goods_img'], 1, array(), false);
	            }
	        }
	        elseif ($_FILES['suppliers_img']['error'] == 1)
	        {
	            sys_msg(sprintf($_LANG['goods_img_too_big'], $php_maxsize), 1, array(), false);
	        }
	        elseif ($_FILES['suppliers_img']['error'] == 2)
	        {
	            sys_msg(sprintf($_LANG['goods_img_too_big'], $htm_maxsize), 1, array(), false);
	        }
	
	        // 商品缩略图
//	        if (isset($_FILES['facade_img']))
//	        {
//	            if ($_FILES['facade_img']['error'] == 0)
//	            {
//	                if (!$image->check_img_type($_FILES['facade_img']['type']))
//	                {
//	                    sys_msg($_LANG['invalid_goods_thumb'], 1, array(), false);
//	                }
//	            }
//	            elseif ($_FILES['facade_img']['error'] == 1)
//	            {
//	                sys_msg(sprintf($_LANG['goods_thumb_too_big'], $php_maxsize), 1, array(), false);
//	            }
//	            elseif ($_FILES['facade_img']['error'] == 2)
//	            {
//	                sys_msg(sprintf($_LANG['goods_thumb_too_big'], $htm_maxsize), 1, array(), false);
//	            }
//	        }
		}
		else
		{
			// 商品图片
	        if ($_FILES['suppliers_img']['tmp_name'] != 'none')
	        {
	            if (!$image->check_img_type($_FILES['suppliers_img']['type']))
	            {
	
	                sys_msg($_LANG['invalid_goods_img'], 1, array(), false);
	            }
	        }
	
	        // 商品缩略图
//	        if (isset($_FILES['facade_img']))
//	        {
//	            if ($_FILES['facade_img']['tmp_name'] != 'none')
//	            {
//	                if (!$image->check_img_type($_FILES['facade_img']['type']))
//	                {
//	                    sys_msg($_LANG['invalid_goods_thumb'], 1, array(), false);
//	                }
//	            }
//	        }
		}
		$suppliers_img='';
		$facade_img='';
		if($_FILES['suppliers_img']['tmp_name'] != '' && $_FILES['suppliers_img']['tmp_name'] != 'none'){
			$suppliers_img   = $image->upload_image($_FILES['suppliers_img']); // 原始图片
		}
		
		$suppliers['suppliers_img']=$suppliers_img;

		if(is_array($_FILES['facade_img']['name'])){

			foreach ($_FILES['facade_img']['name'] as $key => $value) {
				if($_FILES['facade_img']['tmp_name'][$key] != '' && $_FILES['facade_img']['tmp_name'][$key] != 'none'){
					$upload = array(
		                'name' => $_FILES['facade_img']['name'][$key],
		                'type' => $_FILES['facade_img']['type'][$key],
		                'tmp_name' => $_FILES['facade_img']['tmp_name'][$key],
		                'size' => $_FILES['facade_img']['size'][$key],
		            );
					$facade_img   = $image->upload_image($upload); // 原始图片
					$suppliers['facade_img'].=$facade_img.'|';
				}
			}
		}else{
			
			if($_FILES['facade_img']['tmp_name'] != '' && $_FILES['facade_img']['tmp_name'] != 'none'){
				$facade_img   = $image->upload_image($_FILES['facade_img']); // 原始图片
				$suppliers['facade_img']=$facade_img.'|';
			}
		}

		
        $db->autoExecute($ecs->table('suppliers'), $suppliers, 'INSERT');
        $suppliers['suppliers_id'] = $db->insert_id();

        if (isset($_POST['admins']))
        {
            $sql = "UPDATE " . $ecs->table('admin_user') . " SET suppliers_id = '" . $suppliers['suppliers_id'] . "', action_list = '" . SUPPLIERS_ACTION_LIST . "' WHERE user_id " . db_create_in($_POST['admins']);
            $db->query($sql);
        }

        /* 记日志 */
        admin_log($suppliers['suppliers_name'], 'add', 'suppliers');

        /* 清除缓存 */
        clear_cache_files();

        /* 提示信息 */
        $links = array(array('href' => 'suppliers.php?act=add',  'text' => $_LANG['continue_add_suppliers']),
                       array('href' => 'suppliers.php?act=list', 'text' => $_LANG['back_suppliers_list'])
                       );
        sys_msg($_LANG['add_suppliers_ok'], 0, $links);

    }

    if ($_REQUEST['act'] == 'update')
    {
        /* 提交值 */
        $suppliers = array('id'   => trim($_POST['id']));
    	$supp_cat_id=$_POST['supp_cat_id']?'|'.implode('|',$_POST['supp_cat_id']).'|':'';
        $suppliers['new'] = array('suppliers_name'   => trim($_POST['suppliers_name']),
        							'trade_name'   => trim($_POST['trade_name']),
        					'suppliers_site'   => trim($_POST['suppliers_site']),
        					'X_coord'   => trim($_POST['X_coord']),
        					'Y_coord'   => trim($_POST['Y_coord']),
                           'cat_id'   => trim($supp_cat_id),
        					
                           'suppliers_desc'   => trim($_POST['suppliers_desc'])
                           );

        /* 取得供货商信息 */
        $sql = "SELECT * FROM " . $ecs->table('suppliers') . " WHERE suppliers_id = '" . $suppliers['id'] . "'";
        $suppliers['old'] = $db->getRow($sql);
        if (empty($suppliers['old']['suppliers_id']))
        {
            sys_msg('suppliers does not exist');
        }

        /* 判断名称是否重复 */
        $sql = "SELECT suppliers_id
                FROM " . $ecs->table('suppliers') . "
                WHERE suppliers_name = '" . $suppliers['new']['suppliers_name'] . "'
                AND suppliers_id <> '" . $suppliers['id'] . "'";
        if ($db->getOne($sql))
        {
            sys_msg($_LANG['suppliers_name_exist']);
        }
        if (isset($_FILES['suppliers_img']['error']))
		{
			// 最大上传文件大小
	        $php_maxsize = ini_get('upload_max_filesize');
	        $htm_maxsize = '2M';
	        // 商品图片
	        if ($_FILES['suppliers_img']['error'] == 0)
	        {
	            if (!$image->check_img_type($_FILES['suppliers_img']['type']))
	            {
	                sys_msg($_LANG['invalid_goods_img'], 1, array(), false);
	            }
	        }
	        elseif ($_FILES['suppliers_img']['error'] == 1)
	        {
	            sys_msg(sprintf($_LANG['goods_img_too_big'], $php_maxsize), 1, array(), false);
	        }
	        elseif ($_FILES['suppliers_img']['error'] == 2)
	        {
	            sys_msg(sprintf($_LANG['goods_img_too_big'], $htm_maxsize), 1, array(), false);
	        }
	
	        // 商品缩略图
	        if (isset($_FILES['facade_img']))
	        {
	            if ($_FILES['facade_img']['error'] == 0)
	            {
	                if (!$image->check_img_type($_FILES['facade_img']['type']))
	                {
	                    sys_msg($_LANG['invalid_goods_thumb'], 1, array(), false);
	                }
	            }
	            elseif ($_FILES['facade_img']['error'] == 1)
	            {
	                sys_msg(sprintf($_LANG['goods_thumb_too_big'], $php_maxsize), 1, array(), false);
	            }
	            elseif ($_FILES['facade_img']['error'] == 2)
	            {
	                sys_msg(sprintf($_LANG['goods_thumb_too_big'], $htm_maxsize), 1, array(), false);
	            }
	        }
		}
		else
		{
			// 商品图片
	        if ($_FILES['suppliers_img']['tmp_name'] != 'none')
	        {
	            if (!$image->check_img_type($_FILES['suppliers_img']['type']))
	            {
	
	                sys_msg($_LANG['invalid_goods_img'], 1, array(), false);
	            }
	        }
	
	        // 商品缩略图
	        if (isset($_FILES['facade_img']))
	        {
	            if ($_FILES['facade_img']['tmp_name'] != 'none')
	            {
	                if (!$image->check_img_type($_FILES['facade_img']['type']))
	                {
	                    sys_msg($_LANG['invalid_goods_thumb'], 1, array(), false);
	                }
	            }
	        }
		}
		if ($suppliers['id'] > 0)
        {
            /* 删除原来的图片文件 */
            $sql = "SELECT suppliers_img, facade_img " .
                    " FROM " . $ecs->table('suppliers') .
                    " WHERE suppliers_id = '$suppliers[id]'";
            $row = $db->getRow($sql);

            if ($row['suppliers_img'] != '' && is_file('../' . $row['suppliers_img']) && $_FILES['suppliers_img']['tmp_name'])
            {
                @unlink('../' . $row['suppliers_img']);
            }
//          if ($row['facade_img'] != '' && is_file('../' . $row['facade_img']) && $_FILES['facade_img']['tmp_name'])
//          {
//              @unlink('../' . $row['facade_img']);
//          }

            /* 清除原来商品图片 */
            if ($proc_thumb === false)
            {
                get_image_path($_REQUEST[goods_id], $row['goods_img'], false, 'goods', true);
                get_image_path($_REQUEST[goods_id], $row['goods_thumb'], true, 'goods', true);
            }
        }
		$suppliers_img='';
		$facade_img='';
		if($_FILES['suppliers_img']['tmp_name'] != '' && $_FILES['suppliers_img']['tmp_name'] != 'none'){
			$suppliers_img   = $image->upload_image($_FILES['suppliers_img']); // 原始图片
		}
		
		if($suppliers_img){
		$suppliers['new']['suppliers_img']=$suppliers_img;
			
		}
		
		
		
		if(is_array($_FILES['facade_img']['name'])){

			foreach ($_FILES['facade_img']['name'] as $key => $value) {
				if($_FILES['facade_img']['tmp_name'][$key] != '' && $_FILES['facade_img']['tmp_name'][$key] != 'none'){
					$upload = array(
		                'name' => $_FILES['facade_img']['name'][$key],
		                'type' => $_FILES['facade_img']['type'][$key],
		                'tmp_name' => $_FILES['facade_img']['tmp_name'][$key],
		                'size' => $_FILES['facade_img']['size'][$key],
		            );
					$facade_img   = $image->upload_image($upload); // 原始图片
					if(empty($row['facade_img'])){
						$suppliers['new']['facade_img'].=$facade_img.'|';
					}else{
						$suppliers['new']['facade_img']=$row['facade_img'].$facade_img.'|';	
					}
				}
			}
		}else{
			
			if($_FILES['facade_img']['tmp_name'] != '' && $_FILES['facade_img']['tmp_name'] != 'none'){
				$facade_img   = $image->upload_image($_FILES['facade_img']); // 原始图片
				if(empty($row['facade_img'])){
						$suppliers['new']['facade_img'].=$facade_img.'|';
				}else{
						$suppliers['new']['facade_img']=$row['facade_img'].$facade_img.'|';	
				}
			}
		}
//		if($facade_img){
//			$facade_img = $facade_img.'|';

//				$suppliers['new']['facade_img']=$facade_img;
//			}else{
//				$suppliers['new']['facade_img']=$row['facade_img'].$facade_img;	
//			}		
//		}

        /* 保存供货商信息 */
        $db->autoExecute($ecs->table('suppliers'), $suppliers['new'], 'UPDATE', "suppliers_id = '" . $suppliers['id'] . "'");

        /* 清空供货商的管理员 */
        $sql = "UPDATE " . $ecs->table('admin_user') . " SET suppliers_id = 0, action_list = '" . SUPPLIERS_ACTION_LIST . "' WHERE suppliers_id = '" . $suppliers['id'] . "'";
        $db->query($sql);

        /* 添加供货商的管理员 */
        if (isset($_POST['admins']))
        {
            $sql = "UPDATE " . $ecs->table('admin_user') . " SET suppliers_id = '" . $suppliers['old']['suppliers_id'] . "' WHERE user_id " . db_create_in($_POST['admins']);
            $db->query($sql);
        }

        /* 记日志 */
        admin_log($suppliers['old']['suppliers_name'], 'edit', 'suppliers');

        /* 清除缓存 */
        clear_cache_files();

        /* 提示信息 */
        $links[] = array('href' => 'suppliers.php?act=list', 'text' => $_LANG['back_suppliers_list']);
        sys_msg($_LANG['edit_suppliers_ok'], 0, $links);
    }

}

/**
 *  获取供应商列表信息
 *
 * @access  public
 * @param
 *
 * @return void
 */
function suppliers_list()
{
    $result = get_filter();
    if ($result === false)
    {
        $aiax = isset($_GET['is_ajax']) ? $_GET['is_ajax'] : 0;

        /* 过滤信息 */
        $filter['sort_by'] = empty($_REQUEST['sort_by']) ? 'suppliers_id' : trim($_REQUEST['sort_by']);
        $filter['sort_order'] = empty($_REQUEST['sort_order']) ? 'ASC' : trim($_REQUEST['sort_order']);

        $filter['suppliers_name'] = empty($_REQUEST['keywords']) ? '' : trim($_REQUEST['keywords']);
        $filter['trade_name'] = empty($_REQUEST['trade_name']) ? '' : trim($_REQUEST['trade_name']);
        
//      $filter['mobilephone'] = empty($_REQUEST['mobilephone']) ? '' : trim($_REQUEST['mobilephone']);
        
        $where = 'WHERE 1 ';
        if($filter['suppliers_name']){
        	$where .= " AND suppliers_name LIKE '%" . mysql_like_quote($filter['suppliers_name']) ."%'";
        }
        if($filter['trade_name']){
        	$where .= " AND trade_name LIKE '%" . mysql_like_quote($filter['trade_name']) ."%'";
        }

        /* 分页大小 */
        $filter['page'] = empty($_REQUEST['page']) || (intval($_REQUEST['page']) <= 0) ? 1 : intval($_REQUEST['page']);

        if (isset($_REQUEST['page_size']) && intval($_REQUEST['page_size']) > 0)
        {
            $filter['page_size'] = intval($_REQUEST['page_size']);
        }
        elseif (isset($_COOKIE['ECSCP']['page_size']) && intval($_COOKIE['ECSCP']['page_size']) > 0)
        {
            $filter['page_size'] = intval($_COOKIE['ECSCP']['page_size']);
        }
        else
        {
            $filter['page_size'] = 15;
        }

        /* 记录总数 */
        $sql = "SELECT COUNT(*) FROM " . $GLOBALS['ecs']->table('suppliers') . $where;
        $filter['record_count']   = $GLOBALS['db']->getOne($sql);
        $filter['page_count']     = $filter['record_count'] > 0 ? ceil($filter['record_count'] / $filter['page_size']) : 1;

        /* 查询 */
        $sql = "SELECT suppliers_id, suppliers_name, suppliers_desc, is_check
                FROM " . $GLOBALS['ecs']->table("suppliers") . "
                $where
                ORDER BY " . $filter['sort_by'] . " " . $filter['sort_order']. "
                LIMIT " . ($filter['page'] - 1) * $filter['page_size'] . ", " . $filter['page_size'] . " ";

        set_filter($filter, $sql);
    }
    else
    {
        $sql    = $result['sql'];
        $filter = $result['filter'];
    }

    $row = $GLOBALS['db']->getAll($sql);

    $arr = array('result' => $row, 'filter' => $filter, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);

    return $arr;
}
?>