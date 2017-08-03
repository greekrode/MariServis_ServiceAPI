<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\Collection;

use App\Acme\ServiceTypes\ServiceTypeTransformer;
use App\Extensions\Serializers\CustomSerializer;
use App\ServiceType;

class ServiceTypeController extends Controller
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
     *   path="/api/v1/service_types",
     *   summary="Retrieves the collection of Service types resource.",
     *   produces={"application/json"},
     *   tags={"service_types"},
     *   @SWG\Response(
     *       response=200,
     *       description="Service type collection.",
     *       @SWG\Schema(
     *           type="array",
     *           @SWG\Items(ref="#/definitions/servicetype")
     *       )
     *   ),
     *   @SWG\Response(
     *       response=401,
     *       description="Unauthorized action.",
     *   ),
     *   @SWG\Parameter(
     *       name="Authorization",
     *       description="e.g : Bearer (space) 'your_token_here'(without quotation) ",
     *       in="header",
     *       required=true,
     *       type="string",
     *       default="Bearer "
     *   )
     * )
     */
    public function index()
    {
        $serviceTypes = ServiceType::all();
        $total = count($serviceTypes);

        $resource = new Collection($serviceTypes, new ServiceTypeTransformer($total), 'serviceTypes');
        // need "toArray()" if not toArray() it will error: UnexpectedValueException, because -> createData() return an object.
        return $this->manager->createData($resource)->toArray();
    }

    // /**
    //  * Show the form for creating a new resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function create()
    // {
    //
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    /**
     * @SWG\Post(
     *      path="/api/v1/service_types",
     *      summary="Add new Service type.",
     *      produces={"application/json"},
     *      consumes={"application/json"},
     *      tags={"service_types"},
     *      @SWG\Response(
     *          response=200,
     *          description="New Service type has successfully added.",
     *          @SWG\Schema(
     *              type="array",
     *              @SWG\Items(ref="#/definitions/servicetype")
     *          )
     *      ),
     *      @SWG\Response(
     *          response=401,
     *          description="Unauthorized action."
     *      ),
     *      @SWG\Parameter(
     *          name="Authorization",
     *          description="e.g : Bearer(space) 'your_token_here' (without quotation) ",
     *          in="header",
     *          required=true,
     *          type="string",
     *          default="Bearer ",
     *      ),
     *       @SWG\Parameter(
     *           name="body",
     *           in="body",
     *           required=true,
     *           description="Service type object that needs to be added to the database",
     *           type="string",
     *           @SWG\Schema(
     *               @SWG\Property(
     *                   property="nama",
     *                   type="string"
     *               ),
     *               @SWG\Property(
     *                   property="harga",
     *                   type="decimal"
     *               ),
     *               @SWG\Property(
     *                   property="department_id",
     *                   type="integer",
     *                   format="int32"
     *               ),
     *           )
     *      )
     * )
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $serviceType = new ServiceType();
        $serviceType->create($input);

        return redirect()->route('api.v1.service_types.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * @SWG\Get(
     *      path="/api/v1/service_types/{id}",
     *      summary="Find Service type by ID.",
     *      produces={"application/json"},
     *      tags={"service_types"},
     *      @SWG\Response(
     *          response=200,
     *          description="Service type has been founded.",
     *          @SWG\Schema(
     *              type="array",
     *              @SWG\Items(ref="#/definitions/servicetype")
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
     *          description="Service tpye not found."
     *      ),
     *      @SWG\Parameter(
     *          name="Authorization",
     *          description="e.g : Bearer(space) 'your_token_here' (without quotation) ",
     *          in="header",
     *          required=true,
     *          type="string",
     *          default="Bearer ",
     *      ),
     *      @SWG\Parameter(
     *           name="id",
     *           in="path",
     *           description="Please enter the ID of the Service type",
     *           required=true,
     *           type="integer"
     *      )
     * )
     */
    public function show($id)
    {
        $serviceType = ServiceType::findOrFail($id);
        $total = count($serviceType);

        $resource = new Item($serviceType, new ServiceTypeTransformer($total), "serviceType");

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

    /**
     * @SWG\Put(
     *      path="/api/v1/service_types/{id}",
     *      summary="Add new Service type.",
     *      produces={"application/json"},
     *      consumes={"application/json"},
     *      tags={"service_types"},
     *      @SWG\Response(
     *          response=200,
     *          description="The Service type data has been successfully updated.",
     *          @SWG\Schema(
     *              type="array",
     *              @SWG\Items(ref="#/definitions/servicetype")
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
     *          description="Service type not found."
     *      ),
     *      @SWG\Parameter(
     *          name="Authorization",
     *          description="e.g : Bearer(space) 'your_token_here' (without quotation) ",
     *          in="header",
     *          required=true,
     *          type="string",
     *          default="Bearer ",
     *      ),
     *      @SWG\Parameter(
     *           name="id",
     *           in="path",
     *           description="Please enter the ID of the Service type",
     *           required=true,
     *           type="integer"
     *      ),
     *       @SWG\Parameter(
     *           name="body",
     *           in="body",
     *           required=true,
     *           description="Service type object that needs to be updated to the database",
     *           type="string",
     *           @SWG\Schema(
     *               @SWG\Property(
     *                   property="nama",
     *                   type="string"
     *               ),
     *               @SWG\Property(
     *                   property="harga",
     *                   type="decimal"
     *               ),
     *               @SWG\Property(
     *                   property="department_id",
     *                   type="integer",
     *                   format="int32"
     *               ),
     *           )
     *      )
     * )
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();

        $serviceType = ServiceType::findOrFail($id);
        $serviceType->update($input);

        return response()->JSON($serviceType);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * @SWG\Delete(
     *      path="/api/v1/service_types/{id}",
     *      summary="Remove the Service type resource.",
     *      produces={"application/json"},
     *      tags={"service_types"},
     *      @SWG\Response(
     *          response=204,
     *          description="Service type resource deleted."
     *      ),
     *      @SWG\Response(
     *          response=401,
     *          description="Unauthorized action."
     *      ),
     *      @SWG\Response(
     *          response=404,
     *          description="Service type not found."
     *      ),
     *      @SWG\Parameter(
     *          name="Authorization",
     *          description="e.g : Bearer(space) 'your_token_here' (without quotation) ",
     *          in="header",
     *          required=true,
     *          type="string",
     *          default="Bearer ",
     *      ),
     *      @SWG\Parameter(
     *           name="id",
     *           in="path",
     *           description="Please enter the ID of the Service type",
     *           required=true,
     *           type="integer"
     *      ),
     * )
     */
    public function destroy($id)
    {
        // find, if find find fails it will throws -> "FatalThrowableError"
        // findOrFail, if find fails it will throws -> "NotFoundHttpException"
        $serviceType = ServiceType::findOrFail($id);
        $serviceType->delete();

        return response()->JSON($serviceType);
    }
}
