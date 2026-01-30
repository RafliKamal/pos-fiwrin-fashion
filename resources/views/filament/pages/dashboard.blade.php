<x-filament-panels::page>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        .dashboard-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
            margin-bottom: 1rem;
        }

        .dashboard-forecast {
            display: grid;
            grid-template-columns: 66% 32%;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .dashboard-bottom {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 1.5rem;
        }

        @media (max-width: 1024px) {
            .dashboard-stats {
                grid-template-columns: repeat(2, 1fr);
            }

            .dashboard-forecast {
                grid-template-columns: 1fr;
            }

            .dashboard-bottom {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 640px) {
            .dashboard-stats {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="dashboard-stats">
        <x-filament::section>
            <div style="text-align: center; padding: 1rem;">
                <p style="color: #00695C; font-weight: 600; font-size: 0.875rem; margin-bottom: 0.5rem;">💰 Pendapatan
                    Bersih Hari Ini</p>
                <p style="font-size: 2rem; font-weight: 700;">Rp {{ number_format($pendapatanBersih, 0, ',', '.') }}</p>
                <p style="color: #6b7280; font-size: 0.875rem;">Laba bersih hari ini</p>
            </div>
        </x-filament::section>

        <x-filament::section>
            <div style="text-align: center; padding: 1rem;">
                <p style="color: #00695C; font-weight: 600; font-size: 0.875rem; margin-bottom: 0.5rem;">🧾 Transaksi
                    Hari Ini</p>
                <p style="font-size: 2rem; font-weight: 700;">{{ $transaksiHariIni }} Nota</p>
                <p style="color: #6b7280; font-size: 0.875rem;">Total struk pembayaran</p>
            </div>
        </x-filament::section>

        <x-filament::section>
            <div style="text-align: center; padding: 1rem;">
                <p style="color: #00695C; font-weight: 600; font-size: 0.875rem; margin-bottom: 0.5rem;">👗 Produk
                    Terjual</p>
                <p style="font-size: 2rem; font-weight: 700;">{{ $produkTerjual }} Pcs</p>
                <p style="color: #6b7280; font-size: 0.875rem;">Item fashion keluar hari ini</p>
            </div>
        </x-filament::section>
    </div>

    <div class="dashboard-forecast">
        <x-filament::section>
            <x-slot name="heading">Prediksi Penjualan (4 Minggu Kedepan)</x-slot>
            <div style="height: 350px;">
                <canvas id="forecastChart"></canvas>
            </div>
        </x-filament::section>

        <x-filament::section>
            <x-slot name="heading">Rekomendasi Restok (4 Minggu Kedepan)</x-slot>
            <div style="height: 350px; overflow-y: auto;">
                <table style="width: 100%; font-size: 0.875rem;">
                    <thead>
                        <tr style="border-bottom: 2px solid #e5e7eb;">
                            <th style="text-align: left; padding: 0.5rem;">Kategori</th>
                            <th style="text-align: center; padding: 0.5rem;">Stok</th>
                            <th style="text-align: center; padding: 0.5rem;">Prediksi</th>
                            <th style="text-align: center; padding: 0.5rem;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($restockData as $item)
                            <tr style="border-bottom: 1px solid #f3f4f6;">
                                <td style="padding: 0.5rem; font-weight: 500;">{{ $item['kategori'] }}</td>
                                <td style="text-align: center; padding: 0.5rem;">{{ $item['stok'] }}</td>
                                <td style="text-align: center; padding: 0.5rem;">{{ $item['prediksi'] }}</td>
                                <td style="text-align: center; padding: 0.5rem;">
                                    @if($item['status'] === 'kosong')
                                        <span
                                            style="background: #7c3aed; color: white; padding: 0.25rem 0.5rem; border-radius: 0.25rem; font-size: 0.75rem; font-weight: 600;">
                                            ⚠️ Kosong
                                        </span>
                                    @elseif($item['status'] === 'kurang')
                                        <span
                                            style="background: #fef2f2; color: #dc2626; padding: 0.25rem 0.5rem; border-radius: 0.25rem; font-size: 0.75rem; font-weight: 600;">
                                            Kurang {{ abs($item['selisih']) }}
                                        </span>
                                    @elseif($item['status'] === 'pas')
                                        <span
                                            style="background: #fefce8; color: #ca8a04; padding: 0.25rem 0.5rem; border-radius: 0.25rem; font-size: 0.75rem; font-weight: 600;">
                                            Pas
                                        </span>
                                    @else
                                        <span
                                            style="background: #f0fdf4; color: #16a34a; padding: 0.25rem 0.5rem; border-radius: 0.25rem; font-size: 0.75rem; font-weight: 600;">
                                            Aman +{{ $item['selisih'] }}
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="text-align: center; padding: 1rem; color: #9ca3af;">Tidak ada data
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </x-filament::section>
    </div>

    <div style="margin-bottom: 1.5rem;">
        <x-filament::section>
            <x-slot name="heading">Grafik Pendapatan (7 Hari Terakhir)</x-slot>
            <div style="height: 300px;">
                <canvas id="salesChart"></canvas>
            </div>
        </x-filament::section>
    </div>

    <div class="dashboard-bottom">
        <x-filament::section>
            <x-slot name="heading">5 Produk Terlaris</x-slot>
            <div style="height: 280px;">
                <canvas id="topProductsChart"></canvas>
            </div>
        </x-filament::section>

        <x-filament::section>
            <x-slot name="heading">Metode Pembayaran</x-slot>
            <div style="height: 280px; display: flex; justify-content: center; align-items: center;">
                <canvas id="paymentChart" style="max-width: 100%; max-height: 100%;"></canvas>
            </div>
        </x-filament::section>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            new Chart(document.getElementById('forecastChart'), {
                type: 'line',
                data: {
                    labels: @json($forecastLabels),
                    datasets: [{ label: 'Prediksi Terjual (Pcs)', data: @json($forecastValues), borderColor: '#26A69A', backgroundColor: 'rgba(38, 166, 154, 0.2)', fill: true, tension: 0.4 }]
                },
                options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } } }
            });

            new Chart(document.getElementById('salesChart'), {
                type: 'line',
                data: {
                    labels: @json($salesLabels),
                    datasets: [{ label: 'Pendapatan (Rp)', data: @json($salesData), borderColor: '#00695C', backgroundColor: 'rgba(0, 105, 92, 0.2)', fill: true, tension: 0.4 }]
                },
                options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } } }
            });

            new Chart(document.getElementById('topProductsChart'), {
                type: 'bar',
                data: {
                    labels: @json($topProducts->map(fn($p) => $p->produk->nama_barang ?? 'Unknown')),
                    datasets: [{ label: 'Total Terjual', data: @json($topProducts->pluck('total_qty')), backgroundColor: ['#00695C', '#26A69A', '#4DB6AC', '#80CBC4', '#B2DFDB'] }]
                },
                options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
            });

            new Chart(document.getElementById('paymentChart'), {
                type: 'doughnut',
                data: {
                    labels: @json($paymentMethods->pluck('metode_pembayaran')->map(fn($v) => strtoupper($v))),
                    datasets: [{ data: @json($paymentMethods->pluck('total')), backgroundColor: ['#00695C', '#26A69A', '#FF7043'] }]
                },
                options: { responsive: true, maintainAspectRatio: false }
            });
        });
    </script>
</x-filament-panels::page>