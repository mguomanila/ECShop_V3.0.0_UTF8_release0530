<?php

/**
 * ECSHOP 会员帐目管理(包括预付款，余额)
 * ============================================================================
 * * 版权所有 2005-2012 上海商派网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: liubo $
 * $Id: user_account.php 17217 2011-01-19 06:29:08Z liubo $
*/

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');

/* act操作项的初始化 */
if (empty($_REQUEST['act']))
{
    $_REQUEST['act'] = 'list';
}
else
{
    $_REQUEST['act'] = trim($_REQUEST['act']);
}

/*------------------------------------------------------ */
//-- 会员余额记录列表
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'list')
{


    /* 权限判断 */
    admin_priv('surplus_manage');

    /* 指定会员的ID为查询条件 */
    $user_id = !empty($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;

    /* 获得支付方式列表 */
    $payment = array();
    $sql = "SELECT pay_id, pay_name FROM ".$ecs->table('payment').
           " WHERE enabled = 1 AND pay_code != 'cod' ORDER BY pay_id";
    $res = $db->query($sql);

    while ($row = $db->fetchRow($res))
    {
        $payment[$row['pay_name']] = $row['pay_name'];
    }

    

    /* 模板赋值 */
    if (isset($_REQUEST['process_type']))
    {
        $smarty->assign('process_type_' . intval($_REQUEST['process_type']), 'selected="selected"');
    }
    if (isset($_REQUEST['is_paid']))
    {
        $smarty->assign('is_paid_' . intval($_REQUEST['is_paid']), 'selected="selected"');
    }

    
    $smarty->assign('ur_here',       $_LANG['09_user_account']);
    $smarty->assign('id',            $user_id);
    $smarty->assign('payment_list',  $payment);
    $smarty->assign('action_link',   array('text' => $_LANG['surplus_add'], 'href'=>'user_account.php?act=add'));

    $list = account_list();
    $smarty->assign('sum',         $list['sum']);
    
    $smarty->assign('list',         $list['list']);
    $smarty->assign('filter',       $list['filter']);
    $smarty->assign('record_count', $list['record_count']);
    $smarty->assign('page_count',   $list['page_count']);
    $smarty->assign('full_page',    1);

    assign_query_info();
    $smarty->display('user_account_list.htm');
}

/*------------------------------------------------------ */
//-- 添加/编辑会员余额页面
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'add' || $_REQUEST['act'] == 'edit')
{
    admin_priv('surplus_manage'); //权限判断

    $ur_here  = ($_REQUEST['act'] == 'add') ? $_LANG['surplus_add'] : $_LANG['surplus_edit'];
    $form_act = ($_REQUEST['act'] == 'add') ? 'insert' : 'update';
    $id       = isset($_GET['id']) ? intval($_GET['id']) : 0;

    /* 获得支付方式列表, 不包括“货到付款” */
    $user_account = array();
    $payment = array();
    $sql = "SELECT pay_id, pay_name FROM ".$ecs->table('payment').
           " WHERE enabled = 1 AND pay_code != 'cod' ORDER BY pay_id";
    $res = $db->query($sql);

    while ($row = $db->fetchRow($res))
    {
        $payment[$row['pay_name']] = $row['pay_name'];
    }

    if ($_REQUEST['act'] == 'edit')
    {
    	
        /* 取得余额信息 */
        $user_account = $db->getRow("SELECT * FROM " .$ecs->table('user_account') . " WHERE id = '$id'");

        // 如果是负数，去掉前面的符号
        $user_account['amount'] = str_replace('-', '', $user_account['amount']);
    	$smarty->assign('stub_img1',      $user_account['stub_img']);
        
//      $arr=explode('|',$user_account['user_note']);
        if(!empty($user_account['stub_img'])){
        	$user_account['stub_img']='../data/stub_img/'.$user_account['stub_img'];
        }
//		$img=explode(':',$arr[0]);
//		if($img[0]=='img'){
//			$note=array_shift($arr);
//			$user_account['user_note']=implode('|',$arr);
//			$stub_img='../data/stub_img/'.$img[1];
//		}else{
//			$stub_img='';
//		}

//  	$smarty->assign('stub_img',      $stub_img);

        /* 取得会员名称 */
        $sql = "SELECT user_name FROM " .$ecs->table('users'). " WHERE user_id = '$user_account[user_id]'";
        $user_name = $db->getOne($sql);
    }
    else
    {
        $surplus_type = '';
        $user_name    = '';
    }

    /* 模板赋值 */
    $smarty->assign('ur_here',          $ur_here);
    $smarty->assign('form_act',         $form_act);
    $smarty->assign('payment_list',     $payment);
    $smarty->assign('action',           $_REQUEST['act']);
    $smarty->assign('user_surplus',     $user_account);
    $smarty->assign('user_name',        $user_name);
    if ($_REQUEST['act'] == 'add')
    {
        $href = 'user_account.php?act=list';
    }
    else
    {
        $href = 'user_account.php?act=list&' . list_link_postfix();
    }
    $smarty->assign('action_link', array('href' => $href, 'text' => $_LANG['09_user_account']));

    assign_query_info();
    $smarty->display('user_account_info.htm');
}

