<?php
/////////////////////////////////////////////////////////////////////////
//
//
// @ 특정 문자열을 기준으로 중간에 필요한 문자열 추출하기 샘플
//
// @ [ ] <= 안의 문자열만 가져오기 샘플 입니다.
//
/////////////////////////////////////////////////////////////////////////
  
// @ 대상 문자열 샘플
$str = "1111111111[gildong.hong@lge.com]111111111";
  
// @ Cutting 시작 위치
$startPoint = strpos($str, '[') + 1;
  
// @ Cutting 대상 문자열 길이
$length = strpos($str, ']') - $startPoint;
  
// @ Cutting
$str_result = substr($str, $startPoint, $length);
  
  
echo "처리대상 : ".$str;
echo "</br></br></br></br>";
echo "처리결과 : ".$str_result;
  
?>
