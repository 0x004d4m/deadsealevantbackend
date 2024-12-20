<?php

namespace App\Http\Middleware;

use Backpack\LangFileManager\app\Models\Language;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $languageCode = $request->header('Accept-Language', 'en');
        if($languageCode == 'en-GB,en-US;q=0.9,en;q=0.8'){
            $languageCode = 'ar';
        }
        if (!in_array($languageCode, Language::all()->pluck('abbr')->toArray())) {
            return response()->json(['message' => $languageCode . ' Language not supported', 'errors' => ['Accept-Language' => $languageCode . ' Language not supported']], 422);
        }
        App::setLocale($languageCode);
        $request->merge(['locale' => $languageCode]);
        return $next($request);
    }
}
