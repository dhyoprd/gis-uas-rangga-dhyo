<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pura;
use Illuminate\Support\Facades\Storage;

class PuraController extends Controller
{
    public function store(Request $request)
    {
        \Log::info('Incoming request data:', $request->all());

        try {
            $validated = $request->validate([
                'namaPura' => 'required|string|max:255',
                'alamat' => 'required|string',
                'tahun' => 'required|integer',
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric',
                'fotoPura' => 'required|image|max:10240',
            ]);

            \Log::info('Validation passed', $validated);

            // Verify file upload
            if ($request->hasFile('fotoPura') && $request->file('fotoPura')->isValid()) {
                $path = $request->file('fotoPura')->store('public/foto_pura');
                \Log::info('File stored at: ' . $path);
                $publicPath = Storage::url($path);
            } else {
                \Log::error('File upload failed');
                throw new \Exception('File upload failed');
            }

            $pura = Pura::create([
                'nama' => $request->namaPura,
                'alamat' => $request->alamat,
                'tahun_dibuat' => $request->tahun,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'foto' => $publicPath,
            ]);

            \Log::info('Pura created:', $pura->toArray());

            return back()->with('success', 'Data berhasil disimpan!');
        } catch (\Exception $e) {
            \Log::error('Error in PuraController@store: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());

            return back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage())->withInput();
        }
    }
    public function index()
    {
        $puras = Pura::all();
        return view('index', compact('puras'));
    }

    public function edit(Pura $pura)
    {
        return response()->json($pura);
    }

    public function update(Request $request, Pura $pura)
    {
        \Log::info('Update request data:', $request->all());

        try {
            $validated = $request->validate([
                'namaPura' => 'required|string|max:255',
                'alamat' => 'required|string',
                'tahun' => 'required|integer',
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric',
                'fotoPura' => 'nullable|image|max:10240',
            ]);

            $data = [
                'nama' => $request->namaPura,
                'alamat' => $request->alamat,
                'tahun_dibuat' => $request->tahun,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
            ];

            if ($request->hasFile('fotoPura') && $request->file('fotoPura')->isValid()) {
                // Delete old image
                if ($pura->foto) {
                    $oldPath = str_replace('/storage/', 'public/', $pura->foto);
                    Storage::delete($oldPath);
                }

                // Store new image
                $path = $request->file('fotoPura')->store('public/foto_pura');
                $data['foto'] = Storage::url($path);
            }

            $pura->update($data);
            \Log::info('Pura updated:', $pura->toArray());

            return back()->with('success', 'Data berhasil diperbarui!');
        } catch (\Exception $e) {
            \Log::error('Error in PuraController@update: ' . $e->getMessage());
            return back()->with('error', 'Gagal memperbarui data: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(Pura $pura)
    {
        try {
            // Delete associated image
            if ($pura->foto) {
                $path = str_replace('/storage/', 'public/', $pura->foto);
                Storage::delete($path);
            }

            $pura->delete();
            return back()->with('success', 'Data berhasil dihapus!');
        } catch (\Exception $e) {
            \Log::error('Error in PuraController@destroy: ' . $e->getMessage());
            return back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    public function getPurasData()
    {
        try {
            $puras = Pura::all();
            return response()->json($puras, 200);
        } catch (\Exception $e) {
            \Log::error('Error in fetching pura data: ' . $e->getMessage());
            return response()->json(['error' => 'Unable to fetch data'], 500);
        }
    }
}
