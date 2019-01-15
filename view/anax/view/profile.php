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
            <p>
            <a href="<?= url("article/" . $item->id) ?>">
            <?= $item->title ?>
            </a>
            </p>
        </div>
    <?php endforeach;?>
    </div>

    <div class="profile-info">
        <div class="flex-around">
            <img src="https://www.gravatar.com/avatar/<?= $gravatar ?>?s=100" alt="No avatar found." height="100px"/>
        </div>
        <div class="flex-around"> <?= $user->username ?> </div>
        <div>Score: <?= $user->activityScore ?></div>
        <div>Posts: <?= $user->posts ?></div>
    </div>
</div>
<?php if ($this->di->get("session")->get("username") == $user->username) :?>
    <p class="right"><a href="<?= url("user/edit/" . $user->id)?>"> edit profile </a></p>
<?php endif;?>

<h1> Answers / Comments </h1>
    <?php foreach ($comments as $item) : ?>
        <?php foreach ($articles as $a) : ?>
            <?php if ($item->articleId == $a->id) : ?>
            <div>
                <a href="<?= url("article/" . $a->id) ?>">
                    <p> <?= $a->title ?> </p>
                </a>
            </div>
            <?php endif; ?>
        <?php endforeach;?>
    <?php endforeach; ?>
