<?php

namespace Anax\View;

?>

<?php if ($user->id == null) : ?>
    <p>Profile does not exist.</p>
    <?php
        return;
endif;
?>
<div class="flex">
    <div class="post">
    <h1> Posts made: </h1>
    <?php foreach ($items as $item) : ?>
        <div>
            <a href="<?= url("article/" . $item->id) ?>">
                <p> <?= $item->title ?> </p>
            </a>
        </div>
    <?php endforeach;?>
    </div>

    <div class="profile-info">
        <div class="flex-around">
            <img src="https://www.gravatar.com/avatar/<?= $gravatar ?>?s=100" alt="No avatar found." height="100px"/>
        </div>
        <div class="flex-around"> <?= $user->username ?> </div>
        <div>Score:</div>
        <div>Posts:</div>
    </div>
</div>
<p class="right"><a href="<?= url("user/edit/" . $user->id)?>"> edit profile </a></p>
<h1> Answers / Comments </h1>
    <?php foreach ($comments as $item) : ?>
        <?php foreach ($articles as $a) : ?>
            <?php if ($item->articleId == $a->id): ?>
            <div>
                <a href="<?= url("article/" . $a->id) ?>">
                    <p> <?= $a->title ?> </p>
                </a>
            </div>
        <?php endif; ?>
    <?php endforeach;?>
<?php endforeach; ?>
