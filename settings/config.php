<?php
session_start();

//お問い合わせ設定。設置するフォームの項目設定やinputタグのHTML生成を行う。
//URL定義。確認画面＆完了画面のURLを定義する
$inputUrl = "/index.php";
$confirmUrl = "/confirm.php";
$thanksUrl = "/thanks.php";
//管理者メールアドレス
$adminMail = "test@example.com";
$home_url = (empty($_SERVER['HTTPS']) ? 'http://' : 'https://') . $_SERVER['HTTP_HOST'];
/*************入力画面HTML生成*************/
//classやidは各項目の個別のCSS＆JS適用に使用する想定
/*想定バリデーション-------------------------
//require：必須
//telFormat：電話番号フォーマット
//emailFormat：メールアドレスフォーマット
//radioRequire：ラジオボタン、チェックボックスの必須入力
//selectRequire：セレクトボックスの必須入力
//japanese：日本語が１文字以上含まれているかどうか。（迷惑メール対策）
//現在の想定は上記です。
//使用感を見て随時追加します。
-------------------------------------*/
$formParts = array(
  //氏名
  "name1" => array(
    "type" => "text",
    "class" => "name1",
    "id" => "name1",
    "errBoxId" => "name1Err",
    "label" => "姓",
    "require" => true, //HTMLに設置する「必須ラベル」のOn/Off
    "validate" => "require",
  ),
  "name2" => array(
    "type" => "text",
    "class" => "name2",
    "id" => "name2",
    "errBoxId" => "name2Err",
    "label" => "名",
    "require" => true, //HTMLに設置する「必須ラベル」のOn/Off
    "validate" => "require",
  ),
  //電話番号
  "tel" => array(
    "type" => "tel",
    "class" => "tel",
    "id" => "tel",
    "errBoxId" => "telErr",
    "label" => "電話番号",
    "require" => true,
    "validate" => "require,telFormat",
  ),
  //メールアドレス
  "email" => array(
    "type" => "email",
    "class" => "email",
    "id" => "email",
    "errBoxId" => "emailErr",
    "label" => "メールアドレス",
    "require" => true,
    "validate" => "require,emailFormat",
  ),
  //問い合わせ種別
  "contactType" => array(
    "type" => "radio",
    "class" => "contactType",
    "id" => "contactType",
    "errBoxId" => "contactTypeErr",
    "options" => array(
      "当サイトについて",
      "取扱商品について",
      "その他"
    ),
    "label" => "問い合わせ種別",
    "require" => true,
    "validate" => "radioRequire",
  ),
  //当サイトを知ったきっかけ
  "knowReason" => array(
    "type" => "select",
    "class" => "knowReason",
    "id" => "knowReason",
    "errBoxId" => "knowReasonErr",
    "options" => array(
      "",
      "友人",
      "twitter",
      "facebook",
      "instagram"
    ),
    "label" => "当サイトを知ったきっかけ",
    "require" => false,
    "validate" => "selectRequire",
  ),
  //備考
  "remarks" => array(
    "type" => "textarea",
    "class" => "remarks",
    "id" => "remarks",
    "errBoxId" => "remarksErr",
    "label" => "備考",
    "require" => false,
    "validate" => "require,japanese",
  ),
);
//メール文面で同じラベルで表示させる項目を定義(設計中)
$sameLabel = array(
  "name1,name2" => "お名前",
);
//formタグ内のHTMLを生成する
$html = '<form class="form" form="form1" action="'.$confirmUrl.'" method="post">';
foreach ($formParts as $inputName => $attr) {
  //全inputパーツで共通のHTMLタグもinputタグの種別ごとの設定を想定しておく。
  switch ($attr['type']) {
    case 'select':
      //セレクトボックスの場合
      $html .= '<div class="Form-Item">';
      if ($attr['label']) {
        $html .= '<p class="Form-Item-Label"><span class="Form-Item-Label-Required">必須</span>'.$attr['label'].'</p>';
      }else {
        $html .= '<p class="Form-Item-Label">'.$attr['label'].'</p>';
      }

      $html .= '<select class="'.$attr['class'].'" id="'.$attr['id'].'" name="'.$inputName.'">';
      foreach ($attr['options'] as $value) {
        if (!empty($_SESSION[$inputName]) && $_SESSION[$inputName] == $value) {
          if ($value == "") {
            $html .= '<option value="" selected>選択してください</option>';
          }else {
            $html .= '<option value="'.$value.'" selected>'.$value.'</option>';
          }
        }else {
          if ($value == "") {
            $html .= '<option value="">選択してください</option>';
          }else {
            $html .= '<option value="'.$value.'">'.$value.'</option>';
          }
        }
      }
      $html .= '<select>';
      $html .= '<p id="'.$attr['errBoxId'].'" class="getId" data-validate="'.$attr['validate'].'" data-target="'.$attr['id'].'"></p>';
      $html .= '</div>';
    break;

    case 'radio':
      //ラジオボタンの場合
      $html .= '<div class="Form-Item">';
      if ($attr['label']) {
        $html .= '<p class="Form-Item-Label"><span class="Form-Item-Label-Required">必須</span>'.$attr['label'].'</p>';
      }else {
        $html .= '<p class="Form-Item-Label">'.$attr['label'].'</p>';
      }
      foreach ($attr['options'] as $value) {
        if (!empty($_SESSION[$inputName]) && $_SESSION[$inputName] == $value) {
          $html .= '<input type="radio" name="'.$inputName.'" value="'.$value.'" class="'.$attr['class'].'" id="'.$attr['id'].'" checked>'.$value;
        }else {
          $html .= '<input type="radio" name="'.$inputName.'" value="'.$value.'" class="'.$attr['class'].'" id="'.$attr['id'].'">'.$value;
        }
      }
      $html .= '<p id="'.$attr['errBoxId'].'" class="getId" data-validate="'.$attr['validate'].'" data-target="'.$attr['id'].'"></p>';
      $html .= '</div>';
    break;

    case 'checkbox':
      //チェックボックスの場合
      $html .= '<div class="Form-Item">';
      if ($attr['label']) {
        $html .= '<p class="Form-Item-Label"><span class="Form-Item-Label-Required">必須</span>'.$attr['label'].'</p>';
      }else {
        $html .= '<p class="Form-Item-Label">'.$attr['label'].'</p>';
      }
      foreach ($attr['options'] as $value) {
        if (!empty($_SESSION[$inputName]) && $_SESSION[$inputName] == $value) {
          $html .= '<input type="checkbox" name="'.$inputName.'[]" value="'.$value.'" class="'.$attr['class'].'" id="'.$attr['id'].'" checked>'.$value;
        }else {
          $html .= '<input type="checkbox" name="'.$inputName.'[]" value="'.$value.'" class="'.$attr['class'].'" id="'.$attr['id'].'">'.$value;
        }
      }
      $html .= '<p id="'.$attr['errBoxId'].'" class="getId" data-validate="'.$attr['validate'].'" data-target="'.$attr['id'].'"></p>';
      $html .= '</div>';
    break;

    case 'textarea':
      //テキストエリアの場合
      $html .= '<div class="Form-Item">';
      if ($attr['label']) {
        $html .= '<p class="Form-Item-Label"><span class="Form-Item-Label-Required">必須</span>'.$attr['label'].'</p>';
      }else {
        $html .= '<p class="Form-Item-Label">'.$attr['label'].'</p>';
      }
      if (!empty($_SESSION[$inputName])) {
        $html .= '<textarea class="'.$attr['class'].'" id="'.$attr['id'].'" name="'.$inputName.'">'.$_SESSION[$inputName].'</textarea>';
      }else {
        $html .= '<textarea class="'.$attr['class'].'" id="'.$attr['id'].'" name="'.$inputName.'"></textarea>';
      }
      $html .= '<p id="'.$attr['errBoxId'].'" class="getId" data-validate="'.$attr['validate'].'" data-target="'.$attr['id'].'"></p>';
      $html .= '</div>';
    break;

    default:
      //textやdate,email,telなどその他
      $html .= '<div class="Form-Item">';
      if ($attr['label']) {
        $html .= '<p class="Form-Item-Label"><span class="Form-Item-Label-Required">必須</span>'.$attr['label'].'</p>';
      }else {
        $html .= '<p class="Form-Item-Label">'.$attr['label'].'</p>';
      }
      if (!empty($_SESSION[$inputName])) {
        $html .= '<input type="'.$attr['type'].'" name="'.$inputName.'" value="'.$_SESSION[$inputName].'" class="'.$attr['class'].'" id="'.$attr['id'].'">';
      }else {
        $html .= '<input type="'.$attr['type'].'" name="'.$inputName.'" value="" class="'.$attr['class'].'" id="'.$attr['id'].'">';
      }
      $html .= '<p id="'.$attr['errBoxId'].'" class="getId" data-validate="'.$attr['validate'].'" data-target="'.$attr['id'].'"></p>';
      $html .= '</div>';
    break;
  }
  $html .= '<input type="hidden" name="'.$inputName.'_label" value="'.$attr['label'].'">';
  $cnt = 0;
  foreach ($sameLabel as $k => $sl) {
    $html .= '<input type="hidden" name="same_value_'.$cnt.'" value="'.$k."___".$sl.'">';
    $cnt++;
  }
  $html .= '<input type="hidden" name="same_value_count" value="'.count($sameLabel).'">';
  $html .= '<input type="hidden" name="flg" value="true">';
}
$html .= '<input type="submit" id="inputSubmit" class="Form-Btn" value="確認画面へ"></form>';


