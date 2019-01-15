<?php

namespace Anax\View;

?>

<?php foreach ($articles as $a) : ?>
    <a href="<?= url("article/" . $a->id)?>"><?= $a->title ?> </a>
<?php endforeach; ?>
