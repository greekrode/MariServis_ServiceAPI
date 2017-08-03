<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\Collection;

use App\Acme\Inventories\InventoryTransformer;
use App\Extensions\Serializers\CustomSerializer;
use App\Inventory;

class InventoryController extends Controller
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
     *   path="/api/v1/inventories",
     *   summary="Retrieves the collection of Inventories resource.",
     *   produces={"application/json"},
     *   tags={"inventories"},
     *   @SWG\Response(
     *       response=200,
     *       description="Inventories collection.",
     *       @SWG\Schema(
     *           type="array",
     *           @SWG\Items(ref="#/definitions/inventory")
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
        $inventories = Inventory::all();
        $total = count($inventories);

        $resource = new Collection($inventories, new InventoryTransformer($total), "inventories");

        return $this->manager->createData($resource)->toArray();
    }

    // /**
    //  * Show the form for creating a new resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function create()
    // {
    //     //
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    /**
     * @SWG\Post(
     *      path="/api/v1/inventories",
     *      summary="Add new Inventory.",
     *      produces={"application/json"},
     *      consumes={"application/json"},
     *      tags={"inventories"},
     *      @SWG\Response(
     *          response=200,
     *          description="New Inventory has successfully added.",
     *          @SWG\Schema(
     *              type="array",
     *              @SWG\Items(ref="#/definitions/inventory")
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
     *           description="Inventory object that needs to be added to the database",
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
     *                   property="qty",
     *                   type="integer",
     *                   format="int32"
     *               ),
     *               @SWG\Property(
     *                   property="category_id",
     *                   type="integer",
     *                   format="in32"
     *               ),
     *           )
     *      )
     * )
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $inventory = new Inventory();
        $inventory->create($input);

        return redirect()->route('api.v1.inventories.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * @SWG\Get(
     *      path="/api/v1/inventories/{id}",
     *      summary="Find Inventory by ID",
     *      produces={"application/json"},
     *      consumes={"application/json"},
     *      tags={"inventories"},
     *      @SWG\Response(
     *          response=200,
     *          description="Data has been founded.",
     *          @SWG\Schema(
     *              type="array",
     *              @SWG\Items(ref="#/definitions/inventory")
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
     *      @SWG\Parameter(
     *           name="id",
     *           in="path",
     *           description="Please enter the ID of the Inventory",
     *           required=true,
     *           type="integer"
     *      )
     * )
     */
    public function show($id)
    {
        $inventory = Inventory::findOrFail($id);
        $total = count($inventory);

        $resource = new Item($inventory, new InventoryTransformer($total), 'inventory');

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
     *      path="/api/v1/inventories/{id}",
     *      summary="Update the Category resource.",
     *      produces={"application/json"},
     *      consumes={"application/json"},
     *      tags={"inventories"},
     *      @SWG\Response(
     *          response=200,
     *          description="The Inventory data has been successfully updated.",
     *          @SWG\Schema(
     *              type="array",
     *              @SWG\Items(ref="#/definitions/inventory")
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
     *          description="Inventory not found."
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
     *           description="Please enter the ID of the Inventory",
     *           required=true,
     *           type="integer"
     *      ),
     *       @SWG\Parameter(
     *           name="body",
     *           in="body",
     *           required=true,
     *           description="Inventory object that needs to be updated to the database",
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
     *                   property="qty",
     *                   type="integer",
     *                   format="int32"
     *               ),
     *               @SWG\Property(
     *                   property="category_id",
     *                   type="integer",
     *                   format="in32"
     *               ),
     *           )
     *      )
     * )
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();

        $inventory = Inventory::findOrFail($id);
        $inventory->update($input);

        return response()->JSON($inventory);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * @SWG\Delete(
     *      path="/api/v1/inventories/{id}",
     *      summary="Remove the Inventory resource.",
     *      produces={"application/json"},
     *      tags={"inventories"},
     *      @SWG\Response(
     *          response=204,
     *          description="Inventory resource deleted."
     *      ),
     *      @SWG\Response(
     *          response=401,
     *          description="Unauthorized action."
     *      ),
     *      @SWG\Response(
     *          response=404,
     *          description="Inventory not found."
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
     *           description="Please enter the ID of the category",
     *           required=true,
     *           type="integer"
     *      ),
     * )
     */
    public function destroy($id)
    {
        $inventory = Inventory::findOrFail($id);
        $inventory->delete();

        return response()->JSON($inventory);
    }
}
