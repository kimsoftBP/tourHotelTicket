<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\PermissionName;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(PermissionName::class, function (Faker $faker) {
    return [
        'perm_name'=>'partner',
    ];
});
