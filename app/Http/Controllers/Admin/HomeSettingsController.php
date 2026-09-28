<?php

namespace App\Http\Controllers\Admin;
/**
Author:Arda Baran
*/
use App\Http\Controllers\Controller;
use App\Models\HomeStat;
use App\Models\HomeHighlightedProvider;
use App\Models\HomeHighlightedPackage;
use App\Models\IssProvider;
use App\Models\Package;
use Illuminate\Http\Request;

class HomeSettingsController extends Controller
{
    public function index()
    {
        $stats = HomeStat::orderBy('order')->get();
        $highlightedProviders = HomeHighlightedProvider::with('provider')->orderBy('sort_order')->get();
        $highlightedPackages = HomeHighlightedPackage::with('package')->orderBy('sort_order')->get();
        
        $allProviders = IssProvider::orderBy('name')->get();
        $allPackages = Package::with('provider')->orderBy('title')->get();

        return view('admin.home-settings.index', compact(
            'stats',
            'highlightedProviders',
            'highlightedPackages',
            'allProviders',
            'allPackages'
        ));
    }

    public function updateStats(Request $request)
    {
        $request->validate([
            'stats' => 'required|array',
            'stats.*.id' => 'nullable|exists:home_stats,id',
            'stats.*.count' => 'required|integer|min:0',
            'stats.*.label' => 'required|string|max:255',
            'stats.*.order' => 'required|integer|min:0',
        ]);

        foreach ($request->stats as $statData) {
            if (isset($statData['id']) && $statData['id']) {
                HomeStat::where('id', $statData['id'])->update([
                    'count' => $statData['count'],
                    'label' => $statData['label'],
                    'order' => $statData['order'],
                ]);
            } else {
                HomeStat::create([
                    'count' => $statData['count'],
                    'label' => $statData['label'],
                    'order' => $statData['order'],
                ]);
            }
        }

        return redirect()->route('admin.home-settings.index')
            ->with('success', 'İstatistikler başarıyla güncellendi.');
    }

    public function addHighlightedProvider(Request $request)
    {
        $request->validate([
            'iss_provider_id' => 'required|exists:iss_providers,id',
            'sort_order' => 'required|integer|min:0',
        ]);

        HomeHighlightedProvider::create([
            'iss_provider_id' => $request->iss_provider_id,
            'sort_order' => $request->sort_order,
        ]);

        return redirect()->route('admin.home-settings.index')
            ->with('success', 'Öne çıkarılan ISS sağlayıcı eklendi.');
    }

    public function removeHighlightedProvider($id)
    {
        HomeHighlightedProvider::destroy($id);
        return redirect()->route('admin.home-settings.index')
            ->with('success', 'Öne çıkarılan ISS sağlayıcı kaldırıldı.');
    }

    public function addHighlightedPackage(Request $request)
    {
        $request->validate([
            'package_id' => 'required|exists:packages,id',
            'sort_order' => 'required|integer|min:0',
        ]);

        HomeHighlightedPackage::create([
            'package_id' => $request->package_id,
            'sort_order' => $request->sort_order,
        ]);

        return redirect()->route('admin.home-settings.index')
            ->with('success', 'Öne çıkarılan paket eklendi.');
    }

    public function removeHighlightedPackage($id)
    {
        HomeHighlightedPackage::destroy($id);
        return redirect()->route('admin.home-settings.index')
            ->with('success', 'Öne çıkarılan paket kaldırıldı.');
    }
}
