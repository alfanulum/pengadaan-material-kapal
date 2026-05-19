<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\MaterialRequest;
use App\Models\MaterialRequestItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaterialRequestController extends Controller
{
    public function index()
    {
        $requests = MaterialRequest::with(['project', 'items'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('material-requests.index', compact('requests'));
    }

    public function create()
    {
        $projects = Project::all();

        return view('material-requests.create', compact('projects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'nama_barang' => 'required|string|max:255',
            'spesifikasi' => 'nullable|string',
            'qty' => 'required|integer|min:1',
            'satuan' => 'required|string|max:50',
            'tanggal_dibutuhkan' => 'required|date',
            'catatan' => 'nullable|string',
        ]);

        $materialRequest = MaterialRequest::create([
            'user_id' => Auth::id(),
            'project_id' => $request->project_id,
            'kode_pengajuan' => 'REQ-' . date('YmdHis'),
            'tanggal_dibutuhkan' => $request->tanggal_dibutuhkan,
            'catatan' => $request->catatan,
            'status' => 'diajukan',
        ]);

        MaterialRequestItem::create([
            'material_request_id' => $materialRequest->id,
            'nama_barang' => $request->nama_barang,
            'spesifikasi' => $request->spesifikasi,
            'qty' => $request->qty,
            'satuan' => $request->satuan,
        ]);

        return redirect()
            ->route('material-requests.index')
            ->with('success', 'Pengajuan material berhasil dibuat.');
    }

    public function show($id)
    {
        $requestMaterial = MaterialRequest::with(['project', 'items'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('material-requests.show', compact('requestMaterial'));
    }

    public function edit($id)
    {
        $requestMaterial = MaterialRequest::with('items')
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        if ($requestMaterial->status !== 'diajukan') {
            return redirect()
                ->route('material-requests.index')
                ->with('error', 'Pengajuan tidak bisa diedit karena sudah diproses.');
        }

        $projects = Project::all();

        return view('material-requests.edit', compact('requestMaterial', 'projects'));
    }

    public function update(Request $request, $id)
    {
        $requestMaterial = MaterialRequest::with('items')
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        if ($requestMaterial->status !== 'diajukan') {
            return redirect()
                ->route('material-requests.index')
                ->with('error', 'Pengajuan tidak bisa diubah karena sudah diproses.');
        }

        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'nama_barang' => 'required|string|max:255',
            'spesifikasi' => 'nullable|string',
            'qty' => 'required|integer|min:1',
            'satuan' => 'required|string|max:50',
            'tanggal_dibutuhkan' => 'required|date',
            'catatan' => 'nullable|string',
        ]);

        $requestMaterial->update([
            'project_id' => $request->project_id,
            'tanggal_dibutuhkan' => $request->tanggal_dibutuhkan,
            'catatan' => $request->catatan,
        ]);

        $item = $requestMaterial->items->first();

        if ($item) {
            $item->update([
                'nama_barang' => $request->nama_barang,
                'spesifikasi' => $request->spesifikasi,
                'qty' => $request->qty,
                'satuan' => $request->satuan,
            ]);
        }

        return redirect()
            ->route('material-requests.index')
            ->with('success', 'Pengajuan material berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $requestMaterial = MaterialRequest::where('user_id', Auth::id())
            ->findOrFail($id);

        if ($requestMaterial->status !== 'diajukan') {
            return redirect()
                ->route('material-requests.index')
                ->with('error', 'Pengajuan tidak bisa dihapus karena sudah diproses.');
        }

        $requestMaterial->delete();

        return redirect()
            ->route('material-requests.index')
            ->with('success', 'Pengajuan material berhasil dihapus.');
    }
}
