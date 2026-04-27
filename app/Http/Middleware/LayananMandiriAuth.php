<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LayananMandiriAuth {
    /**
     * Pastikan request punya sesi layanan mandiri yang valid.
     * Taruh middleware ini pada route-route portal layanan mandiri.
     */
    public function handle(Request $request, Closure $next) {
        if (!session('lm_penduduk_id')) {
            return redirect()->route('layanan-mandiri')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        return $next($request);
    }
}
