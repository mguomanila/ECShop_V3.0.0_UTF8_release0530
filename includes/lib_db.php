<?php
/*查询地址信息
*/
function getAgentAddress($province,$city,$area){
	$province =" WHERE provinceID=".$province;
	$province_a = getAddress('province',"ecs_province",$province);
	$city =" WHERE cityID=".$city;
	$city_a = getAddress('city',"ecs_city",$city);
	$area =" WHERE areaID=".$area;
	$area_a = getAddress('area',"ecs_area",$area);
	return $province_a['province'].$city_a['city'].$area_a['area'];
}

function  getAddress($filed,$table,$where_address){

	$sql = "SELECT $filed FROM `$table`".$where_address;
	$query = mysql_query($sql);
		if ($query) {
			$row = mysql_fetch_array($query);
		}
	return $row;
}

/*查询下一级*/
function getNextInfo($address_next,$table,$start_time,$end_time){
	foreach($address_next as $key=>$val){
		$agent_where = " WHERE add_time>=$start_time and add_time<=$end_time and process_type=3 and is_paid=1 and user_id=".$val['user_id'];
		$sql = "SELECT amount,user_id from `$table`".$agent_where;
		$data = get_province($sql);
		if($data != NULL)
		{	
			foreach($data as $val)
			{
				$money_agent += $val['amount'];
				$user_id = $val['user_id'];
			}
			$address_next[$key]['money_agent'] = $money_agent;
			$address_next[$key]['user_id'] = $user_id;
		}
	}
	return $address_next;
}

/*
*	统计总金额小计
*	$table                表明
	$where_money          条件
*/

function getAgentMoney($table,$where_money){
		$sql = "SELECT amount,user_id from `$table`".$where_money;
		$temp = get_province($sql);
		if($temp != NULL)
		{
			foreach($temp as $val)
			{	
				if($val['amount'] >= 0){
					$money_agent += $val['amount'];
				}
				$money_agent_total['user_id'] = $val['user_id'];
			}
			$money_agent_total['subtotal'] = $money_agent;
			$money_agent_total['total'] = $money_agent;
		}
	return $money_agent_total;
}

/*

查询
return   返回一个二维数组
*/
function get_province($sql){
	if ($res=mysql_query($sql)){
		while($row=mysql_fetch_array($res)){
			$province[]=$row;
		} 
	}else {
		$province = "ִ执行SQL语句:$sql\n错误".mysql_error();
		
	}
	return $province;
}

?>