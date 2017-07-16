
/*
 * jQuery.Deferred call(string srcPoint);
 * src/フォルダ以下のsrcPointのパスにアクセスする
 * dataObjは送信するデータのオブジェクト
 * jQueryのajax関数の返り値(jQuery.Deferred)を返します
 * src/以下のAPIにアクセスする場合は、call()を経由して行ってください
 */
function call(srcPoint = '', dataObj = {}){
    return $.ajax({
        url: "src/"+srcPoint+".php",
        type: 'POST',
        cache: false,
        data: dataObj,
        dataType: 'json',
        beforeSend: function(xhr) {
            xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
        }
    });
}

function toggleTopPage(){
    $('#enter').slideToggle();
    $('#create').slideToggle();
}

function createRoom(){
    var roomName = $('#roomName').val();
    var roomPass = $('#roomPass').val();

    call('createRoom', {roomName:roomName, password:roomPass}).done(function(data){
        if(data.code === 1){
            location.reload();
            return;
        }
        $('#createNotice').text(data.message);
    });
}

function enterRoom(id){
    var nick = $('#nick').val();
    var pass = $('#pass').val();

    call('login', {roomId:id, nick:nick, password:pass}).done(function(data){
        if(data.code === 1){
            location.href = 'Onset.php';
            return;
        }
        $('#notice').text(data.message);
    });
}

function removeRoom(id){
    var pass = $('#pass').val();

    var check = confirm('本当に削除しますか？');
    if(!check) return;

    call('removeRoom', {roomId:id, password:pass}).done(function(data){
        if(data.code === 1){
            location.reload();
            return;
        }
        $('#notice').text(data.message);
    });
}
