<?php

namespace Anax\View;

$filter = $this->di->get("textfilter");
?>

<div>
    <h1> <?= $post->title?></h1>
    <p> <?= $post->content?></p>
    <p><a href=<?= url("user/profile/" . $post->userId) ?>> <?= $post->userId; ?></a></p>
</div>

<h1> Comments </h1>
<?= $commentForm ?>

<?php foreach ($articleComments as $a) : ?>
    <div class="answer">
    <div class="pic">
        <img src="https://www.gravatar.com/avatar/?s=100" alt="No avatar found." height="50px"/>
        <p> <?= $a->userId ?> </p>
    </div>
    <p> <?= $filter->doFilter($a->content, "markdown") ?> </p>
    </div>
<?php endforeach; ?>


<h1> Answers </h1>
<?= $answerForm; ?>
<?php foreach ($answers as $a) : ?>
    <div class="answer">
    <div class="pic">
        <img src="https://www.gravatar.com/avatar/?s=100" alt="No avatar found." height="50px"/>
        <p> <?= $a->username ?> </p>
    </div>
    <p> <?= $filter->doFilter($a->content, "markdown") ?></p>
    </div>
    <div class="comments">
    <p> Comments: </p>
    <?php foreach ($comments as $c) : ?>
        <?php if ($c->answerId == $a->id) : ?>
            <div>
                <p>
                <?= $c->userId ?>
                -
                <?= $filter->doFilter($c->content, "markdown")?>
                </p>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
    </div>
<a href="comment/<?= $a->id?>"> Comment </a>

<?php endforeach;?>
