<?php

/**
 * ECSHOP 会员管理程序
 * ============================================================================
 * * 版权所有 2005-2012 上海商派网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: liubo $
 * $Id: users.php 17217 2011-01-19 06:29:08Z liubo $
*/

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');
/*加载自己封装的函数库*/
include_once(ROOT_PATH."includes/lib_db.php");
/*------------------------------------------------------ */
//-- 用户帐号列表
/*------------------------------------------------------ */

if ($_REQUEST['act'] == 'list')
{
	
     /* 检查权限 */
    admin_priv('users_manage');
    $sql = "SELECT rank_id, rank_name, min_points FROM ".$ecs->table('user_rank')." ORDER BY min_points ASC ";
    $rs = $db->query($sql);

    $ranks = array();
    while ($row = $db->FetchRow($rs))
    {
        $ranks[$row['rank_id']] = $row['rank_name'];
    }
    
    
    for ($i=1; $i <4 ; $i++)
    {
        $user_type[$i] = $_LANG['user_type'][$i];
    }
	//查询省
	$sql = "SELECT * from ecs_province";
	$province = get_province($sql);
	
	$smarty->assign('province',   $province);
	
	$smarty->assign('user_type',   $user_type);
    $smarty->assign('user_ranks',   $ranks);
    $smarty->assign('ur_here',      $_LANG['03_users_list']);
    $smarty->assign('action_link',  array('text' => $_LANG['04_users_add'], 'href'=>'agent.php?act=add'));
	$user_list = user_list();
    include_once(ROOT_PATH.'includes/cls_certificate.php');
    $cert = new certificate();
    $is_bind_crm = $cert->is_bind_sn('ecos.taocrm','bind_type');
	$smarty->assign('is_bind_crm',  $is_bind_crm);
	$smarty->assign('full_page',    1);
	$smarty->assign('sort_user_id', '<img src="images/sort_desc.gif">');
	if(empty($_POST))
	{
		foreach($user_list['user_list'] as $key=>$val)
		{
			$where_money = " WHERE user_id='".$val['user_id']."' and process_type='3' and is_paid='1'";
			$subtotal = getAgentMoney("ecs_user_account",$where_money);	
			$address_info['total_money'] += $subtotal['total'];
			$user_list['user_list'][$key]['address'] = getAgentAddress(trim($val['province']),trim($val['city']),trim($val['area']));	
				
			$user_list['user_list'][$key]['amount'] = $subtotal['subtotal'];
		}
		$smarty->assign('address_info',    $address_info);
		$smarty->assign('user_list',    array_filter($user_list['user_list']));	
		$smarty->assign('pageHtml','agent_list.htm');		
		$smarty->display('agent_list.htm');	
	}
	else
	{	
		$province_p = $_POST['province'] == 0 ? '' : intval($_POST['province']);		
		if($province_p != 0){
			$city_p = $_POST['city'] == 0 ? '' : intval($_POST['city']);
			$area_p = $_POST['area'] == 0 ? '' : intval($_POST['area']);
		}
		$start_time = empty($_POST['start_time']) ? 0 : intval(strtotime($_POST['start_time']));
		$end_time = empty($_POST['end_time']) ? 0 : intval(strtotime($_POST['end_time']));
		if($start_time != 0){
			$address_info['start_time'] = date('Y-m-d H:i:s',$start_time);
			$address_info['end_time'] = date('Y-m-d H:i:s',$end_time);
		}else{
			$address_info['start_time'] = date('Y-m-d H:i:s',0);;
			$address_info['end_time'] = date('Y-m-d H:i:s',time());
		}
		$username = empty($_POST['keyword']) ? 1 : $_POST['keyword'];
		$order = " order by user_id DESC";
		
		if($end_time < $start_time)
		{
			die("<script> alert('结束时间不能小于开始时间，请重新输入');window.history.go(-1); </script>");
		}	
		$filed = "pay_points_2,user_id, user_name, email, is_validated, user_money, frozen_money, rank_points, pay_points, reg_time,province,city,area";
		$agent_where = " WHERE 1";
		$usersql = "SELECT $filed from ".$ecs->table('users').$agent_where;
		$user_agent_info = get_province($usersql);
		
		if($_POST['is_paid'] != -1 && $username == 1 && $province_p == 0 && $city_p == 0&& $area_p ==0 &&$start_time ==0)
		{	
			$agent_where = " WHERE user_name ='".$username."' and is_validated='".$_POST['is_paid']."'";
			
			if($username != 1)
			{
				$agent_where = $agent_where.$order;
				$username_agent = $username == 1 ? '' :  $username;
			}
			elseif($province_p != 0 && $city_p != 0 && $area_p != 0)
			{
				$agent_where .= " and province=$province_p and city =$city_p and area=$area_p".$order;
			}
			elseif($start_time !=0 && $end_time !=0)
			{	
				$agent_where = " WHERE is_validated='".$_POST['is_paid']."' and reg_time>=$start_time and reg_time<=$end_time order by user_id DESC";
			}
			else{
				$agent_where = " WHERE is_validated='".$_POST['is_paid']."'".$order;
			}
			//查询商户信息
			$sql = "SELECT $filed FROM ".$ecs->table('users').$agent_where ;
			$address = $db->getAll($sql);
		
		}
		if($username != 1 && $province_p == 0 && $city_p == 0&& $area_p ==0)
		{	
			$is_pid = intval($_POST['is_paid']);
			$username_agent = $username == 1 ? '' :  $username;
			
			$agent_where = " WHERE user_name like '".$username."%'" ;
			$usersql = "SELECT $filed from ".$ecs->table('users').$agent_where;
			$address = get_province($usersql);		
			if($address == '')
			{
				die("<script> alert('没有改用户，请重新输入');window.history.go(-1); </script>");
			}

			foreach($address as $val){
				if($_POST['is_paid'] == -1)
				{
					$agent_where = " WHERE parent_id='".$val['user_id']."'";
				}else
				{
					$is_pid = intval($_POST['is_paid']);
					$agent_where = " WHERE parent_id='".$val['user_id']."' and is_validated='".$is_pid."'";
				}
				//查询出代理商的下一级
				$sql = "SELECT $filed from ".$ecs->table('users').$agent_where;
				$address_next = get_province($sql);
				if($start_time != 0&& $end_time != 0){ 
					$address_next = getNextInfo($address_next,'ecs_user_account',$start_time,$end_time);
					if($address_next == '')
					{
						die("<script> alert('用户在这段时间没有任何记录');window.history.go(-1); </script>");
					}
				}else{
					$agent_where = " WHERE  parent_id=".$val['user_id'];
					$sql = "SELECT * from `ecs_users`".$agent_where;
					$user_agent['next'] = get_province($sql);
				}
			}
		}
		elseif($username != 1)
		{ 
			$agent_where = " WHERE user_name='".$username."'";
			$usersql = "SELECT $filed from ".$ecs->table('users').$agent_where;			
			//获取到具体位置的商户	
			$username_add = $db->getRow($usersql);
			if($username_add == false){
				 die("<script> alert('用户名输入无效');window.history.go(-1); </script>");
			}
			if($area_p == ''){
				$user_where = " WHERE province =$province_p and city =$city_p";			
			}else{
				$user_where = " WHERE province =$province_p and city =$city_p and area =$area_p";			
			}
			
			if($_POST['is_paid'] == -1)
			{
				$user_where .= " and parent_id='".$username_add['user_id']."'".$oder;
			}else{
				$is_pid = intval($_POST['is_paid']);
				$user_where .= " and is_validated = $is_pid";
			}
			
			$sql = "SELECT $filed from ".$ecs->table('users').$user_where;
			$address = get_province($sql);
			
			$address_info['province'] = $province_p;
			$address_info['city'] = $city_p;
			$address_info['area'] = $area_p;
			$username_agent = $_POST['keyword'];				
		}
		elseif($province_p != 0 && $city_p != 0&& $area_p !=0)
		{ 
			$end_time = empty($_POST['end_time']) ? time() : intval(strtotime($_POST['end_time']));
			if($_POST['is_paid'] == -1)
			{
				$where_agent = " WHERE province=$province_p and city = $city_p and area =$area_p ORDER BY user_id DESC";
			}else
			{
				$is_pid = intval($_POST['is_paid']);
				$where_agent = " WHERE is_validated =$is_pid and province=$province_p and city = $city_p and area =$area_p ORDER BY user_id DESC";
			}
			$sql = "SELECT $filed FROM ".$ecs->table('users').$where_agent;
			$address = get_province($sql);
			$address_info['province'] = $province_p;
			$address_info['city'] = $city_p;
			$address_info['area'] = $area_p;
			$username_agent = $_POST['keyword'];
		}
		elseif($start_time !=0 && $end_time !=0)
		{	
			if($username != 1)
			{
				$where_agent = " WHERE user_name = '".$username."' ORDER BY user_id DESC";
			}
			elseif($_POST['is_paid'] != -1){
				$where_agent = " WHERE is_validated = '".$_POST['is_paid']."' ORDER BY user_id DESC";
			}else{
				$where_agent = " WHERE 1 ORDER BY user_id DESC";
			}
			$sql = "SELECT $filed FROM".$GLOBALS['ecs']->table('users').$where_agent;
			$address = get_province($sql);
		}
		elseif($province_p ==0 &&$end_time==0 && $area_p==0 && $_POST['is_paid']==-1)
		{
			 die("<script> alert('没有任何的值，请重新输入');window.history.go(-1); </script>");
		}	
		if($province_p != 0 && $city_p !=0){
				$sql = "SELECT * from ecs_city";
				$city = get_province($sql);
				$sql = "SELECT * from ecs_area";
				$area = get_province($sql);
				$smarty->assign('city',   $city);
				$smarty->assign('area',   $area);
			}
		
		if($address_next != ''){
			$user_agent = getUserAgent($address_next,$start_time,$end_time);
			$address_info['total_money'] = $user_agent['total_money'];
			$address = $user_agent['next'];
		}
		//金额			
		$user_agent = getUserAgent($address,$start_time,$end_time);
		$address_info['total_money'] = $user_agent['total_money'];			
		$address = $user_agent['next'];	
		assign_query_info();
		$smarty->assign('agent_name', $username_agent);
		$smarty->assign('address_info',    $address_info);
		$smarty->assign('user_list',    $address);		
		$smarty->display('agent_list.htm');		
	}

}

