<?php
// Composer の autoloader をロード
require_once("../vendor/autoload.php");
require_once("config.php");

if ($_SESSION['flg'] != "true"){
  header('Location: '.home_url().'/inquiry');
  exit;
}


//メール内容のカスタマイズ
$to = array( //送信先のアドレスを定義
  $adminMail, //管理者アドレスを設定
  $_POST['email'] //ユーザ宛
);

$subject = array( //件名
  "お問い合わせがありました。"//管理者
  "お問い合わせありがとうございます！"
);

//本文の作成
$message = $_POST['message'];  // 本文

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
    // $mail->Host       = 'smtp.gmail.com';  // SMTP サーバー(Gmail の場合これ)
    // $mail->SMTPAuth   = true;              // SMTP認証を有効にする
    // $mail->Username   = 'XXXXX@gmail.com'; // ユーザ名 (Gmail ならメールアドレス)
    // $mail->Password   = 'xxxxxxxxxx';      // パスワード
    // $mail->SMTPSecure = 'tls';             // 暗号化通信 (Gmail では使えます)
    // $mail->Port       = 587;               // TCP ポート (TLS の場合 587)
    $mail->Host = 'smtp.mailtrap.io';
    $mail->SMTPAuth = true;
    $mail->Port = 2525;
    $mail->Username = '68645036ec929f';
    $mail->Password = '0eab5ece39e037';

    // メール本体
    $mail->setFrom('yaruo.aa.91@gmail.com', '問い合わせ開発');  // 送信元メールアドレスと名前
    $mail->addAddress($to);  // 送信先メールアドレスと名前
    $mail->Subject = mb_encode_mimeheader($subject, 'ISO-2022-JP');  // 件名
    $mail->Body    = mb_convert_encoding($message, "JIS","UTF-8");  // 本文

    // 送信
    $mail->send();
} catch (Exception $e) {
    echo "送信失敗: {$mail->ErrorInfo}";
    var_dump($e);
}
?>
