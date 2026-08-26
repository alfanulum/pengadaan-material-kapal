<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penerimaan - {{ $receipt->purchaseOrder->kode_po ?? 'N/A' }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 9.5pt;
            color: #111;
            line-height: 1.5;
            background: #fff;
        }

        /* HEADER */
        .header {
            width: 100%;
            margin-bottom: 25px;
            border-bottom: 2px solid #000;
            padding-bottom: 15px;
        }
        .header-table {
            width: 100%;
            border-collapse: collapse;
        }
        .header-table td {
            vertical-align: top;
        }
        .company-name {
            font-size: 14pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 3px;
        }
        .company-sub {
            font-size: 8.5pt;
            color: #555;
        }
        .doc-title {
            text-align: right;
        }
        .doc-title h1 {
            font-size: 14pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 4px;
        }
        .doc-meta {
            font-size: 9pt;
            color: #333;
        }

        /* STATUS */
        .status-box {
            border: 1px solid #000;
            padding: 8px 12px;
            text-align: center;
            font-weight: bold;
            margin-bottom: 25px;
            font-size: 10pt;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* SECTION HEADERS */
        .section-title {
            font-size: 10pt;
            font-weight: bold;
            text-transform: uppercase;
            border-bottom: 1px solid #000;
            padding-bottom: 4px;
            margin-bottom: 12px;
            margin-top: 25px;
            letter-spacing: 0.5px;
        }

        /* INFO TABLES (TWO COLUMNS) */
        .info-wrapper {
            width: 100%;
            margin-bottom: 20px;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
        }
        .info-table td {
            vertical-align: top;
            padding: 4px 0;
            font-size: 9pt;
        }
        .info-label {
            width: 120px;
            color: #555;
        }
        .info-colon {
            width: 15px;
            color: #555;
        }
        .info-value {
            font-weight: bold;
        }
        .col-left { width: 48%; float: left; }
        .col-right { width: 48%; float: right; }
        .clearfix::after { content: ""; display: table; clear: both; }

        /* MAIN DATA TABLE */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            border: 1px solid #000;
        }
        .data-table th, .data-table td {
            border: 1px solid #000;
            padding: 8px;
            font-size: 8.5pt;
        }
        .data-table th {
            background-color: #f5f5f5;
            font-weight: bold;
            text-transform: uppercase;
            text-align: left;
        }
        .data-table th.text-center, .data-table td.text-center { text-align: center; }
        .data-table th.text-right, .data-table td.text-right { text-align: right; }
        
        .total-row td {
            font-weight: bold;
            background-color: #f5f5f5;
        }

        /* NOTES */
        .note-box {
            border: 1px solid #000;
            padding: 10px;
            background-color: #f9f9f9;
            margin-bottom: 15px;
            font-size: 9pt;
            min-height: 40px;
        }

        /* PHOTOS */
        .photo-grid {
            margin-top: 10px;
            width: 100%;
        }
        .photo-item {
            display: inline-block;
            width: 30%;
            margin-right: 2%;
            margin-bottom: 15px;
            text-align: center;
            vertical-align: top;
        }
        .photo-item img {
            width: 100%;
            height: 120px;
            object-fit: cover;
            border: 1px solid #000;
        }
        .photo-caption {
            font-size: 8pt;
            color: #555;
            margin-top: 4px;
        }

        /* SIGNATURES */
        .signature-table {
            width: 100%;
            margin-top: 50px;
            page-break-inside: avoid;
        }
        .signature-table td {
            width: 50%;
            text-align: center;
            vertical-align: bottom;
        }
        .sig-title {
            font-size: 9pt;
            margin-bottom: 70px;
        }
        .sig-name {
            font-weight: bold;
            text-decoration: underline;
            font-size: 9.5pt;
        }
        .sig-role {
            font-size: 8.5pt;
            color: #555;
            margin-top: 2px;
        }

        /* FOOTER */
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 7.5pt;
            color: #777;
            border-top: 1px dashed #ccc;
            padding-top: 10px;
        }
        
        .page-break { page-break-after: always; }
    </style>