/*------------------------------------------------------ */
//-- ajax返回用户列表
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'query')
{
    $user_list = user_list();

    $smarty->assign('user_list',    $user_list['user_list']);
    $smarty->assign('filter',       $user_list['filter']);
    $smarty->assign('record_count', $user_list['record_count']);
    $smarty->assign('page_count',   $user_list['page_count']);

    $sort_flag  = sort_flag($user_list['filter']);
    $smarty->assign($sort_flag['tag'], $sort_flag['img']);

    make_json_result($smarty->fetch('agent_list.htm'), '', array('filter' => $user_list['filter'], 'page_count' => $user_list['page_count']));
}

/*------------------------------------------------------ */
//-- 添加会员帐号
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'add')
{
    /* 检查权限 */
    admin_priv('users_manage');

    $user = array(  'rank_points'   => $_CFG['register_points'],
                    'pay_points'    => $_CFG['register_points'],
                    'sex'           => 0,
                    'credit_line'   => 0
                    );
    /* 取出注册扩展字段 */
    $sql = 'SELECT * FROM ' . $ecs->table('reg_fields') . ' WHERE type < 2 AND display = 1 AND id != 6 ORDER BY dis_order, id';
    $extend_info_list = $db->getAll($sql);
    $smarty->assign('extend_info_list', $extend_info_list);

    $smarty->assign('ur_here',          $_LANG['04_users_add']);
    $smarty->assign('action_link',      array('text' => $_LANG['03_users_list'], 'href'=>'agent.php?act=list'));
    $smarty->assign('form_action',      'insert');
    $smarty->assign('user',             $user);
    $smarty->assign('special_ranks',    get_rank_list(true));

    assign_query_info();
    $smarty->display('user_info.htm');
}