/*------------------------------------------------------ */
//-- 添加/编辑会员余额的处理部分
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'insert' || $_REQUEST['act'] == 'update')
{
    /* 权限判断 */
    admin_priv('surplus_manage');

    /* 初始化变量 */
    $id           = isset($_POST['id'])            ? intval($_POST['id'])             : 0;
    $is_paid      = !empty($_POST['is_paid'])      ? intval($_POST['is_paid'])        : 0;
    $amount       = !empty($_POST['amount'])       ? floatval($_POST['amount'])       : 0;
    $process_type = !empty($_POST['process_type']) ? intval($_POST['process_type'])   : 0;
    $user_name    = !empty($_POST['user_id'])      ? trim($_POST['user_id'])          : '';
    $admin_note   = !empty($_POST['admin_note'])   ? trim($_POST['admin_note'])       : '';
    $user_note    = !empty($_POST['user_note'])    ? trim($_POST['user_note'])        : '';
    $payment      = !empty($_POST['payment'])      ? trim($_POST['payment'])          : '';
    $stub_status  = !empty($_POST['stub_status'])  ? trim($_POST['stub_status'])      : 0;
    

    $user_id = $db->getOne("SELECT user_id FROM " .$ecs->table('users'). " WHERE user_name = '$user_name'");
	
	include_once(ROOT_PATH . 'includes/cls_image.php');

	if($_FILES['stub']['size']>2000000){
		sys_msg('图片过大');
	}
	
	$image = new cls_image($_CFG['bgcolor']);

	if (!empty($_FILES['stub']['name']))
    {
        $img_up_info = basename($image->upload_image($_FILES['stub'], 'stub_img'));
		if($img_up_info==false){
			sys_msg($image->error_msg);
		}
		
		$stub_img = $img_up_info;
    }else{
    	$stub_img = $_POST['stub_img']?$_POST['stub_img']:'';
    }


    /* 此会员是否存在 */
    if ($user_id == 0)
    {
        $link[] = array('text' => $_LANG['go_back'], 'href'=>'javascript:history.back(-1)');
        sys_msg($_LANG['username_not_exist'], 0, $link);
    }

    /* 退款，检查余额是否足够 */
    if ($process_type == 1)
    {
        $user_account = get_user_surplus($user_id);

        /* 如果扣除的余额多于此会员拥有的余额，提示 */
        if ($amount > $user_account)
        {
            $link[] = array('text' => $_LANG['go_back'], 'href'=>'javascript:history.back(-1)');
            sys_msg($_LANG['surplus_amount_error'], 0, $link);
        }
    }

    if ($_REQUEST['act'] == 'insert')
    {
        /* 入库的操作 */
        if ($process_type == 1)
        {
            $amount = (-1) * $amount;
            $integral=0;
        }elseif($process_type == 2){
        	$integral=(-1) * $amount;
        	$amount=0;
        }elseif($process_type == 3){
        	$integral=$amount;

        	$amount=0;
        }else{
        	$integral=0;
        }

        $sql = "INSERT INTO " .$ecs->table('user_account').
               " VALUES ('', '$user_id', '$_SESSION[admin_name]', '$amount', '".gmtime()."', '".gmtime()."', '$admin_note', '$user_note', '$process_type', '$payment', '$is_paid','$integral','0','','0')";
        $db->query($sql);
        $id = $db->insert_id();
    }
    else
    {
    	$data='';
    	if(!empty($stub_img)){
    		$data .="stub_img = '$stub_img',";
    	}
    	if($stub_status != 0){
    		$data .="stub_status = $stub_status,";
    	}

        /* 更新数据表 */
        $sql = "UPDATE " .$ecs->table('user_account'). " SET ".
               "admin_note   = '$admin_note', ".
               "user_note    = '$user_note', ".
               $data.
               "payment      = '$payment' ".
              "WHERE id      = '$id'";

        $db->query($sql);
    }

	
    // 更新会员余额数量
    if ($is_paid == 1)
    {
        $change_desc = $amount > 0 ? $_LANG['surplus_type_0'] : $_LANG['surplus_type_1'];
        $change_type = $amount > 0 ? ACT_SAVING : ACT_DRAWING;
        if($process_type == 3){
        	log_account_change_vr($user_id, $amount, 0, 0, 0,$integral, 0,$change_desc, $change_type);	
        }else{
        	log_account_change_vr($user_id, $amount, 0, 0, $integral,0,0, $change_desc, $change_type);       	
        }

    }
    if(($process_type == 2||$process_type == 1) && $is_paid == 0){
        log_account_change_vr($user_id, $amount, 0, 0, $integral,0, 0,$change_desc, $change_type);
    	
    }

    //如果是预付款并且未确认，向pay_log插入一条记录
    if ($process_type == 0 && $is_paid == 0)
    {
        include_once(ROOT_PATH . 'includes/lib_order.php');

        /* 取支付方式信息 */
        $payment_info = array();
        $payment_info = $db->getRow('SELECT * FROM ' . $ecs->table('payment').
                                    " WHERE pay_name = '$payment' AND enabled = '1'");
        //计算支付手续费用
        $pay_fee   = pay_fee($payment_info['pay_id'], $amount, 0);
        $total_fee = $pay_fee + $amount;

        /* 插入 pay_log */
        $sql = 'INSERT INTO ' . $ecs->table('pay_log') . " (order_id, order_amount, order_type, is_paid)" .
                " VALUES ('$id', '$total_fee', '" .PAY_SURPLUS. "', 0)";
        $db->query($sql);
    }

    /* 记录管理员操作 */
    if ($_REQUEST['act'] == 'update')
    {
        admin_log($user_name, 'edit', 'user_surplus');
    }
    else
    {
        admin_log($user_name, 'add', 'user_surplus');
    }

    /* 提示信息 */
    if ($_REQUEST['act'] == 'insert')
    {
        $href = 'user_account.php?act=list';
    }
    else
    {
        $href = 'user_account.php?act=list&' . list_link_postfix();
    }
    $link[0]['text'] = $_LANG['back_list'];
    $link[0]['href'] = $href;

    $link[1]['text'] = $_LANG['continue_add'];
    $link[1]['href'] = 'user_account.php?act=add';

    sys_msg($_LANG['attradd_succed'], 0, $link);
}

