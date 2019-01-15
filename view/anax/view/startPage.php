<?php

namespace Anax\view;

?>
<div class="startPic">
<img src="img/Dunder_Mifflin,_Inc.svg.png" class="dunder">
</div>
<h1> The office</h1>
<p> Welcome to dunder mifflin, a people persons paper people company </p>
<p> This forum has all of the latest posts about the US show <b>The Office </b>.</p>
<p> Although the series has ended we still live on with live memes, funny throwbacks </p>
<p> and all kinds of posts related to the show. </p>

<h2> Active members </h2>
<?php foreach ($members as $m) : ?>
    <div class="pic">
        <img src="https://www.gravatar.com/avatar/<?= md5(strtolower(trim($m->email))) ?>?s=100" alt="No avatar found." height="50px"/>
        <p> <?= $m->username ?> </p>
    </div>
<?php endforeach; ?>

<h2> Hot topics</h2>
<?php foreach ($articles as $a) : ?>
    <p><?= $a->title ?></p>
<?php endforeach; ?>

<h2> Hot tags </h2>

<?php foreach ($tags as $t => $value) : ?>
    <p><a href="<?= url("tags/tag/" . $t)?>"> <?= $t?> </a></p>
<?php endforeach; ?>