/*------------------------------------------------------ */
//-- 添加会员帐号
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'insert')
{
    /* 检查权限 */
    admin_priv('users_manage');
    $username = empty($_POST['username']) ? '' : trim($_POST['username']);
    $password = empty($_POST['password']) ? '' : trim($_POST['password']);
    $email = empty($_POST['email']) ? '' : trim($_POST['email']);
    $sex = empty($_POST['sex']) ? 0 : intval($_POST['sex']);
    $sex = in_array($sex, array(0, 1, 2)) ? $sex : 0;
    $birthday = $_POST['birthdayYear'] . '-' .  $_POST['birthdayMonth'] . '-' . $_POST['birthdayDay'];
    $rank = empty($_POST['user_rank']) ? 0 : intval($_POST['user_rank']);
    $credit_line = empty($_POST['credit_line']) ? 0 : floatval($_POST['credit_line']);

    $users = init_users();

    if (!$users->add_user($username, $password, $email))
    {
        /* 插入会员数据失败 */
        if ($users->error == ERR_INVALID_USERNAME)
        {
            $msg = $_LANG['username_invalid'];
        }
        elseif ($users->error == ERR_USERNAME_NOT_ALLOW)
        {
            $msg = $_LANG['username_not_allow'];
        }
        elseif ($users->error == ERR_USERNAME_EXISTS)
        {
            $msg = $_LANG['username_exists'];
        }
        elseif ($users->error == ERR_INVALID_EMAIL)
        {
            $msg = $_LANG['email_invalid'];
        }
        elseif ($users->error == ERR_EMAIL_NOT_ALLOW)
        {
            $msg = $_LANG['email_not_allow'];
        }
        elseif ($users->error == ERR_EMAIL_EXISTS)
        {
            $msg = $_LANG['email_exists'];
        }
        else
        {
            //die('Error:'.$users->error_msg());
        }
        sys_msg($msg, 1);
    }

    /* 注册送积分 */
    if (!empty($GLOBALS['_CFG']['register_points']))
    {
        log_account_change($_SESSION['user_id'], 0, 0, $GLOBALS['_CFG']['register_points'], $GLOBALS['_CFG']['register_points'], $_LANG['register_points']);
    }

    /*把新注册用户的扩展信息插入数据库*/
    $sql = 'SELECT id FROM ' . $ecs->table('reg_fields') . ' WHERE type = 0 AND display = 1 ORDER BY dis_order, id';   //读出所有扩展字段的id
    $fields_arr = $db->getAll($sql);

    $extend_field_str = '';    //生成扩展字段的内容字符串
    $user_id_arr = $users->get_profile_by_name($username);
    foreach ($fields_arr AS $val)
    {
        $extend_field_index = 'extend_field' . $val['id'];
        if(!empty($_POST[$extend_field_index]))
        {
            $temp_field_content = strlen($_POST[$extend_field_index]) > 100 ? mb_substr($_POST[$extend_field_index], 0, 99) : $_POST[$extend_field_index];
            $extend_field_str .= " ('" . $user_id_arr['user_id'] . "', '" . $val['id'] . "', '" . $temp_field_content . "'),";
        }
    }
    $extend_field_str = substr($extend_field_str, 0, -1);

    if ($extend_field_str)      //插入注册扩展数据
    {
        $sql = 'INSERT INTO '. $ecs->table('reg_extend_info') . ' (`user_id`, `reg_field_id`, `content`) VALUES' . $extend_field_str;
        $db->query($sql);
    }

    /* 更新会员的其它信息 */
    $other =  array();
    $other['credit_line'] = $credit_line;
    $other['user_rank']  = $rank;
    $other['sex']        = $sex;
    $other['birthday']   = $birthday;
    $other['reg_time'] = local_strtotime(local_date('Y-m-d H:i:s'));

    $other['msn'] = isset($_POST['extend_field1']) ? htmlspecialchars(trim($_POST['extend_field1'])) : '';
    $other['qq'] = isset($_POST['extend_field2']) ? htmlspecialchars(trim($_POST['extend_field2'])) : '';
    $other['office_phone'] = isset($_POST['extend_field3']) ? htmlspecialchars(trim($_POST['extend_field3'])) : '';
    $other['home_phone'] = isset($_POST['extend_field4']) ? htmlspecialchars(trim($_POST['extend_field4'])) : '';
    $other['mobile_phone'] = isset($_POST['extend_field5']) ? htmlspecialchars(trim($_POST['extend_field5'])) : '';

    $db->autoExecute($ecs->table('users'), $other, 'UPDATE', "user_name = '$username'");

    /* 记录管理员操作 */
    admin_log($_POST['username'], 'add', 'users');

    /* 提示信息 */
    $link[] = array('text' => $_LANG['go_back'], 'href'=>'agent.php?act=list');
    sys_msg(sprintf($_LANG['add_success'], htmlspecialchars(stripslashes($_POST['username']))), 0, $link);

}

