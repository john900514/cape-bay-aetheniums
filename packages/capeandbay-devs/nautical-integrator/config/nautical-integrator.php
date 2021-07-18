<?php

return [
    'jwt_secret' => env('JWT_SECRET', 'bufu'),
    'root_default_route' => 'errors.404',
    'anchor_cms_url' => env('ANCHOR_CMS_URL', 'https://anchor.capeandbay.com')
];
