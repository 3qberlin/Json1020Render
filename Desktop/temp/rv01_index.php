<?
        if($_COOKIE["BBNET_PAD_MODE"]=='Y') { 
            setCookie("BBNET_PAD_MODE","Y",30);
        }
	include_once($_SERVER["DOCUMENT_ROOT"]."/admin/inc/main.php"); 
	
	include_once($Sys_TheLocalUrl."admin/inc/check_user_session.php"); //check使用者
	
	//check使用者有無此功能權限
	include_once($Sys_TheLocalUrl."admin/inc/check_functioan_authority.php"); //check使用者是否有這個功能的權限
        include_once($Sys_TheLocalUrl."function/qrcode_function.php"); //line相關
	include_once("../inc/index_start.php");
	//若該程式可以預設
        $sysFirstFlag = $_REQUEST["sysFirstFlag"]+0;
        $qrver = 1;//qrcode 版本
        if($sysFirstFlag==0)
        {    
            $buffer_admin_func_set = Admin_Get_User_Function_Set($accessinfo["UserNo"],$admin_func_id);
           
            $admin_func_set = $buffer_admin_func_set["setstr"];
            unset($buffer_admin_func_set);
            if($admin_func_set!="")
            {
               parse_str($admin_func_set,$default_set);
            }
        }    
        //
	$dep_year = isset( $_REQUEST["dep_year"]) ? $_REQUEST["dep_year"]+0 : 0;
	$dep_month = isset( $_REQUEST["dep_month"]) ? $_REQUEST["dep_month"]+0 : 0;  
	$dep_day =  isset( $_REQUEST["dep_day"]) ? $_REQUEST["dep_day"]+0 : 0; 
	$dep_year2 = isset( $_REQUEST["dep_year2"]) ? $_REQUEST["dep_year2"]+0 : 0;
	$dep_month2 = isset( $_REQUEST["dep_month2"]) ? $_REQUEST["dep_month2"]+0 : 0;
	$dep_day2 = isset( $_REQUEST["dep_day2"]) ? $_REQUEST["dep_day2"]+0 : 0; 
	$dealtype = isset( $_REQUEST["dealtype"]) ? trim($_REQUEST["dealtype"]) :'' ;
	$ordertype = isset( $_REQUEST["ordertype"]) ? trim($_REQUEST["ordertype"]) : '' ;
	$datetype = isset( $_REQUEST["datetype"]) ? trim($_REQUEST["datetype"]) : '';
	$orderno = isset( $_REQUEST["orderno"]) ?  strip_tags(trim($_REQUEST["orderno"])): '';
	$custname = isset( $_REQUEST["custname"]) ? STR_Strip_Quots(strip_tags(trim($_REQUEST["custname"]))) : '';
	$custid =  isset( $_REQUEST["custid"]) ?  strip_tags(trim(strtoupper($_REQUEST["custid"]))) : '';
	$custtype = isset( $_REQUEST["custtype"]) ? trim($_REQUEST["custtype"]) : ''; 
	$fromtype = isset( $_REQUEST["fromtype"]) ? trim($_REQUEST["fromtype"]) : '';  
	$priceid = isset( $_REQUEST["priceid"]) ?  $_REQUEST["priceid"]+0 : 0 ;
	$roomid = isset( $_REQUEST["roomid"]) ? $_REQUEST["roomid"]+0 : 0;
	$hotelid = isset( $_REQUEST["hotelid"]) ? $_REQUEST["hotelid"]+0 : 0;
	$sysid =  isset( $_REQUEST["sysid"]) ?  $_REQUEST["sysid"]+0 : 0;
	$grouptype = isset( $_REQUEST["grouptype"]) ? trim($_REQUEST["grouptype"]): '';
	$order_remark = isset( $_REQUEST["order_remark"]) ?  STR_Strip_Quots(strip_tags(trim($_REQUEST["order_remark"]))) : '';
	$cust_tel = isset( $_REQUEST["cust_tel"]) ?  STR_Strip_Quots(STR_Get_Correct_Tel(trim($_REQUEST["cust_tel"]))):'';
	$search_by_date =  isset( $_REQUEST["search_by_date"]) ? trim($_REQUEST["search_by_date"]):'';
        $country_cust =isset( $_REQUEST["country_cust"]) ? $_REQUEST["country_cust"]:0;
	$country =isset( $_REQUEST["country"]) ? $_REQUEST["country"]:-1;
//	if(!isset($_REQUEST["country"])) $country=-1;
	$pay_method =isset( $_REQUEST["pay_method"]) ? STR_Strip_Quots(trim($_REQUEST["pay_method"])):'';
	$sales_id = isset( $_REQUEST["sales_id"]) ? $_REQUEST["sales_id"]+0: 0 ; //業務id
        $keyin_userno = isset( $_REQUEST["keyin_userno"]) ? $_REQUEST["keyin_userno"]+0:0 ; //業務id
        $remark_type = isset( $_REQUEST["remark_type"]) ? $_REQUEST["remark_type"]+0:0;//備註類別
	$has_deposit = isset( $_REQUEST["has_deposit"]) ? trim($_REQUEST["has_deposit"]): ''; //有無訂金
        $haspay_rate = isset( $_REQUEST["haspay_rate"]) ? $_REQUEST["haspay_rate"]+0: 0 ; //已付金額比例
        $has_rv =  isset( $_REQUEST["has_rv"]) ? $_REQUEST["has_rv"]+0: 0 ; //pos id
        $viplv =isset( $_REQUEST["viplv"]) ? $_REQUEST["viplv"]:-1;  //會員等級
        
        if($has_deposit!='Y') $haspay_rate = 0; //若不是檢查有無訂金則此參數無作用
        
	if($datetype=="") $datetype="O";
	
        if($sysFirstFlag==0 && isset($default_set))
        {
            $dealtype = isset( $default_set["dealtype"]) ? trim($default_set["dealtype"]) :'' ;
            $ordertype = isset( $default_set["ordertype"]) ? trim($default_set["ordertype"]) : '' ;
            $datetype = isset( $default_set["datetype"]) ? trim($default_set["datetype"]) : '';  
            $custtype = isset( $default_set["custtype"]) ? trim($default_set["custtype"]) : ''; 
            $fromtype = isset( $default_set["fromtype"]) ? trim($default_set["fromtype"]) : ''; 
            $grouptype = isset( $default_set["grouptype"]) ? trim($default_set["grouptype"]): '';
            $pay_method =isset( $default_set["pay_method"]) ? STR_Strip_Quots(trim($default_set["pay_method"])):'';
            $sales_id = isset( $default_set["sales_id"]) ? $default_set["sales_id"]+0: 0 ; //業務id
            $keyin_userno = isset( $default_set["keyin_userno"]) ? $default_set["keyin_userno"]+0:0 ; //業務id
            $remark_type = isset( $default_set["remark_type"]) ? $default_set["remark_type"]+0:0;//備註類別
            $country =isset( $default_set["country"]) ? $default_set["country"]:-1;
            $has_deposit = isset( $default_set["has_deposit"]) ? trim($default_set["has_deposit"]): ''; //有無訂金
            $haspay_rate = isset( $default_set["haspay_rate"]) ? $default_set["haspay_rate"]+0: 0 ; //已付金額比例
            $has_rv =  isset( $default_set["has_rv"]) ? $default_set["has_rv"]+0: 0 ; //pos id
            $viplv =isset( $_REQUEST["viplv"]) ? $_REQUEST["viplv"]:-1;  //會員等級
        }    
        
	$systemid = $admin_default_sysid;
	if($admin_default_sysid==0) $systemid = $accessinfo["sysid"];
	
	if($accessuserinfo["hotelid"]>0) $hotelid = $accessuserinfo["hotelid"];
	else if(($accessuserinfo["hotelid"]==0)&&($accessinfo["hotelid"]>0)) $hotelid = $accessinfo["hotelid"];
	
	$sys_width=1200;
	
	$now = Date_Get_Now();
	//print_r($now);
	
	if(($dep_year ==0) || ($dep_month ==0) || ($dep_day ==0) )
	{	
		$dep_year = $now["year"];
		$dep_month = $now["mon"]; 
		$dep_day = $now["mday"]; 
	}
	if(($dep_year2 ==0) || ($dep_month2 ==0) || ($dep_day2 ==0) )
	{	
		$dep_year2 = $now["year"];
		$dep_month2 = $now["mon"]; 
		$dep_day2 = $now["mday"]; 
	}
	
	$inputday = $dep_year."-".$dep_month."-".$dep_day;
	$inputday2 = $dep_year2."-".$dep_month2."-".$dep_day2;
	
	$other_set='';
	
	$sales_mode='N';
	$pipa_mode = -1; //個資等級
        
        $hoteldate = $now["year"]."-".$now["mon"]."-".$now["mday"];
        
        $buffer_check_ip = "";
        if($fromtype==="") 
        {    
            if($custtype=="B") $fromtype = 0;
            else $fromtype=-1;
        }
        if($custtype!='B' && $fromtype>=0) $from_id = $fromtype; 
        $flag_hasrv = false;  //標示是不是有開訂位相關的pos系統，捉出來的訂單是不是要捉取訂位資訊
        $flag_restaurant = false; //訂單功能要不要開啟餐廳訂位功能
        $flag_banquet = false; //訂單功能要不要開啟訂場地功能
        $limit_order_day = 0; //可以看幾日內退房的單
        $flag_vipon = false;  //有沒有開會員等級
	if($systemid>0) 
	{
		$systeminfo = hotel_get_one_system_info($systemid);
                $buffer_check_ip = $systeminfo["lock_ip"];
                 
                if($systeminfo["history_block"]>0 && $accessuserinfo["history"]!="Y")
                {
                     $limit_order_day = $systeminfo["history_block"];
                }    
                 
                if($systeminfo['vip_on'] == 'Y') 
                {    
                    $vipinfo =  Vip_Get_VipInfo($systemid);
                    $buffer_vipinfo = STR_Array_Switch_Key($vipinfo,"lv","name");
                    $buffer_vipinfo[0]= "一般會員";
                    if(count($vipinfo)>0) $flag_vipon = true;
                }
                else $viplv=-1; 
                 
		if($accessinfo["hotelid"]==0)
		{
			//$hotelinfo = hotel_get_all_hotelinfo($systemid);
                       
 			$hotelinfo = hotel_get_admin_hotelinfo($systemid, $accessuserinfo["hotelid"] , $accessinfo["hotelid"], $_REQUEST["hotelid"]+0 , $accessuserinfo["loc_hotel"], $hotelid );                        
                    
                        $buffer_hotelinfo = STR_Array_Switch_Key($hotelinfo, "hotelid","hotel_name");
		}	
		if($hotelid>0)
		{
			$roominfo =  hotel_get_all_room_info($systemid,$hotelid,2,'',0,0);
			$priceinfo = hotel_get_all_promotion($systemid,$hotelid,'','N');
                        $linebot =  SQL_GetRowResult("SELECT *  FROM bot_info WHERE sysid =".$systemid." and hotelid=".$hotelid." and order_platform='17' "); //檢查是不是有開linebot
			$one_hotel_info = hotel_get_one_hotelinfo($systemid,$hotelid);
                        if($one_hotel_info["lock_ip"]!="")
                        {    
                            if($buffer_check_ip!="") $buffer_check_ip.=",";
                        
                            $buffer_check_ip .= $one_hotel_info["lock_ip"];
                        }
                        if($one_hotel_info["hoteldate"]!="") $hoteldate = $one_hotel_info["hoteldate"];
                        if($systeminfo["pos_on"]=='Y') //關於訂位系統的部份檢查
                        {    
                            $restaurant_info = POS_Check_Business_Point_Storetype($systemid,$hotelid,1);
                            $banquet_info = POS_Check_Business_Point_Storetype($systemid,$hotelid,5);
                            
                            if(isset($restaurant_info) && is_array($restaurant_info) && count($restaurant_info)>0) 
                            {    
                                $flag_hasrv = true;
                                if($accessuserinfo["point_set"]=="")
                                {
                                    $flag_restaurant= true;
                                }
                                else
                                {
                                    $buffer_point_set = explode(",",$accessuserinfo["point_set"]);
                                    if(STR_Array_In_Array($buffer_point_set,$restaurant_info))
                                    {
                                        $flag_restaurant= true;
                                    }        
                                }
                                $store_info = $restaurant_info;
                            }
                            if(isset($banquet_info) && is_array($banquet_info) && count($banquet_info)>0) 
                            {    
                                $flag_hasrv = true;
                                if($accessuserinfo["point_set"]=="")
                                {
                                    $flag_banquet= true;
                                }
                                else
                                {
                                    $buffer_point_set = explode(",",$accessuserinfo["point_set"]);
                                    if(STR_Array_In_Array($buffer_point_set,$banquet_info))
                                    {
                                        $flag_banquet= true;
                                    }        
                                }
                                if(isset($restaurant_info) && is_array($restaurant_info) && count($restaurant_info)>0)
                                {
                                    $store_info = array_merge($store_info,$banquet_info);
                                }
                                else
                                {
                                     $store_info = $banquet_info;
                                }
                            }
                            $buffer_store_info = STR_Array_Switch_Key($store_info, "bid","logogram");
                        }        
		}
                $flag_restaurant = false;// 未完成先不開
		$sales_mode = $systeminfo["sales_on"];
		$waiting_on = $systeminfo["waiting"];
                $shuttle_on = true;
                if($systeminfo["sys_mode"]==1 || $systeminfo["sys_mode"]==2) $shuttle_on = false;
		if($sales_mode=='Y')
		{
			$sql = " select No,Username,if(hotelid=0,concat('(總)',nickname),nickname) as nickname from admin_info where sysid= '$systemid' and (hotelid=0 or hotelid='$hotelid') and IfDelete<>'Y' and account_mode < 2 and account_type=1 ";
			$sql.=" order by hotelid desc,No ";
			$sales_info = SQL_GetResultFields($sql);
		}
                if($systeminfo["pipa_on"]=='Y')
                {
                    $pipa_mode=0;
                    $pipa_mode = $accessuserinfo["pipa_lv"];
                }
	}
        else 
        {
            $pipa_mode = 2;
        }
	
        if(!$flag_hasrv) $has_rv = 0;
        
        //$pipa_mode = 2;
        
        if($admin_default_sysid==0) $pipa_mode = 2;
        
        if($order_remark!="" ||  $custname!="" ||  $custid!="" || $cust_tel!="" || $orderno!="")
        {   
            if($orderno=="" && $search_by_date!='Y')
            {
                $pipa_mode=2;
            } 
            else if(Date_CompareTwoDays($inputday,$inputday2)!=0 && $search_by_date=="Y" )
            {
                $pipa_mode = 2;
            }
        }    
        else if(Date_CompareTwoDays($inputday,$inputday2)!=0)
        {
            $pipa_mode = 2;
        }    
        
	if($systeminfo["schedule_nr_order"]=='Y' && $ordertype=='TA') $other_set='Y';
	
        //echo $pipa_mode;
        $platform_info =hotel_get_use_platform($systemid,$hotelid);
        $buffer_platform_info = STR_Array_Switch_Key($platform_info,"bid");
        
        $platform_set = hotel_get_use_platform($systemid,$hotelid,1);
        
	$orderinfo = report_get_order_report_opt($systemid,$hotelid,$from_id,$priceid,$inputday,$inputday2,$ordertype,$datetype,$dealtype,$orderno,$custid,$custname,$custtype,$fromtype,$roomid,$grouptype,$cust_tel,$order_remark,$search_by_date,$country,$pay_method,$sales_id,$other_set,$keyin_userno,$remark_type, $accessuserinfo["loc_hotel"] ,$country_cust,$has_deposit,$haspay_rate,$has_rv,$limit_order_day,$viplv);
	if(is_array($orderinfo) && count($orderinfo)>0)
        {
            if($systemid>0)
            {    
                $orderno_str = implode(",",array_unique(STR_ArrayTwoToOne($orderinfo,"orderno")));
                if($orderno_str!="")
                {
                    $sql=" select rm_orderno,sum(totalprice) as totalprice from product_order_info force index (sidsidrmorderno) where sysid='$systemid' and rm_orderno in ($orderno_str) and cancelled<>'Y' group by rm_orderno  ";
                    $other_order_info = SQL_GetResultFields($sql);
                    $other_order_info = STR_Array_Switch_Key($other_order_info,"rm_orderno","totalprice");
                    if($flag_hasrv)
                    {
                        $sql=" select rm_orderno,group_concat(DISTINCT storeid order by storeid) as storeid from business_reserve force index (sidsidrmorderno) where sysid='$systemid' and rm_orderno in ($orderno_str) and ordertype<>'C' group by rm_orderno";
                        $rv_order_info = SQL_GetResultFields($sql);
                        $rv_order_info = STR_Array_Switch_Key($rv_order_info,"rm_orderno","storeid");
                    }    
                }
            }
            if($linebot["bid"]>0)
            {
                $cust_str = implode(",",array_unique(STR_ArrayTwoToOne($orderinfo,"custid")));
                $line_cust = SQL_GetResultFields(" select custid,title from cust_info_auth where sysid='$systemid' and platform_id=2 and custid in ($cust_str) ");
                $line_cust = STR_Array_Switch_Key($line_cust, "custid");
            }    
        }    
        
	$sys_dealtype = hotel_get_all_sys_default("dealtype");
	$sys_fintype = hotel_get_all_sys_default("fintype");
	
        $ip_check_flag=0;
	if($buffer_check_ip!="")
        {
            $buffer_check_ip_array = explode(",",$buffer_check_ip);
            if(in_array($_SERVER["REMOTE_ADDR"],$buffer_check_ip_array))
            {
                $ip_check_flag=1;
            }        
        }    
        
	//若非系統商，檢查刷卡傳真單的設定, 2010/10/14拉掉
