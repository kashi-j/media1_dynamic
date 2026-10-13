$(function(){
  // ロード時にdisabledを設定
  $('#shop-name').prop('disabled', true);

  // 初期状態の店舗リストを保存
  const initialShops = $("#shop-name").children().clone();

  $("#shop-prefectures").on('input',function() {
    const selectedArea = $('#shop-prefectures option:selected').data('area');
    // 店舗セレクトボックスを初期状態に戻す
    $("#shop-name").empty().append(initialShops.clone());

    // 選択された地域に該当しない店舗を削除
    $("#shop-name option").each(function ($index) {
      if ($index > 0) {
        let shopArea = $(this).data("area");
        if (shopArea !== selectedArea) {
          $(this).remove();
        }
      }
    });
    $('#shop-name').prop('disabled', false);
  });

  //郵便番号にハイフンを自動挿入するメソッド
  const insertStr = (input) => {
    return input.slice(0, 3) + '-' + input.slice(3,input.length);
  }

  //入力時に郵便番号に自動でハイフンを付けるイベント
  $("input.p-postal-code").on('keyup', (e) => {
    // console.log(e);
    var input = $(e.target).val();

    //削除キーではハイフン追加処理が働かないように制御（8がBackspace、46がDelete)
    var key = event.keyCode || event.charCode;
    if( key == 8 || key == 46 ){
      return false;
    }

    //３桁目に値が入ったら発動
    if(input.length === 3){
      $(e.target).val(insertStr(input));
    }
  });

  //フォーカスが外れた際、本当に4桁目に'-'がついているかチェック。なければ挿入するイベント
  //これでコピペした場合にも反応できるハズ？
  $("input.p-postal-code").on('blur',(e) => {
    var input = $(e.target).val();

    //４桁目が'-(ハイフン)’かどうかをチェックし、違ったら挿入
    if(input.length >= 3 && input.substr(3,1) !== '-'){
      $(e.target).val(insertStr(input));
    }
  });

  
});

$(window).on("load", function(){
  $("#js-submit-btn").removeClass('is-disabled');
});