/*------------------------------------------------------ */
//-- 审核会员余额页面
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'check')
{
    /* 检查权限 */
    admin_priv('surplus_manage');

    /* 初始化 */
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

    /* 如果参数不合法，返回 */
    if ($id == 0)
    {
        ecs_header("Location: user_account.php?act=list\n");
        exit;
    }

    /* 查询当前的预付款信息 */
    $account = array();
    $account = $db->getRow("SELECT * FROM " .$ecs->table('user_account'). " WHERE id = '$id'");
    $account['add_time'] = local_date($_CFG['time_format'], $account['add_time']);

    //余额类型:预付款，退款申请，购买商品，取消订单
    if ($account['process_type'] == 0)
    {
        $process_type = $_LANG['surplus_type_0'];
    }
    elseif ($account['process_type'] == 1)
    {
        $process_type = $_LANG['surplus_type_1'];
    }
    elseif ($account['process_type'] == 2)
    {
        $process_type = $_LANG['surplus_type_2'];
    }
    elseif($account['process_type'] == 3)
    {		
    	if(!empty($account['stub_img'])){
        	$account['stub_img']='../data/stub_img/'.$account['stub_img'];
        }
        $process_type = $_LANG['surplus_type_3'];
    }
    else
    {
    	$process_type = $_LANG['surplus_type_4'];
    }

    $sql = "SELECT user_name FROM " .$ecs->table('users'). " WHERE user_id = '$account[user_id]'";
    $user_name = $db->getOne($sql);
	
	
    /* 模板赋值 */
	
   
    $smarty->assign('ur_here',      $_LANG['check']);
    $account['user_note'] = htmlspecialchars($account['user_note']);
    $smarty->assign('surplus',      $account);
    $smarty->assign('process_type', $process_type);
    $smarty->assign('user_name',    $user_name);
    $smarty->assign('id',           $id);
    $smarty->assign('action_link',  array('text' => $_LANG['09_user_account'],
    'href'=>'user_account.php?act=list&' . list_link_postfix()));

    /* 页面显示 */
    assign_query_info();
    $smarty->display('user_account_check.htm');
}

