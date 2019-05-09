<?php
error_reporting(-1);
ini_set('display_errors', 1);


////////////////////////////////////////////////////////////////////
//
//	@	2018.11.14
//
//	@	작성자 : a84146943@gmail.com
//	
//	@	아주 간단한 텔레그램 메시지 발송 함수 
//
////////////////////////////////////////////////////////////////////

    function sendMsg_Telegram( $chat_id, $msg )
    {
        //  Telegram 메시지를 발송한다.
        //  사전에 Telegram Bot 을생성하여 관련 설정값을 취득해야함.

        $send_targetUrl	=	"https://api.telegram.org/[BOT_API_KEY]/sendmessage";

        $targetUrl      =   $send_targetUrl;
        if( strlen(trim($chat_id)) > 0 )
        {
            $targetUrl	=	$targetUrl."?chat_id=".$chat_id;
        }//	end if

        if( strlen(trim($msg)) > 0 )
        {
            $targetUrl	=	$targetUrl."&text=".urlencode( $msg );
        }//	end if

        $ch = curl_init();

        // set URL and other appropriate options
        curl_setopt($ch, CURLOPT_URL			, $targetUrl	);
        curl_setopt($ch, CURLOPT_POST			, false			);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER	, true			);

        // grab URL and pass it to the browser
        $ReturnString	=	curl_exec($ch);

        // close cURL resource, and free up system resources
        curl_close($ch);

        return $ReturnString;

    }// end function

?>
