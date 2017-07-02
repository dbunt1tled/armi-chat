<?php

/* @var $this yii\web\View */

$this->title = 'Chat Application';

?>
<div class="site-index">
        <h1>Test application Chat</h1>

    <div class="body-content ">
        <div class="row">

            <div id="chat" class="panel panel-info col-xs-8">
                <div class="panel-heading">
                    <h2>Chat</h2>
                </div>
                <div class="panel-body">
                    <ul class="media-list"></ul>
                </div>
            </div>

            <div id="onlineUsers" class="panel panel-success col-xs-offset-1 col-xs-3">
                <div class="panel-heading">
                    <h2>Online</h2>
                </div>
                <div class="panel-body">
                    <ul class="list-group"></ul>
                </div>
            </div>
        </div>
        <div class="row" style="margin-top: 20px">
            <form id="formSend" class="col-xs-12" onsubmit="return false;" action="/">

                <label for="nameUser">Send message in chat</label>
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon3"><i class="glyphicon glyphicon-user"></i> Your name</span>
                    <input type="text" class="form-control" id="nameUser" aria-describedby="basic-addon3">
                </div>
                <div class="input-group" style="margin-top: 10px">
                    <span class="input-group-addon" id="basic-addon2"><i class="glyphicon glyphicon-envelope"></i> Message</span>
                    <input type="text" class="form-control" id="msgUser" aria-describedby="basic-addon2">
                    <span class="input-group-addon loadInfo"><i class="glyphicon glyphicon-ok"></i></span>
                    <div class="input-group-btn">
                        <button class="btn btn-default" type="submit">
                            <i class="glyphicon glyphicon-send"></i> Send
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
