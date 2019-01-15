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
            <a href="article/<?= $item->id ?>">
                <?= $item->score ?>
            </a>
            <a href="article/<?= $item->id ?>">
                <?= $filter->doFilter($item->title, "markdown") ?>
            </a>

            <ul>
                <?php foreach (json_decode($item->tags) as $tag) : ?>
                    <li> <?= $tag ?> </li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endforeach; ?>
