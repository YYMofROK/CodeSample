<?php
error_reporting(-1);
ini_set('display_errors', 1);


//  https://api.telegram.org/bot752163521:AAEZy-WAEVJr1HanXfyrEe__Jde7IEQAS8M/getUpdates


//  @   To User 메시지 전송
function bot_TelegremBotSendMsg($chat_id, $msg)
{
    $targetUrl  =       "https://api.telegram.org/[BOT-APIKEY]/sendMessage";
    $targetUrl  =       $targetUrl."?chat_id=".$chat_id;
    $targetUrl  =       $targetUrl."&text=".urlencode( $msg );

    $ch = curl_init();

    // set URL and other appropriate options
    curl_setopt($ch, CURLOPT_URL                        , $targetUrl            );
    curl_setopt($ch, CURLOPT_POST                       , false                 );
    curl_setopt($ch, CURLOPT_RETURNTRANSFER             , true                  );

    // grab URL and pass it to the browser
    $ReturnString       =       curl_exec($ch);

    // close cURL resource, and free up system resources
    curl_close($ch);

    return json_decode($ReturnString, true);

}//    end function

// echo "<pre>";
// var_export( bot_TelegremBotSendMsg($chat_id, $msg) );
// echo "</pre>";




?>
