<?php
/**
 * Supply the basis for the navbar as an array.
 */
return [
    // Use for styling the menu
    "wrapper" => null,
    "class" => "my-navbar rm-default rm-desktop",

    // Here comes the menu items
    "items" => [
        [
            "text" => "Startsida",
            "url" => "",
            "title" => "Start",
        ],
        [
            "text" => "Articles",
            "url" => "article",
            "title" => "articles"
        ],
        [
            "text" => "Tags",
            "url" => "tags",
            "title" => "Tags",
        ],
        [
            "text" => "Om",
            "url" => "about",
            "title" => "About this site",
        ]
    ],
];
