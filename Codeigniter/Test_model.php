<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

  class Test_model extends CI_Model
  {

      public $last_insert_id	=	null;
	    
      public function __construct()
      {
        parent::__construct();
      }//	end function

      public function insert_01( $arrData )
      {
      ///////////////////////////////////////////////////////////////////////////
      //  @   $arrData 입력값 예시
      /*
        $arrData	=	array(
                          "tbl_name"	=> "test_tbl"
                          ,"arr_data"	=>	array(
                                              'fieldName_01'	=>	'[VALUE]'
                                              'fieldName_02'	=>	'[VALUE]'
                                              'fieldName_03'	=>	'[VALUE]'
                                              ,'fieldName_04'	=>	'[VALUE]'
                                              )
                        );
      */
      ///////////////////////////////////////////////////////////////////////////



      ///////////////////////////////////////////////////////////////////////////
      ///////////////////////////////////////////////////////////////////////////
      //	@	트랜잭션 시작
          $this->db->trans_begin();
      ///////////////////////////////////////////////////////////////////////////
      ///////////////////////////////////////////////////////////////////////////

      ///////////////////////////////////////////////////////////////////////////
      //	@	query 1 시작
      
          $arr_Keys	=	array_keys( $arrData['arr_data'] );
          for($loopCnt=0; count($arrData['arr_data'])>$loopCnt; $loopCnt++)
          {
            //	@	특정 필드에 대한 예외 처리가 필요할 경우 활용
            switch( $arr_Keys[ $loopCnt ] )
            {
              default:
                $this->db->set( $arr_Keys[ $loopCnt ] ,	$arrData['arr_data'][$arr_Keys[ $loopCnt ]], TRUE );
            }//	end switch
          }//	end for

          $SQL_1	=	$this->db->get_compiled_insert( $arrData['tbl_name'] );
          
          $this->db->query($SQL_1);
          
          $this->last_insert_id	=	$this->db->insert_id();
          
      //	@	query 1 끝
      ///////////////////////////////////////////////////////////////////////////

      ///////////////////////////////////////////////////////////////////////////
      ///////////////////////////////////////////////////////////////////////////
      //	@	트랜잭션 완료
      if ($this->db->trans_status() === FALSE)
      {
      $this->db->trans_rollback();
      }else{
      $this->db->trans_commit();
      }//	end if
      ///////////////////////////////////////////////////////////////////////////
      ///////////////////////////////////////////////////////////////////////////

      return $this->db->trans_status();
      }//   end function
	  
  }//	end class
	
?>
