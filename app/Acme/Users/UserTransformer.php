<?php

namespace App\Acme\Users;

use League\Fractal\TransformerAbstract; // using fractal package

use App\User;

class UserTransformer extends TransformerAbstract {

    public function transform(User $user) {

        return [
          'id' => (int) $user->id,
          'username' => (String) $user->username,
          'email' => (String) $user->email,
          'token' => $user->token,
          'customer' => [
              'url' => (String) route('api.v1.customers.show', ['id' => $user->customer->id]),
              'name' => $user->customer->nama,
          ],

        ];
    }
}
