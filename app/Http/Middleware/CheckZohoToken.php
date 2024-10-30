<?php

namespace App\Http\Middleware;

use App\Services\Contracts\ZohoServiceContract;
use Closure;
use Illuminate\Http\Request;

class CheckZohoToken
{
    public function __construct(protected ZohoServiceContract $zohoService)
    {
        //
    }

    public function handle(Request $request, Closure $next)
    {
        if ($this->zohoService->isTokenExpired()) {
            try {
                $this->zohoService->refreshAccessToken();
            } catch (\Exception $e) {
                \Log::error('Refresh token error: ' . $e->getMessage());
                return response()->json(['error' => 'Unauthorized'], 401);
            }
        }

        return $next($request);
    }

}
