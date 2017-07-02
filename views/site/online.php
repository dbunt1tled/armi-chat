<?php
/**
 * Created by PhpStorm.
 * User: sid
 * Date: 01.07.2017
 * Time: 14:39
 */
?>
<?php foreach ($users as $user): ?>
    <li class="list-group-item"> <b> <?= $user->users->name; ?> </b> : <span class="label label-success"><?= $user->users->city; ?></span></li>
<?php endforeach; ?>