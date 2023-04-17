<?php

declare(strict_types=1);

use function DI\create;

return [
    \App\Repositories\Users\UserRepository::class => create(\App\Repositories\Users\UserDatabaseRepository::class),
];
