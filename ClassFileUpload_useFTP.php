/*

고수님들 많은 가르침....부탁 합니당...꾸뻑...ㅠ.ㅠ 
난 언제나 고수 되보나...ㅠ.ㅠ


######################################################################

작 성 자 : 은랑

파 일 명 : ClassFileUpload.php

기 능 -----------------------------------------------------------

- include Class File

제 작 : 2005 / 07

주 의 사 항 : 작성자는 이 File을 사용함으로서 발생하는 어떤 결과에도 책임이 없습니다.

작성자는 업데이트의 책임이 없음을 알려드립니다.

이 File의 일부 또는 전체 내용은 작성자와 사전 협의 없이

영리 추구 및 기타 용도로 사용할 수 없습니다.

별도로 사용하고자 하실 경우는 아래 전자우편으로 문의 주시기 바라며

아울러 버그 신고 또한 아래 전자우편으로 부탁드리겠습니다.

전 자 우 편 : a84146943@gmail.com

수정작업 정보 -----------------------------------------------------------

- 수정일자 : 0000 / 00 / 00
- 수정사유 :
- 수정범위 : Line 000 ~ Line 000 -> Line 000 ~ Line 000

- 수정이전 소스 :

- 수정이후 소스 :



######################################################################
*/

##### File_UpLoad class #####
/*
# 사용방법
# 배열에 저장될 인수들을 입력한다.
# 사용할 전송 방법에 따라 아래 HTTP 또는 FTP 둘중 하나의 함수를 선택한다.
# FTP의 경우 FTP_Method 함수 내부의 경로를 시스템에 적합하도록 수정한다.

# File Upload Class Run
$arr_arg = array
(
"File_resources" => $HTTP_POST_FILES[upload], # Target File
"File_Size" => 1048576, # Max File Size
"SavePath" => "upload_file", # File Save Path
"FileNameHead" => $HTTP_POST_VARS[bbs_flag], # File Name Head 
"FTPServer" => "********", # FTP ADDRESS
"FTPport" => "**", # FTP PORT
"FTPid" => "********", # FTP ID
"FTPpw" => "********" # FTP PASSWORD
); // end array


$File_UpLoader = new File_UpLoad($arr_arg); # Class Object 생성
$return_value = $File_UpLoader -> HTTP_Method(); # HTTP 전송 파일 처리 함수
# $return_value = $File_UpLoader -> FTP_Method(); # FTP 전송 파일 처리 함수

# $return_value[file_name] 소스파일명
# $return_value[file_path] SavePath 에 따른 저장경로 및 실제 저장된 파일명

*/
class File_UpLoad
{

##### 변수 설정 #####
var $File_resources; # Target File
var $File_Size; # Max File Size
var $SavePath; # File Save Path
var $FileNameHead; # File Name Head
var $FTP_Server;
var $FTP_port;
var $FTP_id;
var $FTP_pw;





##### 생성자 함수 #####
Function File_UpLoad($arr_arg)
{
$this->File_resources = $arr_arg[File_resources];
$this->File_Size = $arr_arg[File_Size];
$this->SavePath = $arr_arg[SavePath];
$this->FileNameHead = $arr_arg[FileNameHead];
$this->FTP_Server = $arr_arg[FTPServer];
$this->FTP_port = $arr_arg[FTPport];
$this->FTP_id = $arr_arg[FTPid];
$this->FTP_pw = $arr_arg[FTPpw];

}// End Function




##### HTTP 형식 파일 UpLoad 실행 함수 #####
Function HTTP_Method()
{
switch($this->File_resources[size] > $this->File_Size)
{
case TRUE: alert_back($Size."b 미만의 파일만 UpLoad 가능합니다."); break;
case FALSE:
$return_value[file_name] = $this->File_resources[name];
$temp = explode(".",$this->File_resources[name]);
$return_value[file_path] = $this->SavePath."/".uniqid($this->FileNameHead."_").".".$temp[(sizeof($temp) - 1)];
$result = copy($this->File_resources[tmp_name], $return_value[file_path]);
if($result == FALSE) { alert_back("File Upload 중 오류 발생 \n 관리자에게 문의하십시오."); }// end if
break;
}// end switch

return $return_value;
}// end Function




##### FTP 형식 파일 UpLoad 실행 함수 #####
Function FTP_Method()
{
switch($this->File_resources[size] > $this->File_Size)
{
case TRUE: alert_back($Size."b 미만의 파일만 UpLoad 가능합니다."); break;
case FALSE:
$return_value[file_name] = $this->File_resources[name];
$temp = explode(".",$this->File_resources[name]);
$FTP_SaveFileName = uniqid($this->FileNameHead."_").".".$temp[(sizeof($temp) - 1)];
$return_value[file_path] = $this->SavePath."/".uniqid($this->FileNameHead."_").".".$temp[(sizeof($temp) - 1)];
$conn_id = ftp_connect($this->FTP_Server, $this->FTP_port);
ftp_login($conn_id, $this->FTP_id, $this->FTP_pw);

# passive mode on Setting
# ftp_pasv($conn_id, true);

# FTP 접근 경로를 설정해준다.
$upload_dir = "[upload_dir]".$this->SavePath;

ftp_chdir($conn_id, $upload_dir);

# upload the file
$upload = ftp_put($conn_id, $FTP_SaveFileName, $this->File_resources[tmp_name], FTP_BINARY);

ftp_close($conn_id);
break;
}// end switch

return $return_value;

}// end Function



##### alert AND back #####
Function alert_back($msg)
{
?><script language="ⓙavascript">alert("<?=$msg?>");history.go(-1);</script><?
exit;
}# End Function alert_mag($msg)
}// end class
