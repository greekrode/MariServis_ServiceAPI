<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\Collection;

use App\Acme\Customers\CustomerTransformer;
use App\Extensions\Serializers\CustomSerializer;
use App\Customer;
use Auth;

class CustomerController extends Controller
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
     *   path="/api/v1/customers",
     *   summary="Retrieves the collection of Customers resource.",
     *   produces={"application/json"},
     *   tags={"customers"},
     *   @SWG\Response(
     *       response=200,
     *       description="Customers collection.",
     *       @SWG\Schema(
     *           type="array",
     *           @SWG\Items(ref="#/definitions/customer")
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
      $customers = Customer::all();
      $total = count($customers);

      $resource = new Collection($customers, new CustomerTransformer($total), "customers");

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
     *      path="/api/v1/customers",
     *      summary="Add new Customer.",
     *      produces={"application/json"},
     *      consumes={"application/json"},
     *      tags={"customers"},
     *      @SWG\Response(
     *          response=200,
     *          description="New Customer has successfully added.",
     *          @SWG\Schema(
     *              type="array",
     *              @SWG\Items(ref="#/definitions/customer")
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
     *           description="Customer object that needs to be added to the database",
     *           type="string",
     *           @SWG\Schema(
     *               @SWG\Property(
     *                   property="nama",
     *                   type="string"
     *               ),
     *               @SWG\Property(
     *                   property="alamat",
     *                   type="string"
     *               ),
     *               @SWG\Property(
     *                   property="no_telp",
     *                   type="string"
     *               )
     *           )
     *      )
     * )
     */
   public function store(Request $request)
   {
       $input = $request->all();

       $customer = new Customer();
       $customer->create($input);

       return redirect()->route('api.v1.customers.index');
   }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */

    /**
     * @SWG\Get(
     *      path="/api/v1/customer/{id}",
     *      summary="Find customer by ID.",
     *      produces={"application/json"},
     *      tags={"customers"},
     *      @SWG\Response(
     *          response=200,
     *          description="Data has been founded.",
     *          @SWG\Schema(
     *              type="array",
     *              @SWG\Items(ref="#/definitions/customer")
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
     *          description="customer not found."
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
     *           description="Please enter the ID of the customer",
     *           required=true,
     *           type="integer"
     *      )
     * )
     */
  public function show($id)
  {
      // if (!Auth::check()) {
      //     return response()->json(['error' => 'please login to access the api.']);
      // }
      $customer = Customer::findOrFail($id);
      $total = count($customer);

      $resource = new Item($customer, new CustomerTransformer($total), 'customer');

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
     *      path="/api/v1/customers/{id}",
     *      summary="Update the customer resource.",
     *      produces={"application/json"},
     *      consumes={"application/json"},
     *      tags={"customers"},
     *      @SWG\Response(
     *          response=200,
     *          description="The Customer data has been successfully updated.",
     *          @SWG\Schema(
     *              type="array",
     *              @SWG\Items(ref="#/definitions/customer")
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
     *          description="customer not found."
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
     *           description="Please enter the ID of the customer",
     *           required=true,
     *           type="integer"
     *      ),
     *       @SWG\Parameter(
     *           name="body",
     *           in="body",
     *           required=true,
     *           description="Customer object that needs to be updated to the database",
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

      $customer = Customer::findOrFail($id);
      $customer->update($input);

      return response()->JSON($customer);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */

    /**
     * @SWG\Delete(
     *      path="/api/v1/customers/{id}",
     *      summary="Remove the Customer resource.",
     *      produces={"application/json"},
     *      tags={"customers"},
     *      @SWG\Response(
     *          response=204,
     *          description="Customer resource deleted."
     *      ),
     *      @SWG\Response(
     *          response=401,
     *          description="Unauthorized action."
     *      ),
     *      @SWG\Response(
     *          response=404,
     *          description="Customer not found."
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
     *           description="Please enter the ID of the Customer",
     *           required=true,
     *           type="integer"
     *      ),
     * )
     */
  public function destroy($id)
  {
      $customer = Customer::findOrFail($id);
      $customer->delete();

      return response()->JSON($customer);
  }
}