/*------------------------------------------------------ */
//-- 编辑用户帐号
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'edit')
{
    /* 检查权限 */
    admin_priv('users_manage');

    $sql = "SELECT u.user_name, u.sex, u.birthday, u.pay_points, u.rank_points, u.user_rank , u.user_money, u.frozen_money, u.credit_line, u.parent_id, u2.user_name as parent_username, u.qq, u.msn, u.office_phone, u.home_phone, u.mobile_phone".
        " FROM " .$ecs->table('users'). " u LEFT JOIN " . $ecs->table('users') . " u2 ON u.parent_id = u2.user_id WHERE u.user_id='$_GET[id]'";

    $row = $db->GetRow($sql);
    $row['user_name'] = addslashes($row['user_name']);
    $users  = init_users();
    $user   = $users->get_user_info($row['user_name']);

    $sql = "SELECT u.vip_type,u.operating_record,u.job,u.user_id,u.user_type,u.suppliers_type, u.fx_activity,u.sex, u.birthday, u.pay_points, u.rank_points, u.user_rank , u.user_money, u.frozen_money, u.credit_line, u.parent_id, u2.user_name as parent_username, u.qq, u.msn,
    u.office_phone, u.home_phone, u.mobile_phone".
        " FROM " .$ecs->table('users'). " u LEFT JOIN " . $ecs->table('users') . " u2 ON u.parent_id = u2.user_id WHERE u.user_id='$_GET[id]'";

    $row = $db->GetRow($sql);

    if ($row)
    {
        $user['user_id']        = $row['user_id'];
        $user['sex']            = $row['sex'];
        $user['birthday']       = date($row['birthday']);
        $user['pay_points']     = $row['pay_points'];
        $user['rank_points']    = $row['rank_points'];
        $user['user_rank']      = $row['user_rank'];
        $user['user_money']     = $row['user_money'];
        $user['frozen_money']   = $row['frozen_money'];
        $user['credit_line']    = $row['credit_line'];
        $user['formated_user_money'] = price_format($row['user_money']);
        $user['formated_frozen_money'] = price_format($row['frozen_money']);
        $user['parent_id']      = $row['parent_id'];
        $user['parent_username']= $row['parent_username'];
        $user['qq']             = $row['qq'];
        $user['msn']            = $row['msn'];
        $user['office_phone']   = $row['office_phone'];
        $user['home_phone']     = $row['home_phone'];
        $user['mobile_phone']   = $row['mobile_phone'];
        $user['user_type']   	= $row['user_type'];
        $user['vip_type']   	= $row['vip_type'];
        $user['fx_activity']   	= $row['fx_activity'];
        $user['suppliers_type'] = $row['suppliers_type'];
        $user['job'] 			= $row['job'];
        $user['operating_record'] 	= $row['operating_record'];
    }
    else
    {
          $link[] = array('text' => $_LANG['go_back'], 'href'=>'agent.php?act=list');
          sys_msg($_LANG['username_invalid'], 0, $links);
//        $user['sex']            = 0;
//        $user['pay_points']     = 0;
//        $user['rank_points']    = 0;
//        $user['user_money']     = 0;
//        $user['frozen_money']   = 0;
//        $user['credit_line']    = 0;
//        $user['formated_user_money'] = price_format(0);
//        $user['formated_frozen_money'] = price_format(0);
     }

    /* 取出注册扩展字段 */
    $sql = 'SELECT * FROM ' . $ecs->table('reg_fields') . ' WHERE type < 2 AND id != 6 ORDER BY dis_order, id';
    $extend_info_list = $db->getAll($sql);

    $sql = 'SELECT reg_field_id, content ' .
           'FROM ' . $ecs->table('reg_extend_info') .
           " WHERE user_id = $user[user_id]";
    $extend_info_arr = $db->getAll($sql);

    $temp_arr = array();
    foreach ($extend_info_arr AS $val)
    {
        $temp_arr[$val['reg_field_id']] = $val['content'];
    }

    foreach ($extend_info_list AS $key => $val)
    {
        switch ($val['id'])
        {
            case 1:     $extend_info_list[$key]['content'] = $user['msn']; break;
            case 2:     $extend_info_list[$key]['content'] = $user['qq']; break;
            case 3:     $extend_info_list[$key]['content'] = $user['office_phone']; break;
            case 4:     $extend_info_list[$key]['content'] = $user['home_phone']; break;
            case 5:     $extend_info_list[$key]['content'] = $user['mobile_phone']; break;
            default:    $extend_info_list[$key]['content'] = empty($temp_arr[$val['id']]) ? '' : $temp_arr[$val['id']] ;
        }
    }

    $smarty->assign('extend_info_list', $extend_info_list);

    /* 当前会员推荐信息 */
    $affiliate = unserialize($GLOBALS['_CFG']['affiliate']);
    $smarty->assign('affiliate', $affiliate);

    empty($affiliate) && $affiliate = array();

    if(empty($affiliate['config']['separate_by']))
    {
        //推荐注册分成
        $affdb = array();
        $num = count($affiliate['item']);
        $up_uid = "'$_GET[id]'";
        for ($i = 1 ; $i <=$num ;$i++)
        {
            $count = 0;
            if ($up_uid)
            {
                $sql = "SELECT user_id FROM " . $ecs->table('users') . " WHERE parent_id IN($up_uid)";
                $query = $db->query($sql);
                $up_uid = '';
                while ($rt = $db->fetch_array($query))
                {
                    $up_uid .= $up_uid ? ",'$rt[user_id]'" : "'$rt[user_id]'";
                    $count++;
                }
            }
            $affdb[$i]['num'] = $count;
        }
        if ($affdb[1]['num'] > 0)
        {
            $smarty->assign('affdb', $affdb);
        }
    }
    assign_query_info();
    $operating_record=explode('|',$user['operating_record']);
    $smarty->assign('operating_record',             $operating_record);
    
    $smarty->assign('ur_here',          $_LANG['users_edit']);
    $smarty->assign('action_link',      array('text' => $_LANG['03_users_list'], 'href'=>'agent.php?act=list&' . list_link_postfix()));
    $smarty->assign('user',             $user);
    $smarty->assign('form_action',      'update');
    $smarty->assign('special_ranks',    get_rank_list(true));
    $smarty->display('user_info.htm');
}

/*------------------------------------------------------ */
//-- 删除供货商店招图片
/*------------------------------------------------------ */
elseif($_REQUEST['act'] == 'del_img'){

    $user_id = intval($_REQUEST['user_id']);
	$user_img_path=empty($_REQUEST['img_path'])?'':$_REQUEST['img_path'];
	if(!empty($user_id) && !empty($user_img_path)){
        @unlink('../' . $user_img_path);
        $sql = "SELECT operating_record " .
                    " FROM " . $ecs->table('users') .
                    " WHERE user_id = '$user_id'";
        $row = $db->getRow($sql);
        if(empty($row['operating_record'])){
        	$new_img=str_replace($user_img_path,'',$row['operating_record']);
        	
        }else{
        	$new_img=str_replace($user_img_path.'|','',$row['operating_record']);
        	
        }

        if(empty($new_img)){
        	$new_img=null;
        }
        $sql="UPDATE " . $ecs->table('users') . " SET operating_record = '$new_img' WHERE user_id = '$user_id'";
		if($db->query($sql)){
			echo true;
		}else{
			echo false;
		}
	}
}

