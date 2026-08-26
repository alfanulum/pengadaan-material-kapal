<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Purchase Order - {{ $po->kode_po }}</title>
    <style>
        @page {
            margin: 20px;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            color: #000;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        .table-border {
            border: 1px solid #000;
        }
        .table-border th, .table-border td {
            border: 1px solid #000;
            padding: 4px;
            vertical-align: top;
        }
        
        .header-table td {
            vertical-align: middle;
            text-align: center;
        }
        .header-title {
            font-size: 12px;
            font-weight: bold;
        }
        
        .meta-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
        }
        .meta-table td {
            border: none !important;
            padding: 2px !important;
            text-align: left;
        }
        .meta-label {
            width: 60px;
        }
        .meta-colon {
            width: 10px;
        }

        .info-box {
            padding: 8px;
            border-left: 1px solid #000;
            border-right: 1px solid #000;
            border-bottom: 1px solid #000;
        }
        .info-table {
            border: none;
            width: auto;
        }
        .info-table td {
            border: none;
            padding: 2px 4px;
        }

        .item-table {
            border-left: 1px solid #000;
            border-right: 1px solid #000;
            border-bottom: 1px solid #000;
            font-size: 10px;
        }
        .item-table th, .item-table td {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
        }
        .item-table th {
            font-weight: normal;
        }
        
        .item-table .text-left { text-align: left; }
        .item-table .text-right { text-align: right; }

        .footer-grid {
            width: 100%;
            border-left: 1px solid #000;
            border-right: 1px solid #000;
            border-bottom: 1px solid #000;
            border-collapse: collapse;
        }
        .footer-grid td {
            vertical-align: top;
            padding: 5px;
        }

        .ketentuan-table {
            width: 100%;
            font-size: 10px;
            border-collapse: collapse;
        }
        .ketentuan-table td {
            padding: 2px;
            border: none;
        }

        .total-box {
            border-left: 1px solid #000;
            padding: 5px;
            height: 100%;
        }

        .signature-box {
            width: 100%;
            border-left: 1px solid #000;
            border-right: 1px solid #000;
            border-bottom: 1px solid #000;
            border-collapse: collapse;
            text-align: center;
        }
        .signature-box td {
            border: 1px solid #000;
            width: 50%;
            vertical-align: top;
            padding: 5px;
        }
        .sig-space {
            height: 70px;
        }

        .page-break {
            page-break-after: always;
        }

        .footer-notes {
            border: 1px solid #000;
            padding: 5px;
            font-size: 10px;
        }
    </style>
