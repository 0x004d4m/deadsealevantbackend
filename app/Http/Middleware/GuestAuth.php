<?php

namespace App\Http\Middleware;

use App\Models\Customer;
use App\Models\Guest;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class GuestAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $Authorization = str_replace('Bearer ', '', $request->header('Authorization'));
        $Customer = Customer::where('access_token', $Authorization)->first();
        if($Customer){
            $request->merge(['customer_id' => $Customer->id]);
            return $next($request);
        }else{
            $Guest = Guest::where('access_token', $Authorization)->first();
            if($Guest) {
                $request->merge(['guest_id' => $Guest->id]);
                return $next($request);
            }else{
                return $next($request);
            }
        }
    }
}
