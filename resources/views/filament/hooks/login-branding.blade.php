<style>
    /* Fix white line & scrollbar issue */
    html {
        height: 100%;
        background: linear-gradient(260deg, #FFF8E7 30%, #E0F2F1 70%, #B2DFDB 100%) no-repeat fixed !important;
    }

    body {
        margin: 0;
        padding: 0;
        min-height: 100%;
        width: 100%;
        overflow-x: hidden;
        background: transparent !important;
        /* Let html background show through */
    }

    /* Background di BELAKANG kotak login */
    .fi-simple-layout {

        min-height: 100vh;
        width: 100%;
        padding: 1rem;
        box-sizing: border-box;
    }

    /* Kotak login - cream sangat muda */
    .fi-simple-main {
        background: #fcf8ecff !important;
        width: 100%;
        max-width: 400px;
        margin: 0 auto;
        box-shadow: 0 25px 50px -12px rgba(0, 15, 32, 0.20), 0 12px 24px -8px rgba(0, 0, 0, 0.1) !important;
    }

    /* Sembunyikan header default (Fiwrin Fashion & Sign in) */
    .fi-simple-header {
        display: none !important;
    }

    /* Tombol Sign In - Emerald */
    .fi-simple-main .fi-btn {
        background-color: #00695C !important;
        border-color: #00695C !important;
        color: white !important;
    }

    .fi-simple-main .fi-btn:hover {
        background-color: #004D40 !important;
        border-color: #004D40 !important;
        color: white !important;
    }

    /* Responsive: Mobile */
    @media (max-width: 640px) {
        .fi-simple-layout {
            padding: 0.5rem;
        }

        .fi-simple-main {
            border-radius: 12px !important;
            margin: 0.5rem;
        }

        .login-logo-icon {
            width: 56px !important;
            height: 56px !important;
        }

        .login-logo-svg {
            width: 28px !important;
            height: 28px !important;
        }

        .login-brand-title {
            font-size: 1.25rem !important;
        }

        .login-signin-title {
            font-size: 1rem !important;
        }
    }
</style>

<!-- Custom Header: Logo → Fiwrin Fashion → Sign in -->
<div style="text-align: center; margin-bottom: 1.5rem;">
    <!-- Logo Icon -->
    <div class="login-logo-icon"
        style="display: inline-flex; align-items: center; justify-content: center; width: 64px; height: 64px; background: linear-gradient(135deg, #00695C, #26A69A); border-radius: 14px; box-shadow: 0 4px 12px rgba(0, 105, 92, 0.25); margin-bottom: 0.75rem;">
        <svg class="login-logo-svg" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
            stroke-width="1.5" stroke="white" style="width: 32px; height: 32px;">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
        </svg>
    </div>

    <!-- Fiwrin Fashion -->
    <h1 class="login-brand-title" style="font-size: 1.5rem; font-weight: 700; color: #00695C; margin: 0 0 0.25rem 0;">
        Fiwrin Fashion</h1>

    <!-- Sign in -->
    <h2 class="login-signin-title" style="font-size: 1.25rem; font-weight: 600; color: #1f2937; margin: 0 0 -1.5rem 0;">
        Sign in</h2>
</div>