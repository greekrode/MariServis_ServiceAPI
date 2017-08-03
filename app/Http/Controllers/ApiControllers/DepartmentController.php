<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\Collection;

use App\Acme\Departments\DepartmentTransformer;
use App\Extensions\Serializers\CustomSerializer;
use App\Department;

class DepartmentController extends Controller
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
     *   path="/api/v1/departments",
     *   summary="Retrieves the collection of Departments resource.",
     *   produces={"application/json"},
     *   tags={"departments"},
     *   @SWG\Response(
     *       response=200,
     *       description="Departments collection.",
     *       @SWG\Schema(
     *           type="array",
     *           @SWG\Items(ref="#/definitions/department")
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
        $departments = Department::all()->sortBy('id');
        $total = count($departments);

        $resource = new Collection($departments, new DepartmentTransformer($total), 'departments');
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
     *      path="/api/v1/departments",
     *      summary="Add new Department.",
     *      produces={"application/json"},
     *      consumes={"application/json"},
     *      tags={"departments"},
     *      @SWG\Response(
     *          response=200,
     *          description="New Department has successfully added.",
     *          @SWG\Schema(
     *              type="array",
     *              @SWG\Items(ref="#/definitions/department")
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
     *           description="Department object that needs to be added to the database",
     *           type="string",
     *           @SWG\Schema(
     *               @SWG\Property(
     *                   property="nama",
     *                   type="string"
     *               )
     *           )
     *      )
     * )
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $department = new Department();
        $department->create($input);

        return redirect()->route('api.v1.departments.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * @SWG\Get(
     *      path="/api/v1/departments/{id}",
     *      summary="Find Department by ID",
     *      produces={"application/json"},
     *      consumes={"application/json"},
     *      tags={"departments"},
     *      @SWG\Response(
     *          response=200,
     *          description="Data has been founded.",
     *          @SWG\Schema(
     *              type="array",
     *              @SWG\Items(ref="#/definitions/department")
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
     *           description="Please enter the ID of the department",
     *           required=true,
     *           type="integer"
     *      )
     * )
     */
    public function show($id)
    {
        $department = Department::findOrFail($id);
        $total = count($department);

        $resource = new Item($department, new DepartmentTransformer($total), "department");

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
     *      path="/api/v1/departments/{id}",
     *      summary="Update the Inventory resource.",
     *      produces={"application/json"},
     *      consumes={"application/json"},
     *      tags={"departments"},
     *      @SWG\Response(
     *          response=200,
     *          description="The Department data has been successfully updated.",
     *          @SWG\Schema(
     *              type="array",
     *              @SWG\Items(ref="#/definitions/department")
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
     *          description="Department not found."
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
     *           description="Please enter the ID of the department",
     *           required=true,
     *           type="integer"
     *      ),
     *       @SWG\Parameter(
     *           name="body",
     *           in="body",
     *           required=true,
     *           description="Department object that needs to be updated to the database",
     *           type="string",
     *           @SWG\Schema(
     *               @SWG\Property(
     *                   property="nama",
     *                   type="string"
     *               )
     *           )
     *      )
     * )
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();

        $department = Department::findOrFail($id);
        $department->update($input);

        return response()->JSON($department);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * @SWG\Delete(
     *      path="/api/v1/departments/{id}",
     *      summary="Remove the Department resource.",
     *      produces={"application/json"},
     *      tags={"departments"},
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
     *           description="Please enter the ID of the Inventory",
     *           required=true,
     *           type="integer"
     *      ),
     * )
     */
    public function destroy($id)
    {
        // find, if find find fails it will throws -> "FatalThrowableError"
        // findOrFail, if find fails it will throws -> "NotFoundHttpException"
        $department = Department::findOrFail($id);
        $department->delete();

        return response()->JSON($department);
    }
}
