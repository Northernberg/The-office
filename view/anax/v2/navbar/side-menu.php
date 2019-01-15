<?php

namespace Anax\View;

/**
 * Template file to render a view.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());

$navbar = new \Anax\Navigation\Navbar();
$navbar->setDI($di);
if ($this->di->get("session")->has("username")) {
    $html = $navbar->createMenuWithSubMenus([
        "wrapper" => null,
        "class" => "side-menu",
        "items" => [
            [
                "text" => $this->di->get("session")->get("username"),
                "url" => "user/profile/" . $this->di->get("session")->get("username"),
                "title" => "Profile page",
            ],

            [
                "text" => "Logout",
                "url" => "user/logout",
                "title" => "Logout",
            ],
        ],
    ]);
} else {
    $html = $navbar->createMenuWithSubMenus($navbarConfig);
}

$classes = ( $class ?? null);



?><!-- menu wrapper -->
<div <?= classList($classes) ?>>
    <!-- main menu -->
    <?= $html ?>
</div>
