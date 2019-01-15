<?php

namespace Anax\View;

$items = isset($items) ? $items : null;

$filter = $this->di->get("textfilter");

?>

<?php if ($this->di->get("session")->get("username")) : ?>
    <div>
        <a href="article/create"> Create Post </a>
    </div>
<?php endif; ?>

<?php if (!$items) : ?>
    <p>There are no items to show.</p>
    <?php
        return;
endif;
?>

    <?php foreach ($items as $item) : ?>
        <div class="post">
            <p>
            <a href="article/<?= $item->id ?>">
                <?= $filter->doFilter($item->title, "markdown") ?>
            </a>
            </p>

            <ul>
                <li> Tags: </li>
                <?php foreach (unserialize($item->tags) as $tag) : ?>
                    <li><a href="<?= url("tags/tag/" . $tag)?>"> <?= $tag ?>, </a></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endforeach; ?>