</head>
<body>

    <!-- HEADER -->
    <table class="table-border header-table">
        <tr>
            <td style="width: 20%; padding: 10px;">
                <h1 style="font-size: 20px; font-weight: 900; margin:0; color:#1e3a8a; font-style: italic;">XYZ<span style="color:#e5e7eb;">========</span></h1>
                <div style="font-size: 9px; color:#1e3a8a; font-weight: bold; text-align: right; margin-top:-5px;">INDONESIA</div>
            </td>
            <td style="width: 45%; padding: 10px;">
                <div class="header-title">DIRECT PURCHASE ORDER SURAT PESANAN</div>
                <div class="header-title">PENGADAAN LANGSUNG (SPPL)</div>
            </td>
            <td style="width: 35%; padding: 2px;">
                <table class="meta-table">
                    <tr>
                        <td class="meta-label">Nomor</td>
                        <td class="meta-colon">:</td>
                        <td>{{ $po->kode_po }}</td>
                        <td rowspan="4" style="font-size: 16px; font-weight: bold; text-align: center; vertical-align: middle;">
                            M23
                        </td>
                    </tr>
                    <tr>
                        <td class="meta-label">Jubel</td>
                        <td class="meta-colon">:</td>
                        <td>-</td>
                    </tr>
                    <tr>
                        <td class="meta-label">Tanggal</td>
                        <td class="meta-colon">:</td>
                        <td>{{ \Carbon\Carbon::parse($po->tanggal_po)->format('d-M-Y') }}</td>
                    </tr>
                    <tr>
                        <td class="meta-label">Halaman</td>
                        <td class="meta-colon">:</td>
                        <td>1</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <!-- INFO KEPADA YTH -->
    <div class="info-box">
        <table class="info-table">
            <tr>
                <td colspan="3">Kepada Yth</td>
            </tr>
            <tr>
                <td style="width: 120px;">Nama Perusahaan</td>
                <td style="width: 10px;">:</td>
                <td>{{ $po->vendor->nama_vendor ?? '-' }}</td>
            </tr>
            <tr>
                <td>NPWP</td>
                <td>:</td>
                <td>{{ $po->vendor->npwp ?? '-' }}</td>
            </tr>
            <tr>
                <td>Alamat Perusahaan</td>
                <td>:</td>
                <td>{{ $po->vendor->alamat ?? '-' }}</td>
            </tr>
        </table>
    </div>

    <!-- TABLE MATERIAL -->
    <table class="item-table">
        <thead>
            <tr>
                <th style="width: 4%;">NO</th>
                <th style="width: 12%;">KODE MATERIAL</th>
                <th style="width: 33%;">Nama Material<br>Spesifikasi, Ukuran</th>
                <th style="width: 8%;">Jumlah<br>Kode<br>Satuan</th>
                <th style="width: 25%;">Harga Satuan<br>Harga Total<br>(Belum PPN)</th>
                <th style="width: 9%;">No M01</th>
                <th style="width: 9%;">No Proyek</th>
            </tr>
        </thead>
        <tbody>
            @foreach($po->items as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>-</td>
                <td class="text-left">
                    {{ $item->nama_barang }}<br>
                    <span style="font-size: 8px;">{{ $item->spesifikasi }}</span>
                </td>
                <td>
                    {{ $item->qty }}<br><br>
                    {{ $item->satuan }}
                </td>
                <td>
                    <table style="width:100%; border:none; margin:0; padding:0;">
                        <tr>
                            <td style="border:none; text-align:left; padding:0;">sht</td>
                            <td style="border:none; text-align:right; padding:0;">{{ number_format($item->harga_satuan, 2, '.', ',') }}</td>
                            <td style="border:none; text-align:right; padding:0;">{{ number_format($item->subtotal ?? ($item->qty * $item->harga_satuan), 2, '.', ',') }}</td>
                        </tr>
                    </table>
                </td>
                <td>PR13462</td>
                <td>{{ $po->tender->materialRequest->project->kode_project ?? '-' }}</td>
            </tr>
            @endforeach
            <!-- Padding rows to ensure table height if needed -->
            @if(count($po->items) < 3)
                @for($i=0; $i<(3 - count($po->items)); $i++)
                <tr>
                    <td style="height: 40px;"></td><td></td><td></td><td></td><td></td><td></td><td></td>
                </tr>
                @endfor
            @endif
        </tbody>
    </table>

    <!-- KETENTUAN DAN TOTAL -->
    <table class="footer-grid">
        <tr>
            <td style="width: 50%;">
                <table class="ketentuan-table">
                    <tr><td colspan="3">Ketentuan</td></tr>
                    <tr>
                        <td style="width: 140px;">Tanggal Batas Pengiriman</td>
                        <td style="width: 10px;">:</td>
                        <td>{{ $po->deadline_pengiriman ? \Carbon\Carbon::parse($po->deadline_pengiriman)->format('d-M-Y') : '-' }}</td>
                    </tr>
                    <tr>
                        <td>Tempat Penyerahan</td>
                        <td>:</td>
                        <td>GUDANG PUSAT</td>
                    </tr>
                    <tr>
                        <td>Jumlah preq. Pengiriman</td>
                        <td>:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Persyaratan Angkutan</td>
                        <td>:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Persyaratan Kemasan</td>
                        <td>:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Note</td>
                        <td>:</td>
                        <td>{{ $po->catatan }}</td>
                    </tr>
                </table>
            </td>
            <td style="width: 50%; border-left: 1px solid #000; vertical-align: top;">
                @php
                    function terbilang($n) {
                        $n = (int) abs($n);
                        $kata = ['', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam', 'Tujuh', 'Delapan', 'Sembilan', 'Sepuluh', 'Sebelas', 'Dua Belas', 'Tiga Belas', 'Empat Belas', 'Lima Belas', 'Enam Belas', 'Tujuh Belas', 'Delapan Belas', 'Sembilan Belas'];
                        $tens  = ['', '', 'Dua Puluh', 'Tiga Puluh', 'Empat Puluh', 'Lima Puluh', 'Enam Puluh', 'Tujuh Puluh', 'Delapan Puluh', 'Sembilan Puluh'];
                        if ($n < 20)       return $kata[$n];
                        if ($n < 100)      return $tens[intdiv($n,10)] . ($n%10 ? ' ' . $kata[$n%10] : '');
                        if ($n < 200)      return 'Seratus' . ($n > 100 ? ' ' . terbilang($n-100) : '');
                        if ($n < 1000)     return $kata[intdiv($n,100)] . ' Ratus' . ($n%100 ? ' ' . terbilang($n%100) : '');
                        if ($n < 2000)     return 'Seribu' . ($n > 1000 ? ' ' . terbilang($n-1000) : '');
                        if ($n < 1000000)  return terbilang(intdiv($n,1000)) . ' Ribu' . ($n%1000 ? ' ' . terbilang($n%1000) : '');
                        if ($n < 1e9)      return terbilang(intdiv($n,1e6)) . ' Juta' . ($n%1e6 ? ' ' . terbilang($n%1e6) : '');
                        if ($n < 1e12)     return terbilang(intdiv($n,1e9)) . ' Miliar' . ($n%1e9 ? ' ' . terbilang($n%1e9) : '');
                        return terbilang(intdiv($n,1e12)) . ' Triliun' . ($n%1e12 ? ' ' . terbilang($n%1e12) : '');
                    }
                @endphp
                <div style="margin-bottom: 5px;">
                    Jumlah &nbsp;&nbsp;&nbsp;: &nbsp;&nbsp;&nbsp;Rp. {{ number_format($po->total_harga, 2, '.', ',') }}
                </div>
                <div style="font-size: 10px;">
                    {{ ucwords(terbilang($po->total_harga)) }} Rupiah
                </div>
            </td>
        </tr>
    </table>

    <!-- SIGNATURES -->
    <table class="signature-box">
        <tr>
            <td>
                <div>Diterima dan disetujui oleh penjual/Pemasok</div>
                <table style="width:100%; border:none; text-align:left; font-size: 10px; margin-top: 10px;">
                    <tr>
                        <td style="border:none; width:100px;">Nama pimpinan</td>
                        <td style="border:none; width:10px;">:</td>
                        <td style="border:none;">{{ $po->vendor->pic ?? '' }}</td>
                    </tr>
                    <tr>
                        <td style="border:none;">Kode pemasok</td>
                        <td style="border:none;">:</td>
                        <td style="border:none;">VND-{{ $po->vendor->id }}</td>
                    </tr>
                </table>
                <div class="sig-space"></div>
                <div>(...................................................................................)</div>
                <div style="font-size: 9px; margin-top: 2px;">Tanda tangan, Stempel perusahaan, Materai</div>
            </td>
            <td>
                <div>Disetujui</div>
                <div style="margin-top: 5px;">PT XYZ INDONESIA</div>
                <div class="sig-space"></div>
                <div style="margin-top: 25px;">Budi Raharjo</div>
                <div style="font-size: 10px;">Ketua Supply Chain / Manager</div>
            </td>
        </tr>
    </table>

    <div class="page-break"></div>

    <!-- HALAMAN BELAKANG (SYARAT & KETENTUAN) -->
    <div class="footer-notes" style="margin-top: 20px; font-weight: bold; text-align: center;">
        PERSETUJUAN PELAKSANAAN PESANAN PENGADAAN LANGSUNG INI TUNDUK PADA KETENTUAN DAN SYARAT - SYARAT SEPERTI
        TERSEBUT DI HALAMAN INI DAN MERUPAKAN BAGIAN TAK TERPISAHKAN DARI SPPL INI
    </div>
    
    <table style="width:100%; border-left: 1px solid #000; border-right: 1px solid #000; border-bottom: 1px solid #000; font-size: 11px;">
        <tr>
            <td style="width: 50%; padding: 5px; border-right: 1px solid #000;">
                1. DIRKEU Cq. Manager Perbendaharaan<br>
                2. Manager Pergudangan I
            </td>
            <td style="width: 50%; padding: 5px;">
                3. Kasub Rik OPS I SPI<br>
                4. Arsip
            </td>
        </tr>
    </table>

</body>
</html>
