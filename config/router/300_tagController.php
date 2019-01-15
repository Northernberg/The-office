<?php
/**
 * Mount the controller onto a mountpoint.
 */
return [
    "routes" => [
        [
            "info" => "User controller.",
            "mount" => "tags",
            "handler" => "\Anax\Controller\TagController",
        ],
    ]
];
