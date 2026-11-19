@extends('layouts.app')

@section('title', 'Transparansi Anggaran - Kelurahan Notoharjo')

@section('content')
<div class="bg-gradient-to-b from-emerald-900 to-emerald-800 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-extrabold tracking-tight">Transparansi Dana & Anggaran Kelurahan</h1>
        <p class="text-emerald-200 mt-2 text-sm">Laporan keterbukaan alokasi dan realisasi anggaran pembangunan Kelurahan Notoharjo</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-12">
    @foreach($anggaran as $tahun => $items)
        <div class="bg-white rounded-3xl p-6 sm:p-10 border border-slate-200 shadow-sm space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-slate-100 gap-2">
                <div>
                    <h2 class="text-2xl font-extrabold text-slate-900">Tahun Anggaran {{ $tahun }}</h2>
                    <span class="text-xs text-slate-500">Pemerintah Kelurahan Notoharjo • Kecamatan Trimurjo</span>
                </div>
                <div class="text-sm font-semibold text-emerald-700 bg-emerald-50 px-3 py-1.5 rounded-xl border border-emerald-100">
                    Total Item: {{ $items->count() }} Kegiatan
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs sm:text-sm">
                    <thead>
                        <tr class="bg-slate-50 text-slate-600 border-b border-slate-200">
                            <th class="py-3 px-4 font-bold">Jenis</th>
                            <th class="py-3 px-4 font-bold">Bidang / Kegiatan</th>
                            <th class="py-3 px-4 font-bold">Uraian</th>
                            <th class="py-3 px-4 font-bold text-right">Pagu Target</th>
                            <th class="py-3 px-4 font-bold text-right">Realisasi</th>
                            <th class="py-3 px-4 font-bold text-center">Persentase</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($items as $item)
                            @php
                                $persen = $item->target_anggaran > 0 ? min(100, round(($item->realisasi_anggaran / $item->target_anggaran) * 100)) : 100;
                            @endphp
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="py-3.5 px-4 font-semibold">
                                    <span class="px-2 py-0.5 rounded text-xs {{ $item->jenis === 'Pendapatan' ? 'bg-sky-100 text-sky-800' : 'bg-emerald-100 text-emerald-800' }}">
                                        {{ $item->jenis }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 text-slate-600 font-medium">{{ $item->bidang }}</td>
                                <td class="py-3.5 px-4 font-semibold text-slate-900">{{ $item->uraian }}</td>
                                <td class="py-3.5 px-4 text-right text-slate-600">Rp {{ number_format($item->target_anggaran, 0, ',', '.') }}</td>
                                <td class="py-3.5 px-4 text-right font-bold text-emerald-600">Rp {{ number_format($item->realisasi_anggaran, 0, ',', '.') }}</td>
                                <td class="py-3.5 px-4 text-center">
                                    <span class="inline-block px-2.5 py-1 bg-slate-100 text-slate-700 text-xs font-bold rounded-lg">
                                        {{ $persen }}%
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endforeach
</div>
@endsection

