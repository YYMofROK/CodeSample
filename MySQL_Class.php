<? 
/* 
###################################################################### 

작	성	자 :	a84146943@gmail.com 

파	일	명 :	MySQL_Class.php 

기	능	----------------------------------------------------------- 

-	MySQL Query 문 처리 모듈 

제	작 : 2006 / 11 

공  지  사  항 :	

작성자는 이 File을 사용함으로서 발생하는 어떤 결과에도 책임이 없습니다. 

작성자는 업데이트의 책임이 없음을 알려드립니다. 

이 File의 일부 또는 전체 내용은 작성자와 사전 협의 없이 

영리 추구 및 기타 용도로 사용할 수 없습니다. 

별도로 사용하고자 하실 경우는 아래 전자우편으로 문의 주시면 99% 동의할 예정입니다. 

아울러 버그 신고 또한 아래 전자우편으로 부탁드리겠습니다. 

전  자  우  편 : 84146943@hanafos.com 

###################################################################### 
*/ 
CLASS MySQL_manager 
{ 
VAR $DbmsType, $HostName, $HostID, $HostPW, $DbName; 

//	-----	CONSTRUCTOR	----- 
Function MySQL_Manager($DbmsKind, $HostName, $HostID, $HostPW, $DbName) 
{ 
$this -> DbmsKind	=	STRTOUPPER($DbmsKind); 
$this -> HostName	=	TRIM($HostName); 
$this -> HostID	=	TRIM($HostID); 
$this -> HostPW	=	TRIM($HostPW); 
$this -> DbName	=	TRIM($DbName); 

switch($this -> DbmsKind) 
{ 
case "MYSQL": 
//	TRUE 
break; 
default: 
echo "<BR>----- MySQL 이외의 DBMS 는 지원하지 않습니다. -----<BR>"; 
}//	end switch 

}//	end Function 





//	-----	DBMS_CONNECT	----- 
Function DBMS_CONNECT() 
{ 
$this -> DbConnetion	=	MYSQL_CONNECT($this -> HostName, $this -> HostID, $this -> HostPW, $this -> DbName) or DIE("MySQL 접속 실패"); 
MYSQL_SELECT_DB($this -> DbName); 
}//	end Function 





//	-----	EXECUTE SQL	----- 
Function EXECUTE_SQL($QUERY) 
{ 
$this -> QUERY	=	$QUERY; 
$Result	=	MYSQL_QUERY($this -> QUERY, $this->DbConnetion); 

switch(MYSQL_ERRNO() == 0) 
{ 
case TRUE: 
//	정상처리 
break; 
case FALSE: 
//	SQL Query Error 
$this -> DBMS_Log(); 
break; 
}//	end switch 

Return $Result; 
}//	end Function 





//	-----	DBMS_CONNECT	----- 
Function DBMS_CLOSE() 
{ 
$Temp	=	MYSQL_CLOSE($this -> DbConnetion); 
}//	end Function 





//	-----	DBMS_Log	----- 
Function DBMS_Log() 
{ 
$Temp	=	EXPLODE(" ", MICROTIME()); 
$MicroTime	=	DATE("Y.m.d H:i:s", $Temp[1])." ".$Temp[0]; 

$Query_Log	=	"[".$MicroTime."]\r\n"; 
$Query_Log	=	$Query_Log.$this -> QUERY."\r\n"; 
$Query_Log	=	$Query_Log.MYSQL_ERROR()."\r\n"; 
$Query_Log	=	$Query_Log."-----------------------------------------------------------------------\r\n"; 

$FileCon	=	FOPEN($_SERVER["DOCUMENT_ROOT"]."/SQLerrorLog/".DATE("Ymd").".txt", "a"); 
FWRITE($FileCon, $Query_Log); 
FCLOSE($FileCon); 
}//	end function 





//	-----	Table Field information	----- 
Function Field_information($tblName) 
{ 
$Result	=	MYSQL_LIST_FIELDS($this -> DbName,$tblName); 
$CntField	=	MYSQL_NUM_FIELDS($Result); 

For($Cnt = 0; $CntField > $Cnt; $Cnt++) 
{ 
$this -> FieldName[$Cnt]	=	MYSQL_FIELD_NAME($Result, $Cnt);	#	field name 
$this -> FieldType[$Cnt]	=	MYSQL_FIELD_TYPE($Result, $Cnt);	#	field type 
$this -> FieldFlags[$Cnt]	=	MYSQL_FIELD_FLAGS($Result, $Cnt);	#	field attribute 

$FieldResource[$Cnt]['name']	=	MYSQL_FIELD_NAME($Result, $Cnt);	#	field name 
$FieldResource[$Cnt]['type']	=	MYSQL_FIELD_TYPE($Result, $Cnt);	#	field type 
$FieldResource[$Cnt]['flags']	=	MYSQL_FIELD_FLAGS($Result, $Cnt);	#	field attribute 
}//	end For 

Return $FieldResource; 
}//	end Function 





//	-----	Create Insert Query	----- 
//	필드값 배열 형식 
//	배열키를 필드명으로 준다. 
//	Ex)$ArrFieldValue	=	array("필드명1"	=>	"필드값1","필드명2"	=>	"필드값2","필드명3"	=>	"필드값3") 
//	$Query	=	CreateSQL_INSERT($tblName, $ArrFieldValue) 
Function CreateSQL_INSERT($tblName, $ArrFieldValue) 
{ 
$Field_information	=	$this -> Field_information($tblName); 
$CntField	=	COUNT($this -> FieldName); 
$CntValueField	=	ARRAY_KEYS($ArrFieldValue); 
$CntValue	=	COUNT($ArrFieldValue); 

//	입력값 수량 검사 
switch($CntField == $CntValue) 
{ 
case TRUE: 
//	Normal 
break; 
case FALSE: 
DIE("[ 필드 수량 : ".$CntField." ]<br>[ 입력값 수 : ".$CntValue." ]<br>입력값 의 갯수와 필드의 수량이 일치하지 않습니다."); 
break; 
}//	end switch 

//	Field 명 검사 
For($Cnt = 0 ; $CntField > $Cnt ; $Cnt++) 
{ 
switch (IN_ARRAY($CntValueField[$Cnt], $this -> FieldName)) 
{ 
case FALSE: 

DIE("[ ".$Field_information[$Cnt]." ] 필드명 오류 입니다."); 

break; 
}//	end switch 
}//	end for 

$Query	=	"INSERT INTO ".$tblName." SET "; 
For($Cnt = 0 ; $CntField > $Cnt ; $Cnt++) 
{ 
switch(($CntField - 1) == $Cnt) 
{ 
case TRUE: 
$Query	=	$Query.$this -> FieldName[$Cnt]."='".$ArrFieldValue[$this -> FieldName[$Cnt]]."'"; 
break; 
case FALSE: 
$Query	=	$Query.$this -> FieldName[$Cnt]."='".$ArrFieldValue[$this -> FieldName[$Cnt]]."',"; 
break; 
}//	end switch 

}//	end For 

Return $Query; 

}//	end Function 





//	-----	Create UPDATE Query	----- 
//	필드값 배열 형식 
//	배열키를 필드명으로 준다. 
//	Ex)$ArrFieldValue	=	array("필드명1"	=>	"필드값1","필드명2"	=>	"필드값2","필드명3"	=>	"필드값3") 
//	$Query	=	CreateSQL_UPDATE($tblName, $ArrFieldValue, $SQL_WHERE) 
Function CreateSQL_UPDATE($tblName, $ArrFieldValue, $SQL_WHERE) 
{ 
$Field_information	=	$this -> Field_information($tblName); 
$CntField	=	COUNT($this -> FieldName); 
$CntValueField	=	ARRAY_KEYS($ArrFieldValue); 
$CntValue	=	COUNT($ArrFieldValue); 

//	Field 명 검사 
For($Cnt = 0 ; $CntField > $Cnt ; $Cnt++) 
{ 
switch (IN_ARRAY($CntValueField[$Cnt], $this -> FieldName)) 
{ 
case FALSE: 

DIE("[ ".$Field_information[$Cnt]." ] 필드명 오류 입니다."); 

break; 
}//	end switch 
}//	end for 

$Query	=	$Query."UPDATE ".$tblName." SET "; 
For($Cnt = 0 ; $CntField > $Cnt ; $Cnt++) 
{ 
switch(($CntField - 1) == $Cnt) 
{ 
case TRUE: 
$Query	=	$Query.$this -> FieldName[$Cnt]."='".$ArrFieldValue[$this -> FieldName[$Cnt]]."'"; 
break; 
case FALSE: 
$Query	=	$Query.$this -> FieldName[$Cnt]."='".$ArrFieldValue[$this -> FieldName[$Cnt]]."',"; 
break; 
}//	end switch 

}//	end For 

$Query	=	$Query." ".$SQL_WHERE; 

Return $Query; 
}//	end Function 

//	-----	Create DELETE Query	----- 
//	$Query	=	CreateSQL_DELETE($tblName, $SQL_WHERE) 
Function CreateSQL_DELETE($tblName, $SQL_WHERE) 
{ 
$Query	=	"DELETE FROM ".$tblName." ".$SQL_WHERE; 
Return $Query; 
}//	end Function 

}//	end CLASS 

