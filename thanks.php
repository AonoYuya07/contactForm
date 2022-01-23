<?php
//メールの送信処理を行う
require_once("settings/mailSender.php");
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>サイトタイトル</title>
  <meta name="description" content="ディスクリプションを入力">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/contact.css">
  <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
  <script src="js/validate.js"></script>
</head>
<body>

  <div class="contact-form">
    <div class="complete">
      <div>
        <span>送信が完了しました。</span><br>
        この度はお問い合わせいただき
        <p class="blank br480on"> </p>
        誠にありがとうございます。<p class="blank"> </p>
        内容を確認次第、<p class="blank br480on"> </p>
        担当よりご連絡させていただきます。
      </div>
    </div>
    <a class="link-btn-red opa" href="">トップへ</a>
  </div>
</body>
</html>
<style media="screen">
/* お問い合わせ完了 */
.contact-form{
text-align: center;
font-size: 18px;
}
.contact-form .complete{
margin-bottom: 60px;
}
.contact-form .complete span{
margin-bottom: 25px;
display: inline-block;
font-weight: 600;
font-size: 120%;
}
/* 仮想の空白 */
.contact-form .complete .blank{
height: 7px;
}

.contact-form .link-btn-red{
max-width: 100%;
width: 42%;
}
.contact-form .link-btn-red::after{
content: '';
background-image: url(../img/bottom-arrow.png);
position: absolute;
width: 8px;
height: 8px;
background-size: cover;
right: 13%;
top: 4px;
bottom: 0;
margin: auto;
}
@media screen and (max-width:1440px){
}
@media screen and (max-width:1280px){
}
@media screen and (max-width:1024px){
}
@media screen and (max-width:768px){
}
@media screen and (max-width:480px){
.contact-form{
  font-size: 13px;
}
.contact-form .complete{
  margin: 40px 0;
}
.contact-form .complete span{
  font-size: 130%;
  margin-bottom: 25px;
}

.contact-form .link-btn-red{
  width: 50%;
  min-height: 35px;
}
.contact-form .link-btn-red::after{
  width: 5px;
  height: 5px;
  top: 0;
}
}
</style>