</head>
<body>

    <div class="header">
        <table class="header-table">
            <tr>
                <td>
                    <div class="company-name">PT XYZ INDONESIA</div>
                    <div class="company-sub">Divisi Supply Chain — Pengadaan Material</div>
                    <div class="company-sub">Jl. Hang Tuah No.197, Ujung, Surabaya, Jawa Timur</div>
                </td>
                <td class="doc-title">
                    <h1>LAPORAN PENERIMAAN MATERIAL</h1>
                    <div class="doc-meta"><strong>No. Dokumen:</strong> LP-{{ $receipt->id }}-{{ date('Y') }}</div>
                    <div class="doc-meta"><strong>Tanggal Cetak:</strong> {{ now()->format('d M Y') }}</div>
                </td>
            </tr>
        </table>
    </div>

    <div class="status-box">
        HASIL PEMERIKSAAN: {{ strtoupper($receipt->status_label) }} 
        | KONDISI: {{ strtoupper($receipt->kondisi_label) }}
    </div>

    <div class="info-wrapper clearfix">
        <div class="col-left">
            <div class="section-title" style="margin-top: 0;">Referensi Pembelian</div>
            <table class="info-table">
                <tr>
                    <td class="info-label">No. PO</td>
                    <td class="info-colon">:</td>
                    <td class="info-value">{{ $receipt->purchaseOrder->kode_po ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="info-label">Tanggal PO</td>
                    <td class="info-colon">:</td>
                    <td class="info-value">{{ $receipt->purchaseOrder->tanggal_po ? \Carbon\Carbon::parse($receipt->purchaseOrder->tanggal_po)->format('d M Y') : '-' }}</td>
                </tr>
                <tr>
                    <td class="info-label">Vendor</td>
                    <td class="info-colon">:</td>
                    <td class="info-value">{{ $receipt->purchaseOrder->vendor->nama_vendor ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="info-label">Proyek</td>
                    <td class="info-colon">:</td>
                    <td class="info-value">{{ $receipt->purchaseOrder->tender->materialRequest->project->nama_project ?? '-' }}</td>
                </tr>
            </table>
        </div>

        <div class="col-right">
            <div class="section-title" style="margin-top: 0;">Data Penerimaan Gudang</div>
            <table class="info-table">
                <tr>
                    <td class="info-label">Tanggal Diterima</td>
                    <td class="info-colon">:</td>
                    <td class="info-value">{{ $receipt->tanggal_diterima ? $receipt->tanggal_diterima->format('d M Y') : '-' }}</td>
                </tr>
                <tr>
                    <td class="info-label">Total Item Diterima</td>
                    <td class="info-colon">:</td>
                    <td class="info-value">{{ $receipt->jumlah_diterima }} ITEM</td>
                </tr>
                <tr>
                    <td class="info-label">Item Ditolak / Rusak</td>
                    <td class="info-colon">:</td>
                    <td class="info-value">{{ $receipt->jumlah_rusak ? $receipt->jumlah_rusak . ' ITEM' : 'NIHIL' }}</td>
                </tr>
                <tr>
                    <td class="info-label">Pemeriksa (Gudang)</td>
                    <td class="info-colon">:</td>
                    <td class="info-value">{{ $receipt->creator->name ?? 'Petugas Gudang' }}</td>
                </tr>
            </table>
        </div>
    </div>

    <div class="section-title">Rincian Barang Yang Dipesan</div>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 5%;" class="text-center">No</th>
                <th style="width: 30%;">Nama Barang</th>
                <th style="width: 35%;">Spesifikasi</th>
                <th style="width: 15%;" class="text-center">Pesanan (Qty)</th>
                <th style="width: 15%;" class="text-center">Satuan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($receipt->purchaseOrder->items as $i => $item)
                <tr>
                    <td class="text-center">{{ $i + 1 }}</td>
                    <td><strong>{{ $item->nama_barang }}</strong></td>
                    <td>{{ $item->spesifikasi ?? '-' }}</td>
                    <td class="text-center">{{ $item->qty }}</td>
                    <td class="text-center">{{ $item->satuan ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="section-title">Catatan Pemeriksaan Fisik</div>
    <div style="font-weight: bold; margin-bottom: 4px; font-size: 9pt;">Keterangan / Catatan Umum:</div>
    <div class="note-box">
        {{ $receipt->catatan_gudang ?? 'Tidak ada catatan tambahan.' }}
    </div>

    @if ($receipt->detail_permasalahan)
        <div style="font-weight: bold; margin-bottom: 4px; font-size: 9pt; margin-top: 15px;">Detail Permasalahan / Deviasi:</div>
        <div class="note-box" style="border-style: dashed;">
            {{ $receipt->detail_permasalahan }}
        </div>
    @endif

    <table class="signature-table">
        <tr>
            <td>
                <div class="sig-title">Mengetahui &amp; Verifikasi,<br>Manager Supply Chain</div>
                <div class="sig-name">(.....................................)</div>
                <div class="sig-role">PT XYZ INDONESIA</div>
            </td>
            <td>
                <div class="sig-title">Dibuat &amp; Diperiksa Oleh,<br>Petugas Penerimaan Gudang</div>
                <div class="sig-name">{{ $receipt->creator->name ?? '(.....................................)' }}</div>
                <div class="sig-role">PT XYZ INDONESIA</div>
            </td>
        </tr>
    </table>

    <div class="footer">
        Dokumen Laporan Penerimaan Material (LPM) ini dicetak secara elektronik dari Sistem pada {{ now()->format('d M Y H:i:s') }}.<br>
        LPM ini sah digunakan sebagai dasar pencatatan inventori dan lampiran verifikasi tagihan.
    </div>

    @if ($photoData->count() > 0)
        <div class="page-break"></div>
        <div class="header" style="margin-top: 20px;">
            <table class="header-table">
                <tr>
                    <td>
                        <div class="company-name">LAMPIRAN DOKUMENTASI</div>
                        <div class="company-sub">Laporan Penerimaan Material: LP-{{ $receipt->id }}-{{ date('Y') }}</div>
                    </td>
                </tr>
            </table>
        </div>
        
        <div class="photo-grid">
            @foreach ($photoData as $photo)
                <div class="photo-item">
                    <img src="{{ $photo['base64'] }}" alt="Lampiran Foto">
                    @if ($photo['keterangan'])
                        <div class="photo-caption">{{ $photo['keterangan'] }}</div>
                    @endif
                </div>
            @endforeach
        </div>
    @endif

</body>
</html>
