<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\Collection;
use Carbon\Carbon;

use App\Acme\Services\ServiceTransformer;
use App\Extensions\Serializers\CustomSerializer;
use App\Service;
use App\Http\Requests\ServiceRequest;
use App\User;

class ServiceController extends Controller
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
     *   path="/api/v1/services",
     *   summary="Retrieves the collection of Services resource.",
     *   produces={"application/json"},
     *   tags={"services"},
     *   @SWG\Response(
     *       response=200,
     *       description="Services collection.",
     *       @SWG\Schema(
     *           type="array",
     *           @SWG\Items(ref="#/definitions/service")
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
        $services = Service::all();
        $total = count($services);

        $resource = new Collection($services, new ServiceTransformer($total), 'services');
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
     *      path="/api/v1/services",
     *      summary="Add new Service.",
     *      produces={"application/json"},
     *      consumes={"application/json"},
     *      tags={"services"},
     *      @SWG\Response(
     *          response=200,
     *          description="New Service has successfully added.",
     *          @SWG\Schema(
     *              type="array",
     *              @SWG\Items(ref="#/definitions/service")
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
     *           description="Service object that needs to be added to the database",
     *           type="string",
     *           @SWG\Schema(
     *   @SWG\Property(
     *       property="inventory_ids",
     *       type="integer",
     *       format="int32"
     *   ),
     *   @SWG\Property(
     *       property="inventory_qtys",
     *       type="integer",
     *       format="int32"
     *   ),
     *   @SWG\Property(
     *       property="service_type_id",
     *       type="integer",
     *       format="int32"
     *   ),
     *   @SWG\Property(
     *       property="payment_id",
     *       type="integer",
     *       format="int32"
     *   ),
     *   @SWG\Property(
     *       property="user_id",
     *       type="integer",
     *       format="int32"
     *   ),
     *           )
     *      )
     * )
     */
    public function store(ServiceRequest $request)
    {
        $count_array_inventory_ids = count(explode(',', $request['inventory_ids']));
        $count_array_inventory_qtys = count(explode(',', $request['inventory_qtys']));

        if ($count_array_inventory_ids == $count_array_inventory_qtys) {
            if (strlen($request['service_type_ids']) > 0
                || (strlen($request['inventory_ids']) > 0
                && strlen($request['inventory_qtys']) > 0)) {
                // $user = Auth::user();
                $user = User::findOrFail($request['user_id']);
                $ref_no = time() . rand(10*45, 100*98) . $user->customer->id;

                $service = new Service();
                $service->ref_no =  $ref_no;
                $service->customer_id = $user->customer->id;
                $service->payment_id = $request['payment_id'];
                $service->car_id = $request['car_id'];
                // $service->status_transaksi_id = $request['status_transaksi_id'];
                // $service->status_service_id = $request['status_service_id'];
                $service->save();
            } else {
                return response()->json(['error' => 'Please review your services']);
            }
        } else {
            return response()->json(['error' => 'Please review your services']);
        }

        // REMEMBER: ATTACHING PROCESS MUST BE DONE AFTER $service->create().
        // Attach service_service_type
        // check if the "service_type_ids" is provided
        if (strlen($request['service_type_ids']) > 0) { // always provided anyway because of the request's rule.
            // 1. From str to array of service_type's id
            $service_type_ids = explode(',', $request['service_type_ids']);
            // 2. Attaching process
            foreach ($service_type_ids as $sstid) {
                $service->serviceTypes()->attach($sstid);
            }
        }
        // Attach inventory_service
        if (strlen($request['inventory_ids']) > 0 && strlen($request['inventory_qtys']) > 0) {
            $inventory_ids = explode(',', $request['inventory_ids']);
            $inventory_qtys = explode(',', $request['inventory_qtys']);
            $i = 0;

            foreach ($inventory_ids as $iid) {
                $inventory_price = \App\Inventory::find($iid)->harga;
                $service->inventories()
                        ->attach($iid, array('qty' => $inventory_qtys[$i],
                                             'total_harga' => (Double) ($inventory_qtys[$i] * $inventory_price)));

                $i += 1;
            }
        }

        return redirect()->route('api.v1.services.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * @SWG\Get(
     *      path="/api/v1/services/{id}",
     *      summary="Find Service by ID.",
     *      produces={"application/json"},
     *      tags={"services"},
     *      @SWG\Response(
     *          response=200,
     *          description="Data has been founded.",
     *          @SWG\Schema(
     *              type="array",
     *              @SWG\Items(ref="#/definitions/service")
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
     *          description="Service not found."
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
     *           description="Please enter the ID of the Service",
     *           required=true,
     *           type="integer"
     *      )
     * )
     */
    public function show($id)
    {
        $service = Service::findOrFail($id);
        $total = count($service);

        $resource = new Item($service, new ServiceTransformer($total), "service");

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
     *      path="/api/v1/services/{id}",
     *      summary="Update the Service resource.",
     *      produces={"application/json"},
     *      consumes={"application/json"},
     *      tags={"services"},
     *      @SWG\Response(
     *          response=200,
     *          description="The Service data has been successfully updated.",
     *          @SWG\Schema(
     *              type="array",
     *              @SWG\Items(ref="#/definitions/service")
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
     *          description="Service not found."
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
     *           description="Please enter the ID of the service",
     *           required=true,
     *           type="integer"
     *      ),
     *      @SWG\Parameter(
     *           name="body",
     *           in="body",
     *           required=true,
     *           description="Service object that needs to be updated to the database",
     *           type="string",
     *           @SWG\Schema(
     *   @SWG\Property(
     *       property="inventory_ids",
     *       type="integer",
     *       format="int32"
     *   ),
     *   @SWG\Property(
     *       property="inventory_qtys",
     *       type="integer",
     *       format="int32"
     *   ),
     *   @SWG\Property(
     *       property="service_type_id",
     *       type="integer",
     *       format="int32"
     *   ),
     *   @SWG\Property(
     *       property="payment_id",
     *       type="integer",
     *       format="int32"
     *   ),
     *   @SWG\Property(
     *       property="user_id",
     *       type="integer",
     *       format="int32"
     *   ),
     *           )
     *      )
     * )
     */
    public function update(ServiceRequest $request, $id)
    {
        $input = $request->all();

        $service = Service::findOrFail($id);
        $service->update($input);

        return redirect()->route('api.v1.services.show', ['id' => $id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * @SWG\Delete(
     *      path="/api/v1/services/{id}",
     *      summary="Remove the Service resource.",
     *      produces={"application/json"},
     *      tags={"services"},
     *      @SWG\Response(
     *          response=204,
     *          description="Service resource deleted."
     *      ),
     *      @SWG\Response(
     *          response=401,
     *          description="Unauthorized action."
     *      ),
     *      @SWG\Response(
     *          response=404,
     *          description="Service not found."
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
     *           description="Please enter the ID of the Service",
     *           required=true,
     *           type="integer"
     *      ),
     * )
     */
    public function destroy($id)
    {
        // find, if find find fails it will throws -> "FatalThrowableError"
        // findOrFail, if find fails it will throws -> "NotFoundHttpException"
        $service = Service::findOrFail($id);
        // delete row from service_service_type
        if (count($service->serviceTypes) > 0) {
            $service->serviceTypes()->detach();
        }
        // delete row from inventory_service
        if (count($service->inventories) > 0) {
            $service->inventories()->detach();
        }
        $service->delete();

        return response()->JSON(['Successfully cancel / delete the service.']);
    }
}