/*------------------------------------------------------ */
//-- 更新会员余额的状态
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'action')
{
    /* 检查权限 */
    admin_priv('surplus_manage');

    /* 初始化 */
    $id         = isset($_POST['id'])         ? intval($_POST['id'])             : 0;
    $is_paid    = isset($_POST['is_paid'])    ? intval($_POST['is_paid'])        : 0;
    $admin_note = isset($_POST['admin_note']) ? trim($_POST['admin_note'])       : '';

    /* 如果参数不合法，返回 */
    if ($id == 0 || empty($admin_note))
    {
        ecs_header("Location: user_account.php?act=list\n");
        exit;
    }

    /* 查询当前的预付款信息 */
    $account = array();
    $account = $db->getRow("SELECT * FROM " .$ecs->table('user_account'). " WHERE id = '$id'");
    $amount  = $account['amount'];
	$integral  = $account['integral_amount'];

    //如果状态为未确认
    if ($account['is_paid'] == 0)
    {
        //如果是退款申请, 并且已完成,更新此条记录,扣除相应的余额
        if ($is_paid == '1' && $account['process_type'] == '1')
        {
            $user_account = get_user_surplus($account['user_id']);
            $fmt_amount   = str_replace('-', '', $amount);



            //如果扣除的余额多于此会员拥有的余额，提示
//          if ($fmt_amount > $user_account)
//          {
//              $link[] = array('text' => $_LANG['go_back'], 'href'=>'javascript:history.back(-1)');
//              sys_msg($_LANG['surplus_amount_error'], 0, $link);
//          }

            update_user_account($id, $amount, $admin_note, $is_paid,0);

            //更新会员余额数量
//          log_account_change($account['user_id'], $amount, 0, 0, 0, $_LANG['surplus_type_1'], ACT_DRAWING);
        }elseif($is_paid == '2' && $account['process_type'] == '1')
        {
        	$user_account = get_user_integral($account['user_id']);
            $fmt_amount   = str_replace('-', '', $amount);



            //如果扣除的余额多于此会员拥有的余额，提示
            

            update_user_account($id, $amount, $admin_note, $is_paid,0);

            //更新会员余额数量
            log_account_change($account['user_id'], $fmt_amount, 0, 0, 0, $_LANG['surplus_type_1'], ACT_DRAWING);
        
        }
        elseif ($is_paid == '1' && $account['process_type'] == '0')
        {
            //如果是预付款，并且已完成, 更新此条记录，增加相应的余额
            update_user_account($id, $amount, $admin_note, $is_paid,0);

            //更新会员余额数量
            log_account_change($account['user_id'], $amount, 0, 0, 0, $_LANG['surplus_type_0'], ACT_SAVING);

        }elseif($is_paid == '1' && $account['process_type'] == '4'){
        	if(empty($account['friend_id'])){
        	$sql='SELECT * FROM '. $GLOBALS['ecs']->table('users') ." WHERE user_id = '$account[user_id]'" ;
        		
        	}else{
        	$sql='SELECT * FROM '. $GLOBALS['ecs']->table('users') ." WHERE user_id = '$account[friend_id]'" ;
        		
        	}

			$userinfo=$GLOBALS['db']->getRow($sql);
			$parent=$userinfo;
			$lang_content='编号:'.$id.';'.$userinfo['user_name'].'升级金钻收益';
			
			if($userinfo['user_type'] == 1)
			{
				$sql='SELECT * FROM '. $GLOBALS['ecs']->table('users') ." WHERE user_id = $userinfo[parent_id]";
				$parentinfo=$GLOBALS['db']->getRow($sql);
				$set='';
				if($parentinfo['user_type'] == 1){
					$set=',parent_id = '.$parentinfo['ancestor_id'];
				}
			}
			for ($i=0; $i < $i+1; $i++) { 
				$sql='SELECT * FROM '. $GLOBALS['ecs']->table('users') ."users WHERE user_id = $parent[parent_id]";
				$parent=$GLOBALS['db']->getRow($sql);
				if($parent['user_type']!=1){
            		log_account_change_vr($parent['user_id'], 0, 0, 0, 300,0,0, $lang_content, ACT_SAVING);
					break;
				}
			}
        	//如果是预付款，并且已完成, 更新此条记录，增加相应的余额
            update_user_account($id, $amount, $admin_note, $is_paid,0);
            if(empty($account['friend_id'])){
            	
            $sql="UPDATE ". $GLOBALS['ecs']->table('users') . "SET user_type = 2".$set." WHERE user_id = $account[user_id]";
            	
            }else{

            	
            $sql="UPDATE ". $GLOBALS['ecs']->table('users') . "SET user_type = 2".$set." WHERE user_id = $account[friend_id]";
            	
            }
            		log_account_change_vr($account['user_id'], 0, 0, 0, 0,128000,0, $lang_content, ACT_SAVING);
            $GLOBALS['db']->query($sql);
        }
        elseif($is_paid == '1' && $account['process_type'] == '7'){
        	if(empty($account['friend_id'])){
        	$sql='SELECT * FROM '. $GLOBALS['ecs']->table('users') ." WHERE user_id = '$account[user_id]'" ;
        		
        	}else{
        	$sql='SELECT * FROM '. $GLOBALS['ecs']->table('users') ." WHERE user_id = '$account[friend_id]'" ;
        		
        	}

			$userinfo=$GLOBALS['db']->getRow($sql);
//			$parent=$userinfo;
//			$lang_content='编号:'.$id.';'.$userinfo['user_name'].'升级金钻收益';
//			
//			if($userinfo['user_type'] == 1)
//			{
//				$sql='SELECT * FROM '. $GLOBALS['ecs']->table('users') ." WHERE user_id = $userinfo[parent_id]";
//				$parentinfo=$GLOBALS['db']->getRow($sql);
				$set='';
//				if($parentinfo['user_type'] == 1){
//					$set=',parent_id = '.$parentinfo['ancestor_id'];
//				}
//			}
//			for ($i=0; $i < $i+1; $i++) { 
//				$sql='SELECT * FROM '. $GLOBALS['ecs']->table('users') ."users WHERE user_id = $parent[parent_id]";
//				$parent=$GLOBALS['db']->getRow($sql);
//				if($parent['user_type']!=1){
//          		log_account_change_vr($parent['user_id'], 0, 0, 0, 300,0,0, $lang_content, ACT_SAVING);
//					break;
//				}
//			}
//      	//如果是预付款，并且已完成, 更新此条记录，增加相应的余额
            update_user_account($id, $amount, $admin_note, $is_paid,0);
//          if(empty($account['friend_id'])){
//          	
            $sql="UPDATE ". $GLOBALS['ecs']->table('users') . "SET vip_type = 2".$set." WHERE user_id = $account[user_id]";
//          	
//          }else{
//
//          	
//          $sql="UPDATE ". $GLOBALS['ecs']->table('users') . "SET user_type = 2".$set." WHERE user_id = $account[friend_id]";
//          	
//          }
//          		log_account_change_vr($account['user_id'], 0, 0, 0, 0,128000,0, $lang_content, ACT_SAVING);
            $GLOBALS['db']->query($sql);
        }
        elseif($is_paid == '1' && $account['process_type'] == '3'){
        	$affiliate = unserialize($GLOBALS['_CFG']['affiliate']);
    		empty($affiliate) && $affiliate = array();
					$pd	 =strstr($account['user_id'],'|');
					if(!empty($account['friend_id'])){
						$userid=$account['user_id'];
						if($account['precept'] == 1){
							$precept_val=0;
						}else{
							$precept_val=$account['integral_amount'];
							$integral=0;
						}
						$content='编号:'.$id.';好友积分充值;好友ID'.$userid;;
						$sql = "SELECT * FROM ". $GLOBALS['ecs']->table('users') ." WHERE user_id = '$userid'";
						
                    	$user_info =  $GLOBALS['db']->getRow($sql);
                    	$sql = "SELECT * FROM " . $GLOBALS['ecs']->table('users') ." WHERE user_id = '$user_info[parent_id]'";
                    	$userparent_info =  $GLOBALS['db']->getRow($sql);
						if($userparent_info['user_type'] != 1){
							
							$user_integral=$integral*0.15;
							$precept_val_integral=$precept_val*0.21;
							
                			log_account_change_vr($user_info['parent_id'], 0, 0, 0, 0,$user_integral*0.1,$precept_val_integral*0.1, $content, ACT_SAVING);
							

						}
						
						
						$account['user_id']=$account['friend_id'];

						//商家所得积分
        				log_account_change_vr($userid,0,0,0,0,$integral*0.15,$precept_val*0.16,$content, ACT_SAVING);
						
						
						//推荐人所得积分						
						$sql="SELECT * FROM ". $GLOBALS['ecs']->table('users') ." WHERE user_id = $account[user_id]";
                    	$userid_info = $GLOBALS['db']->getRow($sql);
                    	$sql="SELECT * FROM ". $GLOBALS['ecs']->table('users') ." WHERE user_id = $userid_info[parent_id]";
//                  	echo $sql;
                    	$parent_id_info = $GLOBALS['db']->getRow($sql);
                    	if(!empty($userid_info['parent_id'])){
                    		$affiliate['item'][0]['level_money']/=100;
                    		$affiliate['item'][0]['level_point']/=100;
                    		
                    			if($parent_id_info['user_type'] != 1){
                    				log_account_change_vr($userid_info['parent_id'],0,0,0,0,$integral*$affiliate['item'][0]['level_money'],$precept_val*$affiliate['item'][0]['level_point'],$content, ACT_SAVING);                    	
	                    		}
//	                    		else{
//	                    			log_account_change_vr($userid_info['parent_id'],0,0,0,0,$integral*$affiliate['item'][0]['level_money'],$precept_val*$affiliate['item'][0]['level_money']*0.5,$_LANG['surplus_type_3'], ACT_SAVING);                    	
//	                    		}
                    		
                    		

                    	}	
                    	if(!empty($parent_id_info['parent_id'])){
                    		$sql="SELECT * FROM ". $GLOBALS['ecs']->table('users') ." WHERE user_id = $parent_id_info[parent_id]";
	                    	$parent_info = $GLOBALS['db']->getRow($sql);
	                    	if(!empty($userid_info['parent_id'])){
	                    		$affiliate = unserialize($GLOBALS['_CFG']['affiliate']);
	    						empty($affiliate) && $affiliate = array();
	                    		$affiliate['item'][1]['level_money'] /= 100;
	                    		$affiliate['item'][1]['level_point'] /= 100;
	                    		if($account['precept'] == 1){
	                    			if($parent_info['user_type'] != 1){
	                    				
	                    				log_account_change_vr($parent_id_info['parent_id'],0,0,0,0,$integral*$affiliate['item'][1]['level_money'],0,$content, ACT_SAVING);                    	
	                    					
	                    			}
		                    		else{
		                    			log_account_change_vr($parent_id_info['parent_id'],0,0,0,0,$integral*$affiliate['item'][1]['level_point'],0,$content, ACT_SAVING);                    	
		                    		}
	                    		}
	                    		
	
	                    	}
                    	}
					}
			$love=$account['integral_amount']*0.005;
						
        	 //如果是预付款，并且已完成, 更新此条记录，增加相应的余额
        	 if($account['precept'] == 1){
            	update_user_account($id, $amount, $admin_note, $is_paid,$integral );
				//客户所得积分
	            log_account_change_vr($account['user_id'], 0, 0, 0, 0, $integral-$love,$precept_val,$content, ACT_SAVING,$love);
        	 	
        	 }else{
            	update_user_account($id, $amount, $admin_note, $is_paid,$precept_val );
				//客户所得积分
	            log_account_change_vr($account['user_id'], 0, 0, 0, 0, $integral,$precept_val-$love,$content, ACT_SAVING,$love);
        	 	
        	 }
        	 


			

			
            
        }
 		//如果是退款申请, 并且已完成,更新此条记录,扣除相应的余额
        if ($is_paid == '1' && $account['process_type'] == '2')
        {
            $user_account = get_user_integral($account['user_id']);
            $fmt_amount   = str_replace('-', '', $integral);



            //如果扣除的余额多于此会员拥有的余额，提示
            

            update_user_account($id, 0, $admin_note, $is_paid,$integral);

            //更新会员余额数量

        }
        elseif($is_paid == '2' && $account['process_type'] == '2')
        {
        	$user_account = get_user_integral($account['user_id']);
            $fmt_amount   = str_replace('-', '', $integral);



            //如果扣除的余额多于此会员拥有的余额，提示
            

            update_user_account($id, 0, $admin_note, $is_paid,$integral);

            //更新会员余额数量
            log_account_change($account['user_id'], $amount, 0, 0, $fmt_amount, '金积分提现失败', ACT_POINTS);
        }
        elseif ($is_paid == '0')
        {
            /* 否则更新信息 */
            $sql = "UPDATE " .$ecs->table('user_account'). " SET ".
                   "admin_user    = '$_SESSION[admin_name]', ".
                   "admin_note    = '$admin_note', ".
                   "is_paid       = 0 WHERE id = '$id'";
            $db->query($sql);
        }

        /* 记录管理员日志 */
        admin_log('(' . addslashes($_LANG['check']) . ')' . $admin_note, 'edit', 'user_surplus');

        /* 提示信息 */
        $link[0]['text'] = $_LANG['back_list'];
        $link[0]['href'] = 'user_account.php?act=list&' . list_link_postfix();

        sys_msg($_LANG['attradd_succed'], 0, $link);
    }
}

