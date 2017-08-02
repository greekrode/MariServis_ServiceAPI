<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\Collection;

use App\Acme\Cars\CarTransformer;
use App\Extensions\Serializers\CustomSerializer;
use App\Car;
use App\Customer;

class CarController extends Controller
{
    private $manager;

    public function __construct() {
        $this->manager = new Manager();
        $this->manager->setSerializer(new CustomSerializer());
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * @SWG\Get(
     *   path="/api/v1/cars",
     *   summary="Retrieves the collection of Cars resource.",
     *   produces={"application/json"},
     *   tags={"cars"},
     *   @SWG\Response(
     *       response=200,
     *       description="Cars collection.",
     *       @SWG\Schema(
     *           type="array",
     *           @SWG\Items(ref="#/definitions/car")
     *       )
     *   ),
     *   @SWG\Response(
     *       response=401,
     *       description="Unauthorized action.",
     *   ),
     *   @SWG\Parameter(
     *       name="Authorization",
     *       description="e.g : Bearer (space) "your_token_here"(without quotation) ",
     *       in="header",
     *       required=true,
     *       type="string",
     *       default="Bearer "
     *   )
     * )
     */

    public function index()
    {
        $cars = Car::all();
        $total = count($cars);

        $resource = new Collection($cars, new CarTransformer($total), 'cars');
        // need "toArray()" if not toArray() it will error: UnexpectedValueException, because -> createData() return an object.
        return $this->manager->createData($resource)->toArray();
    }

    // /**
    //  * Show the form for creating a new resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
     public function create()
     {

     }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /**
     * @SWG\Post(
     *      path="/api/v1/car",
     *      summary="Add new Car.",
     *      produces={"application/json"},
     *      consumes={"application/json"},
     *      tags={"cars"},
     *      @SWG\Response(
     *          response=200,
     *          description="New Car has successfully added.",
     *          @SWG\Schema(
     *              type="array",
     *              @SWG\Items(ref="#/definitions/car")
     *          )
     *      ),
     *      @SWG\Response(
     *          response=401,
     *          description="Unauthorized action."
     *      ),
     *      @SWG\Parameter(
     *          name="Authorization",
     *          description="e.g : Bearer(space) "your_token_here" (without quotation) ",
     *          in="header",
     *          required=true,
     *          type="string",
     *          default="Bearer ",
     *      ),
     *       @SWG\Parameter(
     *           name="body",
     *           in="body",
     *           required=true,
     *           description="Car object that needs to be added to the database",
     *           type="string",
     *           @SWG\Schema(
     *               @SWG\Property(
     *                   property="nama",
     *                   type="string"
     *               ),
     *               @SWG\Property(
     *                   property="jenis",
     *                   type="string"
     *               ),
     *               @SWG\Property(
     *                   property="no_plat",
     *                   type="string"
     *               ),
     *               @SWG\Property(
     *                   property="model",
     *                   type="string"
     *               ),
     *               @SWG\Property(
     *                   property="customer_id",
     *                   type="integer",
     *                   format="int32"
     *               ),
     *           )
     *      )
     * )
     */

    public function store(Request $request)
    {
        // $customer_id = Auth::user()->customer->id;
        $customer = Customer::findOrFail(1);

        $input = $request->all();

        $customer->cars()->create($input);

        return redirect()->route('api.v1.cars.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * @SWG\Get(
     *      path="/api/v1/car/{id}",
     *      summary="Find Car by ID.",
     *      produces={"application/json"},
     *      tags={"cars"},
     *      @SWG\Response(
     *          response=200,
     *          description="Data has been founded.",
     *          @SWG\Schema(
     *              type="array",
     *              @SWG\Items(ref="#/definitions/car")
     *          )
     *      ),
     *      @SWG\Response(
     *          response=400,
     *          description="Invalid ID."
     *      ),
     *      @SWG\Response(
     *          response=401,
     *          description="Unauthorized action."
     *      ),
     *      @SWG\Response(
     *          response=404,
     *          description="Category not found."
     *      ),
     *      @SWG\Parameter(
     *          name="Authorization",
     *          description="Example = Bearer(space)'your_token'",
     *          in="header",
     *          required=true,
     *          type="string",
     *          default="Bearer",
     *      ),
     *      @SWG\Parameter(
     *           name="id",
     *           in="path",
     *           description="Please enter the categoryId",
     *           required=true,
     *           type="integer"
     *      )
     * )
     */

    public function show($id)
    {
        $car = Car::findOrFail($id);
        $total = count($car);

        $resource = new Item($car, new CarTransformer($total), "car");

        return $this->manager->createData($resource)->toArray();
    }

    // /**
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function edit($id)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();

        $car = Car::findOrFail($id);
        $car->update($input);

        return response()->JSON($car);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /**
     * @SWG\Delete(
     *   path="/api/v1/cars/{id}",
     *   summary="Removes the collection of Car resource.",
     *   produces={"application/json"} ,
     *   tags={"cars"},
     *   @SWG\Response(
     *       response=200,
     *       description="Mediafiles resource deleted.",
     *   ),
     *   @SWG\Response(
     *       response=401,
     *       description="Unauthozied action.",
     *   ),
     *   @SWG\Response(
     *       response=404,
     *       description="Resource not found.",
     *   ),
     *   @SWG\Parameter(
     *       name="Authorization",
     *       in="header",
     *       required=true,
     *       type="string"
     *   ),
     *   @SWG\Parameter(
     *       name="id",
     *       in="path",
     *       required=true,
     *       type="integer"
     *   ),
     * )
     */
    public function destroy($id)
    {
        // find, if find find fails it will throws -> "FatalThrowableError"
        // findOrFail, if find fails it will throws -> "NotFoundHttpException"
        $car = Car::findOrFail($id);
        $car->delete();

        return response()->JSON($car);
    }
}
