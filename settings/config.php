<?php
//お問い合わせ設定。設置するフォームの項目設定やinputタグのHTML生成を行う。
//classやidは各項目の個別のCSS＆JS適用に使用する想定
$formParts = array(
  //氏名
  "name" => array(
    "type" => "text",
    "class" => "name",
    "id" => "name",
    "errBoxId" => "nameErr",
    "label" => "氏名",
    "require" => true
  ),
  //電話番号
  "tel" => array(
    "type" => "tel",
    "class" => "tel",
    "id" => "tel",
    "errBoxId" => "telErr",
    "label" => "電話番号",
    "require" => true
  ),
  //メールアドレス
  "email" => array(
    "type" => "email",
    "class" => "email",
    "id" => "email",
    "errBoxId" => "emailErr",
    "label" => "メールアドレス",
    "require" => true
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
    "require" => true
  ),
  //当サイトを知ったきっかけ
  "knowReason" => array(
    "type" => "select",
    "class" => "knowReason",
    "id" => "knowReason",
    "errBoxId" => "knowReasonErr",
    "options" => array(
      "友人",
      "twitter",
      "facebook",
      "instagram"
    ),
    "label" => "当サイトを知ったきっかけ",
    "require" => false
  ),
  //備考
  "remarks" => array(
    "type" => "textarea",
    "class" => "remarks",
    "id" => "remarks",
    "errBoxId" => "remarksErr",
    "label" => "備考",
    "require" => false
  ),
);
//formタグ内のHTMLを生成する
$inputArr = array();//生成したHTMLを入れる箱
$html = '<form class="form" form="form1" action="confirm.php" method="post">';
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
          $html .= '<option value="'.$value.'" selected>'.$value.'</option>';
        }else {
          $html .= '<option value="'.$value.'">'.$value.'</option>';
        }
      }
      $html .= '<select>';
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
      $html .= '</div>';
    break;
  }
}
$html .= '<input type="submit" class="Form-Btn" value="確認画面へ"></form>';

?>
