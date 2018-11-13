<?php
//  ######################################################################
 
//  작 성 자 : 은랑
 
//  파 일 명 : Calendar.php
 
//  기 능 -----------------------------------------------------------
 
//  - 만년 달력 (공휴일 / 윤년 제외)
 
//  제 작 : 2004 / 09
 
//  주 의 사 항 : 작성자는 이 code를 사용함으로서 발생하는 어떤 결과에도 책임이 없습니다.
 
//  작성자는 업데이트의 책임이 없음을 알려드립니다.
 
//  전 자 우 편 : a84146943@gmail.com
 
//  수정작업 정보 -----------------------------------------------------------
 
//  - 수정일자 : 0000 / 00 / 00
//  - 수정사유 :
//  - 수정범위 : Line 000 ~ Line 000 -> Line 000 ~ Line 000
 
//  - 수정이전 소스 :
 
//  - 수정이후 소스 :
 
 
 
//  ######################################################################
 
$today = date("Y-m-j");
$arr_today_info = explode("-",$today);
 
$year = $arr_today_info[0];
$month = $arr_today_info[1];
$day = $arr_today_info[2];
 
# 월 시작 일자 요일 정보 산출
$first_day = date("w",mktime(0,0,1,$month,1,$year));
 
# 전체 일자 산출
$last_day = date("t",mktime(0,0,1,$month,1,$year));
 
 
 
 
?>
  
<table border="1" cellspacing="0">
<tr>
<td colspan="7" align="center">
<font size="2"><b>오늘은 <?=$year; ?>년 <?=$month; ?>월 <?=$day; ?>일 입니다.</b></font>
</td>
</tr>
<tr>
<td align="center" width="30"><font size="2" color="red">일</font></td>
<td align="center" width="30"><font size="2" color="black">월</font></td>
<td align="center" width="30"><font size="2" color="black">화</font></td>
<td align="center" width="30"><font size="2" color="black">수</font></td>
<td align="center" width="30"><font size="2" color="black">목</font></td>
<td align="center" width="30"><font size="2" color="black">금</font></td>
<td align="center" width="30"><font size="2" color="blue">토</font></td>
</tr>
<?
$max_line = ceil($last_day / 7);
 
for($cnt_line = 0 ; $max_line > $cnt_line ; $cnt_line++)
{
?><tr><?
for($cnt_column = 0 ; 7 > $cnt_column ; $cnt_column++)
{
$cell = $cell + 1;
 
switch ($first_day >= $cell)
{
case true: $day = " "; break;
case false:
 
$value = $cell - $first_day;

switch ($value > $last_day)
{
case true: $day = " "; break;
case false:
 
$day = $value;
switch ($cell % 7)
{
case 0: $color = "blue"; break;
case 1: $color = "red"; break;
default: $color = "black";
 
}// end switch
 
break;
}// end switch
 
break;
}// end switch
 
?><td align="center" width="30"><font size="2" color="<?=$color?>"><?=$day?></font></td><?
 
}// end for
?></tr><?
}// end for
 
?>
</table>
