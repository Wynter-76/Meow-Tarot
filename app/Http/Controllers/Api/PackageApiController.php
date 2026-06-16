<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;

class PackageApiController extends Controller
{
    // GET /api/packages
    public function index()
    {
        return response()->json(Package::orderBy('id')->get());
    }

    // GET /api/packages/{id}
    public function show($id)
    {
        $package = Package::find($id);

        if (!$package) {
            return response()->json(['message' => 'Paket tidak ditemukan'], 404);
        }

        return response()->json($package);
    }

    // POST /api/packages
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'category' => 'required|in:tarot,palm,chat,call',
            'price'    => 'required|integer|min:0',
        ]);

        $package = Package::create($data);

        return response()->json($package, 201);
    }

    // PUT /api/packages/{id}
    public function update(Request $request, $id)
    {
        $package = Package::find($id);

        if (!$package) {
            return response()->json(['message' => 'Paket tidak ditemukan'], 404);
        }

        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'category' => 'required|in:tarot,palm,chat,call',
            'price'    => 'required|integer|min:0',
        ]);

        $package->update($data);

        return response()->json($package);
    }

    // DELETE /api/packages/{id}
    public function destroy($id)
    {
        $package = Package::find($id);

        if (!$package) {
            return response()->json(['message' => 'Paket tidak ditemukan'], 404);
        }

        $package->delete();

        return response()->json(['message' => 'Paket dihapus']);
    }
}