/*------------------------------------------------------ */
//-- 更新用户帐号
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'update')
{
    /* 检查权限 */
    admin_priv('users_manage');
include_once(ROOT_PATH . '/includes/cls_image.php');
    
    $username = empty($_POST['username']) ? '' : trim($_POST['username']);
    $password = empty($_POST['password']) ? '' : trim($_POST['password']);
    $email = empty($_POST['email']) ? '' : trim($_POST['email']);
    $sex = empty($_POST['sex']) ? 0 : intval($_POST['sex']);
    
    $sex = in_array($sex, array(0, 1, 2)) ? $sex : 0;
    $birthday = $_POST['birthdayYear'] . '-' .  $_POST['birthdayMonth'] . '-' . $_POST['birthdayDay'];
    $rank = empty($_POST['user_rank']) ? 0 : intval($_POST['user_rank']);
    $credit_line = empty($_POST['credit_line']) ? 0 : floatval($_POST['credit_line']);

    $users  = init_users();

    if (!$users->edit_user(array('username'=>$username, 'password'=>$password, 'email'=>$email, 'gender'=>$sex, 'bday'=>$birthday ), 1))
    {
        if ($users->error == ERR_EMAIL_EXISTS)
        {
            $msg = $_LANG['email_exists'];
        }
        else
        {
            $msg = $_LANG['edit_user_failed'];
        }
        sys_msg($msg, 1);
    }
    if(!empty($password))
    {
			$sql="UPDATE ".$ecs->table('users'). "SET `ec_salt`='0' WHERE user_name= '".$username."'";
			$db->query($sql);
	}
    /* 更新用户扩展字段的数据 */
    $sql = 'SELECT id FROM ' . $ecs->table('reg_fields') . ' WHERE type = 0 ORDER BY dis_order, id';   //读出所有扩展字段的id
    $fields_arr = $db->getAll($sql);
    $user_id_arr = $users->get_profile_by_name($username);
    $user_id = $user_id_arr['user_id'];

    foreach ($fields_arr AS $val)       //循环更新扩展用户信息
    {
        $extend_field_index = 'extend_field' . $val['id'];
        if(isset($_POST[$extend_field_index]))
        {
            $temp_field_content = strlen($_POST[$extend_field_index]) > 100 ? mb_substr($_POST[$extend_field_index], 0, 99) : $_POST[$extend_field_index];

            $sql = 'SELECT * FROM ' . $ecs->table('reg_extend_info') . "  WHERE reg_field_id = '$val[id]' AND user_id = '$user_id'";
            if ($db->getOne($sql))      //如果之前没有记录，则插入
            {
                $sql = 'UPDATE ' . $ecs->table('reg_extend_info') . " SET content = '$temp_field_content' WHERE reg_field_id = '$val[id]' AND user_id = '$user_id'";
            }
            else
            {
                $sql = 'INSERT INTO '. $ecs->table('reg_extend_info') . " (`user_id`, `reg_field_id`, `content`) VALUES ('$user_id', '$val[id]', '$temp_field_content')";
            }
            $db->query($sql);
        }
    }
	

    /* 更新会员的其它信息 */
    $other =  array();
    
    if($_FILES['operating_record']['name']){
    	
    }
    $num='';
    foreach ($_FILES['operating_record']['size'] as $key => $value) {
    	if($value>1700000){
//  		$num=$num.'、'.$key+1;
			sys_msg('图片过大');
    	}
    }
//  if($num!=''){
//  	$content=trim($num,'、');
//  	sys_msg('第'.$content.'张图片过大');
//  }
	$image = new cls_image($_CFG['bgcolor']);
	$sql = "SELECT operating_record " .
            " FROM " . $ecs->table('users') .
            " WHERE user_id = '$user_id'";
    $row = $db->getRow($sql);
	if(is_array($_FILES['operating_record']['name'])){
		foreach ($_FILES['operating_record']['name'] as $key => $value) {
			if($_FILES['operating_record']['tmp_name'][$key] != '' && $_FILES['operating_record']['tmp_name'][$key] != 'none'){
				$upload = array(
	                'name' => $_FILES['operating_record']['name'][$key],
	                'type' => $_FILES['operating_record']['type'][$key],
	                'tmp_name' => $_FILES['operating_record']['tmp_name'][$key],
	                'size' => $_FILES['operating_record']['size'][$key],
	            );
				$operating_record   = $image->upload_image($upload,'operating_record'); // 原始图片
				$other['operating_record'].=$operating_record.'|';
			}
		}
	}else{
		if($_FILES['operating_record']['tmp_name'] != '' && $_FILES['operating_record']['tmp_name'] != 'none'){
			$operating_record   = $image->upload_image($_FILES['operating_record'],'operating_record'); // 原始图片
			$other['operating_record']=$operating_record.'|';
		}
	}
	if(!empty($row['operating_record'])){
		$other['operating_record']=$row['operating_record'].$other['operating_record'];
	}
	$other['job']=isset($_POST['job']) ? intval($_POST['job']) : 1;
    
    $sql='SELECT * FROM '. $ecs->table('users') ." WHERE user_id = '$_POST[id]'" ;
	$userinfo=$db->getRow($sql);
	if(($userinfo['user_type'] != $_POST['user_type']) && $userinfo['user_type'] == 1)
	{
		$sql='SELECT * FROM '. $ecs->table('users') ." WHERE user_id = $userinfo[parent_id]";
		$parentinfo=$db->getRow($sql);
		if($parentinfo['user_type'] == 1){
			$other['parent_id']=$parentinfo ? $parentinfo['ancestor_id'] : '';
		}
	}
	if($other['job']!=1){
		if($userinfo['job']==1){
			$change_desc='兼职金钻,预支1280金积分';
    		log_account_change_vr($user_id, 0, 0, 0, (-1)*1280,0, 0,$change_desc, ACT_SAVING);
    	}
	}

    $affiliate_name=isset($_POST['affiliate_name']) ? htmlspecialchars($_POST['affiliate_name']) : '';
	if(!empty($affiliate_name)){
		$parent_info=get_assign_user_info($affiliate_name);		
		$other['parent_id']=isset($parent_info) ? htmlspecialchars($parent_info) : '';
	}
    $other['credit_line'] = $credit_line;
    $other['user_rank'] = $rank;

    $other['msn'] = isset($_POST['extend_field1']) ? htmlspecialchars(trim($_POST['extend_field1'])) : '';
    $other['qq'] = isset($_POST['extend_field2']) ? htmlspecialchars(trim($_POST['extend_field2'])) : '';
    $other['office_phone'] = isset($_POST['extend_field3']) ? htmlspecialchars(trim($_POST['extend_field3'])) : '';
    $other['home_phone'] = isset($_POST['extend_field4']) ? htmlspecialchars(trim($_POST['extend_field4'])) : '';
    $other['mobile_phone'] = isset($_POST['extend_field5']) ? htmlspecialchars(trim($_POST['extend_field5'])) : '';
    $other['suppliers_type']=isset($_POST['suppliers']) ? intval($_POST['suppliers']) : 1;
	$other['user_type']=isset($_POST['user_type']) ? intval($_POST['user_type']) : 1;
	$other['vip_type']=isset($_POST['vip_type']) ? intval($_POST['vip_type']) : 1;
	$other['fx_activity']=isset($_POST['fx_activity']) ? htmlspecialchars($_POST['fx_activity']) : '';
    $db->autoExecute($ecs->table('users'), $other, 'UPDATE', "user_name = '$username'");

    /* 记录管理员操作 */
    admin_log($username, 'edit', 'users');

    /* 提示信息 */
    $links[0]['text']    = $_LANG['goto_list'];
    $links[0]['href']    = 'agent.php?act=list&' . list_link_postfix();
    $links[1]['text']    = $_LANG['go_back'];
    $links[1]['href']    = 'javascript:history.back()';

    sys_msg($_LANG['update_success'], 0, $links);

}