/*------------------------------------------------------ */
//-- ajax帐户信息列表
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'query')
{
    $list = account_list();
//  if(isset($sum)){
   	 $smarty->assign('sum',         $list['sum']);

//  }
    $smarty->assign('list',         $list['list']);
    $smarty->assign('filter',       $list['filter']);
    $smarty->assign('record_count', $list['record_count']);
    $smarty->assign('page_count',   $list['page_count']);

    $sort_flag  = sort_flag($list['filter']);
    $smarty->assign($sort_flag['tag'], $sort_flag['img']);

    make_json_result($smarty->fetch('user_account_list.htm'), '', array('filter' => $list['filter'], 'page_count' => $list['page_count']));
}
/*------------------------------------------------------ */
//-- ajax删除一条信息
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'remove')
{
    /* 检查权限 */
    check_authz_json('surplus_manage');
    $id = @intval($_REQUEST['id']);
    $sql = "SELECT u.user_name FROM " . $ecs->table('users') . " AS u, " .
           $ecs->table('user_account') . " AS ua " .
           " WHERE u.user_id = ua.user_id AND ua.id = '$id' ";
    $user_name = $db->getOne($sql);
    
   

	$sql='SELECT * FROM ' .$ecs->table('user_account').
           " WHERE is_paid = 0 AND id = '$id'";

    $arr=$db->GetRow($sql);

	if($arr['process_type'] == 2){
        $fmt_amount   = str_replace('-', '', $arr['integral_amount']);
    	
    	log_account_change($arr['user_id'], 0, 0, 0, $fmt_amount, '金积分提现失败', ACT_POINTS);
	}elseif($arr['process_type'] == 1){
	 	$fmt_amount   = str_replace('-', '', $arr['amount']);
    	
    	log_account_change($arr['user_id'], $fmt_amount, 0, 0, 0, $_LANG['surplus_type_1'], ACT_DRAWING);
	}
    
    $sql = "DELETE FROM " . $ecs->table('user_account') . " WHERE id = '$id'";
    if ($db->query($sql, 'SILENT'))
    {
       admin_log(addslashes($user_name), 'remove', 'user_surplus');
       $url = 'user_account.php?act=query&' . str_replace('act=remove', '', $_SERVER['QUERY_STRING']);
       ecs_header("Location: $url\n");
       exit;
    }
    else
    {
        make_json_error($db->error());
    }
}