/* 
//	환경설정	************************************************** 
1. error Log 기록관련 환경 설정 

  -> $_SERVER["DOCUMENT_ROOT"]/SQLerrorLog 디렉토리 생성	  
  -> $_SERVER["DOCUMENT_ROOT"]/SQLerrorLog 디렉토리 nobody write 권한 부여 
  
2. error Log 기록을 원하지 않을경우 
  
  
  -> Function EXECUTE_SQL($QUERY) 내부의 아래 구문에 대하여 아래와 같이 주석처리 또는 삭제 
  
    
//	switch(MYSQL_ERRNO() == 0) 
//	{ 
//	case TRUE: 
//	//	정상처리 
//	break; 
//	case FALSE: 
//	//	SQL Query Error 
//	$this -> DBMS_Log(); 
//	break; 
//	}//	end switch	  
  
  

$DbmsKind	=	"MySQL"; 
$HostName	=	"localhost"; 
$HostID	=	"**********"; 
$HostPW	=	"**********"; 
$DbName	=	"**********"; 

$MySQL_Manager	=	new MySQL_Manager($DbmsKind, $HostName, $HostID, $HostPW, $DbName); 

$MySQL_Manager	->	DBMS_CONNECT(); 


//	INSERT example	************************************************** 
$tblName	=	"test"; 
$ArrFieldValue	=	array("test" => "12345"); 
$insertQuery	=	$MySQL_Manager	->	CreateSQL_INSERT($tblName, $ArrFieldValue); 
$MySQL_Manager	->	EXECUTE_SQL($insertQuery); 


//	UPDATE example	************************************************** 
$tblName	=	"test"; 
$ArrFieldValue	=	array("test" => "56789"); 
$SQL_WHERE	=	"WHERE test='12345'"; 
$updateQuery	=	$MySQL_Manager	->	CreateSQL_UPDATE($tblName, $ArrFieldValue, $SQL_WHERE); 
$MySQL_Manager	->	EXECUTE_SQL($updateQuery); 


//	DELETE example	************************************************** 
$tblName	=	"test"; 
$SQL_WHERE	=	"WHERE test='12345'"; 
$deleteQuery	=	$MySQL_Manager	->	CreateSQL_DELETE($tblName, $SQL_WHERE); 
$MySQL_Manager	->	EXECUTE_SQL($deleteQuery); 


//	SELECT example	************************************************** 
$Query	=	"SELECT * FROM ".$tblName; 
$Query_WHERE	=	"WHERE test='1234'; 
$selectQuery	=	$Query." ".$Query_WHERE; 
$Result	=	$MySQL_Manager	->	EXECUTE_SQL($deleteQuery);	
$Row	=	MySQL_FETCH_ARRAY($Result); 


$MySQL_Manager	->	DBMS_CLOSE(); 

*/ 
------------------------------------------------------------------------------------------------ 
이렇게 Tip 에 글을 올려본지가 벌써 2년이 넘는듯...ㅠㅠ 

