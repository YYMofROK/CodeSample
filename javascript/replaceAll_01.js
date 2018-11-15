
////////////////////////////////////////////////////////////
//
/   @ ReplaceAll 함수 구현
String.prototype.replaceAll = function(searchStr, replaceStr) {
     return this.split(searchStr).join(replaceStr);
}
 
 
 
//  @   사용샘플
 
//  var temp = "qwe@asead@123@ert";
 
//  var temp1 = temp.replaceAll("@", "$");
