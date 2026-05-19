<?php

namespace App\Http\Controllers;

use App\Models\MaterialRequest;
use Illuminate\Http\Request;

class PlannerMaterialRequestController extends Controller
{
    public function index()
    {
        $requests = MaterialRequest::with(['user', 'project', 'items'])
            ->latest()
            ->get();

        return view('planner.material-requests.index', compact('requests'));
    }

    public function show($id)
    {
        $requestMaterial = MaterialRequest::with(['user', 'project', 'items'])
            ->findOrFail($id);

        return view('planner.material-requests.show', compact('requestMaterial'));
    }

    public function uploadDocuments(Request $request, $id)
    {
        $request->validate([
            'total_rab' => 'nullable|numeric|min:0',
            'file_rab' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:10240',
            'file_perizinan' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
            'catatan_planner' => 'nullable|string',
        ]);

        $requestMaterial = MaterialRequest::findOrFail($id);

        $data = [
            'total_rab' => $request->total_rab,
            'catatan_planner' => $request->catatan_planner,
        ];

        if ($request->hasFile('file_rab')) {
            $data['file_rab'] = $request->file('file_rab')->store('rab', 'public');
        }

        if ($request->hasFile('file_perizinan')) {
            $data['file_perizinan'] = $request->file('file_perizinan')->store('perizinan', 'public');
        }

        $requestMaterial->update($data);

        return redirect()
            ->route('planner.material-requests.show', $requestMaterial->id)
            ->with('success', 'Dokumen RAB dan perizinan berhasil disimpan.');
    }

    public function approve($id)
    {
        $requestMaterial = MaterialRequest::findOrFail($id);

        $requestMaterial->update([
            'status' => 'disetujui',
        ]);

        return redirect()
            ->route('planner.material-requests.index')
            ->with('success', 'Pengajuan material berhasil disetujui.');
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'catatan' => 'required|string',
        ]);

        $requestMaterial = MaterialRequest::findOrFail($id);

        $requestMaterial->update([
            'status' => 'ditolak',
            'catatan' => $request->catatan,
        ]);

        return redirect()
            ->route('planner.material-requests.index')
            ->with('success', 'Pengajuan material berhasil ditolak.');
    }
}
