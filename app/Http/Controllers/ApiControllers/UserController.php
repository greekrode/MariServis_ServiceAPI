<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use JWTAuth;
use JWTAuthException;

use Sorskod\Larasponse\Larasponse;
use App\Acme\Users\UserTransformer;

use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\Serializer\DataArraySerializer;
use League\Fractal\Serializer\JsonApiSerializer;
use League\Fractal\Resource\Collection;
use App\Extensions\Serializers\CustomSerializer;

use App\User;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{
    private $user;
    private $manager;


    public function __construct(User $user, Larasponse $fractal){
        $this->user = $user;

        $this->fractal = $fractal;
        $this->manager = new Manager();
    }

    public function register(UserRequest $request){
        $user = $this->user->create([
          'name' => $request->get('name'),
          'email' => $request->get('email'),
          'password' => bcrypt($request->get('password'))
        ]);

        $user->customer()->create([
          'nama' => $request['name'],
          'alamat' => $request['alamat'],
          'no_telp' => $request['no_telp']
        ]);


        return response()->json(['status'=>true,'message'=>'User created successfully','data'=>$user]);
    }

    public function login(Request $request){
        $credentials = $request->only('email', 'password');
        $tokenPlaceholder = null;
        try {

           if ( !$tokenPlaceholder = JWTAuth::attempt($credentials)) {

            return response()->json(['invalid_email_or_password'], 422);
          }
        } catch (JWTAuthException $e) {

            return response()->json(['failed_to_create_token'], 500);
        }
        return response()->json(['token' => $tokenPlaceholder]);
    }

    function testIf() {
        $var1 = "null";

        if (!$var1 = 0) {
           return "NOT " . $var1;
        }

        return $var1;
    }

    public function getAuthUser(Request $request){

        $this->manager->setSerializer(new JsonApiSerializer());

        $user = JWTAuth::parseToken()->toUser();
        $user->token = substr($request->headers->get('Authorization'), 7);


        $resource = new Item($user, new UserTransformer(), 'user');
        return $this->manager->createData($resource)->toArray();
    }


}