은랑 이라는 필명으로 글을 올렸었는데... 

지금 생각하면 부끄럽기만 하네요..ㅠㅠ 

이번에도 고수님들에게 도움을 청합니다. 

개선방향과 잘못된 코딩습관등 많은 가르침을 바랍니다...ㅠㅠ 
------------------------------------------------------------------------------------------------ 

INSERT UPDATE DELETE  에 대하여 쿼리문의 작성의 편의성을 조금 고려하였습니다. 

$ArrFieldValue	=	array 
( 
"필드명1"	=>	"필드값1", 
"필드명2"	=>	"필드값2", 
"필드명3"	=>	"필드값3" 
. 
. 
. 
) 

형식으로 필드명과 필드값을 입력하도록 하여 가독성을 높였습니다. 

그냥 코딩해서 문자열 연결하는 것과 무슨 차이냐고 하시면...OTL...ㅠㅠ 

다만 필드명과 필드값만 정확하면 INSERT 및 UPDATE 구문에서의 쉼표나 따옴표로 

발생하는 오류는 좀 줄어들지 않을까 해서 작성해 보았습니다. 

제 경험상으로는 코딩상의 편의성이 좀 개선되는 것 같던데... 

개인 취향에 따라 차이점이 있을듯 합니다. 

UPDATE 및 DELETE에서 WHERE 구문은 직접 작성하는 것 이상의 

방법이 도저히 없을듯...ㅠㅠ 

자동으로 pk 필드를 찾아서 pk 값만 넣는것도 생각해 봤는데... 

꼭 pk 값으로만 작업한다는 보장이 없는지라... 

결국 WHERE 절을 입력받는 형식으로 구현하였습니다. 

고수님들의 많은 가르침 바랍니다.
