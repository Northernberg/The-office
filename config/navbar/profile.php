<?php
/**
 * Supply the basis for the navbar as an array.
 */

return [
    // Use for styling the menu
    "wrapper" => null,
    "class" => "side-menu",

    // Here comes the menu items
    "items" => [
        [
            "text" => "Sign up",
            "url" => "user/create",
            "title" => "Register",
        ],
        [
            "text" => "Login",
            "url" => "user/login",
            "title" => "Login",
        ],
    ],
];