/*------------------------------------------------------ */
//-- 批量删除会员帐号
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'batch_remove')
{
    /* 检查权限 */
    admin_priv('users_drop');

    if (isset($_POST['checkboxes']))
    {
        $sql = "SELECT user_name FROM " . $ecs->table('users') . " WHERE user_id " . db_create_in($_POST['checkboxes']);
        $col = $db->getCol($sql);
        $usernames = implode(',',addslashes_deep($col));
        $count = count($col);
        /* 通过插件来删除用户 */
        $users = init_users();
        $users->remove_user($col);

        admin_log($usernames, 'batch_remove', 'users');

        $lnk[] = array('text' => $_LANG['go_back'], 'href'=>'agent.php?act=list');
        sys_msg(sprintf($_LANG['batch_remove_success'], $count), 0, $lnk);
    }
    else
    {
        $lnk[] = array('text' => $_LANG['go_back'], 'href'=>'agent.php?act=list');
        sys_msg($_LANG['no_select_user'], 0, $lnk);
    }
}

/* 编辑用户名 */
elseif ($_REQUEST['act'] == 'edit_username')
{
    /* 检查权限 */
    check_authz_json('users_manage');

    $username = empty($_REQUEST['val']) ? '' : json_str_iconv(trim($_REQUEST['val']));
    $id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);

    if ($id == 0)
    {
        make_json_error('NO USER ID');
        return;
    }

    if ($username == '')
    {
        make_json_error($GLOBALS['_LANG']['username_empty']);
        return;
    }

    $users = init_users();

    if ($users->edit_user($id, $username))
    {
        if ($_CFG['integrate_code'] != 'ecshop')
        {
            /* 更新商城会员表 */
            $db->query('UPDATE ' .$ecs->table('users'). " SET user_name = '$username' WHERE user_id = '$id'");
        }

        admin_log(addslashes($username), 'edit', 'users');
        make_json_result(stripcslashes($username));
    }
    else
    {
        $msg = ($users->error == ERR_USERNAME_EXISTS) ? $GLOBALS['_LANG']['username_exists'] : $GLOBALS['_LANG']['edit_user_failed'];
        make_json_error($msg);
    }
}

/*------------------------------------------------------ */
//-- 编辑email
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'edit_email')
{
    /* 检查权限 */
    check_authz_json('users_manage');

    $id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);
    $email = empty($_REQUEST['val']) ? '' : json_str_iconv(trim($_REQUEST['val']));

    $users = init_users();

    $sql = "SELECT user_name FROM " . $ecs->table('users') . " WHERE user_id = '$id'";
    $username = $db->getOne($sql);


    if (is_email($email))
    {
        if ($users->edit_user(array('username'=>$username, 'email'=>$email)))
        {
            admin_log(addslashes($username), 'edit', 'users');

            make_json_result(stripcslashes($email));
        }
        else
        {
            $msg = ($users->error == ERR_EMAIL_EXISTS) ? $GLOBALS['_LANG']['email_exists'] : $GLOBALS['_LANG']['edit_user_failed'];
            make_json_error($msg);
        }
    }
    else
    {
        make_json_error($GLOBALS['_LANG']['invalid_email']);
    }
}

/*------------------------------------------------------ */
//-- 删除会员帐号
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'remove')
{
    /* 检查权限 */
    admin_priv('users_drop');

    $sql = "SELECT user_name FROM " . $ecs->table('users') . " WHERE user_id = '" . $_GET['id'] . "'";
    $username = $db->getOne($sql);
    /* 通过插件来删除用户 */
    $users = init_users();
    $users->remove_user($username); //已经删除用户所有数据

    /* 记录管理员操作 */
    admin_log(addslashes($username), 'remove', 'users');

    /* 提示信息 */
    $link[] = array('text' => $_LANG['go_back'], 'href'=>'agent.php?act=list');
    sys_msg(sprintf($_LANG['remove_success'], $username), 0, $link);
}

/*------------------------------------------------------ */
//--  收货地址查看
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'address_list')
{
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    $sql = "SELECT a.*, c.region_name AS country_name, p.region_name AS province, ct.region_name AS city_name, d.region_name AS district_name ".
           " FROM " .$ecs->table('user_address'). " as a ".
           " LEFT JOIN " . $ecs->table('region') . " AS c ON c.region_id = a.country " .
           " LEFT JOIN " . $ecs->table('region') . " AS p ON p.region_id = a.province " .
           " LEFT JOIN " . $ecs->table('region') . " AS ct ON ct.region_id = a.city " .
           " LEFT JOIN " . $ecs->table('region') . " AS d ON d.region_id = a.district " .
           " WHERE user_id='$id'";
    $address = $db->getAll($sql);
    $smarty->assign('address',          $address);
    assign_query_info();
    $smarty->assign('ur_here',          $_LANG['address_list']);
    $smarty->assign('action_link',      array('text' => $_LANG['03_users_list'], 'href'=>'agent.php?act=list&' . list_link_postfix()));
    $smarty->display('user_address_list.htm');
}

