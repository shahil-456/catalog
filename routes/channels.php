<?php

use Illuminate\Support\Facades\Broadcast;


Broadcast::channel('online-users', function ($user) {
    return ['id' => $user->id, 'name' => $user->username];
});