/**
 * Created by sid on 01.07.2017.
 */

$(function(){
    window.lastId = 0;

    var nameField = $("#nameUser");
    var msgField = $("#msgUser");
    var chat = $("#chat");
    var msgWrap = $("#chat ul");
    var formSend = $("#formSend");
    var onlineUsers = $("#onlineUsers");
    var onlineUsersWrap = $("#onlineUsers ul");
    var loadInfo = $('.loadInfo');
    if($.cookie("idUser") !== undefined ){
        nameField.val($.cookie("nameUser"));
    }
    function whoOnline() {

        $.get("/", {
                type: 'online',
            },
            function (response) {
                onlineUsersWrap.html(response.data);
            });
        /**/
    }
    //Функция обновления сообщений чата
    function sendMessage() {

        $.get("/", {
                type: 'getMessages',
                lastId: window.lastId,
            },
            function (response) {
                msgWrap.append(response.data);
                if(window.lastId != response.lastId){
                    window.lastId = response.lastId;
                    chat[0].scrollTop = chat[0].scrollHeight;
                }


        });
        /**/
    }
    sendMessage();
    onlineUsers.everyTime(5000, 'refresh', function() {
        whoOnline();
    });
    formSend.everyTime(5000, 'refresh', function() {
        sendMessage();
    });
    formSend.submit(function() {
        var userName = nameField.val().trim();
        var userMsg = msgField.val().trim();

        if(userName.length < 3){
            alert("Пожалуйста, введите свое имя (не меньще 3 символа)!"+' '+userName);
            return false;
        }
        if(userMsg.length < 1){
            alert("Пожалуйста введите сообщение!");
            return false;
        }

        if( $.cookie("idUser") === undefined ){
            $.getJSON('//freegeoip.net/json/?callback=?', function(data) {
                $.get("/", {
                            type: 'connect',
                            name: userName,
                            msg: userMsg,
                            info: JSON.stringify(data, null, 2)
                         },
                        function (response) {
                            $.cookie("nameUser", response.nameUser);
                            $.cookie("idUser", response.idUser);
                            msgField.val('');
                });
            });
        }else{
            loadInfo.html('<img src="/web/img/loader.gif" class="loadgif">');
            $.get("/", {
                    type: 'send',
                    userId: $.cookie("idUser"),
                    msg: userMsg,
                },
                function (response) {
                    msgField.val('');
                    loadInfo.html('<i class="glyphicon glyphicon-ok"></i>');
                });
        }
        return false;
    });

});/**/