<?php

namespace Anax\View;

/**
 * Template file to render a view.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());



?>
<span class="flex">
    <img src="<?= asset($siteLogo) ?>" alt="<?= $siteLogoAlt ?>" width="100px" height="100px">
    <p class="logo-text"> The office </p>
</span>
