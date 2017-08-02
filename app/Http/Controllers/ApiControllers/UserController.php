<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Acme\Users\UserTransformer;

use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\Collection;
use App\Extensions\Serializers\CustomSerializer;

use App\User;
use App\Http\Requests\UserRequest;
use Auth;

class UserController extends Controller
{
    private $user;
    private $manager;


    public function __construct(User $user){
        $this->user = $user;

        $this->manager = new Manager();

        // $this->middleware('auth');
    }

    /**
     * @SWG\Post(
     *   path="/api/auth/register",
     *   summary="Register User",
     *   produces={"application/json"},
     *   consumes={"application/json"},
     *   tags={"register"},
     *   @SWG\Response(
     *       response=200,
     *       description="User registered.",
     *       @SWG\Property(
     *           property="token",
     *           type="string"
     *       )
     *   ),
     *   @SWG\Response(
     *       response=401,
     *       description="Unauthorized action."
     *   ),
     *   @SWG\Parameter(
     *       name="body",
     *       in="body",
     *       required=true,
     *       type="string",
     *       @SWG\Schema(
     *           type="string"
     *    )
     *   )
     * )
     */

    public function register(UserRequest $request){
        $user = $this->user->create([
          'username' => ucfirst($request->get('username')),
          'email' => strtolower($request->get('email')),
          'password' => bcrypt($request->get('password')),
        ]);

        $user->customer()->create([
          'nama' => ucfirst($request['name']),
          'alamat' => ucfirst($request['address']),
          'no_telp' => $request['phoneNumber']
        ]);

        return response()->json(['status'=>true,'message'=>'User created successfully','data'=>$user]);
    }

    public function login(Request $request){// HERE IS THE PROCESS WHEN "VALIDATE CREDENTIALS" AND JWT "GENERATE A TOKEN" FOR USER
        $credentials = $request->only('email', 'password');
        $tokenPlaceholder = null;
        try {
           // attempt to verify the "credentials" and create a "token" for the user
           // JWTAuth::attempt($credentials) -> return token
           if ( !$tokenPlaceholder = JWTAuth::attempt($credentials)) {// ! foo = bar -> if bar "not(!) found(=)" execute the if.
              throw new JWTException();
            // return response()->json(['invalid_email_or_password'], 422);
          }
        } catch (Exception $e) {
            // something went wrong whilst attempting to encode the token
            throw new JWTException();
        }


        // return response()->json(['token' => $tokenPlaceholder]);
        $token = $tokenPlaceholder;

        return redirect('/api/v1/user?token=' . $token);

    }


    /*--------------------BEGIN-----------------------*/
    function testIf() {
        $var1 = "null";

        if (!$var1 = 0) { // if "not found" -> (empty str, "0", 0, false), then "if statement" will get executed and $var1 equals to that value.
           return "NOT " . $var1;
        }

        return $var1; // get executed if $var1 = anything EXCEPT(empty str, "0", 0, false).
    }
    /*--------------------END-----------------------*/
    public function getAuthUser(Request $request){
        // PASSING FROM MIDDLEWARE "VerifyJWTToken" -> try { $user = JWTAuth::toUser($request->input('token')); }
        $this->manager->setSerializer(new CustomSerializer());
        $user = JWTAuth::toUser($request->token);
        // $user = Auth::user(); // JUST CHECK IF THE EMAIL AND PASSWORD MATCH THE DATABASE, ->config\auth.php, 'model' => App\User::class.
        // $user = JWTAuth::parseToken()->toUser();
        // return view('welcome', compact('user'));
        $user->token = $request->token;

        //return response()->json(['result' => $user, 'token' => substr($request->headers->get('Authorization'), 7)]);
        //return $this->fractal->item($user, new UserTransformer());
        $resource = new Item($user, new UserTransformer(), 'user'); // third parameter -> 'user' is a resource KEY. JsonApiSerializer need resource key to add "type".
        return $this->manager->createData($resource)->toArray();
    }

    // public function getToken(Request $request)
    // {
    //     // $token = JWTAuth::getToken();
    //     //
    //     // if (! $token) {
    //     //     throw new BadRequestHttpException('Token not provided');
    //     // }
    //     //
    //     // try {
    //     //     $token = JWTAuth::refresh($token);
    //     // } catch (TokenInvalidException $e) {
    //     //     throw new AccessDeniedHttpException('The token is invalid');
    //     // }
    //     //
    //     // return $token;
    // }
}
