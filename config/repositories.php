<?php
return [
    App\Hexagon\Domain\Repository\UserInterface::class => App\Hexagon\Infrastructure\Repository\UserRepository::class,
    App\Hexagon\Infrastructure\Repository\BaseRepository::class =>[
        App\Hexagon\Infrastructure\Repository\UserRepository::class,
    ],
];
