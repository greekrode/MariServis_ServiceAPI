<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\Collection;

use App\Acme\TransactionStatuses\TransactionStatusTransformer;
use App\Extensions\Serializers\CustomSerializer;
use App\TransactionStatus;

class TransactionStatusController extends Controller
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
     *   path="/api/v1/transaction_statuses",
     *   summary="Retrieves the collection of Transaction status resource.",
     *   produces={"application/json"},
     *   tags={"transaction_statuses"},
     *   @SWG\Response(
     *       response=200,
     *       description="Transaction statuses collection.",
     *       @SWG\Schema(
     *           type="array",
     *           @SWG\Items(ref="#/definitions/transactionstatus")
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
        $transactionStatuses = TransactionStatus::all();
        $total = count($transactionStatuses);

        $resource = new Collection($transactionStatuses, new TransactionStatusTransformer($total), 'transactionStatuses');
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
     *   path="/api/v1/transaction_statuses",
     *   summary="Retrieves the collection of Trasaction statuses resource.",
     *   consumes={"application/json"},
     *   produces={"application/json"},
     *   tags={"transaction_statuses"},
     *   @SWG\Response(
     *       response=200,
     *       description="New Transaction status has successfully added.",
     *       @SWG\Schema(
     *           type="array",
     *           @SWG\Items(ref="#/definitions/transactionstatus")
     *       )
     *   ),
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
     *           description="Transaction status object that needs to be added to the database",
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

        $transactionStatus = new TransactionStatus();
        $transactionStatus->create($input);

        return redirect()->route('api.v1.transaction_statuses.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /**
     * @SWG\Get(
     *      path="/api/v1/transaction_statuses/{id}",
     *      summary="Find Transaction status by ID.",
     *      produces={"application/json"},
     *      tags={"transaction_statuses"},
     *      @SWG\Response(
     *          response=200,
     *          description="Transaction status has been founded.",
     *          @SWG\Schema(
     *              type="array",
     *              @SWG\Items(ref="#/definitions/transactionstatus")
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
     *          description="Transaction status not found."
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
     *           description="Please enter the ID of the Transaction status",
     *           required=true,
     *           type="integer"
     *      )
     * )
     */


    public function show($id)
    {
        $transactionStatus = TransactionStatus::findOrFail($id);
        $total = count($transactionStatus);

        $resource = new Item($transactionStatus, new TransactionStatusTransformer($total), "transactionStatus");

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
     *      path="/api/v1/transaction_statuses/{id}",
     *      summary="Add new Transaction status.",
     *      produces={"application/json"},
     *      consumes={"application/json"},
     *      tags={"transaction_statuses"},
     *      @SWG\Response(
     *          response=200,
     *          description="The Transaction status data has successfully updated",
     *          @SWG\Schema(
     *              type="array",
     *              @SWG\Items(ref="#/definitions/transactionstatus")
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
     *           description="Transaction status object that needs to be updated to the database",
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

        $transactionStatus = TransactionStatus::findOrFail($id);
        $transactionStatus->update($input);

        return response()->JSON($transactionStatus);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * @SWG\Delete(
     *      path="/api/v1/transaction_statuses/{id}",
     *      summary="Remove the Transaction status resource.",
     *      produces={"application/json"},
     *      tags={"transaction_statuses"},
     *      @SWG\Response(
     *          response=204,
     *          description="Transaction status resource deleted."
     *      ),
     *      @SWG\Response(
     *          response=401,
     *          description="Unauthorized action."
     *      ),
     *      @SWG\Response(
     *          response=404,
     *          description="Transaction status not found."
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
     *           description="Please enter the ID of the Transaction status",
     *           required=true,
     *           type="integer"
     *      ),
     * )
     */
    public function destroy($id)
    {
        // find, if find find fails it will throws -> "FatalThrowableError"
        // findOrFail, if find fails it will throws -> "NotFoundHttpException"
        $transactionStatus = TransactionStatus::findOrFail($id);
        $transactionStatus->delete();

        return response()->JSON('Successfully delete.');
    }
}
