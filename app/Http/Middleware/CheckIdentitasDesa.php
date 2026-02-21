<?php

namespace App\Http\Middleware;

use App\Models\IdentitasDesa;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckIdentitasDesa
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Allow access to identitas desa routes
        if ($request->is('admin/identitas-desa*')) {
            return $next($request);
        }

        $identitas = IdentitasDesa::first();

        // Check if identitas desa is filled (not default values)
        $isFilled = $identitas &&
                   $identitas->nama_desa !== 'Desa Belum Diatur' &&
                   $identitas->kode_desa !== '000000' &&
                   !empty($identitas->nama_desa) &&
                   !empty($identitas->kode_desa);

        if (!$isFilled) {
            // Redirect to identitas desa page if not filled
            return redirect()->route('admin.identitas-desa.index')
                           ->with('warning', 'Silakan lengkapi Identitas Desa terlebih dahulu sebelum mengakses menu lainnya.');
        }

        return $next($request);
    }
}
