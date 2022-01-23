<?php
// Composer の autoloader をロード
require_once("vendor/autoload.php");
require_once("settings/config.php");

if ($_SESSION['flg'] != "true"){
  header('Location: '.$home_url."/".$inputUrl);
  exit;
}


//メール内容のカスタマイズ
$to = array( //送信先のアドレスを定義
  $adminMail, //管理者アドレスを設定
  $_POST['email'] //ユーザ宛
);

$subject = array( //件名
  "お問い合わせがありました。",//管理者
  "お問い合わせありがとうございます！"
);

/*-------------------------------------------------------
//本文の作成
-------------------------------------------------------*/
function insertCheck($alreadyInsert,$checkKey,$formParts){
  //formPartsからチェック
  //$formPartsのキーに$_POSTの配列が含まれているかどうかチェックする。
  if (array_key_exists($checkKey,$formParts)) {
    //すでにインサート済かどうかをチェック
    if (!in_array($checkKey,$alreadyInsert)) {
      return true;
    }else {
      return false;
    }
  }else {
    return false;
  }

}

//本文作成用の関数を定義
function makeBody($introduction,$formParts){
  //冒頭文を定義
  $bodyText = $introduction."\n";
  $alreadyInsert = array();
  //同じ項目は同じラベルで対応する
  for ($i=0; $i < $_POST["same_value_count"]; $i++) {
    $explode = explode("___",$_POST["same_value_".$i]);
    $keys = explode(",",$explode[0]);
    $bodyText .= "■".$explode[1]."\n";
    foreach ($keys as $val) {
      $bodyText .= $_POST[$val]." ";
      $alreadyInsert[] = $val;
    }
    $bodyText .= "\n\n";
  }
  foreach ($_POST as $postKey => $postValue) {
    $result = insertCheck($alreadyInsert,$postKey,$formParts);
    if ($result) {
      $bodyText .= "■".$_POST[$postKey."_label"]."\n";
      $bodyText .= $_POST[$postKey]."\n\n";
    }
  }

  return $bodyText;
}
//
//メールの冒頭文を定義
$adminIntroduction = "ユーザからのお問い合わせがありました。\n";
$userIntroduction = "この度はお問い合わせいただきありがとうございます。\n下記内容にて承りましたので、ご確認ください。\n";

$adminMailBody = makeBody($adminIntroduction,$formParts);
$userMailBody = makeBody($userIntroduction,$formParts);
//作成した本文を配列へ
$message = array(
  $adminMailBody,//管理者あての本文
  $userMailBody  //ユーザあての本文
);

/*-------------------------------------------------------
//以下、システム設定
-------------------------------------------------------*/
// メール日本語対応
mb_language("japanese");
mb_internal_encoding("UTF-8");

// PHPMailer クラスをネーム空間にインポート
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// インスタンス生成
$mail = new PHPMailer(true);

try {
    // SMTPの設定
    $mail->isSMTP();                       // SMTP 利用
    // $mail->SMTPSecure = 'tls';             // 暗号化通信 (Gmail では使えます)
    $mail->Host = 'smtp.mailtrap.io';
    $mail->SMTPAuth = true;
    $mail->Port = 2525;
    $mail->Username = '68645036ec929f';
    $mail->Password = '0eab5ece39e037';
    $mail->CharSet = 'UTF-8';
    $mail->Encoding = 'base64';
    setlocale(LC_ALL, 'ja_JP.UTF-8');
    // メール送信処理。定義しているアドレスの個数分ループさせる。
    for ($i=0; $i < count($to); $i++) {
      $mail->setFrom('yaruo.aa.91@gmail.com', '問い合わせ開発');  // 送信元メールアドレスと名前
      $mail->addAddress($to[$i]);  // 送信先メールアドレスと名前
      $mail->Subject = mb_encode_mimeheader($subject[$i], 'ISO-2022-JP');  // 件名
      $mail->Body    = $message[$i];  // 本文

      // 送信
      $mail->send();
    }
    //全ての処理完了後はセッションを破棄する
    $_SESSION = array();
    session_destroy();
} catch (Exception $e) {
    echo "送信失敗: {$mail->ErrorInfo}";
    var_dump($e);
}
?>