/*------------------------------------------------------ */
//-- 会员余额函数部分
/*------------------------------------------------------ */
/**
 * 查询会员余额的数量
 * @access  public
 * @param   int     $user_id        会员ID
 * @return  int
 */
function get_user_surplus($user_id)
{
    $sql = "SELECT SUM(user_money) FROM " .$GLOBALS['ecs']->table('account_log').
           " WHERE user_id = '$user_id'";

    return $GLOBALS['db']->getOne($sql);
}

/**
 * 查询会员积分余额的数量
 * @access  public
 * @param   int     $user_id        会员ID
 * @return  int
 */
function get_user_integral($user_id)
{
    $sql = "SELECT SUM(pay_points) FROM " .$GLOBALS['ecs']->table('account_log').
           " WHERE user_id = '$user_id'";

    return $GLOBALS['db']->getOne($sql);
}



/**
 * 更新会员账目明细
 *
 * @access  public
 * @param   array     $id          帐目ID
 * @param   array     $admin_note  管理员描述
 * @param   array     $amount      操作的金额
 * @param   array     $is_paid     是否已完成
 *
 * @return  int
 */
function update_user_account($id, $amount, $admin_note, $is_paid,$integral)
{
    $sql = "UPDATE " .$GLOBALS['ecs']->table('user_account'). " SET ".
           "admin_user  = '$_SESSION[admin_name]', ".
           "amount      = '$amount', ".
           "paid_time   = '".gmtime()."', ".
           "admin_note  = '$admin_note', ".
           "is_paid     = '$is_paid' ,".
           "integral_amount      = '$integral' WHERE id = '$id'";

    return $GLOBALS['db']->query($sql);
}

