<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Sorskod\Larasponse\Larasponse;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\Collection;

use App\Category;
use App\Acme\Categories\CategoryTransformer;
use App\Extensions\Serializers\CustomSerializer;


class CategoryController extends Controller
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
     *   path="/api/v1/categories",
     *   summary="Retrieves the collection of Categories resource.",
     *   produces={"application/json"},
     *   tags={"categories"},
     *   @SWG\Response(
     *       response=200,
     *       description="Categories collection.",
     *       @SWG\Schema(
     *           type="array",
     *           @SWG\Items(ref="#/definitions/category")
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
        $categories = Category::all()->sortBy('id');
        $total = count($categories);

        $resource = new Collection($categories, new CategoryTransformer($total), 'categories');
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
     *      path="/api/v1/categories",
     *      summary="Add new Category.",
     *      produces={"application/json"},
     *      consumes={"application/json"},
     *      tags={"categories"},
     *      @SWG\Response(
     *          response=200,
     *          description="New Category has successfully added.",
     *          @SWG\Schema(
     *              type="array",
     *              @SWG\Items(ref="#/definitions/category")
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
     *           description="Category object that needs to be added to the database",
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

        $category = new Category();
        $category->create($input);

        return redirect()->route('api.v1.categories.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * @SWG\Get(
     *      path="/api/v1/categories/{id}",
     *      summary="Find Category by ID.",
     *      produces={"application/json"},
     *      tags={"categories"},
     *      @SWG\Response(
     *          response=200,
     *          description="Data has been founded.",
     *          @SWG\Schema(
     *              type="array",
     *              @SWG\Items(ref="#/definitions/category")
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
     *      )
     * )
     */
    public function show($id)
    {
        $category = Category::findOrFail($id);
        $total = count($category);

        $resource = new Item($category, new CategoryTransformer($total), "category");

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
     *      path="/api/v1/categories/{id}",
     *      summary="Update the Category resource.",
     *      produces={"application/json"},
     *      consumes={"application/json"},
     *      tags={"categories"},
     *      @SWG\Response(
     *          response=200,
     *          description="The Category data has been successfully updated.",
     *          @SWG\Schema(
     *              type="array",
     *              @SWG\Items(ref="#/definitions/category")
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
     *       @SWG\Parameter(
     *           name="body",
     *           in="body",
     *           required=true,
     *           description="Category object that needs to be updated to the database",
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

        $category = Category::findOrFail($id);
        $category->update($input);

        return response()->JSON($category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * @SWG\Delete(
     *      path="/api/v1/categories/{id}",
     *      summary="Remove the Category resource.",
     *      produces={"application/json"},
     *      tags={"categories"},
     *      @SWG\Response(
     *          response=204,
     *          description="Category resource deleted."
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
        // find, if find find fails it will throws -> "FatalThrowableError"
        // findOrFail, if find fails it will throws -> "NotFoundHttpException"
        $category = Category::findOrFail($id);
        $category->delete();

        return response()->JSON($category);
    }
}
