<?php

namespace App\Http\Controllers;

use App\User;
use App\Customer;
use App\Mail\Customer\Confirmation;
use App\Mail\Customer\NewPassword;
use App\Http\Controllers\Controller;
use App\Http\Requests\Customer as CustomerRequest;
use App\Http\Resources\Customer as CustomerResource;

use Illuminate\Support\Facades\Mail;
use Spatie\QueryBuilder\QueryBuilder;

use Illuminate\Support\Facades\Log;

class CustomersController extends Controller
{
    /**
     * Display all customers.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $query = QueryBuilder::for(Customer::class)->allowedFilters('name', 'email', 'cpf');

        return CustomerResource::collection($query->paginate());
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function me()
    {
        return new CustomerResource(auth()->user()->customer);
    }

    /**
     * Store a newly customer.
     *
     * @param  CustomerRequest $request
     * @return \Illuminate\Http\Response
     */
    public function register(CustomerRequest $request)
    {
        $user = User::create($request->all());
        $customer = $user->customer()->create($request->all());

        Mail::to($user->email)->send(new Confirmation($customer));

        return new CustomerResource($customer);
    }

    /**
     * Update customer profile.
     *
     * @param  CustomerRequest $request
     * @return \Illuminate\Http\Response
     */
    public function profile(CustomerRequest $request)
    {
        $user = auth()->user();
        
        //Log::debug('CustomersController:profile: $ request: '.print_r($request,true));

        $user->update($request->all());
        $user->customer->update($request->all());

        return new CustomerResource($user->customer);
    }

    /**
     * Confirm user e-mail.
     *
     * @param  string $token
     * @return \Illuminate\Http\Response
     */
    public function confirmation($token)
    {
        $user = User::where('token', $token)->firstOrFail();
        $user->update([
            'active' => 1
        ]);

        return response(';)');
    }
    
    /**
     * Store a newly customer.
     *
     * @param  CustomerRequest $request
     * @return \Illuminate\Http\Response
     */
    public function forgotPassword(CustomerRequest $request)
    {
        Log.debug('Forgot password request: '.print_r($request, true));
        $user = User::where('email',$request->email);
        $customer = $user->customer()->create($request->all());

        Mail::to($user->email)->send(new Confirmation($customer));

        return new CustomerResource($customer);
    }
    
    /**
     * Reset user password.
     *
     * @param  string $token
     * @return \Illuminate\Http\Response
     */
    public function resetPassword($token)
    {
        $user = User::where('token', $token)->firstOrFail();
        
        return new CustomerResource(auth()->user()->customer);
    }
}
