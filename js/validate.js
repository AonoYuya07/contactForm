function includeJa(text) {
  try {
    let gmi = 'gmi';
    let regeIncludeHiragana = '^(?=.*[\u3041-\u3096]).*$';
    let regeIncludeKatakana = '^(?=.*[\u30A1-\u30FA]).*$';
    let regeIncludeKanji = '^(?=.*[\u4E00-\u9FFF]).*$';
    let regeHiragana = new RegExp(regeIncludeHiragana, gmi);
    let regeKatakana = new RegExp(regeIncludeKatakana, gmi);
    let regeKanji = new RegExp(regeIncludeKanji, gmi);

    let includeJa = false;
    if (regeHiragana.test(text))
    includeJa = true;
    if (regeKatakana.test(text))
    includeJa = true;
    if (regeKanji.test(text))
    includeJa = true;

    return includeJa;
  } catch (error) {
    alert(error);
  }
}
$(document).on("click","#inputSubmit",function(){
  let flg = "正常";
  $(".getId").each(function(){
    $("#"+$(this).attr("id")).text("");
  })
  $(".getId").each(function(){
    let target = $(this).attr("data-target");
    let vlidate = $(this).attr("data-validate");
    //カンマを含む場合は文字列を分割
    // let validateStrArr = [];
    // console.log(vlidate);
    // if (vlidate.indexOf(',') != -1) {
    //   validateStrArr = vlidate.split(',');
    //   console.log(vlidate);
    // }else {
    //   validateStrArr = validateStrArr.push(vlidate);//単一の場合でも配列に統一する
    // }
    // console.log(validateStrArr);
    let validateStrArr = vlidate.split(',');
    // console.log(validateStrArr);
    let thisEle = $(this);
    $.each(validateStrArr, function(idx, val) {
      switch (val) {
        case "require":
          if ($("#"+target).val() == "") {
            $("#"+thisEle.attr("id")).text("この項目は必須入力です。");
            flg = "異常";
          }
        break;
        case "telFormat":
          let tel = $("#"+target).val().replace(/-/g, ""); //ハイフンは取っ払う
          if (tel.match(/[^0-9]+/)) { //半角数字チェック
            $("#"+thisEle.attr("id")).text('電話番号は半角数字のみにてご入力下さい');
            flg = "異常";
          } else if (tel.length < 10) { //桁数チェック
            $("#"+thisEle.attr("id")).text('電話番号が正しくありません');
            flg = "異常";
          }
        break;
        case "emailFormat":
          if(!$("#"+target).val().match(/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/)){
            $("#"+thisEle.attr("id")).text('メールアドレスの形式が違います');
            flg = "異常";
          }
        break;
        case "radioRequire":
        // console.log($("#"+target).length);
          if($("#"+target+":checked").length == 0){
            $("#"+thisEle.attr("id")).text("この項目は必須入力です。");
            flg = "異常";
          }
        break;
        case "selectRequire":
        console.log($("#"+target).val() != "");
        console.log($("#"+target).val());
          if ($("#"+target).val() == "") {
            $("#"+thisEle.attr("id")).text("この項目は必須入力です。");
            flg = "異常";
          }
        break;
        case "japanese":
        // console.log($("#"+target).val().search(/^[ぁ-んァ-ヶー一-龠 　\r\n\t]+$/));
          if(!includeJa($("#"+target).val())){
            $("#"+thisEle.attr("id")).text("日本語を１文字以上入力してください。");
            flg = "異常";
          }
        break;
      }
    })
  });
  if(flg == "異常"){
    console.log("エラー");
    // スクロールの速度
    var speed = 400; // ミリ秒で記述
    var href= "#";
    var target = $(href == "#" || href == "" ? 'html' : href);
    var position = target.offset().top;
    $('body,html').animate({scrollTop:position}, speed, 'swing');
    return false;
  }
})
