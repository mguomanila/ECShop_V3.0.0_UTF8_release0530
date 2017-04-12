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
		if ($query) 
		{
			$row = mysql_fetch_array($query);
		}
	return $row;
}

/*查询下一级*/
function getNextInfo($address_next,$table,$start_time,$end_time)
{
	foreach($address_next as $key=>$val)
	{
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
				if($val['amount'] >= 0)
				{
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
function get_province($sql)
{
	if ($res=mysql_query($sql))
	{
		while($row=mysql_fetch_array($res))
		{
			$province[]=$row;
		} 
	}else {
		$province = "ִ执行SQL语句:$sql\n错误".mysql_error();
		
	}
	return $province;
}

/**
 * 二维数组根据字段进行排序
 * @params array $array 需要排序的数组
 * @params string $field 排序的字段
 * @params string $sort 排序顺序标志 SORT_DESC 降序；SORT_ASC 升序
 */
 function arraySequence($array, $field, $sort = 'SORT_DESC')
{
    $arrSort = array();
    foreach ($array as $uniqid => $row) {
        foreach ($row as $key => $value) {
            $arrSort[$key][$uniqid] = $value;
        }
    }
    array_multisort($arrSort[$field], constant($sort), $array);
    return $array;
}

/**
    * 导出数据为excel表格
    *@param $data    一个二维数组,结构如同从数据库查出来的数组
    *@param $title   excel的第一行标题,一个数组,如果为空则没有标题
    *@param $filename 下载的文件名
    *@examlpe 
    $stu = M ('User');
    $arr = $stu -> select();
    exportexcel($arr,array('id','账户','密码','昵称'),'文件名!');
*/
function exportexcel($data=array(),$title=array(),$filename='report'){
    header("Content-type:application/octet-stream");
    header("Accept-Ranges:bytes");
    header("Content-type:application/vnd.ms-excel");  
    header("Content-Disposition:attachment;filename=".$filename.".xls");
    header("Pragma: no-cache");
    header("Expires: 0");
    //导出xls 开始
    if (!empty($title)){
        foreach ($title as $k => $v) {
            $title[$k]=iconv("UTF-8", "GB2312",$v);
        }
        $title= implode("\t", $title);
        echo "$title\n";
    }

    if (!empty($data)){
        foreach($data as $key=>$val){
            foreach ($val as $ck => $cv) {
                $data[$key][$ck]=iconv("UTF-8", "GB2312", $cv);
            }
            $data[$key]=implode("\t", $data[$key]);
            
        }
        echo implode("\n",$data);
    }
}

function excelListInfo($user_agent){
	$name = date('YmdHis',time());

	foreach($user_agent as $key=>$val){
		$user_excel[$key]['user_id'] = $val['user_id'];
		$user_excel[$key]['user_name'] = $val['user_name'];
		$user_excel[$key]['user_money'] = $val['user_money'];
		if($val['user_type'] == 1){
			$user_excel[$key]['user_type'] = '会员';
		}
		if($val['user_type'] == 2){
			$user_excel[$key]['user_type'] = '金钻';
		}
		if($val['user_type'] == 3){
			$user_excel[$key]['user_type'] = '铂金';
		}		
		$user_excel[$key]['address'] = $val['address'];
		$user_excel[$key]['amount'] = $val['amount'];
	}
	
	exportexcel($user_excel,array('编号','用户名','可用资金','用户类型','地区','金额'),$name);
}
?>