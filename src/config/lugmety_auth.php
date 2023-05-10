<?php
$api_base_url = env("API_BASE_URL", "http://api.lugmety.engineering");
return [
    "redis" => [
        "connection" => "default"
    ],
    "services" => [
        "introspect_url" => "$api_base_url/auth/v1/oauth/introspect"
    ]
];