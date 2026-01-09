<?php

use Tests\TestCase;
use Pest\Laravel\{actingAs, get, post, put, delete};
uses(TestCase::class)->in('Feature', 'Unit');
dump('Pest.php loaded');

beforeEach(function () {
    $manifestPath = public_path('build/manifest.json');

    mkdir(public_path('build'), 0777, true);

    $styles = [
        "resources/css/app.scss",
        "resources/css/navbar.scss",
        "resources/css/mobile-navbar.scss",
        "resources/css/home.scss",
        "resources/css/register.scss",
        "resources/css/login.scss",
        "resources/css/about.scss",
        "resources/css/forum.scss",
        "resources/css/myAccount.scss",
        "resources/css/create.scss",
        "resources/css/forumposts.scss",
        "resources/css/postlikes.scss",
        "resources/css/detail.scss",
        "resources/css/blogarticles.scss",
        "resources/css/adminmessages.scss",
        "resources/css/dashboard-articles.scss",
    ];

    $manifest = [];

    foreach ($styles as $style) {
        $filename = basename($style, '.scss') . '.css';

        $manifest[$style] = [
            "file" => $filename,
            "src" => $style,
            "isEntry" => true
        ];
    }

    $manifest["resources/js/app.js"] = [
        "file" => "app.js",
        "src" => "resources/js/app.js",
        "isEntry" => true
    ];

    file_put_contents($manifestPath, json_encode($manifest));
});

