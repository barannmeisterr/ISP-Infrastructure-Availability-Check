<?php
/**
Author:Arda Baran
*/
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IssProvider;
use App\Models\IssServiceArea;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class IssProviderController extends Controller
{
    public function index()
    {
        $providers = IssProvider::withCount('serviceAreas')
            ->orderBy('name')
            ->paginate(15);

        return view('admin.iss-providers.index', compact('providers'));
    }

    public function create()
    {
        return view('admin.iss-providers.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validateProvider($request);

        $validated['slug'] = Str::slug($validated['slug'] ?? $validated['name']);
        $validated['services'] = $this->normalizeServices($request->input('services'));

        $provider = IssProvider::create($validated);

        $serviceAreas = $this->normalizeLines($request->input('service_areas'));
        $this->syncServiceAreas($provider, $serviceAreas);

        return redirect()
            ->route('admin.iss-providers.index')
            ->with('success', 'ISS sağlayıcı başarıyla eklendi.');
    }

    public function show(IssProvider $issProvider)
    {
        $issProvider->load('serviceAreas', 'packages');
        return view('admin.iss-providers.show', compact('issProvider'));
    }

    public function edit(IssProvider $issProvider)
    {
        $issProvider->load('serviceAreas');
        return view('admin.iss-providers.edit', compact('issProvider'));
    }

    public function update(Request $request, IssProvider $issProvider)
    {
        $validated = $this->validateProvider($request, $issProvider->id);

        $validated['slug'] = Str::slug($validated['slug'] ?? $validated['name']);
        $validated['services'] = $this->normalizeServices($request->input('services'));

        $issProvider->update($validated);

        $issProvider->serviceAreas()->delete();
        $serviceAreas = $this->normalizeLines($request->input('service_areas'));
        $this->syncServiceAreas($issProvider, $serviceAreas);

        return redirect()
            ->route('admin.iss-providers.index')
            ->with('success', 'ISS sağlayıcı başarıyla güncellendi.');
    }

    public function destroy(IssProvider $issProvider)
    {
        $issProvider->delete();

        return redirect()
            ->route('admin.iss-providers.index')
            ->with('success', 'ISS sağlayıcı başarıyla silindi.');
    }

    /* =======================
       🔧 YARDIMCI METOTLAR
       ======================= */

    private function validateProvider(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'name'          => 'required|string|max:255',
            'slug'          => 'nullable|string|max:255|unique:iss_providers,slug,' . $ignoreId,
            'logo_path'     => 'nullable|string|max:500',
            'location'      => 'nullable|string|max:255',
            'company_info'  => 'nullable|string',
            'cagrimerkezi'  => 'nullable|string|max:255',
            'whatsapp_no'   => 'nullable|string|max:255',
            'fax'           => 'nullable|string|max:255',
            'email'         => 'nullable|email|max:255',
            'website'       => 'nullable|string|max:255',
            'unvan'         => 'nullable|string|max:500',
            'address'         => 'nullable|string|max:1000',
        ]);
    }

    private function normalizeServices(string|array|null $services): ?string
    {
        if (!$services) {
            return null;
        }

        // ✅ Eğer array geldiyse (choice box)
        if (is_array($services)) {
            $clean = array_values(array_unique(array_map('trim', $services)));
            return $clean ? json_encode($clean) : null;
        }

        // ✅ Eğer string geldiyse (textarea - eski sistem)
        $servicesArray = array_filter(
            array_map('trim', explode("\n", $services))
        );

        return $servicesArray ? json_encode(array_values($servicesArray)) : null;
    }


    private function normalizeLines(?string $text): array
    {
        return $text
            ? array_filter(array_map('trim', explode("\n", $text)))
            : [];
    }
    public function fetchPackages(IssProvider $issProvider)
    {


        return redirect()
            ->back()
            ->with('success', 'Paketler başarıyla çekildi.');
    }

    private function syncServiceAreas(IssProvider $provider, array $areas): void
    {
        foreach ($areas as $area) {
            IssServiceArea::create([
                'iss_provider_id' => $provider->id,
                'city' => $area,
            ]);
        }
    }
}
