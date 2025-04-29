<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdvertisementController extends Controller
{
    // Listázás
    public function index()
    {
        $ads = Advertisement::latest()->paginate(10);
        return view('pages.admin.ads.index', compact('ads'));
    }

    // Létrehozás nézet
    public function create()
    {
        return view('pages.admin.ads.create');
    }

    // Tárolás
    public function store(Request $request)
    {
        $validated = $this->validateAdvertisement($request);
        $ad = $this->createAdvertisement($validated);
        $this->handleMediaUpload($request, $ad);

        return redirect()->route('admin.ads.index')->with('success', 'Hirdetés létrehozva!');
    }

    // Szerkesztés nézet
    public function edit(Advertisement $ad)
    {
        return view('pages.admin.ads.edit', compact('ad'));
    }

    // Frissítés
    public function update(Request $request, Advertisement $ad)
    {
        $validated = $this->validateAdvertisement($request, $ad->id);
        $this->updateAdvertisement($ad, $validated);
        $this->handleMediaUpload($request, $ad);

        return redirect()->route('admin.ads.index')->with('success', 'Hirdetés frissítve!');
    }

    // Törlés
    public function destroy(Advertisement $ad)
    {
        $ad->delete();
        return back()->with('success', 'Hirdetés törölve!');
    }

    // In AdvertisementController
    public function forceDestroy($adId)
    {
        $ad = Advertisement::withTrashed()->findOrFail($adId);
        Storage::deleteDirectory("public/ads/{$ad->id}"); // Delete media
        $ad->forceDelete(); // Permanent delete
        return back()->with('success', 'Hirdetés véglegesen törölve!');
    }

    // Validáció
    private function validateAdvertisement(Request $request, $adId = null)
    {
        return $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'duration_seconds' => 'required|integer|min:1',
            'reward_amount' => 'required|numeric|min:0',
            'media_type' => 'required|in:image,video',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'media_file' => 'nullable|file|mimes:' . ($request->media_type === 'video' ? 'mp4' : 'jpeg,png,jpg') . '|max:51200'
        ]);
    }

    // Hirdetés létrehozása/frissítése
    private function createAdvertisement($data)
    {
        return Advertisement::create($data);
    }

    private function updateAdvertisement($ad, $data)
    {
        $ad->update($data);
    }

    // Média kezelés
    private function handleMediaUpload($request, $ad)
    {
        $directory = "public/ads/{$ad->id}";

        // Thumbnail
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store("{$directory}/thumbnails");
            $ad->update(['image' => basename($path), 'image_path' => $path]);
        }

        // Fő média
        if ($request->hasFile('media_file')) {
            $fileName = $ad->media_type === 'video' ? 'video.mp4' : 'image.jpg';
            $path = $request->file('media_file')->storeAs($directory, $fileName);
            if ($ad->media_type === 'video') {
                $ad->update(['video_path' => $path]);
            } else {
                $ad->update(['image_path' => $path]);
            }
        }
    }
}
