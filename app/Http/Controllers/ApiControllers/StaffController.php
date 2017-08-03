<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\Collection;

use App\Acme\Staffs\StaffTransformer;
use App\Extensions\Serializers\CustomSerializer;
use App\Staff;

class StaffController extends Controller
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
     *   path="/api/v1/staffs",
     *   summary="Retrieves the collection of Staffs resource.",
     *   produces={"application/json"},
     *   tags={"staffs"},
     *   @SWG\Response(
     *       response=200,
     *       description="Customers collection.",
     *       @SWG\Schema(
     *           type="array",
     *           @SWG\Items(ref="#/definitions/staff")
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
        $staffs = Staff::all();
        $total = count($staffs);

        $resource = new Collection($staffs, new StaffTransformer($total), 'staffs');
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
     *      path="/api/v1/staffs",
     *      summary="Add new Staff.",
     *      produces={"application/json"},
     *      consumes={"application/json"},
     *      tags={"staffs"},
     *      @SWG\Response(
     *          response=200,
     *          description="New Staff has successfully added.",
     *          @SWG\Schema(
     *              type="array",
     *              @SWG\Items(ref="#/definitions/staff")
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
     *           description="Staff object that needs to be added to the database",
     *           type="string",
     *           @SWG\Schema(
     *               @SWG\Property(
     *                   property="nama",
     *                   type="string"
     *               ),
     *               @SWG\Property(
     *                   property="no_telp",
     *                   type="string"
     *               ),
     *               @SWG\Property(
     *                   property="alamat",
     *                   type="string"
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

        $staff = new Staff();
        $staff->create($input);

        return redirect()->route('api.v1.staffs.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * @SWG\Get(
     *      path="/api/v1/staffs{id}",
     *      summary="Find staff by ID.",
     *      produces={"application/json"},
     *      tags={"staffs"},
     *      @SWG\Response(
     *          response=200,
     *          description="Staff has been founded.",
     *          @SWG\Schema(
     *              type="array",
     *              @SWG\Items(ref="#/definitions/staff")
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
     *          description="Staff not found."
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
     *           description="Please enter the ID of the staff",
     *           required=true,
     *           type="integer"
     *      )
     * )
     */
    public function show($id)
    {
        $staff = Staff::findOrFail($id);
        $total = count($staff);

        $resource = new Item($staff, new StaffTransformer($total), "staff");

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
     *      path="/api/v1/staffs/{id}",
     *      summary="Add new Staff.",
     *      produces={"application/json"},
     *      consumes={"application/json"},
     *      tags={"staffs"},
     *      @SWG\Response(
     *          response=200,
     *          description="The Staff data has successfully updated",
     *          @SWG\Schema(
     *              type="array",
     *              @SWG\Items(ref="#/definitions/staff")
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
     *           description="Staff object that needs to be updated to the database",
     *           type="string",
     *           @SWG\Schema(
     *               @SWG\Property(
     *                   property="nama",
     *                   type="string"
     *               ),
     *               @SWG\Property(
     *                   property="no_telp",
     *                   type="string"
     *               ),
     *               @SWG\Property(
     *                   property="alamat",
     *                   type="string"
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

        $staff = Staff::findOrFail($id);
        $staff->update($input);

        return response()->JSON($staff);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * @SWG\Delete(
     *      path="/api/v1/staffs/{id}",
     *      summary="Remove the Staff resource.",
     *      produces={"application/json"},
     *      tags={"staffs"},
     *      @SWG\Response(
     *          response=204,
     *          description="Staff resource deleted."
     *      ),
     *      @SWG\Response(
     *          response=401,
     *          description="Unauthorized action."
     *      ),
     *      @SWG\Response(
     *          response=404,
     *          description="Staff not found."
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
     *           description="Please enter the ID of the Staff",
     *           required=true,
     *           type="integer"
     *      ),
     * )
     */
    public function destroy($id)
    {
        // find, if find find fails it will throws -> "FatalThrowableError"
        // findOrFail, if find fails it will throws -> "NotFoundHttpException"
        $staff = Staff::findOrFail($id);
        $staff->delete();

        return response()->JSON($staff);
    }
}
