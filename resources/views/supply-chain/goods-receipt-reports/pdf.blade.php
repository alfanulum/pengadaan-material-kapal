<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penerimaan Material - {{ $receipt->purchaseOrder->kode_po ?? 'N/A' }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 10pt;
            color: #1e293b;
            line-height: 1.5;
        }

        /* HEADER */
        .header {
            border-bottom: 3px solid #1e3a5f;
            padding-bottom: 12px;
            margin-bottom: 20px;
        }
        .header-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }
        .company-name {
            font-size: 16pt;
            font-weight: bold;
            color: #1e3a5f;
        }
        .company-sub {
            font-size: 9pt;
            color: #64748b;
            margin-top: 2px;
        }
        .doc-title {
            text-align: right;
        }
        .doc-title h1 {
            font-size: 14pt;
            font-weight: bold;
            color: #1e3a5f;
        }
        .doc-title p {
            font-size: 9pt;
            color: #64748b;
        }

        /* STATUS BANNER */
        .status-banner {
            padding: 10px 15px;
            border-radius: 6px;
            margin-bottom: 18px;
            font-weight: bold;
            font-size: 10pt;
        }
        .status-sesuai    { background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; }
        .status-catatan   { background: #fef3c7; color: #78350f; border: 1px solid #fde68a; }
        .status-masalah   { background: #fee2e2; color: #7f1d1d; border: 1px solid #fecaca; }

        /* SECTION */
        .section {
            margin-bottom: 18px;
        }
        .section-title {
            font-size: 10pt;
            font-weight: bold;
            color: #1e3a5f;
            background: #f1f5f9;
            padding: 6px 10px;
            border-left: 4px solid #1e3a5f;
            margin-bottom: 10px;
        }

        /* INFO GRID */
        .info-grid {
            width: 100%;
            border-collapse: collapse;
        }
        .info-grid td {
            padding: 5px 8px;
            vertical-align: top;
            font-size: 9.5pt;
        }
        .info-grid td.label {
            color: #64748b;
            width: 35%;
            font-weight: bold;
        }
        .info-grid td.colon { width: 3%; }
        .info-grid td.value { color: #1e293b; }
        .info-grid tr:nth-child(even) { background: #f8fafc; }

        /* TWO COLUMN */
        .two-col {
            width: 100%;
        }
        .two-col .col {
            width: 48%;
            vertical-align: top;
            padding-right: 10px;
        }
        .two-col .col:last-child { padding-right: 0; }

        /* TABLE MATERIAL */
        .material-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9pt;
        }
        .material-table th {
            background: #1e3a5f;
            color: white;
            padding: 7px 8px;
            text-align: left;
            font-size: 8.5pt;
        }
        .material-table td {
            padding: 6px 8px;
            border-bottom: 1px solid #e2e8f0;
            vertical-align: top;
        }
        .material-table tr:nth-child(even) td { background: #f8fafc; }
        .material-table tfoot td {
            font-weight: bold;
            background: #f1f5f9;
            border-top: 2px solid #1e3a5f;
        }
        .text-right { text-align: right; }
        .text-center { text-align: center; }

        /* BADGE */
        .badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 20px;
            font-size: 8pt;
            font-weight: bold;
        }
        .badge-green  { background: #d1fae5; color: #065f46; }
        .badge-yellow { background: #fef3c7; color: #78350f; }
        .badge-red    { background: #fee2e2; color: #7f1d1d; }
        .badge-orange { background: #ffedd5; color: #9a3412; }
        .badge-blue   { background: #dbeafe; color: #1e40af; }

        /* CATATAN BOX */
        .note-box {
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 10px;
            background: #f8fafc;
            font-size: 9.5pt;
            min-height: 40px;
        }
        .note-box.warning {
            background: #fff7ed;
            border-color: #fed7aa;
        }

        /* FOTO */
        .photo-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 8px;
        }
        .photo-item {
            text-align: center;
        }
        .photo-item img {
            width: 120px;
            height: 100px;
            object-fit: cover;
            border: 1px solid #e2e8f0;
            border-radius: 4px;
        }
        .photo-caption {
            font-size: 7.5pt;
            color: #64748b;
            margin-top: 3px;
            max-width: 120px;
        }

        /* TANDA TANGAN */
        .signature-section {
            margin-top: 30px;
            page-break-inside: avoid;
        }
        .signature-table {
            width: 100%;
            border-collapse: collapse;
        }
        .signature-table td {
            width: 50%;
            text-align: center;
            padding: 15px;
            vertical-align: bottom;
        }
        .signature-line {
            border-top: 1px solid #1e293b;
            margin-top: 60px;
            padding-top: 6px;
            font-size: 9pt;
        }

        /* FOOTER */
        .doc-footer {
            border-top: 1px solid #e2e8f0;
            margin-top: 20px;
            padding-top: 8px;
            font-size: 8pt;
            color: #94a3b8;
            display: flex;
            justify-content: space-between;
        }

        .separator {
            border: none;
            border-top: 1px solid #e2e8f0;
            margin: 14px 0;
        }

        /* PAGE BREAK */
        .page-break { page-break-after: always; }
    </style>
</head>
<body>

    {{-- ===== HEADER DOKUMEN ===== --}}
    <div class="header">
        <div class="header-top">
            <div>
                <div class="company-name">PT PAL INDONESIA</div>
                <div class="company-sub">Divisi Supply Chain — Pengadaan Material Kapal</div>
                <div class="company-sub">Jl. Hang Tuah No.197, Ujung, Surabaya, Jawa Timur</div>
            </div>
            <div class="doc-title">
                <h1>LAPORAN PENERIMAAN MATERIAL</h1>
                <p>Nomor: {{ $receipt->purchaseOrder->kode_po ?? 'N/A' }}</p>
                <p>Tanggal Cetak: {{ now()->format('d M Y H:i') }}</p>
            </div>
        </div>
    </div>

    {{-- ===== BANNER STATUS ===== --}}
    @php
        $statusClass = match($receipt->status_penerimaan) {
            'diterima_sesuai'         => 'status-sesuai',
            'diterima_dengan_catatan' => 'status-catatan',
            default                   => 'status-masalah',
        };
    @endphp
    <div class="status-banner {{ $statusClass }}">
        Status Penerimaan: {{ $receipt->status_label }}
        &nbsp;&nbsp;|&nbsp;&nbsp;
        Kondisi: {{ $receipt->kondisi_label }}
        &nbsp;&nbsp;|&nbsp;&nbsp;
        Diperiksa: {{ $receipt->creator->name ?? 'Petugas Gudang' }}
        &nbsp;&nbsp;|&nbsp;&nbsp;
        Tanggal: {{ $receipt->tanggal_diterima?->format('d M Y') }}
    </div>

    {{-- ===== INFORMASI PURCHASE ORDER ===== --}}
    <div class="section">
        <div class="section-title">A. INFORMASI PESANAN PEMBELIAN (PO)</div>
        <table class="info-grid">
            <tr>
                <td class="label">Kode Pesanan Pembelian</td>
                <td class="colon">:</td>
                <td class="value"><strong>{{ $receipt->purchaseOrder->kode_po ?? '-' }}</strong></td>
                <td class="label">Tanggal PO</td>
                <td class="colon">:</td>
                <td class="value">{{ $receipt->purchaseOrder->tanggal_po ? \Carbon\Carbon::parse($receipt->purchaseOrder->tanggal_po)->format('d M Y') : '-' }}</td>
            </tr>
            <tr>
                <td class="label">Kode Tender</td>
                <td class="colon">:</td>
                <td class="value">{{ $receipt->purchaseOrder->tender->kode_tender ?? '-' }}</td>
                <td class="label">Nama Tender</td>
                <td class="colon">:</td>
                <td class="value">{{ $receipt->purchaseOrder->tender->nama_tender ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Nama Vendor</td>
                <td class="colon">:</td>
                <td class="value">{{ $receipt->purchaseOrder->vendor->nama_vendor ?? '-' }}</td>
                <td class="label">Kontak Vendor</td>
                <td class="colon">:</td>
                <td class="value">{{ $receipt->purchaseOrder->vendor->telepon ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Proyek</td>
                <td class="colon">:</td>
                <td class="value">{{ $receipt->purchaseOrder->tender->materialRequest->project->nama_proyek ?? '-' }}</td>
                <td class="label">Deadline Pengiriman</td>
                <td class="colon">:</td>
                <td class="value">{{ $receipt->purchaseOrder->deadline_pengiriman ? \Carbon\Carbon::parse($receipt->purchaseOrder->deadline_pengiriman)->format('d M Y') : '-' }}</td>
            </tr>
            <tr>
                <td class="label">Total Nilai Pesanan</td>
                <td class="colon">:</td>
                <td class="value"><strong>Rp {{ number_format($receipt->purchaseOrder->total_harga ?? 0, 0, ',', '.') }}</strong></td>
                <td class="label">Status PO</td>
                <td class="colon">:</td>
                <td class="value">{{ ucfirst(str_replace('_', ' ', $receipt->purchaseOrder->status ?? '-')) }}</td>
            </tr>
        </table>
    </div>

    {{-- ===== INFORMASI PENERIMAAN ===== --}}
    <div class="section">
        <div class="section-title">B. INFORMASI PENERIMAAN</div>
        <table class="info-grid">
            <tr>
                <td class="label">Tanggal Diterima</td>
                <td class="colon">:</td>
                <td class="value"><strong>{{ $receipt->tanggal_diterima?->format('d M Y') ?? '-' }}</strong></td>
                <td class="label">Petugas Gudang</td>
                <td class="colon">:</td>
                <td class="value">{{ $receipt->creator->name ?? 'Petugas Gudang' }}</td>
            </tr>
            <tr>
                <td class="label">Jumlah Diterima</td>
                <td class="colon">:</td>
                <td class="value"><strong>{{ $receipt->jumlah_diterima }} item</strong></td>
                <td class="label">Jumlah Rusak</td>
                <td class="colon">:</td>
                <td class="value">{{ $receipt->jumlah_rusak ? $receipt->jumlah_rusak . ' item' : '-' }}</td>
            </tr>
            <tr>
                <td class="label">Kondisi Barang</td>
                <td class="colon">:</td>
                <td class="value"><strong>{{ $receipt->kondisi_label }}</strong></td>
                <td class="label">Tindakan Selanjutnya</td>
                <td class="colon">:</td>
                <td class="value">{{ $receipt->tindakan_label ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Status Penerimaan</td>
                <td class="colon">:</td>
                <td class="value"><strong>{{ $receipt->status_label }}</strong></td>
                <td class="label">Dokumentasi Foto</td>
                <td class="colon">:</td>
                <td class="value">{{ $receipt->photos->count() }} foto</td>
            </tr>
        </table>
    </div>

    {{-- ===== RINCIAN MATERIAL ===== --}}
    <div class="section">
        <div class="section-title">C. RINCIAN MATERIAL / BARANG</div>
        <table class="material-table">
            <thead>
                <tr>
                    <th style="width:5%">No</th>
                    <th style="width:25%">Nama Barang</th>
                    <th style="width:28%">Spesifikasi</th>
                    <th style="width:10%" class="text-right">Jumlah Pesan</th>
                    <th style="width:8%">Satuan</th>
                    <th style="width:12%" class="text-right">Harga Satuan</th>
                    <th style="width:12%" class="text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($receipt->purchaseOrder->items as $i => $item)
                <tr>
                    <td class="text-center">{{ $i + 1 }}</td>
                    <td><strong>{{ $item->nama_barang }}</strong></td>
                    <td>{{ $item->spesifikasi ?? '-' }}</td>
                    <td class="text-right">{{ $item->qty }}</td>
                    <td>{{ $item->satuan ?? '-' }}</td>
                    <td class="text-right">Rp {{ number_format($item->harga_satuan ?? 0, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($item->subtotal ?? ($item->qty * $item->harga_satuan), 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5" class="text-right">Total</td>
                    <td></td>
                    <td class="text-right">Rp {{ number_format($receipt->purchaseOrder->total_harga ?? 0, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>
    </div>

    {{-- ===== CATATAN PEMERIKSAAN ===== --}}
    <div class="section">
        <div class="section-title">D. CATATAN PEMERIKSAAN GUDANG</div>

        <p style="font-size:9pt; color:#475569; margin-bottom:5px;"><strong>Catatan Umum:</strong></p>
        <div class="note-box">{{ $receipt->catatan_gudang ?? 'Tidak ada catatan.' }}</div>

        @if ($receipt->detail_permasalahan)
        <p style="font-size:9pt; color:#9a3412; margin-top:10px; margin-bottom:5px;"><strong>⚠ Detail Permasalahan:</strong></p>
        <div class="note-box warning">{{ $receipt->detail_permasalahan }}</div>
        @endif

        @if ($receipt->tindakan_selanjutnya)
        <p style="font-size:9pt; color:#475569; margin-top:10px; margin-bottom:5px;"><strong>Tindakan Selanjutnya:</strong></p>
        <div class="note-box">{{ $receipt->tindakan_label }}</div>
        @endif
    </div>

    {{-- ===== FOTO BUKTI PENERIMAAN ===== --}}
    @if ($photoData->count() > 0)
    <div class="section">
        <div class="section-title">E. BUKTI FOTO PENERIMAAN BARANG ({{ $photoData->count() }} Foto)</div>
        <div class="photo-grid">
            @foreach ($photoData as $photo)
            <div class="photo-item">
                <img src="{{ $photo['base64'] }}" alt="Foto penerimaan">
                @if ($photo['keterangan'])
                <div class="photo-caption">{{ $photo['keterangan'] }}</div>
                @endif
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- ===== TANDA TANGAN ===== --}}
    <div class="signature-section">
        <div class="section-title">F. PENGESAHAN</div>
        <p style="font-size:9pt; color:#475569; margin-bottom:15px;">
            Laporan penerimaan material ini dibuat berdasarkan hasil pemeriksaan fisik barang yang diterima
            dari Vendor dan dicatat oleh Petugas Gudang yang bertanggung jawab.
        </p>
        <table class="signature-table">
            <tr>
                <td>
                    <p style="font-size:9pt; color:#475569;">Mengetahui,</p>
                    <p style="font-weight:bold; font-size:9.5pt;">Staf Supply Chain</p>
                    <div class="signature-line">
                        <p>(................................)</p>
                        <p style="color:#64748b; font-size:8pt;">Supply Chain PT PAL Indonesia</p>
                    </div>
                </td>
                <td>
                    <p style="font-size:9pt; color:#475569;">Diperiksa oleh,</p>
                    <p style="font-weight:bold; font-size:9.5pt;">Petugas Gudang</p>
                    <div class="signature-line">
                        <p>({{ $receipt->creator->name ?? '................................' }})</p>
                        <p style="color:#64748b; font-size:8pt;">Petugas Gudang PT PAL Indonesia</p>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    {{-- ===== FOOTER ===== --}}
    <div class="doc-footer">
        <span>PT PAL Indonesia — Sistem Pengadaan Material Kapal</span>
        <span>Dokumen ini dicetak secara elektronik pada {{ now()->format('d M Y H:i') }}</span>
        <span>{{ $receipt->purchaseOrder->kode_po ?? '' }}</span>
    </div>

</body>
</html>
