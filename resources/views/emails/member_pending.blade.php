<div style="background:#f5f7fb;padding:24px 12px;margin:0;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif;color:#1f2937;">
    <div style="max-width:600px;margin:0 auto;background:#ffffff;border:1px solid #e5e7eb;border-radius:12px;overflow:hidden;box-shadow:0 4px 14px rgba(0,0,0,0.06);">

        <div style="padding:28px 24px;">
            <h2 style="margin:0 0 8px;font-size:22px;line-height:1.3;color:#0f172a;">Halo {{ $member->full_name }},</h2>
            <p style="margin:0 0 14px;font-size:14px;color:#374151;">Terima kasih telah melakukan pendaftaran sebagai member Fansclub Esports.</p>

            <p style="margin:0 0 14px;font-size:14px;color:#374151;">Data kamu sudah berhasil kami terima dan saat ini sedang dalam proses peninjauan oleh tim admin.</p>

            <div style="margin:18px 0;padding:14px 16px;background:#f1f5f9;border:1px dashed #cbd5e1;border-radius:10px;">
                <div style="font-size:12px;color:#64748b;letter-spacing:.02em;">ID Pendaftaran</div>
                <div style="font-size:20px;font-weight:700;color:#0f172a;letter-spacing:.04em;">{{ $member->membership_id }}</div>
            </div>

            <p style="margin:0 0 14px;font-size:14px;color:#374151;">Kami akan mengirimkan pemberitahuan selanjutnya setelah proses verifikasi selesai.</p>

            <p style="margin:0;font-size:14px;color:#374151;">Terima kasih telah bergabung dan mendukung komunitas kami.</p>

            <div style="margin-top:22px;color:#6b7280;font-size:13px;">
                Salam,<br>
                <strong style="color:#111827;">Admin Fansclub Esports</strong>
            </div>
        </div>

        <div style="padding:14px 20px;border-top:1px solid #f1f5f9;background:#fafafa;color:#9ca3af;font-size:12px;text-align:center;">
            Email ini dikirim otomatis. Mohon tidak membalas email ini.
        </div>
    </div>
</div>
