<?php

namespace Anax\View;

$items = isset($articles) ? $articles : null;

?>

<?php if (!$articles) : ?>
    <p>There are no items to show.</p>
    <?php
        return;
endif;
?>

<?php foreach ($articles as $a) : ?>
        <ul>
            <?php foreach (json_decode($a->tags) as $tag) : ?>
                <li><a href="<?=url("tags/tag/" . $tag)?>"> <?= $tag ?> </a></li>
            <?php endforeach; ?>
        </ul>
<?php endforeach; ?>
