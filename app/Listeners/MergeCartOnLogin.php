<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Cache;

class MergeCartOnLogin
{
    public function handle(Login $event): void
    {
        $key = "cart_user_" . $event->user->getAuthIdentifier();

        $guestCart = session()->get("cart", []);
        $userCart  = Cache::get($key, []);

        foreach ($guestCart as $k => $item) {
            if (isset($userCart[$k])) {
                $userCart[$k]["quantity"] += $item["quantity"];
            } else {
                $userCart[$k] = $item;
            }
        }

        Cache::forever($key, $userCart);
        session()->put("cart", $userCart);
    }
}
