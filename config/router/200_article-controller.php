<?php
/**
 * Mount the controller onto a mountpoint.
 */
return [
    "routes" => [
        [
            "info" => "User controller.",
            "mount" => "article",
            "handler" => "\Anax\Controller\ArticleController",
        ],
    ]
];