//	$card_img = array();
	if($systemid>0)
	{
		$pic_default_url = $Sys_TheLocalUrl.$systeminfo["folder"]."/upload/mail/";
		$pic_default_http = $Sys_TheLocalHttp.$systeminfo["folder"]."/upload/mail/"; 
		
		if($hotelid==0)
		{
                    
			for($i=0;$i<count($hotelinfo);$i++)
			{
//				if($hotelinfo[$i]["card_img"]!="")
//				{
//					$buffer_img_file = $pic_default_url.$hotelinfo[$i]["card_img"];
//					if(file_exists($buffer_img_file))
//					{
//						$card_img[$hotelinfo[$i]["hotelid"]] = $pic_default_http.$hotelinfo[$i]["card_img"];
//					}
//					else 
//					{
//						$card_img[$hotelinfo[$i]["hotelid"]]="";
//					}
//				}
//				else 
//				{
//					$card_img[$hotelinfo[$i]["hotelid"]]="";
//				}
                                $order_folder[$hotelinfo[$i]["hotelid"]] = $hotelinfo[$i]["folder"];
			}
                            $order_folder[1] = $systeminfo["folder"];
		}
		else 
		{
//			if($one_hotel_info["card_img"]!="")
//			{
//				$buffer_img_file = $pic_default_url.$one_hotel_info["card_img"];
//				if(file_exists($buffer_img_file))
//				{
//					$card_img[$hotelid] = $pic_default_http.$one_hotel_info["card_img"];
//				}
//				else 
//				{
//					$card_img[$hotelid]="";
//				}
//			}
//			else 
//			{
//				$card_img[$hotelinfo[$i]["hotelid"]]="";
//			}
                        if($hotelid==1)  $order_folder[1] = $systeminfo["folder"];
                        else $order_folder[$hotelid] = $one_hotel_info["folder"];
                       
		}
	}	
	
	
	if($accessuserinfo["superuser"]=='Y' || $admin_authority[4]=='1')
	{
		$history_show = true;
	}
	else $history_show = false;
	
	//若為超級使用者 
	if($history_show)
	{
		$sys_width = 1260;
		include_once("../inc/inc_all_user_info.php");
	}
	
	
	$order_check_flag=""; //開不開放訂房確認單
	if($systeminfo["order_check_form"]!='') $order_check_flag = $systeminfo["order_check_form"];
	
//	$sql = " select bid,name from b2b_info  where open='Y' and del<>'Y' ";
//	if($systemid>0) $sql.=" and (sysid=0 or sysid='$systemid') and (lock_bank='0' or lock_bank='".$systeminfo["atm_bank"]."') ";
//        $b2binfo = SQL_GetResultFields($sql);
        
        $b2binfo = b2b_get_company_name( $systemid , $hotelid , $systeminfo["atm_bank"] );	
	$b2bcount = count($b2binfo);
        $buffer_b2binfo = STR_Array_Switch_Key($b2binfo,"bid","name");
        
	$country_list = hotel_get_all_sys_default("country");
	$country_data = STR_Array_Switch_Key($country_list,"type","name");
	
        $all_user_info = hotel_get_all_hotel_user($systemid,$hotelid,'Y');
        
	//統計資料
	$sum_traffic = array();
	$sum_price = array();
	$sum_room = array();
	$sum_people = array();
	$sum_ordertype = array();
	$sum_cust_type = array();
	$sum_group = array();
        
        //$company_type = hotel_get_all_sys_default("companytype"); 
        $company_type = b2b_get_company_type();
        
        if(count($orderinfo)>0)
        {    
            $buffer_room_str = implode(",",array_unique(STR_ArrayTwoToOne($orderinfo,"roomid")));
            
            $buffer_roominfo = SQL_GetResultFields("select concat(hotelid,'-',roomid) as roomid ,room_symbol,room_name from room_info where sysid='$systemid' ".($hotelid>0?" and hotelid='$hotelid'":""));
            $buffer_roominfo = STR_Array_Switch_Key($buffer_roominfo, "roomid");
        }
        if(count($orderinfo)>0)
        {    
            $buffer_price_str = implode(",",array_unique(STR_ArrayTwoToOne($orderinfo,"priceid")));
            $buffer_priceinfo = SQL_GetResultFields("select priceid,name from price_info where sysid='$systemid' and priceid in ($buffer_price_str) ");
            $buffer_priceinfo = STR_Array_Switch_Key($buffer_priceinfo, "priceid","name");
        }    
        
        //$other_order_open_sysid = array(2,4,18,25,55,21,22,45,64,65,30,37,78,79,81,82,69,83,86,87,88,89,90,93,94,95,96,100,101,104,106,107,108,116,118);
        if($systeminfo["mms_on"]=='Y')
        {
            $mms_sample = SQL_GetResultFields("select * from ecard_info where sendtype='S' and del<>'Y' and sysid='$systemid' and (hotelid=0 or hotelid='$hotelid' ) order by hotelid desc,seqno");
        }
        $fp10_auth = ($accessuserinfo["No"]==1?"1":Admin_Check_User_Function_Level($accessuserinfo["No"],"FP10"));
        $fp01_auth = ($accessuserinfo["No"]==1?"1":Admin_Check_User_Function_Level($accessuserinfo["No"],"FP01"));
        $qr_link_setting = array(1,4,21,22,30,129,166,167,169,175,179,183);   //開放複製付款連結的系統id
        