/*------------------------------------------------------ */
//-- 脱离推荐关系
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'remove_parent')
{
    /* 检查权限 */
    admin_priv('users_manage');

    $sql = "UPDATE " . $ecs->table('users') . " SET parent_id = 0 WHERE user_id = '" . $_GET['id'] . "'";
    $db->query($sql);

    /* 记录管理员操作 */
    $sql = "SELECT user_name FROM " . $ecs->table('users') . " WHERE user_id = '" . $_GET['id'] . "'";
    $username = $db->getOne($sql);
    admin_log(addslashes($username), 'edit', 'users');

    /* 提示信息 */
    $link[] = array('text' => $_LANG['go_back'], 'href'=>'agent.php?act=list');
    sys_msg(sprintf($_LANG['update_success'], $username), 0, $link);
}

/*------------------------------------------------------ */
//-- 查看用户推荐会员列表
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'aff_list')
{
    /* 检查权限 */
    admin_priv('users_manage');
    $smarty->assign('ur_here',      $_LANG['03_users_list']);

    $auid = $_GET['auid'];
    $user_list['user_list'] = array();

    $affiliate = unserialize($GLOBALS['_CFG']['affiliate']);
    $smarty->assign('affiliate', $affiliate);

    empty($affiliate) && $affiliate = array();

    $num = count($affiliate['item']);
    $up_uid = "'$auid'";
    $all_count = 0;
    for ($i = 1; $i<=$num; $i++)
    {
        $count = 0;
        if ($up_uid)
        {
            $sql = "SELECT user_id FROM " . $ecs->table('users') . " WHERE parent_id IN($up_uid)";
            $query = $db->query($sql);
            $up_uid = '';
            while ($rt = $db->fetch_array($query))
            {
                $up_uid .= $up_uid ? ",'$rt[user_id]'" : "'$rt[user_id]'";
                $count++;
            }
        }
        $all_count += $count;

        if ($count)
        {
            $sql = "SELECT user_id, user_name, '$i' AS level, email, is_validated, user_money, frozen_money, rank_points, pay_points, reg_time ".
                    " FROM " . $GLOBALS['ecs']->table('users') . " WHERE user_id IN($up_uid)" .
                    " ORDER by level, user_id";
            $user_list['user_list'] = array_merge($user_list['user_list'], $db->getAll($sql));
        }
    }

    $temp_count = count($user_list['user_list']);
    for ($i=0; $i<$temp_count; $i++)
    {
        $user_list['user_list'][$i]['reg_time'] = local_date($_CFG['date_format'], $user_list['user_list'][$i]['reg_time']);
    }

    $user_list['record_count'] = $all_count;

    $smarty->assign('user_list',    $user_list['user_list']);
    $smarty->assign('record_count', $user_list['record_count']);
    $smarty->assign('full_page',    1);
    $smarty->assign('action_link',  array('text' => $_LANG['back_note'], 'href'=>"agent.php?act=edit&id=$auid"));

    assign_query_info();
    $smarty->display('affiliate_list.htm');
}
//处理查询信息
elseif ($_REQUEST['act'] == 'agent_select'){
	$father = $_GET['province'];
	$sql = "SELECT * FROM ".$ecs->table('city')." WHERE father = '$father'";
	$city = get_province($sql);
	$province_json = json_encode($city);
	echo $province_json;
	
}
elseif ($_REQUEST['act'] == 'area_select'){
	$father = $_GET['city'];
	$sql = "SELECT * FROM ".$ecs->table('area')." WHERE father = '$father'";
	$city = get_province($sql);
	$province_json = json_encode($city);
	echo $province_json;
	
}
//处理指定状态
elseif ($_REQUEST['act'] == 'agent_status')
{
   $userID = $_GET['status'];
   $sql = "SELECT * FROM ".$ecs->table('users')." WHERE user_id = '$userID'";  
   $user_info_agent = $db->getRow($sql);
   if($user_info_agent['is_validated']  == 1){
	   $sql = "UPDATE ecs_users set is_validated = 0 where user_id=".$userID;
	   @$state = $db->getRow($sql);
	   exit(true);
   }else{
	   $sql = "UPDATE ecs_users set is_validated = 1 where user_id=".$userID;
	   @$state = $db->getRow($sql);
	   exit(true);
   }
}



/**
 *  返回用户列表数据
 *
 * @access  public
 * @param
 *
 * @return void
 */
