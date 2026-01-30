<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peringatan Stok</title>
</head>

<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f3f4f6;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="max-width: 600px; margin: 0 auto;">
        <!-- Header -->
        <tr>
            <td
                style="background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%); padding: 25px 20px; text-align: center; border-radius: 12px 12px 0 0;">
                <h1 style="margin: 0; color: white; font-size: 22px;">⚠️ Peringatan Stok Menipis</h1>
            </td>
        </tr>

        <!-- Content -->
        <tr>
            <td style="background: #ffffff; padding: 25px 20px;">
                <p style="margin: 0 0 15px; font-size: 15px; color: #374151;">
                    Halo Pemilik <strong>Fiwrin Fashion</strong>,
                </p>
                <p style="margin: 0 0 20px; font-size: 14px; color: #6b7280;">
                    Berdasarkan prediksi AI untuk <strong style="color: #dc2626;">4 minggu ke depan</strong>,
                    beberapa kategori produk memiliki stok yang tidak mencukupi:
                </p>

                <!-- Items List (Mobile Friendly) -->
                @foreach($lowStockItems as $item)
                    <div
                        style="background: #fef2f2; border-left: 4px solid #dc2626; padding: 12px 15px; margin-bottom: 10px; border-radius: 0 8px 8px 0;">
                        <div style="font-weight: bold; font-size: 15px; color: #1f2937; margin-bottom: 8px;">
                            {{ $item['kategori'] }}
                        </div>
                        <table width="100%" cellspacing="0" cellpadding="0" style="font-size: 13px;">
                            <tr>
                                <td style="color: #6b7280; padding: 2px 0;">Prediksi Terjual</td>
                                <td style="text-align: right; font-weight: 600; color: #374151;">{{ $item['prediksi'] }} pcs
                                </td>
                            </tr>
                            <tr>
                                <td style="color: #6b7280; padding: 2px 0;">Stok Saat Ini</td>
                                <td style="text-align: right; font-weight: 600; color: #374151;">{{ $item['stok'] }} pcs
                                </td>
                            </tr>
                            <tr>
                                <td style="color: #dc2626; padding: 2px 0; font-weight: 600;">Kekurangan</td>
                                <td style="text-align: right; font-weight: bold; color: #dc2626;">
                                    {{ abs($item['selisih']) }} pcs
                                </td>
                            </tr>
                        </table>
                    </div>
                @endforeach

                <!-- Recommendation Box -->
                <div style="background: #fef3c7; border-radius: 8px; padding: 15px; margin-top: 20px;">
                    <p style="margin: 0; font-size: 14px; color: #92400e;">
                        💡 <strong>Rekomendasi:</strong> Segera lakukan restok untuk kategori di atas agar tidak
                        kehabisan stok.
                    </p>
                </div>

                <p style="margin: 20px 0 0; font-size: 12px; color: #9ca3af; text-align: center;">
                    Email ini dikirim otomatis oleh sistem prediksi AI
                </p>
            </td>
        </tr>

        <!-- Footer -->
        <tr>
            <td style="background: #1f2937; padding: 20px; text-align: center; border-radius: 0 0 12px 12px;">
                <p style="margin: 0; font-size: 12px; color: #9ca3af;">
                    © {{ date('Y') }} Fiwrin Fashion POS
                </p>
                <p style="margin: 5px 0 0; font-size: 11px; color: #6b7280;">
                    Tugas Akhir - M Rafli Kamal 🎓
                </p>
            </td>
        </tr>
    </table>
</body>

</html>