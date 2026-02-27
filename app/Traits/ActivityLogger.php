<?php

namespace App\Traits;

/**
 * Trait ActivityLogger
 *
 * Dual-strategy activity logging:
 * - Jika Spatie Activitylog terinstall → pakai activity()
 * - Jika belum → fallback ke Laravel Log (channel 'daily')
 *
 * Cara pakai di controller:
 *   use App\Traits\ActivityLogger;
 *   class MyController extends Controller {
 *     use ActivityLogger;
 *     ...
 *     $this->catat('status_desa', 'Menambahkan data', $model, ['tahun' => 2024]);
 *   }
 */
trait ActivityLogger {
    /**
     * Catat aktivitas dengan fallback aman.
     *
     * @param string     $logName   Nama log/kategori, cth: 'status_desa'
     * @param string     $pesan     Deskripsi aktivitas
     * @param mixed|null $model     Model yang terpengaruh (opsional)
     * @param array      $properties Data tambahan (opsional)
     */
    protected function catat(
        string $logName,
        string $pesan,
        mixed  $model = null,
        array  $properties = []
    ): void {
        try {
            if ($this->spatieAktif()) {
                $log = activity($logName)->causedBy(auth()->user());

                if ($model && method_exists($model, 'getKey')) {
                    $log = $log->performedOn($model);
                }

                if (!empty($properties)) {
                    $log = $log->withProperties($properties);
                }

                $log->log($pesan);
                return;
            }
        } catch (\Throwable $e) {
            // Spatie ada tapi ada error — lanjut ke fallback
        }

        // Fallback: Laravel Log
        $context = array_merge([
            'user_id'    => auth()->id(),
            'user_name'  => auth()->user()?->name ?? 'system',
            'model'      => $model ? get_class($model) : null,
            'model_id'   => $model?->getKey() ?? null,
            'ip'         => request()->ip(),
        ], $properties);

        \Illuminate\Support\Facades\Log::channel('daily')
            ->info("[{$logName}] {$pesan}", $context);
    }

    /**
     * Cek apakah Spatie Activitylog tersedia.
     * Dicache agar tidak dicek berulang kali.
     */
    private function spatieAktif(): bool {
        static $cache = null;

        if ($cache === null) {
            $cache = function_exists('activity')
                && class_exists(\Spatie\Activitylog\Models\Activity::class);
        }

        return $cache;
    }
}
