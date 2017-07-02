<?php
/**
 * Created by PhpStorm.
 * User: sid
 * Date: 01.07.2017
 * Time: 14:39
 */
?>
<?php foreach ($messages as $message): ?>
    <li class="chatLine">
        <div class="chatBody">
            <span class="label label-primary chatName"><?= $message->users->name; ?></span>
            <?= $message->msg; ?>
        </div>
        <div class="chatTime">
            <span class="label label-default"><i> <?= date('d.m.Y H:i:s',$message->created_at); ?>  </i></span>
        </div>
        <div class="clear"></div>
    </li>
<?php endforeach; ?>