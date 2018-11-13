<?php
//  ######################################################################
 
//  작 성 자 : 은랑

//	버블정렬 예제 샘플파일
 
//  ######################################################################
 

$arr_data       =   array(78, 68, 15, 35, 46, 79, 95, 3, 5, 2, 1);
$loopCnt1       =   0;
$loopCntlimit1  =   count($num);
 
$loopCnt2       =   0;
$loopCntlimit2  =   count($num) + 1;
for($loopCnt1=0; $loopCntlimit1>$loopCnt1; $loopCnt1++)
{
    for($loopCnt2=0; $loopCntlimit2>$loopCnt2; $loopCnt2++)
    {
        $temp   =   "";
        if($arr_data[$loopCnt1] > $arr_data[$loopCnt2])
        {
            $temp   =   $arr_data[$loopCnt1];
            $arr_data[$loopCnt1]    =   $arr_data[$loopCnt2];
            $arr_data[$loopCnt2]    =   $temp;
        }// end if
         
    }// end for
}// end for
echo "<pre>";
    var_dump( $arr_data );
echo "</pre>";
?>
