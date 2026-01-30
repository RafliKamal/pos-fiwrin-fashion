<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Kasir</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            prefix: 'tw-',
            important: true,
        }
    </script>

    @livewireStyles
    @filamentStyles

    <style>
        /* 1. Reset & Base Layout */
        body {
            overflow: hidden;
            background-color: #f3f4f6;
        }

        .scroll-area {
            overflow-y: auto;
            height: calc(100vh - 170px);
            scrollbar-width: thin;
        }

        .cart-section {
            height: 100vh;
            background: white;
            display: flex;
            flex-direction: column;
            border-right: 1px solid #dee2e6;
        }

        .product-section {
            height: 100vh;
            display: flex;
            flex-direction: column;
            background-color: #f8f9fa;
        }

        /* 2. Product Components */
        .product-card {
            cursor: pointer;
            transition: all 0.2s;
            border: none;
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08);
            border: 1px solid #198754;
        }

        .product-img {
            height: 110px;
            object-fit: cover;
            background: #e9ecef;
        }

        .cat-chip {
            cursor: pointer;
            user-select: none;
            border: 1px solid #dee2e6;
            background: white;
            color: #495057;
            transition: all 0.2s;
            font-weight: 500;
        }

        .cat-chip.active {
            background: #198754;
            color: white;
            border-color: #198754;
            box-shadow: 0 4px 6px rgba(25, 135, 84, 0.2);
        }

        /* 3. NOTIFIKASI */
        .notification-wrapper {
            position: fixed !important;
            top: 16px !important;
            right: 16px !important;
            left: auto !important;
            bottom: auto !important;
            width: 380px !important;
            z-index: 99999 !important;
            pointer-events: none !important;
        }

        .notification-wrapper * {
            position: static !important;
        }

        .notification-wrapper .fi-notifications,
        .notification-wrapper [wire\:id] {
            position: relative !important;
            width: 100% !important;
            display: flex !important;
            flex-direction: column !important;
            gap: 8px !important;
            align-items: flex-end !important;
        }

        .fi-no-notification {
            pointer-events: auto !important;
            background: white !important;
            border-radius: 10px !important;
            padding: 14px 16px !important;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15) !important;
            border-left: 4px solid #ef4444 !important;
            display: flex !important;
            align-items: flex-start !important;
            gap: 12px !important;
            max-width: 360px !important;
            width: 100% !important;
            animation: slideInRight 0.3s ease-out !important;
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(100%);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .fi-no-notification .fi-no-notification-icon,
        .fi-no-notification>svg {
            width: 20px !important;
            height: 20px !important;
            min-width: 20px !important;
            flex-shrink: 0 !important;
            color: #ef4444 !important;
        }

        .fi-no-notification-content {
            flex: 1 !important;
            min-width: 0 !important;
        }

        .fi-no-notification-title {
            font-size: 14px !important;
            font-weight: 600 !important;
            color: #1f2937 !important;
            line-height: 1.4 !important;
            margin: 0 0 2px 0 !important;
        }

        .fi-no-notification-body {
            font-size: 13px !important;
            color: #6b7280 !important;
            line-height: 1.4 !important;
            margin: 0 !important;
        }

        .fi-no-notification-body p {
            margin: 0 !important;
        }

        .fi-no-notification-close-btn,
        .fi-no-notification button[type="button"] {
            padding: 4px !important;
            color: #9ca3af !important;
            background: transparent !important;
            border: none !important;
            cursor: pointer !important;
            flex-shrink: 0 !important;
        }

        .fi-no-notification-close-btn:hover,
        .fi-no-notification button[type="button"]:hover {
            color: #6b7280 !important;
        }

        .fi-no-notification-date {
            display: none !important;
        }

        /* ===================== */
        /* MOBILE RESPONSIVE */
        /* ===================== */
        @media (max-width: 767px) {
            body {
                overflow: auto;
            }

            .row.g-0.h-100 {
                height: auto !important;
                flex-direction: column;
            }

            /* Cart section - hidden by default on mobile */
            .col-md-4.col-lg-3.cart-section {
                display: none !important;
                order: 1;
            }

            /* Cart section - when active on mobile */
            .col-md-4.col-lg-3.cart-section.mobile-active {
                display: flex !important;
                flex-direction: column !important;
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 60px;
                z-index: 999;
                width: 100% !important;
                max-width: 100% !important;
                height: auto !important;
            }

            /* Cart scroll area - SCROLLABLE on mobile */
            .col-md-4.col-lg-3.cart-section.mobile-active .scroll-area {
                flex: 1 !important;
                overflow-y: auto !important;
                height: auto !important;
                max-height: none !important;
            }

            /* Product section - full width on mobile */
            .col-md-8.col-lg-9.product-section {
                width: 100% !important;
                max-width: 100% !important;
                flex: 0 0 100% !important;
                height: auto !important;
                min-height: calc(100vh - 60px);
                padding-bottom: 70px !important;
                order: 2;
            }

            .product-section.mobile-hidden {
                display: none !important;
            }

            /* Product scroll area - visible overflow */
            .product-section .scroll-area {
                height: auto !important;
                max-height: none !important;
                overflow-y: visible !important;
            }

            /* Mobile Tab Navigation */
            .mobile-tabs {
                display: flex !important;
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                background: white;
                z-index: 1000;
                box-shadow: 0 -4px 12px rgba(0, 0, 0, 0.1);
                padding: 8px;
                gap: 8px;
            }

            .mobile-tabs .tab-btn {
                flex: 1;
                padding: 12px;
                border: none;
                border-radius: 8px;
                font-weight: 600;
                font-size: 14px;
            }

            .mobile-tabs .tab-btn.active {
                background: #198754;
                color: white;
            }

            .mobile-tabs .tab-btn:not(.active) {
                background: #f8f9fa;
                color: #495057;
            }

            /* Cart footer - for mobile */
            .col-md-4.col-lg-3.cart-section.mobile-active .p-3.bg-white.border-top {
                margin-top: auto !important;
                padding-bottom: 10px !important;
            }

            /* Notification wrapper smaller on mobile */
            .notification-wrapper {
                width: calc(100% - 32px) !important;
                max-width: 320px !important;
            }
        }

        @media (min-width: 768px) {
            .mobile-tabs {
                display: none !important;
            }
        }
    </style>
</head>

<body class="bg-light">
    <!-- WRAPPER FIXED UNTUK NOTIFIKASI -->
    <div class="notification-wrapper">
        @livewire('notifications')
    </div>

    @livewire('kasir-component')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @livewireScripts
    @filamentScripts

    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('error', (event) => {
                if (event.status === 419 || event.status === 403) {
                    window.location.reload();
                }
            });
        });
    </script>
</body>

</html>