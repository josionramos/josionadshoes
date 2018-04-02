<?php

namespace App\Http\Controllers;

use App\Models\Address\Address;
use App\Http\Controllers\Controller;
use App\Http\Requests\Address as AddressRequest;
use App\Http\Resources\Address\Address as AddressResource;

class AddressesController extends Controller
{
    /**
     * Auth customer
     *
     * @var \App\Customer
     */
    protected $customer;

    /**
     * Constructor.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->customer = auth()->user()->customer;

            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $query = $this->customer->addresses();

        return AddressResource::collection($query->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  AddressRequest  $request
     * @return AddressResource
     */
    public function store(AddressRequest $request)
    {
        $address = new Address($request->all());

        return new AddressResource(
            $this->customer->addresses()->save($address)
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  Address  $address
     * @return AddressResource
     */
    public function show(Address $address)
    {
        return new AddressResource($address);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int         $addressId
     * @param  AddressRequest  $request
     * @return AddressResource
     */
    public function update($addressId, AddressRequest $request)
    {
        $address = $this->customer->addresses()->findOrFail($addressId);
        $address->update($request->all());

        return new AddressResource($address);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @throws \Exception
     * @param  int  $addressId
     * @return \Illuminate\Http\Response
     */
    public function destroy($addressId)
    {
        $address = $this->customer->addresses()->findOrFail($addressId);
        $address->delete();

        return response('oka');
    }
}
