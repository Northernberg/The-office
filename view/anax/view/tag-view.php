<?php

namespace Anax\View;

?>

<h1> Articles related to <?= $tag ?></h1>
<?php foreach ($articles as $a) : ?>
    <div class="post">
        <li>
            <a href="<?= url("article/" . $a->id)?>"><?= $a->title ?> </a>
        </li>
        <ul>
            <li> Tags: </li>
            <?php foreach (json_decode($a->tags) as $tag) : ?>
                <li><a href="<?= url("tags/tag/" . $tag)?>"> <?= $tag ?>, </a></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endforeach; ?>
