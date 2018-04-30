<?php


$baseUrl = "http://グローバルIPアドレス/";
$network = 2;  //1: ホームネットワークにいるとき  2: 外出先にいるとき

$homeUrl = "http://プライベートIPアドレス/";

function httpGet($url){
  global $network;
    $option = [
        CURLOPT_RETURNTRANSFER => true, //文字列として返す
        CURLOPT_TIMEOUT        => 3, // タイムアウト時間
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
    curl_setopt($ch, CURLOPT_USERPWD, "THETAYLXXXXXXXX:XXXXXXXX");
    
    curl_setopt_array($ch, $option);    

    $json    = curl_exec($ch);
    $info    = curl_getinfo($ch);
    $errorNo = curl_errno($ch);

    // OK以外はエラーなので空白配列を返す
    if ($errorNo !== CURLE_OK) {
        // 詳しくエラーハンドリングしたい場合はerrorNoで確認
        // タイムアウトの場合はCURLE_OPERATION_TIMEDOUT
        return [];
    }

    // 200以外のステータスコードは失敗とみなし空配列を返す
    if ($info['http_code'] !== 200) {
        return [];
    }

    // 文字列から変換
    $jsonArray = json_decode($json, true);

    return $jsonArray;
}



function httpPost($url, $data){
  global $network;
  $option = [
      CURLOPT_RETURNTRANSFER => true, //文字列として返す
      CURLOPT_TIMEOUT        => 3, // タイムアウト時間
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_AUTOREFERER => true,
  ];

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
  curl_setopt($ch, CURLOPT_VERBOSE, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
  curl_setopt($ch, CURLOPT_USERPWD, "THETAYLXXXXXXXX:XXXXXXXX");
  curl_setopt_array($ch, $option);

  $result = curl_exec($ch);
  $info    = curl_getinfo($ch);
  $errorNo = curl_errno($ch);
  curl_close($ch);

  // // OK以外はエラーなので空白配列を返す
  // if ($errorNo !== CURLE_OK) {
  //     // 詳しくエラーハンドリングしたい場合はerrorNoで確認
  //     // タイムアウトの場合はCURLE_OPERATION_TIMEDOUT
  //     return [];
  // }

  // // 200以外のステータスコードは失敗とみなし空配列を返す
  // if ($info['http_code'] !== 200) {
  //     return [];
  // }

  // 文字列から変換
  $jsonArray = json_decode($result, true);

  return $jsonArray;

}



?>