function user_list()
{
    $result = get_filter();
    if ($result === false)
    {

        /* 过滤条件 */
        $filter['keywords'] = empty($_REQUEST['keywords']) ? '' : trim($_REQUEST['keywords']);
        if (isset($_REQUEST['is_ajax']) && $_REQUEST['is_ajax'] == 1)
        {
            $filter['keywords'] = json_str_iconv($filter['keywords']);
        }
        $filter['start_time'] = !empty($_REQUEST['start_time']) ? $_REQUEST['start_time']: '';
        $filter['end_time'] = !empty($_REQUEST['end_time']) ? $_REQUEST['end_time'] : '';
        if((!is_numeric($filter['start_time'])) && (!empty($filter['start_time']))){
//			echo 123;
			$filter['start_time']=local_strtotime($filter['start_time']);
//			echo $filter['start_time'];
		}
		if((!is_numeric($filter['end_time'])) && (!empty($filter['end_time']))){
			$filter['end_time']=local_strtotime($filter['end_time']);
		}
        $filter['mobilephone'] = empty($_REQUEST['mobilephone']) ? '' : trim($_REQUEST['mobilephone']);
        $filter['rank'] = empty($_REQUEST['rank']) ? 0 : intval($_REQUEST['rank']);
        $filter['user_type'] = empty($_REQUEST['user_type']) ? 0 : intval($_REQUEST['user_type']);
        $filter['job'] = empty($_REQUEST['job']) ? 1 : intval($_REQUEST['job']);
        $filter['pay_points_gt'] = empty($_REQUEST['pay_points_gt']) ? 0 : intval($_REQUEST['pay_points_gt']);
        $filter['pay_points_lt'] = empty($_REQUEST['pay_points_lt']) ? 0 : intval($_REQUEST['pay_points_lt']);

        $filter['sort_by']    = empty($_REQUEST['sort_by'])    ? 'user_id' : trim($_REQUEST['sort_by']);
        $filter['sort_order'] = empty($_REQUEST['sort_order']) ? 'DESC'     : trim($_REQUEST['sort_order']);
		$filter['is_paid'] = empty($_REQUEST['is_paid']) == -1 ? 0 : intval($_REQUEST['is_paid']);
        $ex_where = ' WHERE is_validated=1 ';
        if ($filter['keywords'])
        {
            $ex_where .= " AND user_name LIKE '%" . mysql_like_quote($filter['keywords']) ."%'";
        }
        if ($filter['mobilephone'])
        {
            $ex_where .= " AND mobile_phone LIKE '%" . mysql_like_quote($filter['mobilephone']) ."%'";
        }
        if($filter['job'] == 2){
        	$ex_where .= " AND job = 2";
        }
        if ($filter['rank'])
        {
            $sql = "SELECT min_points, max_points, special_rank FROM ".$GLOBALS['ecs']->table('user_rank')." WHERE rank_id = '$filter[rank]'";
            $row = $GLOBALS['db']->getRow($sql);
            if ($row['special_rank'] > 0)
            {
                /* 特殊等级 */
                $ex_where .= " AND user_rank = '$filter[rank]' ";
            }
            else
            {
                $ex_where .= " AND rank_points >= " . intval($row['min_points']) . " AND rank_points < " . intval($row['max_points']);
            }
        }
        if($filter['is_paid'])
        {
        	$ex_where .=" AND is_validated = '$filter[is_paid]' ";
        }

        if($filter['start_time'])
        {
        	$ex_where .= " AND reg_time >= '$filter[start_time]' ";
        }
        if($filter['end_time'])
        {
        	$ex_where .= " AND reg_time < '$filter[end_time]' ";
        }
        if ($filter['pay_points_gt'])
        {
             $ex_where .=" AND pay_points >= '$filter[pay_points_gt]' ";
        }
        if ($filter['pay_points_lt'])
        {
            $ex_where .=" AND pay_points < '$filter[pay_points_lt]' ";
        }

        $filter['record_count'] = $GLOBALS['db']->getOne("SELECT COUNT(*) FROM " . $GLOBALS['ecs']->table('users') . $ex_where);
		


        /* 分页大小 */
        $filter = page_and_size($filter);
        
			$sql = "SELECT pay_points_2,user_id, user_name, email, is_validated, user_money, frozen_money, rank_points, pay_points, reg_time,province,city,area".
                " FROM " . $GLOBALS['ecs']->table('users') . $ex_where .
                " ORDER by " . $filter['sort_by'] . ' ' . $filter['sort_order'];
		
			
        $filter['keywords'] = stripslashes($filter['keywords']);
        set_filter($filter, $sql);
    }
    else
    {
        $sql    = $result['sql'];
        $filter = $result['filter'];
    }
    $user_list = $GLOBALS['db']->getAll($sql);
    $count = count($user_list);
    for ($i=0; $i<$count; $i++)
    {
        $user_list[$i]['reg_time'] = local_date($GLOBALS['_CFG']['date_format'], $user_list[$i]['reg_time']);
    }

    $arr = array('user_list' => $user_list, 'filter' => $filter,
        'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);
		
    return $arr;
}
/**
 * 获得用户信息
 */
function get_assign_user_info($user,$code=''){
	if(empty($code)){
		$sql='SELECT * FROM ' .$GLOBALS['ecs']->table('users'). ' AS u ' .
            " WHERE u.user_name = '$user'";
 	}elseif($code=='recomme'){
 		$sql='SELECT * FROM ' .$GLOBALS['ecs']->table('users'). ' AS u ' .
            " WHERE u.user_id = '$user'";
 	}
	$users=$GLOBALS['db']->getOne($sql);

	if(!$users){
		$msg=('账户不存在');
		sys_msg($msg, 1);
	}
	return $users;
}
//计算总金额
function getUserAgent($address_next,$start_time,$end_time){
	if(!empty($address_next)){
		foreach($address_next as $k=>$v)
		{		
			if($start_time == 0 && $end_time == 0)
			{
				$where_money = " WHERE user_id='".$v['user_id']."' and process_type='3' and is_paid='1'";
			}else
			{
				$where_money = " WHERE user_id='".$v['user_id']."' and process_type='3' and is_paid='1' and add_time >= $start_time and add_time <= $end_time";
			}
			$subtotal = getAgentMoney("ecs_user_account",$where_money);				
			$address_next[$k]['amount'] = $subtotal['subtotal'];
			$address_info['total_money'] += $subtotal['total'];

			$address_next[$k]['address'] = getAgentAddress(trim($v['province']),trim($v['city']),trim($v['area']));
			$address_next[$k]['reg_time'] = date('Y-m-d',$v['reg.time']);
		}
	}
	$address_next_agent['next'] = $address_next;
	$address_next_agent['total_money'] =$address_info['total_money'];
	return $address_next_agent;
}
//查询分页
function pageAbout($page_where,$filed,$userID,$start_time,$end_time){
	
	$filter_page['record_count'] = $GLOBALS['db']->getOne("SELECT COUNT(*) FROM " . $GLOBALS['ecs']->table('users') . $page_where);
	
	/* 分页大小 */
	$filter_page = page_and_size($filter_page);

		$sql = "SELECT $filed ".
			" FROM " . $GLOBALS['ecs']->table('users') . $ex_where .
			" ORDER by user_id " . $filter_page['sort_order'] .
			" LIMIT " . $filter_page['start'] . ',' . $filter_page['page_size'];
	
	$filter_page['keywords'] = stripslashes($filter_page['keywords']);
	set_filter($filter_page, $sql);
	$filter_page_sum['page'] = $filter_page;
	$filter_fi =$filter_page;
	$filter_fi["sort_by"] = $userID;
	$filter_fi["start_time"] = $start_time;
	$filter_fi["end_time"] = $end_time;
	$filter_page_sum['filter'] = $filter_fi;
	
	return $filter_page_sum;
}

?>