?>
<script>
	var need_reflush="";
        var refresh_flag="";
        var rv01_pad_mode="<? echo $_COOKIE["BBNET_PAD_MODE"];?>";
        var fromtype_flag="";
        var buffer_b2b_name="";
        <? if($systemid>0 && $hotelid>0) {?>
        var promotion_info = new Array();
        <? for($i=0;$i<count($priceinfo);$i++) {?>
            promotion_info[<? echo $i;?>] = new Array();
            promotion_info[<? echo $i;?>][0] = <? echo $priceinfo[$i]["priceid"];?>;
            promotion_info[<? echo $i;?>][1] = "<? echo $priceinfo[$i]["priceid"];?> ) <? echo ($priceinfo[$i]["b2b"]>0)?"[企]":"";?> <? echo ($priceinfo[$i]["open"]=='Y')?"[網]":"";?> <? echo $priceinfo[$i]["name"];?>";
        <? } ?>
        <? } ?>  
        var b2b_info = new Array();
         <? for($i=0;$i<count($b2binfo);$i++) {?>
            b2b_info[<? echo $i;?>] = new Array();
            b2b_info[<? echo $i;?>][0] = <? echo $b2binfo[$i]["bid"];?>;
            b2b_info[<? echo $i;?>][1] = "<? echo $b2binfo[$i]["name"];?>";
        <? } ?>
	function gotodetail(orderno,sysid)
	{
		var theform = document.sysform;
                sysMain_show_dark_background();
                var show_content ="<iframe name=order_frame id=order_frame width=650 height="+($(window).outerHeight()-35)+" frameborder=0 border=0 cellspacing=0  src=''></iframe>";
		sysMain_ShowMsg(show_content,"","order_frame","","",Number($(window).scrollTop())+1,"","","1","sysMain_hide_dark_background");
		theform.target = "order_frame";
		theform.orderno.value=orderno;
		theform.sysid.value=sysid;
		theform.action = "rv01_orderinfo_detail.php";
		theform.submit();
	}
        function order_detail_show(orderno)
        {
              var theform = document.sysform;
                theform.orderno.value=orderno;
                
		theform.ordertype.value=1;
		sysMain_show_dark_background();
		var show_content ="<iframe name=order_frame id=order_frame width=780 height=600 frameborder=0 border=0 cellspacing=0   src=''></iframe>";
		sysMain_ShowMsg(show_content,"","order_frame","","","","","","1","sysMain_hide_dark_background");
		theform.action='../inc/inc_orderinfo_detail.php';
		theform.method="POST";
		theform.target="order_frame";
		theform.submit();   
        }
	function rv01_send_card_email(orderno,sysid)
	{
		var theform = document.sysform;
                sysMain_show_dark_background();
		var show_content ="<iframe name=rm_frame id=rm_frame width=780 height=400 frameborder=0 border=0 cellspacing=0   src=''></iframe>";
		sysMain_ShowMsg(show_content,"","rm_frame","","","","","","2","sysMain_hide_dark_background");
		theform.method="POST";
		theform.target="rm_frame";
		theform.orderno.value=orderno;
		theform.sysid.value=sysid;
		theform.action = "rv01_order_send_card.php";
		theform.submit();
	}
	function gotomodify(orderno,sysid)
	{
		var theform = document.sysform;
		//modify_order = window.open("","modify_order","height=600,width=1100,toolbar=yes,menubar=no,location=no,directory=no,status=no,scrollbars=yes,resizeable=yes,left=170,top=0");
		//theform.target = "modify_order";
                 sysMain_show_dark_background();
                var modwidth = Number($(window).outerWidth());
                var modheight = Number($(window).outerHeight());
            
                if(modwidth>1050) modwidth=1050;
                modheight -= 20;
		var show_content ="<iframe name=modify_frame id=modify_frame width="+modwidth+" height="+modheight+" frameborder=0 border=0 cellspacing=0   src=''></iframe>";
                if(document.documentMode && document.documentMode<=9)
                {
                    sysMain_ShowMsg(show_content,"","modify_frame","","","",modwidth,modheight,"4","rv01_close_pop");
                }
		else  sysMain_ShowMsg_Fixed(show_content,"","modify_frame","","","1",modwidth,modheight,"4","rv01_close_pop");
                theform.orderno.value=orderno;
                theform.method="POST";
		theform.sysid.value=sysid;
                theform.target="modify_frame";
		<? if($systemid==4) { ?>
		theform.action = "../fp01/fp01_modify_order.php";
		<? } else { ?>
		theform.action = "../fp01/fp01_modify_order.php";
		<? } ?>
		theform.submit();
	}
	function goto_order_check(orderno,sysid)
	{
		var theform = document.sysform;
		order_check = window.open("","order_check","height=600,width=1100,toolbar=yes,menubar=no,location=no,directory=no,status=no,scrollbars=yes,resizeable=yes,left=170,top=0");
		theform.target = "order_check";
		theform.orderno.value=orderno;
		theform.sysid.value=sysid;
		theform.action = "rv01_order_confirm.php";
		theform.submit();
		order_check.focus();
	}
	<?php 
	if($history_show)
	{ 
		?>
	function goto_order_history(orderno,sysid)
	{
		var theform = document.sysform;
		order_history = window.open("","order_history","height=600,width=1100,toolbar=yes,menubar=no,location=no,directory=no,status=no,scrollbars=yes,resizeable=yes,left=170,top=0");
		theform.target = "order_history";
		theform.orderno.value=orderno;
		theform.sysid.value=sysid;
		theform.action = "rv01_order_history.php";
		theform.submit();
		order_history.focus();
	}
	<?php } ?>
	
	function rv01_set_pad_mode()
	{
		if(rv01_pad_mode!='Y')
		{
			setCookie("BBNET_PAD_MODE","Y",30);
                        rv01_pad_mode='Y';
		}
		else
		{
			setCookie("BBNET_PAD_MODE","");
                        rv01_pad_mode='';
		}
	}    
	function gotocancel(nowid,sysid)
	{
		var theform = document.orderform;
		if(confirm("您確定要取消此筆訂單，若此訂單已入住，已入房帳會自動取消，取消後入住資料將被清除"))
		{
			theform.target = "SysFunFrame";
			eval("theform.orderno.value=theform.cur_orderno_"+nowid+".value;");
			theform.sysid.value=sysid;
                       
                        theform.action = "rv01_orderinfo_cancel.php";
                        
			theform.submit();
		}	
	}
	
	function gotohandle(nowid,sysid)
	{
		var theform = document.orderform;
		
			theform.target = "SysFunFrame";
			theform.method="POST";
			eval("theform.orderno.value=theform.cur_orderno_"+nowid+".value;");
			eval("theform.handle_remark.value=theform.cur_handle_remark_"+nowid+".value;");
			eval("theform.handle_status.value=theform.cur_handle_status_"+nowid+".value;");
			theform.sysid.value=sysid;
			theform.action = "rv01_orderinfo_handle.php";
			theform.submit();	
	}
	
	function sendtodeal(mday)
	{
		var theform = document.inputform;
		var flag=0;
		var changeflag = "changeflag["+mday+"]";
		for(i=0;(i<theform.elements.length && flag==0);i++)
		{
			if(theform.elements[i].name==changeflag)
			{
				theform.elements[i].value = 'Y';
			}
		}
	}

	function checkform()
	{
		var theform = document.inputform;
		var i=0;
		var flag = 0;
		for(i=0;(i<theform.elements.length && flag==0);i++)
		{
			if(theform.elements[i].name.substring(0,10)=="changeflag")
			{
				if(theform.elements[i].value == "Y") flag = 1;
			}
		}
		if(flag==0)
		{ 
			alert("請先作修改後再送出資料");
			return false;
		}
		else return true;
	}
	
	function changeordertype(ordertype)
	{
		var theform = document.searchform;
		
		theform.ordertype.value=ordertype;
		if(ordertype.substring(0,1)=="T")
		{
			theform.dep_year.value=<? echo $now["year"];?>;
			theform.dep_month.value=<? echo $now["mon"];?>;
			theform.dep_day.value=<? echo $now["mday"];?>;
			theform.dep_year2.value=<? echo $now["year"];?>;
			theform.dep_month2.value=<? echo $now["mon"];?>;
			theform.dep_day2.value=<? echo $now["mday"];?>;
		}
		if(ordertype=="TP") theform.datetype.value='P';
		else if(ordertype=="TN") theform.datetype.value='L';
		else if(ordertype=="TL") theform.datetype.value='L';
		else if(ordertype=="TC") theform.datetype.value='C';
		else if(ordertype=="TA") theform.datetype.value='A';
		theform.submit();
	}
	function change_fromtype()
	{
		var theform = document.searchform;
                
                
		if(theform.custtype.value=="B")
		{
                    if(fromtype_flag!="B")
                    {    
                        buffer_b2b_name="";
                        theform.b2b_filter.value='';
                        rv01_b2b_info_set(0);
                        $("#b2b_filter").show();
                        fromtype_flag ="B";
                    }    
                    
		}
		else
		{
                    if(fromtype_flag!='C')
                    {    
			theform.fromtype.length=<?php echo count($platform_set)+4;?>;
                        theform.fromtype.options[0].value="-1";
			theform.fromtype.options[0].text ="全部";
                        theform.fromtype.options[0].style.backgroundColor="<?php echo $Sys_Date_Color[0];?>";
			theform.fromtype.options[1].value="-2";
			theform.fromtype.options[1].text ="實體";
                        theform.fromtype.options[1].style.backgroundColor="<?php echo $Sys_Date_Color[1];?>";
                        theform.fromtype.options[2].value="-3";
			theform.fromtype.options[2].text ="網路";
                        theform.fromtype.options[2].style.backgroundColor="<?php echo $Sys_Date_Color[2];?>";
                        theform.fromtype.options[3].value="-4";
			theform.fromtype.options[3].text ="官網訂房系統";
                        theform.fromtype.options[3].style.backgroundColor="<?php echo $Sys_Date_Color[3];?>";
                        <?php for($i=0;$i<count($platform_set);$i++) { ?>
                        theform.fromtype.options[<?php echo $i+4;?>].value="<?php echo $platform_set[$i]["bid"];?>";
			theform.fromtype.options[<?php echo $i+4;?>].text ="<?php echo $platform_set[$i]["name"];?>";  
                        theform.fromtype.options[<?php echo $i+4;?>].style.backgroundColor="<?php echo $platform_set[$i]["sysid"]==0?"#ffffff":$Sys_Date_Color[4];?>";
                        <?php } ?>    
                         $("#b2b_filter").hide();
                         theform.b2b_filter.value='';
                         theform.fromtype.selectedIndex = 0;
                         fromtype_flag ='C';
                     }    
		}
		
	}
	function rv01_show_shuttle_info(orderno)
	{
		var show_content;
                sysMain_show_dark_background();
		show_content ="<iframe id=shuttle_frame width=820 height=300 frameborder=0 border=0 cellspacing=0   src='rv01_shuttle_info.php?orderno="+orderno+"'></iframe>";
		sysMain_ShowMsg(show_content,"","shuttle_frame","","","","","","2","sysMain_hide_dark_background");
	}
	function rv01_cust_detail(custid,orderno)
	{       
                var theform = document.sysform;
		var show_content ="<iframe name=mem_frame id=mem_frame width=900 height=600 frameborder=0 border=0 cellspacing=0  src=''></iframe>";
		sysMain_ShowMsg(show_content,"","mem_frame","","","","","","2","mem01_close_mem_detail");
		theform.method="POST";
		theform.target="mem_frame";
		theform.custid.value=custid;
                theform.orderno.value=orderno;
		theform.action = "../mem01/mem01_custinfo_detail_new.php";
                sysMain_show_dark_background();
		theform.submit();
	}
        function rv01_close_pop()
	{
            sysMain_hide_dark_background();
            if(refresh_flag =='Y')
            {
                window.location.reload();
            }	
	}
        function mem01_close_mem_detail()
	{
           rv01_close_pop();
	}
	function rv01_deposit_manage(orderno,sysid)
	{
		var theform = document.sysform;
                 sysMain_show_dark_background();
		var show_content ="<iframe name=dp_frame id=dp_frame width=600 height=400 frameborder=0 border=0 cellspacing=0  src=''></iframe>";
		sysMain_ShowMsg(show_content,"","dp_frame","","","","","","3","rv01_close_deposit");
		theform.method="POST";
		theform.target="dp_frame";
		theform.orderno.value=orderno;
		theform.sysid.value=sysid;
                <? if($systemid==4) {?>
		theform.action = "rv01_deposit.php";
                <? } else { ?>
                theform.action = "rv01_deposit.php";    
                <? } ?>
		theform.submit();
	}
        function rv01_close_deposit()
        {
            rv01_close_pop();
        }
	function rv01_send_mms(orderno,sysid)
	{
		var theform = document.sysform;
                sysMain_show_dark_background();
		var show_content ="<iframe name=mms_frame id=mms_frame width=620 height=400 frameborder=0 border=0 cellspacing=0   src=''></iframe>";
		sysMain_ShowMsg(show_content,"","mms_frame","","","","","","3","sysMain_hide_dark_background");
		theform.method="GET";
		theform.target="mms_frame";
		theform.orderno.value=orderno;
		theform.sysid.value=sysid;
		theform.action = "rv01_mms_send.php";
		theform.submit();
	}
        function rv01_send_line(orderno,sysid)
	{
		var theform = document.sysform;
                //sysMain_show_dark_background();
		var show_content ="<iframe name=mms_frame id=mms_frame width=620 height=400 frameborder=0 border=0 cellspacing=0   src=''></iframe>";
		sysMain_ShowMsg(show_content,"","mms_frame","","","","","","3","sysMain_hide_dark_background");
		theform.method="GET";
		theform.target="mms_frame";
		theform.orderno.value=orderno;
		theform.sysid.value=sysid;
		theform.action = "rv01_line_send.php";
		theform.submit();
	}
	function goto_other_order(orderno)
	{
		var show_content;
		sysMain_show_dark_background();
		<?php if($systemid==4) {?>
		show_content ="<iframe id=walk_frame width=700 height=200 frameborder=0 border=0 cellspacing=0 style='z-index:100'  src='../fp01/fp01_other_order.php?orderno="+orderno+"'></iframe>";
		<?php } else {?>
		show_content ="<iframe id=walk_frame width=700 height=200 frameborder=0 border=0 cellspacing=0 style='z-index:100'  src='../fp01/fp01_other_order.php?orderno="+orderno+"'></iframe>";
		<?php } ?>
		sysMain_ShowMsg(show_content,"","walk_frame","","","","","","1","sysMain_hide_dark_background");
	}
        function rv01_price_info_set(priceid)
        {
            var theform = document.searchform;
            var buffer_name = theform.price_filter.value;
            var i=0;
            var price_count=0;
            var selectIndex=0;
            
            theform.priceid.length=0;
            
            if(buffer_name=="")
            {
                theform.priceid.length=1;
                theform.priceid.options[0].value = "";
                theform.priceid.options[0].text = "全部";
                price_count++;
            }    
            
            for(i=0;i<promotion_info.length;i++)
            {
                if(buffer_name=="" || (buffer_name!="" && promotion_info[i][1].indexOf(buffer_name)>=0))
                {
                    theform.priceid.length = price_count+1;
                    theform.priceid.options[price_count].value = promotion_info[i][0];
                    theform.priceid.options[price_count].text = promotion_info[i][1];
                    if(priceid == promotion_info[i][0])
                    {
                        selectIndex = price_count;
                    }
                    price_count++;
                }
                 theform.priceid.selectedIndex = selectIndex;
            }
        }
        function rv01_b2b_info_set(b2bid)
        {
            var theform = document.searchform;
            var buffer_name = theform.b2b_filter.value;
            var i=0;
            var b2b_count=0;
            var selectIndex=0;
            
            theform.fromtype.length=0;
            
            if(buffer_name=="")
            {
                theform.fromtype.length=<?php echo count($company_type)+1;?>;
                theform.fromtype.options[0].value = "0";
                theform.fromtype.options[0].text = "全部";
                theform.fromtype.options[0].style.backgroundColor="#fad9d6";
                b2b_count++;
                <?php for($i=0;$i<count($company_type);$i++){?>
                theform.fromtype.options[b2b_count].value = <?php echo "-".$company_type[$i]["type"];?>;
                theform.fromtype.options[b2b_count].text = "<?php echo $company_type[$i]["name"];?>";
                theform.fromtype.options[b2b_count].style.backgroundColor="#fafbd6";
                 if(b2bid == <?php echo "-".$company_type[$i]["type"];?>)
                    {
                        selectIndex = b2b_count;
                    }
                b2b_count++;
                <?php } ?>
            }    
            
            for(i=0;i<b2b_info.length;i++)
            {
                if(buffer_name=="" || (buffer_name!="" && b2b_info[i][1].indexOf(buffer_name)>=0))
                {
                    theform.fromtype.length = b2b_count+1;
                    theform.fromtype.options[b2b_count].value = b2b_info[i][0];
                    theform.fromtype.options[b2b_count].text = b2b_info[i][1];
                    if(b2bid == b2b_info[i][0])
                    {
                        selectIndex = b2b_count;
                    }
                    b2b_count++;
                }
                 theform.fromtype.selectedIndex = selectIndex;
            }
        }
        function is_touch_device() {
            return (('ontouchstart' in window)
                 || (navigator.MaxTouchPoints > 0)
                 || (navigator.msMaxTouchPoints > 0));
        }
        function rv01_show_filter_div()
        {
           $("#filter_div:hidden").show().find("span#filter_msg").html("請選擇篩選條件");  
           $("#filter_div").css("margin-left",(Math.round((Number($("#filter_div").width())-Number($("#filter_button").width()))/2)*(-1)).toString()+"px").css("margin-top",(Number($("#filter_button").height()+Number($("#filter_div").height())+2)*(-1)).toString()+"px");
        }
        function rv01_hide_filter_div()
        {
            $("tr.menutr td.filter_unsel").removeClass("filter_unsel");
            $("#filter_div").hide();
        }
        function rv01_clean_filter()
        {
            $("tr.menutr td.filter_unsel").removeClass("filter_unsel");
        }
        function rv01_filter_order(filtertype,set1,set2)
        {
            rv01_clean_filter();
            sysMain_show_cover_mask("filter_div");
            if($("tr.menutr").length==0)
            {
                rv01_show_order_filter_msg("無可篩選的訂單");
            }
            else
            {    
                if(filtertype=='traffic')
                {
                   if(set2=='')
                   {
                       $("tr.menutr td").addClass("filter_unsel");
                       $("tr.menutr["+filtertype+"='"+set1+"'] td").removeClass("filter_unsel");
                        rv01_show_order_filter_msg("篩選完成，共 "+$("tr.menutr td.menutd:not(.filter_unsel)").length+" 筆");
                   }
                   else
                   {
                       if(set1==3)
                       {    
                            rv01_get_order_filter(filtertype,set1,set2);
                       }
                   }    
                }
                else if(filtertype=='mms')
                {
                    if(set1==2)
                    {
                        set2 = $("#mms_select").val();
                    }
                    else
                    {
                        set2= '';
                    }
                    rv01_get_order_filter(filtertype,set1,set2);
                }
                else
                {
                     $("tr.menutr["+filtertype+"='N'] td").addClass("filter_unsel");
                      rv01_show_order_filter_msg("篩選完成，共 "+$("tr.menutr td.menutd:not(.filter_unsel)").length+" 筆");
                }
               
            }
        }
        function rv01_get_order_filter(filtertype,set1,set2)
        {
            var orderno = new Array();
            var buffer_no = 0;
            var i=0;
            var orderno_str="";
            
            if(filtertype=='traffic')
            {    
              
               $("tr.menutr["+filtertype+"='"+set1+"']").each(function(){
               
                   buffer_no = $(this).attr("orderno");
                   
                  if(!bbnet_in_array(buffer_no,orderno))
                  {    
                    
                    orderno[i] = buffer_no;
                    i++;
                  }  
               });
            }
            else if(filtertype=='mms') 
            {
                $("tr.menutr").each(function(){
                   buffer_no = $(this).attr("orderno");
                   
                  if(!bbnet_in_array(buffer_no,orderno))
                  {    
                    orderno[i] = buffer_no;
                    i++;
                  }  
               });
            }
            if(orderno.length>0)
            {    
                orderno_str = orderno.join();
                $.ajax({
                    url: 'rv01_get_order_filter.php',
                    type: 'GET',
                    data: {
                    orderno: orderno_str,
                    filtertype: filtertype,
                    set1: set1,
                    set2: set2
                    },
                    dataType: "json",
                    cache: false,
                    error: function(xhr) {
                        rv01_show_order_filter_msg('發生錯誤');
                    },
                    success: function(response) {
                        rv01_show_order_filter(response);
                    }
                });
            }
            else
            {
                 $("tr.menutr td").addClass("filter_unsel");
                rv01_show_order_filter_msg("篩選完成，共 0 筆");
            }
        }
        function rv01_show_order_filter(jsonstr)
        {
            var i=0;
            if(jsonstr.status==0)
            {
                $("tr.menutr td").addClass("filter_unsel");
                for(i=0;i<jsonstr.data.length;i++)
                {
                    $("tr.menutr[orderno='"+jsonstr.data[i]+"'] td").removeClass("filter_unsel");
                }
                rv01_show_order_filter_msg("篩選完成，共 "+$("tr.menutr td.menutd:not(.filter_unsel)").length+" 筆");
            }
            else alert(jsonstr.data);
        }
        function rv01_show_order_filter_msg(msg)
        {
            sysMain_close_cover_mask();
            alert(msg);
        }
        function rv01_order_save()
        {
            var theform = document.searchform;
            theform.action="rv01_save_file.php";
            theform.target="SysFunFrame";
            theform.submit();
            theform.action='';
            theform.target="_self";
        }
        function goto_order_setroom(orderno)
        {
            var submit_str;
            var buffer_url="fp10/fp10_index.php";
	 		
            titlename="訂單排房";

            submit_option = "lock_orderno="+orderno;
			
            submit_str = buffer_url;
            sysMain_frameSet(submit_str,submit_option,titlename);
        }
        function rv01_copy_order(orderno,hotelid)
        {
            var submit_str;
            var buffer_url="fp01/fp01_index.php";
	 		
            titlename="房間預訂";

            submit_option = "orderno="+orderno+"&hotelid="+hotelid;
			
            submit_str = buffer_url;
            sysMain_frameSet(submit_str,submit_option,titlename);
        }
        function shownotice(type)
	{
		if(type==0)
		{
			$("#notice1").hide();
		}
		else
		{
			$("#notice1").show();
		}
	}
        function rv01_goto_reseve(orderno,type)
        {
            var submit_str;
            var buffer_url;
            var submit_option;
            var titlename;
            if(type==0)
            {    
               buffer_url="pos13/pos13_index.php";
               titlename="餐廳訂位處理";
            }
            else
            {
               buffer_url="pos21/pos21_index.php";
               titlename="場地預訂管理";
            }
            submit_option = "pms_rmorderno="+orderno;
            submit_str = buffer_url;
            sysMain_frameSet(submit_str,submit_option,titlename);
        }
        function sysfun_save_set(settype)
        {
            var theform = document.searchform;
            theform.method="get";
            theform.setclear.value=settype;
            theform.target="SysFunFrame";
            theform.action = "../inc/fun_set_save.php";
            theform.submit();
            theform.action="";
            theform.target="_self";
        }
        function get_order_link(url)
        {
            var targetId = "_hiddenCopyText_";
            if(url!="")
            {
                
                var target = document.createElement("textarea");
                target.style.position = "absolute";
                target.style.left = "-9999px";
                target.style.top = "0";
                target.id = targetId;
                document.body.appendChild(target);
                target.textContent = url;
                target.focus();
                target.setSelectionRange(0, target.value.length);
                document.execCommand("copy");
                target.remove();
                alert("連結已複製");
            }
            else
            {
                alert("無可複製的連結");
            }
        }
