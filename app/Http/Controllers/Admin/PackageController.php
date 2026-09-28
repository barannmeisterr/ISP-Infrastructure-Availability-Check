<?php
/**
Author:Arda Baran
*/
namespace App\Http\Controllers\Admin;

use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\PackageArea;
use App\Models\IssProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::with('provider', 'areas')
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('admin.packages.index', compact('packages'));
    }

    public function create()
    {
        $providers = IssProvider::orderBy('name')->get();
        return view('admin.packages.create', compact('providers'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            /** -------------------------------
             * BASE VALIDATION
             * ------------------------------- */
            $rules = [
                'iss_provider_id'  => 'required|exists:iss_providers,id',
                'title'            => 'required|string|max:255',
                'xdsltype'         => 'required|integer|in:' . implode(',', array_keys(config('xdsl'))),
                'download'         => 'required|integer|min:0',
                'upload'           => 'required|integer|min:0',
                'price'            => 'required|numeric|min:0',
                'commitment'       => 'nullable|boolean',
                'commitment_month' => 'nullable|required_if:commitment,1|integer|min:1',
                'quota'            => 'nullable|boolean',
                'ping'             => 'nullable|string|max:255',
                'description'      => 'nullable|string',
                'areas_csv'        => 'nullable|file|mimes:csv,txt|max:2048',
            ];

            // CSV YOKSA → manuel alanlar zorunlu
            if (!$request->hasFile('areas_csv')) {
                $rules = array_merge($rules, [
                    'areas'                    => 'nullable|array',
                    'areas.*.city'             => 'required|string|max:255',
                    'areas.*.il_id'            => 'nullable|integer',
                    'areas.*.ilce_id'          => 'nullable|integer',
                    'areas.*.mahalle_id'       => 'nullable|integer',
                    'areas.*.csbm_id'          => 'nullable|integer',
                    'areas.*.bina_id'          => 'nullable|integer',
                ]);
            }

            $validated = $request->validate($rules);

            $validated['commitment'] = $request->boolean('commitment');
            $validated['quota']      = $request->boolean('quota');

            $areas = $validated['areas'] ?? [];
            unset($validated['areas'], $validated['areas_csv']);

            /** -------------------------------
             * PACKAGE CREATE
             * ------------------------------- */
            $package = Package::create($validated);

            /** -------------------------------
             * CSV > MANUAL PRIORITY
             * ------------------------------- */
            if ($request->hasFile('areas_csv')) {
                $this->importAreasFromCsvForCreate($request, $package);
            } else {
                foreach ($areas as $area) {
                    if (empty(trim($area['city'] ?? ''))) continue;

                    PackageArea::create([
                        'package_id' => $package->id,
                        'city'       => trim($area['city']),
                        'il_id'      => $area['il_id'] ?? null,
                        'ilce_id'    => $area['ilce_id'] ?? null,
                        'mahalle_id' => $area['mahalle_id'] ?? null,
                        'csbm_id'    => $area['csbm_id'] ?? null,
                        'bina_id'    => $area['bina_id'] ?? null,
                    ]);
                }
            }

            DB::commit();

            return redirect()
                ->route('admin.packages.index')
                ->with('success', 'Paket başarıyla eklendi.');

        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);

            return back()
                ->withInput()
                ->with('error', 'Paket eklenirken bir hata oluştu.');
        }
    }

    public function downloadAreasCsvTemplate(): StreamedResponse
    {
        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename=package_areas_template.csv',
        ];

        $callback = function () {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, [
                'city',
                'il_id',
                'ilce_id',
                'mahalle_id',
                'csbm_id',
                'bina_id',
            ]);

            fputcsv($handle, ['Antalya', 7, 2038, 2351, 842580, 25314849]);
            fputcsv($handle, ['Mersin', 33, 2121, 1475, 2222215, 151511]);
            fputcsv($handle, ['İstanbul', 34, 1234, 1141441, 1212121, 151515]);

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function edit(Package $package)
    {
        $package->load('areas');
        $providers = IssProvider::orderBy('name')->get();

        return view('admin.packages.edit', compact('package', 'providers'));
    }

    public function show(Package $package)
    {
        // ✅ Sadece provider eager load
        $package->load('provider');

        // ✅ Alanları paginate ile çek
        $areas = $package->areas()
            ->orderBy('id')
            ->paginate(50);

        return view('admin.packages.show', compact('package', 'areas'));
    }


    public function update(Request $request, Package $package)
    {
        $validated = $request->validate([
            'iss_provider_id'  => 'required|exists:iss_providers,id',
            'title'            => 'required|string|max:255',
            'xdsltype'         => 'required|integer|in:' . implode(',', array_keys(config('xdsl'))),
            'download'         => 'required|integer|min:0',
            'upload'           => 'required|integer|min:0',
            'price'            => 'required|numeric|min:0',
            'commitment'       => 'nullable|boolean',
            'commitment_month' => 'nullable|required_if:commitment,1|integer|min:1',
            'quota'            => 'nullable|boolean',
            'ping'             => 'nullable|string|max:255',
            'description'      => 'nullable|string',

        ]);

        $validated['commitment'] = $request->boolean('commitment');
        $validated['quota']      = $request->boolean('quota');



        $package->update($validated);



        return redirect()
            ->route('admin.packages.index')
            ->with('success', 'Paket başarıyla güncellendi.');
    }
    private function importAreasFromCsv($file, Package $package): array
    {
        $handle = fopen($file->getRealPath(), 'r');
        if (!$handle) {
            throw new \RuntimeException('CSV dosyası açılamadı.');
        }

        // Header
        $header = fgetcsv($handle);
        $header = array_map(
            fn ($h) => trim(str_replace("\xEF\xBB\xBF", '', $h)),
            $header
        );

        $required = ['city','il_id','ilce_id','mahalle_id','csbm_id','bina_id'];
        foreach ($required as $col) {
            if (!in_array($col, $header)) {
                throw new \RuntimeException("CSV kolon hatası: {$col}");
            }
        }

        $inserted = 0;
        $skipped  = 0;

        while (($row = fgetcsv($handle)) !== false) {
            if (count($row) < count($header)) continue;

            $data = array_combine($header, $row);

            if (empty(trim($data['city'] ?? ''))) {
                $skipped++;
                continue;
            }

            try {
                PackageArea::create([
                    'package_id' => $package->id,
                    'city'       => trim($data['city']),
                    'il_id'      => is_numeric($data['il_id'] ?? null) ? (int)$data['il_id'] : null,
                    'ilce_id'    => is_numeric($data['ilce_id'] ?? null) ? (int)$data['ilce_id'] : null,
                    'mahalle_id' => is_numeric($data['mahalle_id'] ?? null) ? (int)$data['mahalle_id'] : null,
                    'csbm_id'    => is_numeric($data['csbm_id'] ?? null) ? (int)$data['csbm_id'] : null,
                    'bina_id'    => is_numeric($data['bina_id'] ?? null) ? (int)$data['bina_id'] : null,
                ]);

                $inserted++;

            } catch (\Illuminate\Database\QueryException $e) {

                // UNIQUE violation → duplicate
                if ($e->getCode() === '23000') {
                    $skipped++;
                    continue;
                }

                throw $e; // başka hata → yukarı fırlat
            }
        }

        fclose($handle);

        return [
            'inserted' => $inserted,
            'skipped'  => $skipped,
        ];
    }

    public function importAreasFromCsvForEdit(Request $request, Package $package)
    {
        $request->validate([
            'areas_csv' => 'required|file|mimes:csv,txt|max:2048',
        ]);

        DB::beginTransaction();

        try {
            $result = $this->importAreasFromCsv($request->file('areas_csv'), $package);

            DB::commit();

            return back()->with(
                'success',
                "CSV yüklendi. {$result['inserted']} yeni kayıt eklendi, {$result['skipped']} kayıt zaten vardı."
            );

        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);

            return back()->with('error', 'CSV yüklenirken hata oluştu.');
        }
    }


    private function importAreasFromCsvForCreate(Request $request, Package $package): void
    {
        $file = $request->file('areas_csv');
        $rows = array_map('str_getcsv', file($file->getRealPath()));

        if (count($rows) < 2) return;

        // BOM + trim temizliği
        $header = array_map(fn ($h) =>
        trim(str_replace("\xEF\xBB\xBF", '', $h)),
            $rows[0]
        );

        $required = ['city','il_id','ilce_id','mahalle_id','csbm_id','bina_id'];

        foreach ($required as $col) {
            if (!in_array($col, $header)) return;
        }

        foreach (array_slice($rows, 1) as $row) {
            if (count($row) < count($header)) continue;

            $data = array_combine($header, $row);
            if (empty(trim($data['city'] ?? ''))) continue;

            PackageArea::create([
                'package_id' => $package->id,
                'city'       => trim($data['city']),
                'il_id'      => is_numeric($data['il_id'] ?? null) ? (int)$data['il_id'] : null,
                'ilce_id'    => is_numeric($data['ilce_id'] ?? null) ? (int)$data['ilce_id'] : null,
                'mahalle_id' => is_numeric($data['mahalle_id'] ?? null) ? (int)$data['mahalle_id'] : null,
                'csbm_id'    => is_numeric($data['csbm_id'] ?? null) ? (int)$data['csbm_id'] : null,
                'bina_id'    => is_numeric($data['bina_id'] ?? null) ? (int)$data['bina_id'] : null,
            ]);
        }
    }

    public function destroy(Package $package)
    {
        $package->delete();

        return redirect()
            ->route('admin.packages.index')
            ->with('success', 'Paket başarıyla silindi.');
    }
}
