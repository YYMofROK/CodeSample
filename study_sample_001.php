<?php
////////////////////////////////////////////////////////////////////
//
// @ HTML 과 PHP 연동 아울러 제어문 및 반복문에 대한 예제 입니다.
//
// @ 표를 이용해서 5 X 5 표를 만든다.
//
// @ 표의 각 셀에 * 을 하나씩 넣어서리 다이아몬드형을 만든다.
//
////////////////////////////////////////////////////////////////////
 
 
?>
  
<table border="1">
<?
$max_line  = 5;       // Line 최대값 지정
$max_column  = 5;  // column 최대값 지정
  
for($cnt_line=0; $cnt_line < $max_line; $cnt_line++)
{
 ?><tr><?
 switch ($cnt_line <= (ceil($max_line / 2)-1))
 {
  case true:
    
   for($cnt_column=0; $cnt_column < $max_column ;$cnt_column ++)
   {
     
    $target_value1 = abs($cnt_column-(ceil($max_column / 2)-1));
    $target_value2 = $cnt_line;
     
     
    switch($target_value1 <= $target_value2)
    {
     case true: ?><td align="center" width="20">*</td><?  break;
     case false: ?><td align="center" width="20"> </td><? break;
    }// end switch
   }// end for
    
   
  break;
  case false:
   
    
   for($cnt_column=0; $cnt_column < $max_column ;$cnt_column ++)
   {
     
     
     
     
    $target_value1 = abs($cnt_column-(ceil($max_column / 2)-1));
    $target_value2 = $max_line - ($cnt_line +1);
     
    switch($target_value1 <= $target_value2)
    {
     case true: ?><td align="center" width="20">*</td><?  break;
     case false: ?><td align="center" width="20"> </td><? break;
    }// end switch
     
   }// end for
    
    
    
  break;
   
 }// end switch
?></tr><?
}// end for
 
?>
<table>
