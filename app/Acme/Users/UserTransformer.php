<?php

namespace App\Acme\Users;

use League\Fractal\TransformerAbstract; // using fractal package

use App\User;

class UserTransformer extends TransformerAbstract {

    public function transform(User $user) {
        return [
          'id' => (int) $user->id,
          'name' => $user->name,
          'email' => $user->email,
          'created_at' => $user->created_at,
          'updated_at' => $user->updated_at,
          'token' => $user->token,
        ];
    }
}
