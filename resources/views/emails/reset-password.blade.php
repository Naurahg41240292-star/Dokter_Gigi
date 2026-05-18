<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - D'Smile</title>
    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        background-color: #f8fafc;
        color: #1e293b;
        line-height: 1.6;
    }

    .email-container {
        max-width: 600px;
        margin: 0 auto;
        background-color: #ffffff;
        border-radius: 1.5rem;
        overflow: hidden;
        box-shadow: 0 24px 80px rgba(15, 23, 42, 0.16);
    }

    .email-header {
        background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
        padding: 2rem;
        text-align: center;
        color: white;
    }

    .email-header-logo {
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1rem;
    }

    .logo-icon {
        width: 2.5rem;
        height: 2.5rem;
        background-color: rgba(255, 255, 255, 0.2);
        border-radius: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    .logo-text {
        font-size: 1.25rem;
        font-weight: 700;
    }

    .email-header h1 {
        font-size: 1.875rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
    }

    .email-header p {
        font-size: 0.9rem;
        opacity: 0.9;
    }

    .email-body {
        padding: 2.5rem;
    }

    .greeting {
        font-size: 1rem;
        margin-bottom: 1.5rem;
        color: #475569;
    }

    .greeting strong {
        color: #1e293b;
    }

    .message-box {
        background-color: #f1f5f9;
        border-left: 4px solid #2563eb;
        padding: 1rem;
        margin: 1.5rem 0;
        border-radius: 0.5rem;
    }

    .message-box p {
        color: #475569;
        font-size: 0.95rem;
    }

    .button-section {
        text-align: center;
        margin: 2rem 0;
    }

    .reset-button {
        display: inline-block;
        background-color: #2563eb;
        color: white;
        text-decoration: none;
        padding: 0.875rem 2rem;
        border-radius: 1rem;
        font-weight: 700;
        font-size: 1rem;
        box-shadow: 0 10px 25px rgba(37, 99, 235, 0.2);
        transition: all 0.3s ease;
    }

    .reset-button:hover {
        background-color: #1e40af;
        box-shadow: 0 15px 35px rgba(37, 99, 235, 0.3);
    }

    .link-section {
        background-color: #f8fafc;
        padding: 1.5rem;
        border-radius: 0.75rem;
        margin: 1.5rem 0;
        border: 1px solid #e2e8f0;
    }

    .link-section p {
        font-size: 0.85rem;
        color: #64748b;
        margin-bottom: 0.75rem;
    }

    .reset-link {
        word-break: break-all;
        background-color: white;
        padding: 0.75rem;
        border-radius: 0.5rem;
        font-size: 0.8rem;
        color: #2563eb;
        font-family: 'Courier New', monospace;
        border: 1px solid #e2e8f0;
    }

    .security-tips {
        background-color: #fef2f2;
        border: 1px solid #fed7d7;
        padding: 1.5rem;
        border-radius: 0.75rem;
        margin: 1.5rem 0;
    }

    .security-tips h3 {
        color: #991b1b;
        font-size: 0.95rem;
        margin-bottom: 0.75rem;
    }

    .security-tips ul {
        list-style: none;
        padding-left: 0;
    }

    .security-tips li {
        color: #7f1d1d;
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
        padding-left: 1.5rem;
        position: relative;
    }

    .security-tips li:before {
        content: "✓";
        position: absolute;
        left: 0;
        color: #dc2626;
        font-weight: bold;
    }

    .expiry-warning {
        background-color: #fef3c7;
        border-left: 4px solid #f59e0b;
        padding: 1rem;
        margin: 1.5rem 0;
        border-radius: 0.5rem;
    }

    .expiry-warning p {
        color: #78350f;
        font-size: 0.9rem;
    }

    .email-footer {
        background-color: #f1f5f9;
        padding: 2rem;
        text-align: center;
        border-top: 1px solid #e2e8f0;
    }

    .footer-text {
        font-size: 0.85rem;
        color: #64748b;
        margin-bottom: 1rem;
    }

    .footer-social {
        font-size: 0.85rem;
        color: #64748b;
    }

    .footer-social a {
        color: #2563eb;
        text-decoration: none;
        margin: 0 0.5rem;
    }

    .divider {
        height: 1px;
        background-color: #e2e8f0;
        margin: 1.5rem 0;
    }
    </style>
</head>

<body>
    <div class="email-container">
        <!-- Header -->
        <div class="email-header">
            <div class="email-header-logo">
                <div class="logo-icon">🦷</div>
                <div class="logo-text">D'Smile</div>
            </div>
            <h1>Reset Password</h1>
            <p>Permintaan Reset Password Akun Anda</p>
        </div>

        <!-- Body -->
        <div class="email-body">
            <div class="greeting">
                Halo, <strong>Pasien D'Smile</strong>
            </div>

            <div class="message-box">
                <p>Kami menerima permintaan untuk reset password akun Anda. Klik tombol di bawah untuk membuat password
                    baru.</p>
            </div>

            <!-- CTA Button -->
            <div class="button-section">
                <a href="{{ $resetLink }}" class="reset-button">Reset Password Sekarang</a>
            </div>

            <!-- Alternative Link -->
            <div class="link-section">
                <p><strong>Atau salin link berikut ke browser Anda:</strong></p>
                <div class="reset-link">{{ $resetLink }}</div>
            </div>

            <div class="divider"></div>

            <!-- Security Tips -->
            <div class="security-tips">
                <h3>💡 Tips Keamanan Password</h3>
                <ul>
                    <li>Gunakan kombinasi huruf besar, huruf kecil, angka, dan simbol</li>
                    <li>Minimal 8 karakter untuk keamanan optimal</li>
                    <li>Jangan bagikan password dengan siapa pun</li>
                    <li>Hindari password yang mudah ditebak</li>
                </ul>
            </div>

            <!-- Expiry Warning -->
            <div class="expiry-warning">
                <p><strong>⏰ Perhatian:</strong> Link reset password ini hanya berlaku selama <strong>60 menit</strong>.
                    Jika link sudah kadaluarsa, silakan lakukan permintaan reset password kembali.</p>
            </div>

            <div class="message-box">
                <p><strong>Tidak meminta reset password?</strong> Abaikan email ini. Akun Anda tetap aman dan tidak ada
                    yang berubah.</p>
            </div>
        </div>

        <!-- Footer -->
        <div class="email-footer">
            <div class="footer-text">
                <p>© 2026 D'Smile Clinic. Semua hak dilindungi.</p>
            </div>
            <div class="footer-social">
                <p>Hubungi kami: <a href="mailto:support@dsmile.com">support@dsmile.com</a></p>
            </div>
        </div>
    </div>
</body>

</html>