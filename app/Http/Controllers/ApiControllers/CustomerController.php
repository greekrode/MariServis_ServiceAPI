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

  // /**
  //  * Store a newly created resource in storage.
  //  *
  //  * @param  \Illuminate\Http\Request  $request
  //  * @return \Illuminate\Http\Response
  //  */
  // public function store(Request $request)
  // {
  //     $input = $request->all();
  //
  //     $customer = new Customer();
  //     $customer->create($input);
  //
  //     return redirect()->route('api.v1.customers.index');
  // }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
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
  public function destroy($id)
  {
      $customer = Customer::findOrFail($id);
      $customer->delete();

      return response()->JSON($customer);
  }
}