/**
 *
 *
 * @access  public
 * @param
 *
 * @return void
 */
function account_list()
{
    $result = get_filter();
    if ($result === false)
    {
        /* 过滤列表 */
        $filter['user_id'] = !empty($_REQUEST['user_id']) ? intval($_REQUEST['user_id']) : 0;
        $filter['keywords'] = empty($_REQUEST['keywords']) ? '' : trim($_REQUEST['keywords']);
        if (isset($_REQUEST['is_ajax']) && $_REQUEST['is_ajax'] == 1)
        {
            $filter['keywords'] = json_str_iconv($filter['keywords']);
        }
        $filter['start_time'] = !empty($_REQUEST['start_time']) ? $_REQUEST['start_time']: '';
        $filter['end_time'] = !empty($_REQUEST['end_time']) ? $_REQUEST['end_time'] : '';
//      echo $filter['start_time'];
		if((!is_numeric($filter['start_time'])) && (!empty($filter['start_time']))){
//			echo 123;
			$filter['start_time']=local_strtotime($filter['start_time']);
//			echo $filter['start_time'];
		}
		if((!is_numeric($filter['end_time'])) && (!empty($filter['end_time']))){
			$filter['end_time']=local_strtotime($filter['end_time']);
		}
        $filter['process_type'] = isset($_REQUEST['process_type']) ? intval($_REQUEST['process_type']) : -1;
        $filter['payment'] = empty($_REQUEST['payment']) ? '' : trim($_REQUEST['payment']);
        $filter['is_paid'] = isset($_REQUEST['is_paid']) ? intval($_REQUEST['is_paid']) : -1;
        $filter['sort_by'] = empty($_REQUEST['sort_by']) ? 'add_time' : trim($_REQUEST['sort_by']);
        $filter['sort_order'] = empty($_REQUEST['sort_order']) ? 'DESC' : trim($_REQUEST['sort_order']);
        $filter['start_date'] = empty($_REQUEST['start_date']) ? '' : local_strtotime($_REQUEST['start_date']);
        $filter['end_date'] = empty($_REQUEST['end_date']) ? '' : (local_strtotime($_REQUEST['end_date']) + 86400);

        $filter['sum'] = !empty($_REQUEST['sum']) ? $_REQUEST['sum'] : 0;
        $filter['stub_status'] = isset($_REQUEST['stub_status']) ? $_REQUEST['stub_status'] : '';
        $where = " WHERE 1 ";
        if ($filter['user_id'] > 0)
        {
            $where .= " AND ua.user_id = '$filter[user_id]' ";
        }
        if ($filter['process_type'] != -1)
        {
            $where .= " AND ua.process_type = '$filter[process_type]' ";
        }
        else
        {
            $where .= " AND ua.process_type " . db_create_in(array(SURPLUS_SAVE, SURPLUS_RETURN,SURPLUS_INTEGRAL,SURPLUS_INTEGRAL_SAVE,SURPLUS_JEWEL,SURPLUS_TRANSFER,SURPLUS_VIP));
        }
        if($filter['stub_status'] != '' && $filter['stub_status'] != -1){

        	$where .= " AND ua.stub_status = $filter[stub_status] AND ua.stub_img <> '' ";
        }
        if(!empty($filter['start_time']) )
        {
        	$where .= " AND ua.add_time >= '$filter[start_time]' ";
        }
        if(!empty($filter['end_time']) )
        {
        	$where .= " AND ua.add_time < '$filter[end_time]' ";
        }
        if ($filter['payment'])
        {
            $where .= " AND ua.payment = '$filter[payment]' ";
        }
        if ($filter['is_paid'] != -1)
        {
            $where .= " AND ua.is_paid = '$filter[is_paid]' ";
        }

        if ($filter['keywords'])
        {
            $where .= " AND u.user_name LIKE '%" . mysql_like_quote($filter['keywords']) . "%'";
            $sql = "SELECT COUNT(*) FROM " .$GLOBALS['ecs']->table('user_account'). " AS ua, ".
                   $GLOBALS['ecs']->table('users') . " AS u " . $where;
        }
        /*　时间过滤　*/
        if (!empty($filter['start_date']) && !empty($filter['end_date']))
        {
            $where .= "AND paid_time >= " . $filter['start_date']. " AND paid_time < '" . $filter['end_date'] . "'";
        }
        if($filter['process_type'] != -1 && $filter['sum'] == 1){
        	if($filter['process_type'] == 2){
        	$find='SUM(integral_amount) AS sun_int ';
        	$str = '积分';
        	}else{
        	$find='SUM(amount) AS sun_amount ';
        		$str = '元';
        	}
        	
        	$sql = "SELECT $find FROM ".$GLOBALS['ecs']->table('user_account'). ' AS ua LEFT JOIN ' .
            $GLOBALS['ecs']->table('users'). ' AS u ON ua.user_id = u.user_id'.$where;
    		$sum = $GLOBALS['db']->getOne($sql);
            $sum = $sum?$sum.$str:'0'.$str;
        }else{
        	$find='';
        	$sum='暂未求和';
        }

        $sql = "SELECT COUNT(*) FROM " .$GLOBALS['ecs']->table('user_account'). " AS ua RIGHT JOIN ".
                   $GLOBALS['ecs']->table('users') . " AS u ON u.user_id=ua.user_id " . $where;
                   
        $filter['record_count'] = $GLOBALS['db']->getOne($sql);

        /* 分页大小 */
        $filter = page_and_size($filter);

        /* 查询数据 */
        $sql  = "SELECT ua.*, u.user_name FROM" .
            $GLOBALS['ecs']->table('user_account'). ' AS ua LEFT JOIN ' .
            $GLOBALS['ecs']->table('users'). ' AS u ON ua.user_id = u.user_id'.
            $where . "ORDER by " . $filter['sort_by'] . " " .$filter['sort_order']. " LIMIT ".$filter['start'].", ".$filter['page_size'];

        $filter['keywords'] = stripslashes($filter['keywords']);
        set_filter($filter, $sql);
        
    }
    else
    {
        $sql    = $result['sql'];
        $filter = $result['filter'];
    }

    $list = $GLOBALS['db']->getAll($sql);
    foreach ($list AS $key => $value)
    {
        $list[$key]['surplus_amount']       = price_format(abs($value['amount']), false);
        $list[$key]['add_date']             = local_date($GLOBALS['_CFG']['time_format'], $value['add_time']);
        $list[$key]['process_type_name']    = $GLOBALS['_LANG']['surplus_type_' . $value['process_type']];
     }

    $arr = array('list' => $list,'sum'=>$sum, 'filter' => $filter, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);
	



    return $arr;
    
}

?>