</script>
<script src='/js/jquery-3.6.1.min.js'></script>
<script src='/js/bbnet.js'></script>
<script src='/js/sys_control.js'></script>
<script src='/js/jquery.powertip.js'></script>
<script src="../css/bootstrap-5.0.2-dist/js"></script>
<link rel="stylesheet" type="text/css" href="../inc/jquery.powertip.css" />
<link rel='stylesheet' type='text/css' href='../css/bootstrap-5.0.2-dist/css/bootstrap.css'>
<style>
	div.remarkdiv {background-color:#eeeeee;border:1px solid #000000;height:200px;width:300px;position:absolute;margin-left:-100px}
        .filter_unsel{filter:alpha(opacity=10);/*for ie*/
        opacity:0.1;
       -moz-opacity:0.1;
       -khtml-opacity:0.1;}
</style>
<div class=divstyle0>
	<form name=searchform method=get> <input type=hidden name=ordertype value="<? echo $ordertype;?>">
        <input type="hidden" name="sysFirstFlag" value="1">
        <input type="hidden" name="setclear" value="0">  
        <input type="hidden" name="func_id" value="<?php echo $admin_func_id;?>">
	<? if($systemid>0&&($accessinfo["hotelid"]==0)&&count($hotelinfo)>1) { ?>
	<div style='width:750px;margin-left:2px' class=divstyle3>
	<span style='width:108px' class=spstyle4>分館</span>
	<select name=hotelid onchange="javascript:document.searchform.submit();">
	<? Str_Echo_Option_From_Array($hotelinfo,$hotelid,0,"全部","hotelid","hotel_name");?>
	</select>
	</div>
	<? } ?>
	<table width=1300 cellspacing=0 cellpadding=0 border=0>
	<tr>
	<td width=990>
	<table width=980 class=tbstyle2>
		
		<tr>
			<? 
				$rowspan =4;
				if(($systemid>0)&&($hotelid>0))
				{
					$rowspan++;
				}
			?>
			<td rowspan=<? echo $rowspan; ?> width=5% class=tdstyle1>查<br>尋<br>條<br>件</td>
		
		<td width=7% class=tdstyle2>
			開始日
		</td>
		<td colspan=6>
		 <? 
			    	$calendar_default_form = "searchform";
			    	$calendar_start_type = 2;
			    	include_once($Sys_TheLocalUrl."class/calendar_list.php"); 
   				?>
			<IFRAME id=ca_fr_0 style="DISPLAY: none; WIDTH: 212px; POSITION: absolute; HEIGHT: 160px;z-index:5" marginWidth=0 marginHeight=0  frameBorder=0 scrolling=no ></IFRAME><SPAN id=ca_div_0 style="DISPLAY: none; POSITION: absolute;z-index:6"></SPAN>
			<select name="dep_year">
			<? Str_Echo_Num_Option($GLOBALS["sys_seting"]["Sys_Start_Year"],$now["year"]+4,$dep_year);?>
			</select>年
			<select name="dep_month">
			<? Str_Echo_Num_Option(1,12,$dep_month);?>
			</select>月
			<select name="dep_day">
			<? Str_Echo_Num_Option(1,31,$dep_day);?>
			</select>日
			<IMG style="CURSOR: hand" onclick=javascript:showcalendar(1,0,0); src="/class/images/calendar2.gif" align=absMiddle>
			<?	
				$datelist_sel_type = 1 ;
				$datelist_type = 1;
				include($Sys_TheLocalUrl."class/date_list.php"); 
			?>
		</td>
                 <td align="center" >
                <label style="color:#ff0000;font-weight:bold;vertical-align:middle"><input type="checkbox" name="has_deposit" id="has_deposit" value='Y' <?php echo $has_deposit=='Y'?"checked":"";?>>有訂金</label>
                <select name="haspay_rate" id="haspay_rate" style="width:90px<?php echo ($has_deposit=='Y'?"":";display:none"); ?>" >
                    <option value="0" <?php echo $haspay_rate==0?"selected":"";?>>全部</option>
                    <option value="1" <?php echo $haspay_rate==1?"selected":"";?> style="background-color:#fafbd6">訂金足額</option>
                    <option value="2" <?php echo $haspay_rate==2?"selected":"";?> style="background-color:#fafbd6">訂金不足額</option>
                    <option value="3" <?php echo $haspay_rate==3?"selected":"";?> style="background-color:#fafbd6">訂金超付</option>
                    <option value="4" <?php echo $haspay_rate==4?"selected":"";?> style="background-color:#fad9d6">全付清</option>
                    <option value="5" <?php echo $haspay_rate==5?"selected":"";?> style="background-color:#fad9d6">有尾款</option>
                    <option value="6" <?php echo $haspay_rate==6?"selected":"";?> style="background-color:#fad9d6">需退款</option>
                </select>
                <span class='rv_status' style='float:right;height:19px;background-color:#FF0000;color:#ffffff' id='default_set_button'><span style='margin:2px'>設定</span>
                    <div style="position:absolute;display:none;text-align:left">
                        <a href="javascript:sysfun_save_set(0);" class=button5>儲存預設值</a><br>
                        <a href="javascript:sysfun_save_set(1);" class=button7>清除預設值</a>
                    </div> 
                </span>
                </td>
		</tr>
		<tr>
		<td width=7% class=tdstyle2> 結束日 </td>
		<td width=26%>
		<IFRAME id=ca_fr_1 style="DISPLAY: none; WIDTH: 212px; POSITION: absolute; HEIGHT: 160px;z-index:5" marginWidth=0 marginHeight=0  frameBorder=0 scrolling=no ></IFRAME><SPAN id=ca_div_1 style="DISPLAY: none; POSITION: absolute;z-index:6"></SPAN>
			<select name="dep_year2">
			<? Str_Echo_Num_Option($GLOBALS["sys_seting"]["Sys_Start_Year"],$now["year"]+4,$dep_year2);?>
			</select>年
			<select name="dep_month2">
			<? Str_Echo_Num_Option(1,12,$dep_month2);?>
			</select>月
			<select name="dep_day2">
			<? Str_Echo_Num_Option(1,31,$dep_day2);?>
			</select>日
			<IMG style="CURSOR: hand" onclick=javascript:showcalendar(2,0,0); src="/class/images/calendar2.gif" align=absMiddle>
		</td>
		<td width=7% class=tdstyle2> 日期狀態 </td>
		<td >
			<div style='float:left;'>
			<select name="datetype">
			<option value='O' <? echo (($datetype=="O")?"selected":"");?>>訂單日</option>
			<option value='A' <? echo (($datetype=="A")?"selected":"");?>>入住日</option>
                        <option value='B' <? echo (($datetype=="B")?"selected":"");?>>入住日(全)</option>
                        <option value='S' <? echo (($datetype=="S")?"selected":"");?>>到達日</option>
                        <option value='D' <? echo (($datetype=="D")?"selected":"");?>>退房日</option>
			<option value='C' <? echo (($datetype=="C")?"selected":"");?>>取消日</option>
			<option value='P' <? echo (($datetype=="P")?"selected":"");?>>付款日</option>
			<option value='L' <? echo (($datetype=="L")?"selected":"");?>>到期日</option>
                        <option value='M' <? echo (($datetype=="M")?"selected":"");?>>最後修改日</option>
                       
			</select>
                            <img src='../images/notice_icon.png' border=0 style='cursor:pointer' width=20 align=absmiddle title='選項說明' onclick="javascript:shownotice(1);">
                            <div id=notice1  style="border:1px solid #888888;position:absolute;display:none;width:550px;font-size:9pt;background-color:#ffffff" class=clearfix>
				<div style='width:100%;text-align:right;height:24px;'> <span style="margin:3px"><a href='javascript:shownotice(0);' class=button1>關 閉</a></span> </div>
                                <span style="margin-left:10px">不論用何篩選條件，總價皆以整筆訂單計算</span>
                                <ul>
				<li><font color=0099ff>訂單日</font>：以訂單成立日期為篩選條件。</li>
				<li><font color=0099ff>入住日</font>：以訂單入住區間篩選條件，列表只顯示搜尋條件的小訂單，總價以整筆訂單計算。</li>
				<li><font color=0099ff>入住日(全)</font>：以訂單入住區間篩選條件，列表以整筆大訂單顯示。</li>
				<li><font color=0099ff>到達日</font>：以整筆訂單入住日第一天為篩選條件。</li>
                                <li><font color=0099ff>退房日</font>：以整筆訂單退房日期為篩選條件。</li>
				<li><font color=0099ff>取消日</font>：以取消訂單日期為篩選條件。</li>
                                <li><font color=0099ff>付款日</font>：以轉正式單日期為篩選條件。</li>
                                <li><font color=0099ff>到期日</font>：以訂金繳款期限為篩選條件。</li>
                                <li><font color=0099ff>最後修改日</font>：以訂單有修改的最後日期為篩選條件。</li>
				</ul>
                            </div>
		</td>
		<td width=7% class=tdstyle2> 處理狀態 </td>
		<td>
			<select name="dealtype">
			<? Str_Echo_Option_From_Array($sys_dealtype,$dealtype,0,"全部","type","name","");?>
			</select>
		</td>
		<td width=7% class=tdstyle2> 預付方式 </td>
		<td >
			<select name="pay_method" style='width:120px'>
			<option value="" <? echo ($pay_method=="")?"selected":"";?>>全部</option>
			<option value="6-" <? echo ($pay_method=="6-")?"selected":"";?>>ATM</option>
			<option value="6-Y" <? echo ($pay_method=="6-Y")?"selected":"";?>>ATM系統轉帳</option>
			<option value="6-N" <? echo ($pay_method=="6-N")?"selected":"";?>>ATM手動轉帳</option>
			<option value="5-" <? echo ($pay_method=="5-")?"selected":"";?>>刷卡</option>
			<option value="5-Y" <? echo ($pay_method=="5-Y")?"selected":"";?>>網路刷卡</option>
			<option value="5-N" <? echo ($pay_method=="5-N")?"selected":"";?>>手動刷卡</option>
			<option value="0-" <? echo ($pay_method=="0-")?"selected":"";?>>前台自付</option>
			<option value="7-" <? echo ($pay_method=="7-")?"selected":"";?>>票券</option>
			<option value="10-" <? echo ($pay_method=="10-")?"selected":"";?>>信用交易</option>
                        <option value="16-" <? echo ($pay_method=="16-")?"selected":"";?>>訂金轉移</option>
                        <option value="21-" <? echo ($pay_method=="21-")?"selected":"";?>>電子支付</option>
			</select>
                     
		</td>
		</tr>
		<tr>
		<td class=tdstyle2>訂單類別</td>
		<td >
			客戶
			<select name="custtype" onchange='javascript:change_fromtype();'>
			<option value='' <? echo (($custtype=="")?"selected":"");?>>全部</option>
			<option value='C' <? echo (($custtype=="C")?"selected":"");?>>一般客戶</option>
			<option value='B' <? echo (($custtype=="B")?"selected":"");?>>合約客戶</option>
			</select>
			團散
			<select name="grouptype" onchange='javascript:change_fromtype();'>
			<option value='' <? echo (($grouptype=="")?"selected":"");?>>全部</option>
			<option value='F' <? echo (($grouptype=="F")?"selected":"");?>>散客單</option>
			<option value='G' <? echo (($grouptype=="G")?"selected":"");?>>團體單</option>
			</select>
		</td>
		<td class=tdstyle2> 訂單來源 </td>
		<td colspan=3>
			<select name='fromtype' style="width:198px">
			<option value=''>全部</option>
			</select><input type="text" name="b2b_filter" style='width:42px;display:none' id='b2b_filter' placeholder="◄搜尋" class="select_filter">
		</td>
		<td class=tdstyle2>旅客國籍</td>
		<td width=190 >
                    <select name="country_cust" style="width:65px">
                        <option value="0" <?php echo ($country_cust==0)?"selected":"";?>>訂房人</option> 
                        <option value="1" <?php echo ($country_cust==1)?"selected":"";?>>入住人</option> 
                    </select>
			<select name="country" style='width:115px'>
			<option value=-1 <?php echo ($country==-1)?"selected":"";?>>全部</option>
			<? Str_Echo_Option_From_Array($country_list,$country,1,"","type","name","");?>
			</select>
		</td>
		</tr>
		<? if($systemid>0 and $hotelid>0) { ?>
			<tr>
		<td class=tdstyle2  > 房型 </td>
		<td  >
		<select name=roomid style='width:200px'>
			<? Str_Echo_Option_From_Array($roominfo,$roomid,0,"全部","roomid","room_name","");?>
		</select>
		</td>
		<td class=tdstyle2 > 專案 </td>
		<td colspan=<?php echo ($flag_vipon)?"3":"5";?>>
			<select name=priceid style='width:<?php echo ($flag_vipon)?"198":"300";?>px' id='priceid'>
			
			</select>&nbsp;
                    <input type="text" name="price_filter" style='width:64px;font-size:8pt' id='price_filter' placeholder="◄搜尋專案" class="select_filter">
                <?php if($flag_vipon) {?>
                </td>
                <td class="tdstyle2">會員等級</td>
                <td>
                 <select name="viplv" style='width:80px'>
                        <option value=-1 <?php echo ($viplv==-1)?"selected":"";?>>全部</option>    
			<? Str_Echo_Option_From_Array($vipinfo,$viplv,0,"一般會員","lv","name","");?>
			</select>   
                <?php } ?>    
                <?php if($flag_hasrv) { ?>
                    <span style="float:right">
                        訂位&nbsp;&nbsp;<select name="has_rv" style='width:80px'>
                            <?php Str_Echo_Option_From_Array($store_info,$has_rv,0,"全部","bid","name");?>
                        </select>
                    </span>    
                <?php } ?>
		</td>
              
		</tr>
		<? } ?>
		<tr>
		<td colspan=8>
				<table width=100% cellpadding="0" cellpadding="0" class=tbstyle1>
				<tr>
				<td class=tdstyle2 colspan=2>
                                    <label><input type=checkbox value='Y' name='search_by_date' <? echo $search_by_date=='Y'?"checked":"";?>>以下搜尋條件，加上日期區間</label>
				</td>
				<td class=tdstyle2 width=10%> 訂單編號 </td>
				<td width=23%>
					<input type=text name=orderno value="<? echo $orderno;?>" style='width:100%' onfocus="this.value=''">
				</td>
				<td class=tdstyle2 width=10%> <select name='remark_type'>
                                        <option value='0' <? echo ($remark_type==0)?"selected":"";?>>其它需求</option>
                                        <option value='1' <? echo ($remark_type==1)?"selected":"";?>>付款資料</option>
                                        <option value='2' <? echo ($remark_type==2)?"selected":"";?>>處理備註</option>
                                        <option value='3' <? echo ($remark_type==3)?"selected":"";?>>對帳單號</option>
                                        <option value='4' <? echo ($remark_type==4)?"selected":"";?>>團名</option>
                                    </select> </td>
				<td width=23%>
					<input type=text name='order_remark' value='<? echo $order_remark;?>' style='width:100%' onfocus="this.value=''">
				</td>
				<td align=right rowspan=2 width=60px>
				<input type=reset value=" Reset " style='width:100%'><br>
				<input type=submit value=" 查詢 " style='width:100%'>
				</td>	
				</tr>
				<tr>
				<td class=tdstyle2  width=10%> 客人姓名 </td>
				<td  width=23% >
					<input type=text name=custname value="<? echo $custname;?>" style='width:100%' onfocus="this.value=''">
				</td>
				<td class=tdstyle2 > 客人身份証 </td>
				<td >
					<input type=text name=custid value="<? echo $custid;?>" style='width:100%' onfocus="this.value=''">
				</td>
				<td class=tdstyle2 > 聯絡電話 </td>
				<td >
					<input type=text name=cust_tel value="<? echo $cust_tel;?>" style='width:100%' onfocus="this.value=''">
				</td>
				</table>
			</td>
		</tr>
		</table>
	</td>
	
	<td style='font-size:9pt' >
			<div class=rv_status style='width:200px;background-color:#eeeeee;text-align:left'><span class='rv_status' style='height:15px;background-color:#FF0000;color:#ffffff'>註</span>：有其它需求備註(移上可看內容)</div>
			<div class=rv_status style='width:200px;background-color:#eeeeee;text-align:left'><span class='rv_status' style='height:15px;background-color:#CC0000;color:#ffffff'>加</span>：有加購項目</div>
			<div class=rv_status style='width:200px;background-color:#eeeeee;text-align:left'><span class='rv_status' style='height:15px;background-color:#007399;color:#ffffff'>網</span>：網路訂房</div>
			<div class=rv_status style='width:200px;background-color:#eeeeee;text-align:left'><span class='rv_status' style='height:15px;background-color:#5C9A00;color:#ffffff'>企</span>：企業訂房</div>
			<div class=rv_status style='width:200px;background-color:#eeeeee;text-align:left'><span class='rv_status' style='height:15px;background-color:#A142D0;color:#ffffff'>修</span>：有修改記錄</div>
			<div class=rv_status style='width:200px;background-color:#eeeeee;text-align:left'><span class='rv_status' style='height:15px;background-color:#CC6D00;color:#ffffff'>團</span>：團體訂房</div>
			<div class=rv_status style='width:200px;background-color:#eeeeee;text-align:left'><span class='rv_status' style='height:15px;background-color:#9BA102;color:#ffffff'>國</span>：國旅卡訂單</div>
			<div class=rv_status style='width:200px;background-color:#eeeeee;text-align:left'><span class='rv_status' style='height:15px;background-color:#CC06AE;color:#ffffff'>發</span>：需要開發票(點選可看發票內容)</div>
                        <div class=rv_status style='width:200px;background-color:#eeeeee;text-align:left'><span class='rv_status' style='height:15px;background-color:#0E02FB;color:#ffffff'>對</span>：對帳單號(移上可看內容)</div>
		</td>
		<td width=80 style='font-size:9pt' align=center>
		<div class=rv_status style='width:74px;background-color:#3d3d3d;text-align:center;min-height:108px'><B><font color=#ffffff>訂單底色</font></B>
		<div class=rv_status style='width:70px;background-color:#ffffff;margin:2px'>正式單</div>
		<div class=rv_status style='width:70px;background-color:#eeeeee;margin:2px'>未付款單</div>
		<div class=rv_status style='width:70px;background-color:#d9d6fb;margin:2px'>過期單</div>
		<div class=rv_status style='width:70px;background-color:#fbd9d6;margin:2px'>取消單</div>
		<? if($waiting_on=='Y') { ?>
		<div class=rv_status style='width:70px;background-color:#fafbd6;margin:2px'>候補單</div>
		<? } ?>
		</div>
		</td>
	</tr>		
	</table>	
   <div style="width:100%;text-align:center;padding-top:100px;font-size:10pt" id=list0>
		<? include("../inc/inc_loading.php");?>
	</div>
	<div align=left class=divstyle1 style='width:<? echo $sys_width;?>px;padding:2px;text-align:right;'>
	<span style='width:64%;text-align:left;'>
	<a href="javascript:changeordertype('');" class=<? echo ($ordertype=="")?"button2":"button1";?>>全部</a> 
	<a href="javascript:changeordertype('Y');" class=<? echo ($ordertype=="Y")?"button2":"button1";?>>正式單</a> 
	<a href="javascript:changeordertype('N');" class=<? echo ($ordertype=="N")?"button2":"button1";?>>未付款</a> 
	<a href="javascript:changeordertype('L');" class=<? echo ($ordertype=="L")?"button2":"button1";?>>已過期</a> 
	<a href="javascript:changeordertype('C');" class=<? echo ($ordertype=="C")?"button2":"button1";?>>取消單</a> 
	<a href="javascript:changeordertype('B');" class=<? echo ($ordertype=="B")?"button2":"button1";?>>未取消</a> 
	<? if($waiting_on=='Y') { ?>
	<a href="javascript:changeordertype('W');" class=<? echo ($ordertype=="W")?"button2":"button1";?>>候補單</a> 
	<? } ?>
        <a href="javascript:changeordertype('K');" class=<? echo ($ordertype=="K")?"button2":"button1";?>>Walk In</a> &nbsp;
	<a href="javascript:changeordertype('TP');" class=<? echo ($ordertype=="TP")?"button4":"button3";?>>今日付款</a> 
	<a href="javascript:changeordertype('TN');" class=<? echo ($ordertype=="TN")?"button4":"button3";?>>今日催款</a> 
	<a href="javascript:changeordertype('TL');" class=<? echo ($ordertype=="TL")?"button4":"button3";?>>今日過期</a> 
	<a href="javascript:changeordertype('TC');" class=<? echo ($ordertype=="TC")?"button4":"button3";?>>今日取消</a> 
	<a href="javascript:changeordertype('TA');" class=<? echo ($ordertype=="TA")?"button4":"button3";?>>今日住房</a>
        <span id='filter_button'><a href="javascript:rv01_show_filter_div();"  class=button8>訂單篩選</a>
        <div id="filter_div" style="position:absolute;display:none;border:1px solid #999999;background-color:#999999;min-width:400px;width:480px" class="div-radius"><span style='margin:5px'>
            <a href="javascript:rv01_filter_order('otherorder',0,'');" class="button2" functype='msg' remark='篩選預訂有加購的訂單'>有加購</a>
            <a href="javascript:rv01_filter_order('invoice',0,'');" class="button2" functype='msg' remark='篩選預訂有要開發票的訂單'>有發票</a>
            <a href="javascript:rv01_filter_order('remark',0,'');" class="button2" functype='msg' remark='篩選預訂有其它需求的訂單'>有其它需求</a>
            <a href="javascript:rv01_filter_order('twcard',0,'');" class="button2" functype='msg' remark='篩選預訂有標式國旅卡的訂單'>國旅卡</a>
            <a href="javascript:rv01_filter_order('modify',0,'');" functype='msg' class="button2" remark='篩選有修改過的訂單'>有修改</a>
            <a href="javascript:rv01_show_filter_div();" class="button3" functype='traffic'>交通方式</a>
            <?php if($systeminfo["mms_on"]=="Y") {?> 
            <a href="javascript:rv01_show_filter_div();" class="button3" functype='mms'>簡訊</a>
            <?php } ?>
            <a href="javascript:rv01_clean_filter();" class="button7" style='font-family:arial;font-weight:bolder' functype='msg' remark='取消篩選'>清除篩選</a>
            <a href="javascript:rv01_hide_filter_div();" class="button8" style='font-family:arial;font-weight:bolder' functype='msg' remark='關閉篩選' >X</a><BR>
            <span style='width:100%;height:45px;' class='div-radius'><span style='margin:5px;color:#ffffff;line-height:30px' id='filter_msg'>請選擇篩選條件</span>
                <span style='margin:5px;display:none' id='filter_traffic' class='filter_non_msg'><a href="javascript:rv01_filter_order('traffic',0,'')" class='button4'>大眾交通工具</a>
                    <a href="javascript:rv01_filter_order('traffic',1,'')" class='button4'>自行開車</a>
                    <a href="javascript:rv01_filter_order('traffic',2,'')" class='button4'>旅行社遊覽車</a><br>
                    <span style='margin-top:2px'>
                    <a href="javascript:rv01_filter_order('traffic',3,'')" class='button4'>需接送</a>
                    <?php if($shuttle_on) { ?>
                    <a href="javascript:rv01_filter_order('traffic',3,'Y')" class='button6'>接送已填單</a>
                    <a href="javascript:rv01_filter_order('traffic',3,'N')" class='button8'>接送未填單</a>
                    <?php } ?>
                    </span>
                </span>
               <?php if($systeminfo["mms_on"]=="Y") {?> 
                <span style='margin:5px;display:none;margin-top:10px' id='filter_mms' class='filter_non_msg'><a href="javascript:rv01_filter_order('mms',0,'')" class='button6'>未發簡訊</a>
                    <a href="javascript:rv01_filter_order('mms',1,'')" class='button4'>已發簡訊</a>
                    <?php if(count($mms_sample)>0){?>
                   <span style='margin-left:10px;border-left:1px solid #ffffff;'><select id='mms_select' name='mms_select' style='margin-left:10px'>
                                <?php for($i=0;$i<count($mms_sample);$i++) { ?>
				<option value="<?php echo $mms_sample[$i]["bid"];?>"><?php echo $mms_sample[$i]["title"];?></option>
				<?php } ?></select> <a href="javascript:rv01_filter_order('mms',2,'')" class='button8'>依此類別篩選</a>
                   </span>             
                    <?php } ?>
                </span>
                  
               <?php } ?> 
            </span></span>
        </div></span>
	</span>
	<span style='width:35%;text-align:right;'>
            <a href="rv01_index.php" class=button5>初始化</a>
	<a href="javascript:<?php echo (($admin_default_sysid>0 && $ip_check_flag==1 && $systemid!=49)||$accessinfo["UserNo"]==1||$accessinfo["UserNo"]==2282)?"rv01_order_save();":($ip_check_flag==0?"alert('請先指定旅宿ip');":"alert('無此權限');");?>" class=button1>另存</a>
       
        <a href="javascript:window.location.reload();" class=button1>重整</a>
	<b>建單</b>
		<select name=keyin_userno style='width:90px' onchange='javascript:document.searchform.submit();'>
			<option value='0' <?php echo ($keyin_userno==0)?"selected":"";?> style='background-color:#fbfad6'>全部帳號</option>
			<?
				for($i=0;$i<count($all_user_info);$i++) 
				{ 
					if($all_user_info[$i]["IfDelete"]!='Y' &&  $all_user_info[$i]["account_mode"]!=2) { 
					?>
					<option value=<? echo $all_user_info[$i]["No"];?> <? echo $all_user_info[$i]["No"]==$accessinfo["UserNo"]?"style='background-color:#fad9d6'":"";?> <? echo ($keyin_userno==$all_user_info[$i]["No"])?"selected":"";?> >
					(<? echo $all_user_info[$i]["account_mode"]==2?"P":(($all_user_info[$i]["hotelid"]==0)?"總":"分");?>)<? echo $all_user_info[$i]["nickname"];?>
					</option>
					<?
					}
				}
			?>			
			</select>	
            <?php if($sales_mode=='Y'){?>
		<b>業務</b>
		<select name='sales_id' style='width:90px' onchange='javascript:document.searchform.submit();'>
		<option value=-1 <?php echo($sales_id==-1)?"selected":"";?>>尚未指定業務</option>
		<?php Str_Echo_Option_From_Array($sales_info,$sales_id,0,"全部","No","nickname");?>
		</select>	
	<?php } ?>
	</span>
	</div>
	</form>
	 <div  id=list1>
         <form name="sysform" method=post>
	<input type=hidden name="orderno">
	<input type=hidden name="sysid" value="<? echo $systemid;?>">
	<input type=hidden name=custid value="0">
        <input type=hidden name="fromrv" value='Y'>
        <input type="hidden" name="ordertype" value="1">
         </form>
	<? if(count($orderinfo)>0) {  ?>
	<form name="orderform" method=post>
	<input type=hidden name="orderno">
	<input type=hidden name="sysid" value="<? echo $systemid;?>">
	<input type=hidden name=custid value="0">
	<input type=hidden name="handle_remark">
	<input type=hidden name="handle_status">
	<input type=hidden name="fromrv" value='Y'>
	<table width=<? echo $sys_width;?> class=tbstyle1 id=rv01tbl style='word-break:break-all;'>
	<tr>
	<td class=tdstyle1 width=3%>&nbsp;</td>
	<td class=tdstyle1 width=5%>訂單編號</td>
	<td class=tdstyle1 width=6%>訂購時間</td>
	<td class=tdstyle1 width=6%>訂購人</td>
	<td class=tdstyle1 width=2%>&nbsp;</td>
	<td class=tdstyle1 width=6%>入住時間</td>
	<td class=tdstyle1 id=order_content>訂單內容</td>
	<td class=tdstyle1 width=6%>入住人</td>
	<td class=tdstyle1 width=2%>間</td>
	<td class=tdstyle1 width=5%>小計</td>
	<td class=tdstyle1 width=5%>總價</td>
	<td class=tdstyle1 width=5%>已付</td>
	<td class=tdstyle1 width=6%>其它</td>
	<td class=tdstyle1 width=5%>訂單狀況</td>
	<td class=tdstyle1 width=6%>預付方式</td>
	<td class=tdstyle1 width=14%>處理備註 / 訂單處理</td>
	<? if($history_show) { ?>
	<td class=tdstyle2 width=6%>處理人員</td>
	<? } ?>
	</tr>
	<? 
	$i=0;
	$qty=0;
	$cur_orderno=0;
	$prebgcolor ="";
	$sum[0]=0;
	$sum[1]=0;
	$sum[2]=0;
	$sum[3]=0;
        $sum[4]=0;
        $sum[5]=0;
        $sum[6]=0;
        $sum[7]=0;
        $sum[8]=0;  // commission
        $ischannel='N';  //判斷如果是ota串接的訂單，不可直接修改或取消
        $enddaycheck = false;  //判斷是否已過退房日
	while(isset($orderinfo[$i]))
	{
		$bgcolor="#ffffff";
		if($cur_orderno != $orderinfo[$i]["orderno"])
		{
//			if($prebgcolor=="ffffff") $prebgcolor="f7f7f7";
//			else  $prebgcolor="ffffff";
			if($qty!=0) { ?>
			 <tr bgcolor='#aaaaaa'><td colspan=<?php echo $history_show?"17":"16";?> style='height:2px'></td></tr>
			<? } 
		}
		//$bgcolor = $prebgcolor;
                $col1_bgcolor = "#ffffff";
		if($orderinfo[$i]["ordertype"]=="C") 
                {    
                    $bgcolor='#fbd9d6';
                    $col1_bgcolor = "#F48B82";
                }    
		else if(($orderinfo[$i]["ordertype"]=="")||($orderinfo[$i]["ordertype"]=="N")) 
                {    
                    $bgcolor='#EEEEEE';
                    $col1_bgcolor = "#AAAAAA";
                }    
		else if($orderinfo[$i]["ordertype"]=="W")
                {    
                    $bgcolor='fafbd6';
                    $col1_bgcolor = "#F6FA66";
                }    
		if($orderinfo[$i]["pay_limit_check"]=='Y') 
                {    
                    $bgcolor='d9d6fb';
                    $col1_bgcolor = "#A39CFB";
                }    
                
                $buffer_pipa_mode = $pipa_mode;
                
                if(Date_CompareTwoDays("now()", $orderinfo[$i]["endday"])>1) $buffer_pipa_mode=2;
                
                $commission = $orderinfo[$i]['commission']+0;
                if( $commission != 0 ) { $commission = round($commission/100);}  // 透過if 判斷節省 '/ ' 的 cpu 消耗
                
                if(Date_CompareTwoDays($hoteldate,$orderinfo[$i]["endday"])<=0)
                {
                    $enddaycheck = true;
                }
                else
                {
                    $enddaycheck = false;
                }    
	?>
	<tr bgcolor=<? echo $bgcolor;?> class='menutr' 
            modify='<?php echo ($orderinfo[$i]["modifyday"]!="0000-00-00 00:00:00")?"Y":"N";?>'
            traffic='<?php echo $orderinfo[$i]["traffic_type"];?>' 
            twcard='<?php echo(($orderinfo[$i]["paytype"]==5)&&($orderinfo[$i]["card_type"]=='TW'))?"Y":"N";?>'
            otherorder='<?php echo ($orderinfo[$i]["other_order"]!="")?"Y":"N";?>'
            remark='<?php echo ($orderinfo[$i]["order_remark"]!="")?"Y":"N";?>' 
            invoice='<?php echo (($orderinfo[$i]["inv_no"]!="")&&($orderinfo[$i]["inv_type"]>0))?"Y":"N";?>' 
            orderno='<?php echo $orderinfo[$i]["orderno"];?>'
            >
		<? if($cur_orderno != $orderinfo[$i]["orderno"]) 
		{
			$order_id_count=1;
			//統計主訂單的數字
			$sum_people[0]+=$orderinfo[$i]["adult"];
			$sum_people[1]+=$orderinfo[$i]["child"];
			$sum_traffic[$orderinfo[$i]["traffic_type"]][0] ++;
			if(($orderinfo[$i]["traffic_type"]==1)||($orderinfo[$i]["traffic_type"]==2)) $sum_traffic[$orderinfo[$i]["traffic_type"]][1] += $orderinfo[$i]["car_count"];
			
                        if($orderinfo[$i]["ordertype"]=='Y') {
                            $sum_ordertype[1][0]++;                            
                            $sum_ordertype[1][2]+= ($orderinfo[$i]["totalprice"] + $other_order_info[$orderinfo[$i]["orderno"]] );
                            
                        }else if($orderinfo[$i]["ordertype"]=="C") {
                            $sum_ordertype[2][0]++;                            
                            $sum_ordertype[2][2]+= ($orderinfo[$i]["totalprice"] + $other_order_info[$orderinfo[$i]["orderno"]] );
                            
                        }else if($orderinfo[$i]["ordertype"]=="W") {
                            $sum_ordertype[3][0]++;                            
                            $sum_ordertype[3][2]+= ($orderinfo[$i]["totalprice"] + $other_order_info[$orderinfo[$i]["orderno"]] );
                            
                        }else {
                            $sum_ordertype[0][0]++;                            
                            $sum_ordertype[0][2]+= ($orderinfo[$i]["totalprice"] + $other_order_info[$orderinfo[$i]["orderno"]] );
                        }
			
			if($orderinfo[$i]["b2bid"]>0){
                            $sum_cust_type[1][0]++;
                            $sum_cust_type[1][2]+= ($orderinfo[$i]["totalprice"] + $other_order_info[$orderinfo[$i]["orderno"]] );
                        }else if($orderinfo[$i]["create_id"]==0){
                            $sum_cust_type[2][0]++;
                            $sum_cust_type[2][2]+= ($orderinfo[$i]["totalprice"] + $other_order_info[$orderinfo[$i]["orderno"]] );
                        }else{
                            $sum_cust_type[0][0]++;
                            $sum_cust_type[0][2]+= ($orderinfo[$i]["totalprice"] + $other_order_info[$orderinfo[$i]["orderno"]] );
                        }
			
			if($orderinfo[$i]["custtype"]==1){
                            $sum_group[1][0]++;
                            $sum_group[1][2]+= ($orderinfo[$i]["totalprice"] + $other_order_info[$orderinfo[$i]["orderno"]] );
                        }
			else {
                            $sum_group[0][0]++;
                            $sum_group[0][2]+= ($orderinfo[$i]["totalprice"] + $other_order_info[$orderinfo[$i]["orderno"]] );
                        }
                        
                        if($orderinfo[$i]["from_id"]>0 && ($buffer_platform_info[$orderinfo[$i]["from_id"]]["type"]==1 || $buffer_platform_info[$orderinfo[$i]["from_id"]]["type"]==4) )  $ischannel='Y';
                        else $ischannel='N';
                        
                        // 透過 priceid 來更改 form_id
                        if( $GLOBALS["develop"]==true ){                            
                            $ischannel ='Y';
                        }
                        
			?>
			<td  align=center class=mainrow bgcolor="<? echo $col1_bgcolor;?>"><? echo $qty+1;?>
                            <BR>
                        <span style="cursor:pointer" class="menubutton" orderno='<? echo $orderinfo[$i]["orderno"];?>'><img src="../images/menu.png" class='unclosemenu' width="16" border="0"></span>
                            
                        </td>
			<td  align="center" class="mainrow menutd"  id='orderno_<? echo $orderinfo[$i]["orderno"];?>'>
                        <a href="javascript:gotodetail('<? echo $orderinfo[$i]["com_order_no"];?>',<? echo $orderinfo[$i]["sysid"];?>);" style='margin-bottom:3px'><? echo STR_StrZero(8,$orderinfo[$i]["orderno"]);?></a>    
                        
                        <BR>
                        <div style="display:none;position:absolute;width:56px;text-align:center;z-index:30;background-color:#ffffff" class='menudiv'>
                        <a href="javascript:gotodetail('<? echo $orderinfo[$i]["com_order_no"];?>',<? echo $orderinfo[$i]["sysid"];?>);" class=button1 style='margin-top:2px;min-width:42px' title='預訂單內容'>訂單</a>       
                        <a href="javascript:order_detail_show('<? echo $orderinfo[$i]["orderno"];?>');" class=button5 style='margin-top:2px;min-width:42px' title='訂單詳細內容'>總覽</a>   
			<? if(((Date_CompareTwoDays($hoteldate,$orderinfo[$i]["endday"])<=0)&&($orderinfo[$i]["ordertype"]!='C')&&($systemid>0) &&  $admin_authority[1]==1) || ($accessinfo["UserNo"]==1) ) { 
                            if( $ischannel!='Y' || $accessuserinfo["sysid"]==0 ||  ( $accessuserinfo["superuser"]=='Y' ) ){                            
                            ?>
			<BR><a href="javascript:gotomodify('<? echo $orderinfo[$i]["orderno"];?>',<? echo $orderinfo[$i]["sysid"];?>);" class=button1 style='margin-top:2px;min-width:42px' title='修改預訂單內容'>修改</a>
			<?php 
                              }//if( $ischannel!='Y' )
                        if($orderinfo[$i]["ordertype"]!="W" && $admin_authority[1]==1 ){?>
			<BR><a href="javascript:goto_other_order('<? echo $orderinfo[$i]["orderno"];?>');" class=button1 style='margin-top:2px;min-width:42px' title='加購行程、餐點或其它服務'>加購</a>
			<? } ?>
                        <?php if($orderinfo[$i]["ordertype"]!="W" && ($fp10_auth+0)>0 && $accessinfo["hotelid"]>0) {?>
                        <BR><a href="javascript:goto_order_setroom('<? echo $orderinfo[$i]["orderno"];?>');" class=button1 style='margin-top:2px;min-width:42px' title='連結至訂單排房'>排房</a>
                        <?php } ?>
			<?php if(($orderinfo[$i]["ordertype"]=='' && ($order_check_flag!="")) || ($orderinfo[$i]["ordertype"]=='Y' && ($order_check_flag=='A' || $order_check_flag=='W')) ||($orderinfo[$i]["ordertype"]=='W' && $order_check_flag=='W') ){ ?>
			<BR><a href="javascript:goto_order_check('<? echo $orderinfo[$i]["orderno"];?>',<? echo $orderinfo[$i]["sysid"];?>);" class=button1 style='margin-top:2px;min-width:42px' title='訂房確認單'>確認單</a>
			<?php } ?>
                        <?php if($systemid>0 && $orderinfo[$i]["ordertype"]=='' && in_array($systemid,$qr_link_setting) ) {
                             $qrauthcode = qrcode_authcode($systemid,$qrver,$orderinfo[$i]["com_order_no"]);
                             $qr=$orderinfo[$i]["com_order_no"]."-".$qrver."-".$qrauthcode;
                             $order_url=$Sys_TheLocalSslHttp.$order_folder[$orderinfo[$i]["hotelid"]]."/reserve/?qr=".$qr;
                            ?>
                        <BR><a href="javascript:get_order_link('<?php echo $order_url;?>');" class=button1 style='margin-top:2px;min-width:42px' title='複製付款連結'><img src='../images/copy.png' height="14" align='absmiddle' >連結</a>
                        <?php } ?>
			<? } else {?>
			<?php if($orderinfo[$i]["ordertype"]!="W" && ($accessuserinfo["sysid"]==0 || $systemid==45 || $systemid==118 || $systemid==60 )){  /* 元泰要求要隨時可以改加購  */?>
			<BR><a href="javascript:goto_other_order('<? echo $orderinfo[$i]["orderno"];?>');" class=button1 style='margin-top:2px;min-width:42px' title='加購行程、餐點或其它服務'>加購</a>
			<? } ?>
			<?php } ?>
                       
                        <?php 
				//檢查簡訊系統權限
				if($systeminfo["mms_on"]=="Y") 
				{ 
					if($admin_authority[3]>0)
					{
						?>
						<a href="javascript:rv01_send_mms(<?php echo $orderinfo[$i]["orderno"];?>,<?php echo $orderinfo[$i]["sysid"];?>)" class=button1 style='margin-top:2px;min-width:42px' title='針對此筆訂單傳送簡訊'>簡訊</a>
						<?php
					} 
				}
                                if(isset($line_cust[$orderinfo[$i]["custid"]]) && $line_cust[$orderinfo[$i]["custid"]]["custid"] = $orderinfo[$i]["custid"])
                                {
                                    ?>
                                    <a href="javascript:rv01_send_line(<?php echo $orderinfo[$i]["orderno"];?>,<?php echo $orderinfo[$i]["sysid"];?>)" class=button5 style='margin-top:2px;min-width:42px' title='針對此筆訂單傳送Line訊息'>Line</a>
                                    <?php
                                }        
                                if(($systeminfo["deposit_on"]=="Y")&&(($orderinfo[$i]["ordertype"]=="Y")||($orderinfo[$i]["ordertype"]=="C" && $orderinfo[$i]["payprice"]>0))) { ?>
				<a href="javascript:rv01_deposit_manage(<?php echo $orderinfo[$i]["orderno"]?>,<?php echo $orderinfo[$i]["sysid"];?>);" class=button3 style='margin-top:2px;min-width:42px' title='處理此筆訂單的預付訂金'>訂金</a>
				<?php  }
				?>
                                <?php  if($enddaycheck && $accessinfo["sysid"]>0 && ($fp01_auth+0)>0) { ?>
                                <a href="javascript:rv01_copy_order(<?php echo $orderinfo[$i]["orderno"]?>,<?php echo $orderinfo[$i]["hotelid"];?>);" class=button7 style='margin-top:2px;min-width:42px' title='複製此筆訂單內容成立一筆新訂單'>複製</a>
                                <?php }
                                if($enddaycheck && $accessinfo["sysid"]>0 && $accessinfo["hotelid"]>0 && $orderinfo[$i]["ordertype"]!="W" && $orderinfo[$i]["ordertype"]!='C' && $flag_restaurant) {?>
                                <a href="javascript:rv01_goto_reseve(<?php echo $orderinfo[$i]["orderno"];?>,0);" class="button9" style='margin-top:2px;min-width:42px' title='餐廳訂位'>訂位</a>
                                <?php }
                                if($enddaycheck && $accessinfo["sysid"]>0 && $accessinfo["hotelid"]>0 && $orderinfo[$i]["ordertype"]!="W" && $orderinfo[$i]["ordertype"]!='C' && $flag_banquet) {?>
                                <a href="javascript:rv01_goto_reseve(<?php echo $orderinfo[$i]["orderno"];?>,1);" class="button9" style='margin-top:2px;min-width:42px' title='場地或會議室預約'>訂場地</a>
                                <?php } ?>
                        </div>
                        <?php echo ($orderinfo[$i]["uncancellable"]=='Y')?"<span class='rv_status' style='height:15px;border:1px solid #ff0000;color:#ff0000'>不退</span>":"";?>
			</td>
                        <td  align=center class="mainrow td_powertip" style='position:relative' <? echo (($orderinfo[$i]["order_remark"]!="")?"title=\"".nl2br(STR_Strip_Quots(strip_tags($orderinfo[$i]["order_remark"])))."\"":"");?>><? echo str_replace(" ","<BR>",$orderinfo[$i]["orderdate"]);?><BR>
			<? 
                                echo ($orderinfo[$i]["from_id"]>0)?"<span class='rv_status' style='height:15px;background-color:#0099ff;color:#ffffff'><b> ".$buffer_platform_info[$orderinfo[$i]["from_id"]]["name"]." </b></span><BR>":"";
				echo (($orderinfo[$i]["order_remark"]!="")?"<span class='rv_status' style='height:15px;background-color:#FF0000;color:#ffffff'>註</span>":""); 
			   	echo (($orderinfo[$i]["other_order"]=="Y")?"<span class='rv_status' style='height:15px;background-color:#CC0000;color:#ffffff'>加</span>":""); 
			   	echo (($orderinfo[$i]["create_id"]==0)?"<span class='rv_status' style='height:15px;background-color:#007399;color:#ffffff' title='".($accessuserinfo["superuser"]=='Y'?$orderinfo[$i]["ip"]:"")."'>網</span>":"");
			   	echo (($orderinfo[$i]["b2bid"]>0)?"<span class='rv_status' style='height:15px;background-color:#5C9A00;color:#ffffff' title='".$buffer_b2binfo[$orderinfo[$i]["b2bid"]]."'>企</span>":""); 
			   	echo (($orderinfo[$i]["modifyday"]=="0000-00-00 00:00:00")?"":"<span class='rv_status' style='height:15px;background-color:#A142D0;color:#ffffff' title='".$orderinfo[$i]["modifyday"]."'>修</span>");
			   	echo (($orderinfo[$i]["custtype"]==0)?"":"<span class='rv_status' style='height:15px;background-color:#CC6D00;color:#ffffff'>團</span>"); 
			   	echo (($orderinfo[$i]["paytype"]==5)&&($orderinfo[$i]["card_type"]=='TW'))?"<span class='rv_status' style='height:15px;background-color:#9BA102;color:#ffffff'>國</span>":""; 
                                echo (($orderinfo[$i]["bank_orderno"]!=""))?"<span class='rv_status' style='height:15px;background-color:#0E02FB;color:#ffffff' title='".$orderinfo[$i]["bank_orderno"]."'>對</span>":""; 
			 	if(($orderinfo[$i]["inv_no"]!="")&&($orderinfo[$i]["inv_type"]>0)){ ?><div id='inv_<? echo $orderinfo[$i]["orderno"];?>' style='display:none;position:absolute;width:200px;height:200px;z-index:3'>
					<div style='border:1px solid #999999'>
					<div style='text-align:right;background-color:#eeeeee;vertical-align:bottom'><a style='cursor:pointer' onclick="javascript:document.getElementById('inv_<? echo $orderinfo[$i]["orderno"];?>').style.display='none';"><img src='../image/delete.gif' border=0 alt='關閉' align='bottom'></a></div>
					<table width=100% class=tbstyle1 bgcolor='#ffffff' >
					<tr>
					<td width=25% class=tdstyle1>格式</td>
					<td ><? echo $orderinfo[$i]["inv_type"];?>聯式</td>
					</tr>
					<tr>
					<td class=tdstyle1>統編</td>
                                        <td ><? echo strip_tags($orderinfo[$i]["inv_no"]);?></td>
					</tr>
					<tr>
					<td class=tdstyle1>抬頭</td>
                                        <td ><? echo strip_tags($orderinfo[$i]["inv_title"]);?></td>
					</tr>
					</table>
					</div>
					</div><a style='cursor:pointer' onclick="javascript:document.getElementById('inv_<? echo $orderinfo[$i]["orderno"];?>').style.display='';"><span class='rv_status' style='height:15px;background-color:#CC06AE;color:#ffffff'>發</span></a>
				<?php } 
                                if($flag_hasrv)
                                {
                                    if(isset($rv_order_info[$orderinfo[$i]["orderno"]]) && $rv_order_info[$orderinfo[$i]["orderno"]]!="")
                                    {
                                        $buffer_storeid = explode(",",$rv_order_info[$orderinfo[$i]["orderno"]]);
                                        for($k=0;$k<count($buffer_storeid);$k++)
                                        {
                                            echo "<span class='rv_status' style='height:15px;background-color:#000000;color:#ffffff'>".$buffer_store_info[$buffer_storeid[$k]]."</span>";
                                        }
                                    }    
                                }    
                                
                                ?>
                                        
			</td>
			<td  align=center class=mainrow><? echo "[<font color=0099ff>".$country_data[$orderinfo[$i]["country"]]."</font>]"; ?>
			<? if($systemid>0) { ?><a href="javascript:rv01_cust_detail('<? echo $orderinfo[$i]["custid"];?>','<?php echo $orderinfo[$i]["orderno"];?>');" alt="詳細資料"><img src='../image/detail.jpg' width=10 height=10 border=0></a><? } ?>
			<BR>
                        <span class=pipa_name><? echo strip_tags($orderinfo[$i]["cust_name"]); //STR_Hide_Str(strip_tags($orderinfo[$i]["cust_name"]),2,($buffer_pipa_mode==2?1:0)); ?></span><br><span class=pipa_phone><? echo STR_Hide_Str(($orderinfo[$i]["cust_mobile"]!=""?strip_tags($orderinfo[$i]["cust_mobile"]):strip_tags($orderinfo[$i]["cust_phone1"])),3,($buffer_pipa_mode==2?3:0));?></span>
			</td>
		<? } ?>
		<td align=center><? echo $orderinfo[$i]["orderid"];?></td>
		<td align=center><? echo $orderinfo[$i]["checkinday"];?><BR><? echo $orderinfo[$i]["checkoutday"];?><BR><font color=#ff0000><? echo Date_CompareTwoDays($orderinfo[$i]["checkoutday"],$orderinfo[$i]["checkinday"]);?></font> 天</td>
		<td >
			<? if($hotelid == 0) { echo $buffer_hotelinfo[$orderinfo[$i]["hotelid"]]."<br>"; }?>
			<? echo "(".$orderinfo[$i]["priceid"].")".$buffer_priceinfo[$orderinfo[$i]["priceid"]];?><br>
			<? echo  "(".$buffer_roominfo[$orderinfo[$i]["hotelid"]."-".$orderinfo[$i]["roomid"]]["room_symbol"].")".$buffer_roominfo[$orderinfo[$i]["hotelid"]."-".$orderinfo[$i]["roomid"]]["room_name"];?>
		</td>
		<td align=center>
		<span class=pipa_name><? echo "[<font color=0099ff>".$country_data[$orderinfo[$i]["guest_country"]]."</font>]"; ?><BR><? echo (($orderinfo[$i]["custtype"]==1)&&($orderinfo[$i]["group_name"]!=""))?"<span class='rv_status' style='height:15px;background-color:#CC6D00;color:#ffffff'>團</span>".strip_tags($orderinfo[$i]["group_name"]):strip_tags($orderinfo[$i]["guest_name"]);//STR_Hide_Str((($orderinfo[$i]["custtype"]==1)&&($orderinfo[$i]["group_name"]!=""))?strip_tags($orderinfo[$i]["group_name"]):strip_tags($orderinfo[$i]["guest_name"]),2,($buffer_pipa_mode==2?1:0));?></span><br><span class=pipa_phone><? echo STR_Hide_Str(($orderinfo[$i]["guest_mobile"]!=""?strip_tags($orderinfo[$i]["guest_mobile"]):strip_tags($orderinfo[$i]["guest_phone"])),3,($buffer_pipa_mode==2?3:0));?></span></td>
		<td align=center><? echo $orderinfo[$i]["roomqty"];?></td>
		<td align=right><? echo ($orderinfo[$i]["roomqty"]>1)?"<font color=#ff9900 style='font-size:7pt'>@</font><font color=#0099ff>".number_format(round($orderinfo[$i]["oneprice"]/$orderinfo[$i]["roomqty"]))."</font><BR>":"";?><? echo number_format($orderinfo[$i]["oneprice"]);?></td>
		<? if($cur_orderno != $orderinfo[$i]["orderno"]) { ?>
			<td  align=right class=mainrow><? 
                        if(isset($other_order_info[$orderinfo[$i]["orderno"]]) && $other_order_info[$orderinfo[$i]["orderno"]]!=0)
                        {
                            echo "<font color=#ff9900>加</font>".number_format($other_order_info[$orderinfo[$i]["orderno"]]);
                            echo "<BR><font color=#0099ff>房</font>".number_format($orderinfo[$i]["totalprice"]);
                            
                            if( $orderinfo[$i]["commission"] > 0 ){
                                echo "<BR><font color=#009933>佣</font>".number_format($commission) ;
                            }
                            
                            echo "<BR><font color=#ff0000>總</font>".number_format($other_order_info[$orderinfo[$i]["orderno"]]+$orderinfo[$i]["totalprice"]);
                        }    
                        else {
                            if( $orderinfo[$i]["commission"] > 0 ){
                                echo "<font color=#009933>佣</font>".number_format($commission)."<BR>";
                            }
                            echo "<font color=#ff0000>總</font>".number_format($orderinfo[$i]["totalprice"]);
                        }
                        ?>
                        </td>
			<td  align=right class=mainrow>
                            <font color="#0099ff"><font color="#ff9900">應</font> <? echo number_format($orderinfo[$i]["prepay"]);?></font><BR>
                            <font color="#ff9900">已</font> <? echo number_format($orderinfo[$i]["payprice"]);?><BR>                            
                            <? if($orderinfo[$i]["bonus_price"] > 0 ){ ?>                                  
                                  <span class='rv_status' style='height:15px;background-color:#ff0000;color:#ffffff'> 折 </span><font style='text-align:right;'><? echo number_format($orderinfo[$i]["bonus_price"]);?> </font>
                                  <BR>
                            <? }?>
                            <font color="#ff0000">未 <? echo number_format($orderinfo[$i]["totalprice"]+$other_order_info[$orderinfo[$i]["orderno"]]-$orderinfo[$i]["payprice"]-$orderinfo[$i]["bonus_price"]);?> </font>
                            <? if($orderinfo[$i]["cancel_price"] > 0 ){ ?>
                                <BR><font color="#ff00ff">應扣 <? echo number_format($orderinfo[$i]["cancel_price"]);?> </font>
                            <?}?>
                            
			</td>
			<td class=mainrow>
			<? if($orderinfo[$i]["adult"]>0) { ?>
				大人：<font color=0099ff><? echo $orderinfo[$i]["adult"];?></font> 人<br>
			<? } 
			   if($orderinfo[$i]["child"]>0) { ?>	
				小孩：<font color=0099ff><? echo $orderinfo[$i]["child"];?></font> 人<br>
			<? } 
				if($orderinfo[$i]["traffic_type"]==3)
				{
					?>
					<a style="cursor:pointer" class="button1" href="javascript:rv01_show_shuttle_info(<? echo $orderinfo[$i]["orderno"];?>);">
					<?
				}
				
				echo $GLOBALS["sys_seting"]["TrafficType"][$orderinfo[$i]["traffic_type"]][0];
				if($orderinfo[$i]["traffic_type"]==3) echo"</a>";
				if($orderinfo[$i]["traffic_type"]==1 || $orderinfo[$i]["traffic_type"]==2) echo "：<font color=0099ff>".$orderinfo[$i]["car_count"]."</font> 輛"; 
			?><br>
			
			</td>
			<td  align=center class=mainrow>
				<? 
					echo report_get_order_type($orderinfo[$i]["ordertype"]);
					if($orderinfo[$i]["ordertype"]=="C") echo "<br>".$orderinfo[$i]["cancelday"];
					else if ($orderinfo[$i]["pay_limit_check"]=='Y') echo "<br><font color=ff0000>已過期</font>";
				?>
				<?php 
				//檢查簡訊系統權限
				if($systeminfo["mms_on"]=="Y") 
				{ 
					if($admin_authority[3]>0)
					{
						?>
						<a href="javascript:rv01_send_mms(<?php echo $orderinfo[$i]["orderno"];?>,<?php echo $orderinfo[$i]["sysid"];?>)" class=button1>簡訊</a>
						<?php
					} 
				}
				?>
			</td>
			<td  align=center class=mainrow valign="middle">
			<? 
				if( ($systeminfo["deposit_on"]=="Y")&&(($orderinfo[$i]["ordertype"]=="Y")||($orderinfo[$i]["ordertype"]=="C" && ($orderinfo[$i]["payprice"]>0 || $ischannel=='Y'))  )) { ?>
				<div style='width:100%;text-align:center;padding-bottom:2px'><a href="javascript:rv01_deposit_manage(<?php echo $orderinfo[$i]["orderno"]?>,<?php echo $orderinfo[$i]["sysid"];?>);" class=button3>訂金處理</a></div>
				<?php  }
				if($orderinfo[$i]["ordertype"]=='Y') 
				{
					if($orderinfo[$i]["paytype"]==0 || $orderinfo[$i]["paytype"]==4) 
					{
						if(($orderinfo[$i]["card_type"]=="ATM")) echo "<span class='rv_status' style='background-color:#003399;color:#ffffff;width:98%'> ATM </span>";
						else echo "<span class='rv_status' style='background-color:#999999;color:#ffffff;width:98%'> 前台自付 </span>";
						if($orderinfo[$i]["payprice"]>0 || $orderinfo[$i]["from_id"]!=0 )
						{
							echo "<br>".$orderinfo[$i]["card_no"];
							echo "<br>".$orderinfo[$i]["card_info"];
						}
					}
					if($orderinfo[$i]["paytype"]==6)
					{
						echo "<span class='rv_status' style='background-color:#003399;color:#ffffff;width:98%'> ATM ";
						if($orderinfo[$i]["pay_id"]==0) echo "<BR> 系統轉帳 ";
						echo "</span>";
						
						echo "<br>".$orderinfo[$i]["card_no"];
						echo "<br>".$orderinfo[$i]["card_info"];
					}
					else if($orderinfo[$i]["paytype"]==5)
					{
						 echo "<span class='rv_status' style='background-color:#FF0000;color:#ffffff;width:98%'> 信用卡 ";
						 if($orderinfo[$i]["pay_id"]==0) echo "<BR> 網路刷卡 ";
						 if($orderinfo[$i]["card_type"]=='TW') echo "<BR> 國旅卡  ";
						 echo "</span>";
						 echo "<br>".$orderinfo[$i]["card_no"];
						 echo "<br>".$orderinfo[$i]["card_info"];
					}
					else if($orderinfo[$i]["paytype"]==7)
					{
						 echo "<span class='rv_status' style='background-color:#5C9A00;color:#ffffff;width:98%'> 票券 </span>";
						 echo "<br>".$orderinfo[$i]["card_no"];
						 echo "<br>".$orderinfo[$i]["card_info"];
					}
					else if($orderinfo[$i]["paytype"]==10)
					{
						 echo "<span class='rv_status' style='background-color:#CC6D00;color:#ffffff;width:98%'> 信用交易 </span>";
						 echo "<br>".$orderinfo[$i]["card_no"];
						 echo "<br>".$orderinfo[$i]["card_info"];
					}
                                        else if($orderinfo[$i]["paytype"]==16)
					{
						 echo "<span class='rv_status' style='background-color:#ff9933;color:#ffffff;width:98%'> 訂金轉移 </span>";
						 echo "<br>".$orderinfo[$i]["card_no"];
						 echo "<br>".$orderinfo[$i]["card_info"];
					}
                                         else if($orderinfo[$i]["paytype"]==17)
					{
						 echo "<span class='rv_status' style='background-color:#B9CC0C;color:#ffffff;width:98%'> 支票 </span>";
						 echo "<br>".$orderinfo[$i]["card_no"];
						 echo "<br>".$orderinfo[$i]["card_info"];
					}
                                         else if($orderinfo[$i]["paytype"]==21)
					{
						 echo "<span class='rv_status' style='background-color:#33CC33;color:#ffffff;width:98%'> 電子支付 </span>";
						 echo "<br>".($orderinfo[$i]["card_type"]=="CVS"?"超商支付":$orderinfo[$i]["card_type"]);
						 echo "<br>".$orderinfo[$i]["card_info"];
					}
                                        
				}
				else 
				{
                                    /* 2021/10/14 拉掉
					if(($orderinfo[$i]["cust_email"]!="") && ($orderinfo[$i]["ordertype"]!='C') && (isset($card_img[$orderinfo[$i]["hotelid"]])) && ($card_img[$orderinfo[$i]["hotelid"]]!="") && ($card_img[$orderinfo[$i]["hotelid"]]!=NULL))
					{
						
						<a href="javascript:rv01_send_card_email(<? echo $orderinfo[$i]["orderno"]?>,<? echo $orderinfo[$i]["sysid"];?>);" class=button1>寄刷卡單</a>
						
					}
                                      */
                                        echo "繳款期限<BR>".str_replace(" ","<BR>",$orderinfo[$i]["pay_limit_date"]);
				}
				 ?>
			</td>
			<td class=mainrow valign=top>
			<div>
				<input type=hidden name=cur_orderno_<? echo $qty;?> value="<? echo $orderinfo[$i]["orderno"];?>">
				<textarea name='cur_handle_remark_<? echo $qty;?>' class=order_remark placeholder="請輸入訂單處理備註"><? echo $orderinfo[$i]["handle_remark"];?></textarea>
				<select name='cur_handle_status_<? echo $qty;?>' style='margin-left:3px;margin-top:5px'><? Str_Echo_Option_From_Array($sys_dealtype,$orderinfo[$i]["handle_status"],1,"","type","name");?></select>
				<? if($admin_authority[1]==1) { ?>
                                <input type=button value="處理" style='margin-left:3px;margin-top:3px' onclick="gotohandle('<? echo $qty;?>',<? echo $orderinfo[$i]["sysid"];?>)">
                                <? } ?>
				<? 
                                    
				if($orderinfo[$i]["ordertype"]=="C")
				{
					echo "<font color=ff0000>已取消</font>";
				}
                                else if($ischannel=='Y' &&   $admin_default_sysid > 0 &&  $accessuserinfo["superuser"]!='Y') echo "<font color=#0099ff>無法取消，請由平台取消</font>";
                                else if(((Date_CompareTwoDays($hoteldate,$orderinfo[$i]["endday"])<=0 || $orderinfo[$i]["ordertype"]!="Y") && $admin_authority[1]==1) || $accessuserinfo["superuser"]=='Y') {?>	
					<input type=button value="取消" style='margin-left:3px;margin-top:5px;border:1px solid #ff0000;background-color:#ffffff;color:#ff0000' class="order_cancel" qty='<?php echo $qty;?>' sysid='<? echo $orderinfo[$i]["sysid"];?>' orderno="<? echo $orderinfo[$i]["orderno"];?>">
				<? } ?>
				<span class='rv_status closeremark' style='float:right;height:15px;background-color:#FF0000;color:#ffffff;display:none;cursor:pointer;font-family:Sans-serif;font-weight:bold;margin-top:5px;margin-right:5px'> X </span>
			</div>	
			</td>
			<? if($history_show) { ?>
			<td class=mainrow>
				<? echo "訂 : ".(($orderinfo[$i]["create_id"]==0)?"客人":$sys_info_all_user[$orderinfo[$i]["create_id"]][1]);?><br>
				<? echo "改 : ".$sys_info_all_user[$orderinfo[$i]["modify_id"]][1];?>
				<?php if(($orderinfo[$i]["modifyday"]!="0000-00-00 00:00:00")) { ?><a href='javascript:goto_order_history(<?php echo $orderinfo[$i]["orderno"];?>,<?php echo $orderinfo[$i]["sysid"];?>)' class='button1'>記錄</a><?php } ?>
			</td>
			<? } ?>
			<? 
				$sum[0] += $orderinfo[$i]["totalprice"]+$other_order_info[$orderinfo[$i]["orderno"]];
				$sum[1] += $orderinfo[$i]["payprice"];
				$sum[2] += $orderinfo[$i]["totalprice"]+$other_order_info[$orderinfo[$i]["orderno"]]-$orderinfo[$i]["payprice"];
                                $sum[6] += $orderinfo[$i]["totalprice"];
                                $sum[7] += $other_order_info[$orderinfo[$i]["orderno"]];
                                $sum[8] += $commission;
				$qty++;
			 } 
			 if(($orderinfo[$i]["orderno"]!=$orderinfo[$i+1]["orderno"])||($orderinfo[$i]["sysid"]!=$orderinfo[$i+1]["sysid"]))
			 {
			 	if($order_id_count>1) { 
			 	?>
			 	<script>
			 	$("td#orderno_<? echo $orderinfo[$i]["orderno"];?>").attr("rowSpan",<? echo $order_id_count?>).siblings('.mainrow').attr("rowSpan",<? echo $order_id_count?>);
			 	</script>
			 	<?
			 	}
			 }
			 ?>
	</tr>
	<?
		$sum[3]+=$orderinfo[$i]["roomqty"];
                $sum[4]+=$orderinfo[$i]["oneprice"];
                $sum[5]+=(Date_CompareTwoDays($orderinfo[$i]["checkoutday"],$orderinfo[$i]["checkinday"]))*$orderinfo[$i]["roomqty"];
		$cur_orderno = $orderinfo[$i]["orderno"];
		//統計資料
                
                if($orderinfo[$i]["ordertype"]=='Y') {
                    $sum_ordertype[1][1]+=$orderinfo[$i]["roomqty"];
                }else if($orderinfo[$i]["ordertype"]=="C") {
                    $sum_ordertype[2][1]+=$orderinfo[$i]["roomqty"];
                }else if($orderinfo[$i]["ordertype"]=="W") {
                    $sum_ordertype[3][1]+=$orderinfo[$i]["roomqty"];
                }else {
                    $sum_ordertype[0][1]+=$orderinfo[$i]["roomqty"];
                }
                        
		if($orderinfo[$i]["custtype"]==1) $sum_group[1][1] += $orderinfo[$i]["roomqty"];
		else $sum_group[0][1] += $orderinfo[$i]["roomqty"];
		
		$sum_price[$orderinfo[$i]["priceid"]] += $orderinfo[$i]["roomqty"];
		$sum_room[ $orderinfo[$i]["roomid"] ] += $orderinfo[$i]["roomqty"];
		
		
		if($orderinfo[$i]["b2bid"]>0) $sum_cust_type[1][1]+= $orderinfo[$i]["roomqty"];
		else if($orderinfo[$i]["create_id"]==0) $sum_cust_type[2][1]+= $orderinfo[$i]["roomqty"];
		else $sum_cust_type[0][1]+= $orderinfo[$i]["roomqty"];
		$order_id_count++;
		$i++;
	}
	?>
		<tr bgcolor='fbf7e0'>
		<td colspan=6></td>
		<td class=tdstyle2>總計</td>
		<td colspan=2 align=right><font color="#ff0000"><? echo $sum[3];?></font> 間 共<font color="#0099ff"><? echo $sum[5];?></font> 間夜</td>
                
		<td  align=right colspan="2"><? echo "<font color=#ff9900>加</font>".number_format($sum[7]);
                            echo "<BR><font color=#0099ff>房</font>".number_format($sum[6]);
                            if( $sum[8] > 0 ){
                                echo "<BR><font color=#009933>佣</font>".number_format( $sum[8]);
                            }                            
                            echo "<BR><font color=#ff0000>總</font>".number_format($sum[0]);?></td>
		<td align=right><? echo number_format($sum[1]);?></td>
		<td colspan=<?php echo $history_show?"5":"4";?>></td>
	</tr>
	</table>
        <? if($pipa_mode==2) { ?>
        <font color="#ff000">(部份資料打 ** 以保護客戶隱私)</font>
        <? } ?>
	<BR>
	<table width=1000 cellspacing="0" cellpadding="0" border=0 >
	<tr>
		<td valign=top>
			<table width=350 class=tbstyle1 id=rv01tbl2 style='word-break:break-all;margin-left:5px;margin-top:5px'>
			<tr>
			<td class=tdstyle2 width=100>訂單狀況</td>
			<td class=tdstyle2>筆數</td>
                        <td class=tdstyle2>間數</td>
                        <td class=tdstyle2>總價</td>
			</tr>
			<tr>
			<td class=tdstyle1>正式</td>
			<td class=tdstyle3><? echo $sum_ordertype[1][0];?></td>
                        <td class=tdstyle3><? echo $sum_ordertype[1][1];?></td>
                        <td class=tdstyle3><? echo $sum_ordertype[1][2]>0 ? number_format($sum_ordertype[1][2]):""; ?></td>
			</tr>
			<tr>
			<td class=tdstyle1>未付款</td>
			<td class=tdstyle3><? echo $sum_ordertype[0][0];?></td>
                        <td class=tdstyle3><? echo $sum_ordertype[0][1];?></td>
                        <td class=tdstyle3><? echo $sum_ordertype[0][2]>0 ? number_format($sum_ordertype[0][2]):""; ?></td>
			</tr>
			<tr>
			<td class=tdstyle1>已取消</td>
			<td class=tdstyle3><? echo $sum_ordertype[2][0];?></td>
                        <td class=tdstyle3><? echo $sum_ordertype[2][1];?></td>
                        <td class=tdstyle3><? echo $sum_ordertype[2][2]>0 ? number_format($sum_ordertype[2][2]):""; ?></td>
			</tr>
			<? if($waiting_on=='Y') { ?>
			<tr>
			<td class=tdstyle1>候補</td>
			<td class=tdstyle3><? echo $sum_ordertype[3][0];?></td>
                        <td class=tdstyle3><? echo $sum_ordertype[3][1];?></td>
                        <td class=tdstyle3><? echo $sum_ordertype[3][2]>0 ? number_format($sum_ordertype[3][2]):""; ?></td>
			</tr>
			<? } ?>
			</table>
			
			<table width=350 class=tbstyle1 id=rv01tbl3 style='word-break:break-all;margin-left:5px;margin-top:5px'>
			<tr>
			<td class=tdstyle2 width=100>訂單來源</td>
			<td class=tdstyle2>筆數</td>
			<td class=tdstyle2>間數</td>
                        <td class=tdstyle2>總價</td>
			</tr>
			<tr>
			<td class=tdstyle1>企業訂房</td>
			<td class=tdstyle3><? echo $sum_cust_type[1][0];?></td>
			<td class=tdstyle3><? echo $sum_cust_type[1][1];?></td>
                        <td class=tdstyle3><? echo $sum_cust_type[1][2]>0 ? number_format($sum_cust_type[1][2]):""; ?></td>
			</tr>
			<tr>
			<td class=tdstyle1>網路訂房</td>
			<td class=tdstyle3><? echo $sum_cust_type[2][0];?></td>
			<td class=tdstyle3><? echo $sum_cust_type[2][1];?></td>
                        <td class=tdstyle3><? echo $sum_cust_type[2][2]>0 ? number_format($sum_cust_type[2][2]):""; ?></td>
			</tr>
			<tr>
			<td class=tdstyle1>一般訂房</td>
			<td class=tdstyle3><? echo $sum_cust_type[0][0];?></td>
			<td class=tdstyle3><? echo $sum_cust_type[0][1];?></td>
                        <td class=tdstyle3><? echo $sum_cust_type[0][2]>0 ? number_format($sum_cust_type[0][2]):""; ?></td>
			</tr>
			</table>
			
			<table width=350 class=tbstyle1 id=rv01tbl4 style='word-break:break-all;margin-left:5px;margin-top:5px'>
			<tr>
			<td class=tdstyle2 width=100>團散別</td>
			<td class=tdstyle2>筆數</td>
			<td class=tdstyle2>間數</td>
                        <td class=tdstyle2>總價</td>
			</tr>
			<tr>
			<td class=tdstyle1>團體</td>
			<td class=tdstyle3><? echo $sum_group[1][0];?></td>
			<td class=tdstyle3><? echo $sum_group[1][1];?></td>
                        <td class=tdstyle3><? echo $sum_group[1][2]>0 ? number_format($sum_group[1][2]):""; ?></td>
			</tr>
			<tr>
			<td class=tdstyle1>散客</td>
			<td class=tdstyle3><? echo $sum_group[0][0];?></td>
			<td class=tdstyle3><? echo $sum_group[0][1];?></td>
                        <td class=tdstyle3><? echo $sum_group[0][2]>0 ? number_format($sum_group[0][2]):""; ?></td>
			</tr>
			</table>
		</td>
		<td valign=top>
			<table width=250 class=tbstyle1 id=rv01tbl5 style='word-break:break-all;margin-left:5px;margin-top:5px'>
			<tr>
			<td class=tdstyle2 width=100>預計人數</td>
			<td class=tdstyle3><? echo $sum_people[0]+$sum_people[1];?></td>
			</tr>
			<tr>
			<td class=tdstyle1>大人</td>
			<td class=tdstyle3><? echo $sum_people[0];?></td>
			</tr>
			<tr>
			<td class=tdstyle1>小孩</td>
			<td class=tdstyle3><? echo $sum_people[1];?></td>
			</tr>
			</table>
			
			<table width=250 class=tbstyle1 id=rv01tbl6 style='word-break:break-all;margin-left:5px;margin-top:5px'>
			<tr>
			<td class=tdstyle2 width=100>交通方式</td>
			<td class=tdstyle2>筆數</td>
			<td class=tdstyle2>車數</td>
			</tr>
			<tr>
			<td class=tdstyle1>大眾交通工具</td>
			<td class=tdstyle3><? echo $sum_traffic[0][0];?></td>
			<td class=tdstyle3></td>
			</tr>
			<tr>
			<td class=tdstyle1>自行開車</td>
			<td class=tdstyle3><? echo $sum_traffic[1][0];?></td>
			<td class=tdstyle3><? echo $sum_traffic[1][1];?></td>
			</tr>
			<tr>
			<td class=tdstyle1>旅行社遊覽車</td>
			<td class=tdstyle3><? echo $sum_traffic[2][0];?></td>
			<td class=tdstyle3><? echo $sum_traffic[2][1];?></td>
			</tr>
			<tr>
			<td class=tdstyle1>接送</td>
			<td class=tdstyle3><? echo $sum_traffic[3][0];?></td>
			<td class=tdstyle3></td>
			</tr>
			</table>
		</td>
		<td valign=top>
			<table width=350 class=tbstyle1 id=rv01tbl7 style='word-break:break-all;margin-left:5px;margin-top:5px'>
			<tr>
			<td class=tdstyle2 width=25>代號</td>
			<td class=tdstyle2>專案名稱</td>
			<td class=tdstyle2 width=50>間數</td>
			</tr>
			<?
				$price_count = count($sum_price);
				
				foreach($sum_price as $buffer_priceid => $buffer_roomqty)
				{
					if($buffer_roomqty)
					{
						?>
						<tr>
						<td class=tdstyle1><? echo $buffer_priceid;?></td>
						<td class=tdstyle1 style='text-align:left'><? echo $buffer_priceinfo[$buffer_priceid];?></td>
						<td class=tdstyle3><? echo $buffer_roomqty;?></td>
						</tr>
						<?
						
					}
				}
			?>
			</table>
		</td>
               
		<td valign=top>
                    <?php if($hotelid>0) { ?> 
			<table width=150 class=tbstyle1 id=rv01tbl8 style='word-break:break-all;margin-left:5px;margin-top:5px'>
			<tr>
			<td class=tdstyle2 width=100>房型</td>
			<td class=tdstyle2 width=50>間數</td>
			</tr>
			<?
				$room_count = count($sum_room);
				
				foreach($sum_room as $buffer_roomid => $buffer_roomqty)
				{
					if($buffer_roomqty>0)
					{
						?>
						<tr>
						<td  class=tdstyle1><? echo $buffer_roominfo[$hotelid."-".$buffer_roomid]["room_symbol"];?></td>
						<td class=tdstyle3><? echo $buffer_roomqty;?></td>
						</tr>
						<?
						
					}
					
				}
			?>
			</table>
                    <? } ?>
		</td>
	</tr>
	</table>
	<?
	}
	?>
	</form>
	</div>
</div>
<script>
        function detectIE9_order() {
            var ua = window.navigator.userAgent;
            var msie = ua.indexOf('MSIE ');
            var trident = ua.indexOf('Trident/');

            if (msie > 0) {
                
                // IE 10 or older => return version number
                if(parseInt(ua.substring(msie + 5, ua.indexOf('.', msie)), 10) < 9 )
                {
                    
                    return true;
                }
                else return false;
            }
            else return false;
        }
	$("textarea.order_remark").each(function(){
		var buffer_height=$(this).height();
		if(buffer_height<$(this).parent().parent().height()-30)
		{
			$(this).height($(this).parent().parent().height()-30);
		}
		});
	$("textarea.order_remark").click(function(){
		$("div.remarkdiv textarea").width($("div.remarkdiv").parent().width());
		$("div.remarkdiv textarea").height($("div.remarkdiv").parent().height()-20);
		$("div.remarkdiv span.closeremark").hide();
		$("div.remarkdiv").removeClass("remarkdiv");
		$(this).parent().addClass("remarkdiv");
		$(this).height($(this).parent().height()-30).width($(this).parent().width());
		$(this).parent().children("span.closeremark").show();
                $(this).parent().children(".order_cancel").hide();
		});
	$("span.closeremark").click(function(){
		$("div.remarkdiv textarea").width($("div.remarkdiv").parent().width());
		$("div.remarkdiv textarea").height($("div.remarkdiv").parent().height()-20);
		$(this).parent().removeClass("remarkdiv");
                $(this).parent().children(".order_cancel").show();
		$(this).hide();
		});
	change_fromtype();
        $(".order_cancel").click(function(){
         
            var theform = document.orderform;
            var orderno = $(this).attr("orderno");
            var sysid = $(this).attr("sysid");
                      var show_content ="<iframe name=cancel_frame id=cancel_frame width=780 height=600 frameborder=0 border=0 cellspacing=0   src=''></iframe>";
		sysMain_ShowMsg(show_content,"","cancel_frame","","","","","","1","sysMain_hide_dark_background");
			theform.target = "cancel_frame";
			theform.orderno.value=orderno;
			theform.sysid.value=sysid;
                       
                        theform.action = "rv01_orderinfo_cancel_check.php";
                       
			theform.submit();
        });
	document.searchform.fromtype.value = '<? echo $fromtype;?>';
        <? if($hotelid>0) { ?>
        $("#price_filter").keyup(function(){
           if($(this).val()!="" && $(this).val().charCodeAt(($(this).val().length-1))!=12288)
           {
               rv01_price_info_set(0);
           }
           else if($(this).val()=="") rv01_price_info_set(0);
        });
        rv01_price_info_set(<? echo $priceid;?>);
        <? } ?>
        $(function(){
        var badBrowser = false;   
        if(navigator.appName.indexOf("Internet Explorer")!=-1){     //yeah, he's using IE
            if(detectIE9_order())
            {
                badBrowser =true;
            }
        } 
        if(badBrowser){
           
           $(".td_powertip").each(function(){
              if($(this).attr("title") && $(this).attr("title")!="")
              {
                  $(this).attr("title",$(this).attr("title").replace(/\<br \/\>/g,""));
              }    
           });
        }
        else
        {    
            $(".td_powertip").powerTip({ placement: 'e' });    
        }
        
        if(is_touch_device())
        {
            $("span.menubutton").click(function()
            {
                $("div.menudiv").hide();
                $("td#orderno_"+$(this).attr("orderno")+" div.menudiv").show();
            });
            
            $("body").bind("click",function(event){
                if($(event.target).attr("class")!="unclosemenu")
                {    
                    $("div.menudiv").hide();
                }    
            });
        }
        else
        {
            $("span.menubutton").hide();
        }
        
         $("td.menutd").mouseover(function(){
               $(this).children("div.menudiv").show(); 
            }).mouseout(function(){
               $(this).children("div.menudiv").hide();  
            });
       
        });
        $("#b2b_filter").keyup(function(){
           
           if($(this).val()!="" && $(this).val().charCodeAt(($(this).val().length-1))!=12288)
           {
               rv01_b2b_info_set(0);
           }
           else if($(this).val()=="" && buffer_b2b_name!="")
           {    
               rv01_b2b_info_set(0);
           }
           buffer_b2b_name = $(this).val();
        });
        $("#filter_div a").mouseover(function(){
           var now_func = $(this).attr("functype");
       
           if(now_func=="msg")
           {    
               $("#filter_msg").show().html($(this).attr("remark"));
               $("#filter_traffic").hide();
               $("#filter_mms").hide();
           }    
           else if(now_func=="traffic")
           {    
               $("#filter_msg").hide().html("");
               $("#filter_traffic").show();
               $("#filter_mms").hide();
           }    
           else if(now_func=="mms")
           {    
               $("#filter_msg").hide().html(""); 
               $("#filter_traffic").hide();
               $("#filter_mms").show();
           }    
        });
        $("input:checkbox#has_deposit").click(function(){
           if($(this).prop("checked"))
           {
               $("select#haspay_rate").show();
           }
           else
           {
               $("select#haspay_rate").hide();
           }    
        });
       $("span#default_set_button").mouseover(function(){
          $(this).find("div").show(); 
       }).mouseout(function(){
           $(this).find("div").hide();
       });
</script>
		<? include("../inc/inc_loading_end.php");?>
<?
	include_once("../inc/index_end.php");
?>