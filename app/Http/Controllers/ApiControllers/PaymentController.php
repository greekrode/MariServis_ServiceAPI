<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\Collection;

use App\Acme\Payments\PaymentTransformer;
use App\Extensions\Serializers\CustomSerializer;
use App\Payment;

class PaymentController extends Controller
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
        $payments = Payment::all();
        $total = count($payments);

        $resource = new Collection($payments, new PaymentTransformer($total), 'payments');
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
    public function store(Request $request)
    {
        $input = $request->all();

        $payment = new Payment();
        $payment->create($input);

        return redirect()->route('api.v1.payments.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $payment = Payment::findOrFail($id);
        $total = count($payment);

        $resource = new Item($payment, new PaymentTransformer($total), "payment");

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

        $payment = Payment::findOrFail($id);
        $payment->update($input);

        return response()->JSON($payment);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // find, if find find fails it will throws -> "FatalThrowableError"
        // findOrFail, if find fails it will throws -> "NotFoundHttpException"
        $payment = Payment::findOrFail($id);
        $payment->delete();

        return response()->JSON($payment);
    }
}
