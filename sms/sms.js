		function sendSms(){
		  var mobile = document.getElementById(mobile_field).value;
		  var smscode = document.getElementById("sms_code").value;
		  var mobile1 = encodeURI(mobile);
		  alert(mobile1);
		console.log('mobile1=' + mobile1+'&smscode=' + smscode);
		  Ajax.call(
		  	'sms/sms.php?act=send',
		  	'mobile=' + mobile+'&smscode=' + smscode, 
		  	sendSmsResponse, 
		  	'POST', 
		  	'JSON');
		}
		function sendSmsResponse(result){
		  if (result.code==2){
			    RemainTime();		
				alert('手机验证码已经成功发送到您的手机');
		  }else{
			  if(result.msg){
				alert(result.msg);
			  }else{
				alert('手机验证码发送失败');
			  }
		  }
		}
		function register2(){
			var mobile = document.getElementById(mobile_field).value;
			if (mobile_field != ''){
			  var mobile_code = document.getElementById("mobile_code").value;
			  var result = Ajax.call('sms/sms.php?act=check', 'mobile=' + mobile + '&mobile_code=' + mobile_code, null, 'POST', 'JSON', false);	
			 if (result.code==2){
					return register();
			  }else{
					alert(result.msg);
					return false;
			  }
			}
		  return register();			
		}
		
		var iTime = 59;
		var Account;
		function RemainTime(){
			document.getElementById('zphone').disabled = true;
			var iSecond,sSecond="",sTime="";
			if (iTime >= 0){
				iSecond = parseInt(iTime%60);
				if (iSecond >= 0){
					sSecond = iSecond + "秒";
				}
				sTime=sSecond;
				if(iTime==0){
					clearTimeout(Account);
					sTime='获取手机验证码';
					iTime = 59;
					document.getElementById('zphone').disabled = false;
				}else{
					Account = setTimeout("RemainTime()",1000);
					iTime=iTime-1;
				}
			}else{
				sTime='没有倒计时';
			}
			document.getElementById('zphone').value = sTime;
		}		