/*-------------------------------------------------------------------------------
//確認画面設定
-------------------------------------------------------------------------------*/
if ($_SERVER['REQUEST_URI'] == $confirmUrl) {
  //フラグがない場合は入力画面へ遷移させる
  if ($_POST['flg'] != true){
    header('Location: '.$inputUrl);
    exit;
  }
  //セッション保持
  $_SESSION = $_POST;

  //ラベルと＄_POSTの紐付け設定
  foreach ($formParts as $inputName => $attr) {
    $postParam[$_POST[$inputName]] = $attr['label'];
  }

  //値保持
  $confirmHTML = '<form class="form" form="form1" action="'.$thanksUrl.'" method="post">';
  foreach ($_POST as $key => $value){
    if (is_array($value)){
      foreach ($value as $key1 => $value1){
        if (strpos($key, "same_value") === false && strpos($key, "flg") === false && strpos($key, "inputSubmit") === false && strpos($key, "label") === false) {
          $confirmHTML .= '<div class="Form-Item">';
          $confirmHTML .= '<p class="Form-Item-Label">'.$postParam[$value1].'</p>';
          $confirmHTML .= '<p class="value">'.$value1.'</p>';
          $confirmHTML .= '</div>';
        }
        $confirmHTML .= '<input type="hidden" name="'.$key[$key1].'" value="'.$value1.'">';
      }
    }else{
      if (strpos($key, "same_value") === false && strpos($key, "flg") === false && strpos($key, "inputSubmit") === false && strpos($key, "label") === false) {
        $confirmHTML .= '<div class="Form-Item">';
        $confirmHTML .= '<p class="Form-Item-Label">'.$postParam[$value].'</p>';
        $confirmHTML .= '<p class="value">'.$value.'</p>';
        $confirmHTML .= '</div>';
      }
      $confirmHTML .= '<input type="hidden" name="'.$key.'" value="'.$value.'">';
    }
  }
  $confirmHTML .= '<input type="submit" id="inputSubmit" class="Form-Btn" value="送信"></form>';
  $confirmHTML .= '<input value="前に戻る" onclick="history.back();" type="button" class="Form-Btn">';
}
?>
