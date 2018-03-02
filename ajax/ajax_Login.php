<?php 
include("../inc/include.php");
if($_GET['act'] == "login"){
		$username = $_GET['name'];
		$password = password($_GET['password']);

		$member_row = $db->get_one("member","Email='$username' and Password='$password'");
		$member_row_mobile = $db->get_one("member","Supplier_Mobile='$username' and Password='$password'");
		$member_row_name = $db->get_one("member","UserName='$username' and Password='$password'");
		if($member_row){
			if($member_row['IsSupplier'] =='1'){
					$_SESSION['UserName'] = $username;
					$_SESSION['member_MemberId']=$member_row['MemberId'];
					$_SESSION['Email']=$member_row['Email'];
					$_SESSION['Title']=$member_row['Title'];
					$_SESSION['FirstName']=$member_row['FirstName'];
					$_SESSION['LastName']=$member_row['LastName'];
					$_SESSION['Password']=$member_row['Password'];
					$_SESSION['Level']=$member_row['MemberLevel'];
					$_SESSION['IsSupplier']=$member_row['IsSupplier'];
					$_SESSION['Is_Business_License']=$member_row['Is_Business_License'];

					$db->update('member', "MemberId='{$member_row['MemberId']}'", array(
							'LastLoginIp'	=>	get_ip(),
							'LastLoginTime'	=>	$service_time,
							'LoginTimes'	=>	$member_row['LoginTimes']+1
						)
					);
					$db->insert('member_login_log', array(
							'MemberId'	=>	(int)$_SESSION['MemberId'],
							'LoginTime'	=>	$service_time,
							'LoginIp'	=>	get_ip()
						)
					);
					echo "0";
					exit;
				/*elseif($member_row['IsUse'] == '1'){
					echo "2";
					exit;
				}
				elseif($member_row['IsUse'] == '0'){
					echo "3";
					exit;
				}*/
			}else{
				$_SESSION['UserName'] = $username;
				
				$_SESSION['member_MemberId']=$member_row['MemberId'];
				$_SESSION['Email']=$member_row['Email'];
				$_SESSION['Title']=$member_row['Title'];
				$_SESSION['FirstName']=$member_row['FirstName'];
				$_SESSION['LastName']=$member_row['LastName'];
				$_SESSION['Password']=$member_row['Password'];
				$_SESSION['Level']=$member_row['MemberLevel'];
				$_SESSION['IsSupplier']=$member_row['IsSupplier'];

				$db->update('member', "MemberId='{$member_row['MemberId']}'", array(
						'LastLoginIp'	=>	get_ip(),
						'LastLoginTime'	=>	$service_time,
						'LoginTimes'	=>	$member_row['LoginTimes']+1
					)
				);
				$db->insert('member_login_log', array(
						'MemberId'	=>	(int)$_SESSION['MemberId'],
						'LoginTime'	=>	$service_time,
						'LoginIp'	=>	get_ip()
					)
				);
				echo "0";
				exit;
			}
		}elseif($member_row_mobile){
			if($member_row_mobile['IsSupplier'] =='1'){
				
					$_SESSION['UserName'] = $username;
					$_SESSION['member_MemberId']=$member_row_mobile['MemberId'];
					$_SESSION['Email']=$member_row_mobile['Email'];
					$_SESSION['Title']=$member_row_mobile['Title'];
					$_SESSION['FirstName']=$member_row_mobile['FirstName'];
					$_SESSION['LastName']=$member_row_mobile['LastName'];
					$_SESSION['Password']=$member_row_mobile['Password'];
					$_SESSION['Level']=$member_row_mobile['MemberLevel'];
					$_SESSION['IsSupplier']=$member_row_mobile['IsSupplier'];
					$_SESSION['Is_Business_License']=$member_row_mobile['Is_Business_License'];

					$db->update('member', "MemberId='{$member_row_mobile['MemberId']}'", array(
							'LastLoginIp'	=>	get_ip(),
							'LastLoginTime'	=>	$service_time,
							'LoginTimes'	=>	$member_row_mobile['LoginTimes']+1
						)
					);
					$db->insert('member_login_log', array(
							'MemberId'	=>	(int)$_SESSION['MemberId'],
							'LoginTime'	=>	$service_time,
							'LoginIp'	=>	get_ip()
						)
					);
					
					echo "0";
					exit;
				/*elseif($member_row_mobile['IsUse'] == '1'){
					echo "2";
					exit;
				}
				elseif($member_row_mobile['IsUse'] == '0'){
					echo "3";
					exit;
				}*/
			}else{
				$_SESSION['UserName'] = $username;
				$_SESSION['member_MemberId']=$member_row_mobile['MemberId'];
				$_SESSION['Email']=$member_row_mobile['Email'];
				$_SESSION['Title']=$member_row_mobile['Title'];
				$_SESSION['FirstName']=$member_row_mobile['FirstName'];
				$_SESSION['LastName']=$member_row_mobile['LastName'];
				$_SESSION['Password']=$member_row_mobile['Password'];
				$_SESSION['Level']=$member_row_mobile['MemberLevel'];
				$_SESSION['IsSupplier']=$member_row_mobile['IsSupplier'];
				$db->update('member', "MemberId='{$member_row_mobile['MemberId']}'", array(
						'LastLoginIp'	=>	get_ip(),
						'LastLoginTime'	=>	$service_time,
						'LoginTimes'	=>	$member_row_mobile['LoginTimes']+1
					)
				);
				$db->insert('member_login_log', array(
						'MemberId'	=>	(int)$_SESSION['MemberId'],
						'LoginTime'	=>	$service_time,
						'LoginIp'	=>	get_ip()
					)
				);
				
				echo "0";
				exit;
			}
		}elseif($member_row_name){
			if($member_row_name['IsSupplier']=='1'){
					$_SESSION['UserName'] = $username;
					$_SESSION['member_MemberId']=$member_row_name['MemberId'];
					$_SESSION['Email']=$member_row_name['Email'];
					$_SESSION['Title']=$member_row_name['Title'];
					$_SESSION['FirstName']=$member_row_name['FirstName'];
					$_SESSION['LastName']=$member_row_name['LastName'];
					$_SESSION['Password']=$member_row_name['Password'];
					$_SESSION['Level']=$member_row_name['MemberLevel'];
					$_SESSION['IsSupplier']=$member_row_name['IsSupplier'];
					$_SESSION['Is_Business_License']=$member_row_name['Is_Business_License'];
					$db->update('member', "MemberId='{$member_row_name['MemberId']}'", array(
							'LastLoginIp'	=>	get_ip(),
							'LastLoginTime'	=>	$service_time,
							'LoginTimes'	=>	$member_row_name['LoginTimes']+1
						)
					);
					$db->insert('member_login_log', array(
							'MemberId'	=>	(int)$_SESSION['MemberId'],
							'LoginTime'	=>	$service_time,
							'LoginIp'	=>	get_ip()
						)
					);
					echo "0";
					exit;
				/*elseif($member_row_name['IsUse'] == '1'){
					echo "2";
					exit;
				}
				elseif($member_row_name['IsUse'] == '0'){
					echo "3";
					exit;
				}*/
			}else{
				$_SESSION['UserName'] = $username;
				$_SESSION['member_MemberId']=$member_row_name['MemberId'];
				$_SESSION['Email']=$member_row_name['Email'];
				$_SESSION['Title']=$member_row_name['Title'];
				$_SESSION['FirstName']=$member_row_name['FirstName'];
				$_SESSION['LastName']=$member_row_name['LastName'];
				$_SESSION['Password']=$member_row_name['Password'];
				$_SESSION['Level']=$member_row_name['MemberLevel'];
				$_SESSION['IsSupplier']=$member_row_name['IsSupplier'];

				$db->update('member', "MemberId='{$member_row_name['MemberId']}'", array(
						'LastLoginIp'	=>	get_ip(),
						'LastLoginTime'	=>	$service_time,
						'LoginTimes'	=>	$member_row_name['LoginTimes']+1
					)
				);
				$db->insert('member_login_log', array(
						'MemberId'	=>	(int)$_SESSION['MemberId'],
						'LoginTime'	=>	$service_time,
						'LoginIp'	=>	get_ip()
					)
				);
				echo "0";
				exit;
			}
		}else{
			echo "1";
			exit;
		}
}
?>