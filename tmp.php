<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>サイトタイトル</title>
  <meta name="description" content="ディスクリプションを入力">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/input.css">
  <!-- [if lt IE 9] -->
  <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  <script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
  <!-- [endif] -->
</head>
<body>
  <form id="contact" action="" class="form" method="post">
    <dl class="form_list">
      <div class="form_item">
        <dt class="form_title"><span class="text">氏名</span></dt>
        <dd class="form_contents"><input id="yourname" class="form_data" type="text" name="yourname" value="<?php if($_SESSION['yourname']): echo $_SESSION["yourname"]; endif;?>" placeholder="八百武太郎"></dd>
      </div>
      <div class="form_item">
        <dt class="form_title"><span class="text">氏名（カタカナ）</span></dt>
        <dd class="form_contents"><input id="furigana" class="form_data" type="text" name="furigana" value="<?php if($_SESSION['furigana']): echo $_SESSION["furigana"]; endif;?>" placeholder="ヤオタケタロウ"></dd>
      </div>
      <div class="form_item">
        <dt class="form_title"><span class="text">メールアドレス</span></dt>
        <dd class="form_contents">
          <input id="email" class="form_data" type="email" name="email" value=<?php if($_SESSION['email']): echo $_SESSION["email"]; endif;?>"" placeholder="メールアドレス">
        </dd>
      </div>
      <div class="form_item">
        <dt class="form_title"><span class="text">電話番号</span></dt>
        <dd class="form_contents"><input id="tel" class="form_data" type="tel" name="tel" value="<?php if($_SESSION['tel']): echo $_SESSION["tel"]; endif;?>" placeholder="00012341234"></dd>
      </div>
      <div class="form_item">
        <dt class="form_title"><span class="text">郵便番号</span></dt>
        <dd class="form_contents"><input id="zip" class="form_data" type="text" name="zip" value="<?php if($_SESSION['zip']): echo $_SESSION["zip"]; endif;?>" placeholder="939-8083"></dd>
      </div>
      <div class="form_item">
        <dt class="form_title"><span class="text">ご住所</span></dt>
        <dd class="form_contents"><input id="address" class="form_data" type="text" name="address" value="<?php if($_SESSION['address']): echo $_SESSION["address"]; endif;?>" placeholder="富山県西中野本町2番21号"></dd>
      </div>
      <div class="form_item">
        <dt class="form_title"><span class="text">お問い合わせ内容</span></dt>
        <dd class="form_contents"><textarea id="contents" class="form_data" name="contents" id="" cols="30" rows="10" placeholder="ご予約やお食事についてのご質問・ご要望等"><?php if($_SESSION['contents']): echo $_SESSION["contents"]; endif;?></textarea></dd>
      </div>
    </dl>
    <div class="purapori"></div>
    <p class="form_attention">※個人情報の取り扱いにご確認の上、送信いただきますようお願いいたします。</p>
    <input id="send" class="submit" type="submit" name="" value="確認画面へ">
  </form>
</body>
</html>
