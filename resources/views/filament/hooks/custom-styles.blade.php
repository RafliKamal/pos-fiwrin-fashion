<style>
    /* Custom Filament Theme - Emerald & Cream */

    /* Main Content Background */
    .fi-main {
        background-color: #FFF8E7 !important;
    }

    /* Body Background - untuk empty space */
    .fi-body {
        background-color: #FFF8E7 !important;
    }

    body {
        background-color: #FFF8E7 !important;
    }

    /* Sidebar Styling - Cream dengan text Emerald */
    .fi-sidebar {
        background-color: #FFF8E7 !important;
        border-right: 1px solid #E0F2F1 !important;
    }

    .fi-sidebar-header {
        background-color: #FFF8E7 !important;
        border-bottom: 1px solid #E0F2F1 !important;
    }

    .fi-sidebar-nav-groups {
        padding: 0.5rem !important;
    }

    /* Navigation Items - Emerald Text */
    .fi-sidebar-item-label {
        color: #00695C !important;
    }

    .fi-sidebar-item-icon {
        color: #00695C !important;
    }

    .fi-sidebar-item:hover {
        background-color: #E0F2F1 !important;
        border-radius: 0.5rem !important;
    }

    /* Sidebar Group - Keep cream background */
    .fi-sidebar-group {
        background-color: #FFF8E7 !important;
    }

    .fi-sidebar-group-button {
        background-color: #FFF8E7 !important;
        color: #26A69A !important;
    }

    /* Override Filament Primary Color Variables */
    :root {
        --primary-50: 224 242 241 !important;
        --primary-100: 178 223 219 !important;
        --primary-200: 128 203 196 !important;
        --primary-300: 77 182 172 !important;
        --primary-400: 38 166 154 !important;
        --primary-500: 0 150 136 !important;
        --primary-600: 0 105 92 !important;
        --primary-700: 0 77 64 !important;
        --primary-800: 0 59 52 !important;
        --primary-900: 0 45 40 !important;
    }

    /* Active sidebar item - CORRECT SELECTOR: fi-active */
    /* Only target fi-sidebar-item with fi-active, not groups */
    .fi-sidebar-item.fi-active.fi-sidebar-item-has-url {
        background-color: #00695C !important;
        border-radius: 0.375rem !important;
    }

    /* The anchor/button inside - this is what actually shows the background */
    .fi-sidebar-item.fi-active.fi-sidebar-item-has-url .fi-sidebar-item-btn,
    .fi-sidebar-item.fi-active.fi-sidebar-item-has-url>a,
    .fi-sidebar-item.fi-active.fi-sidebar-item-has-url>button {
        background-color: #00695C !important;
        border-radius: 0.375rem !important;
    }

    .fi-sidebar-item.fi-active.fi-sidebar-item-has-url:hover,
    .fi-sidebar-item.fi-active.fi-sidebar-item-has-url:hover .fi-sidebar-item-btn,
    .fi-sidebar-item.fi-active.fi-sidebar-item-has-url:hover>a {
        background-color: #004D40 !important;
    }

    .fi-sidebar-item.fi-active.fi-sidebar-item-has-url .fi-sidebar-item-label,
    .fi-sidebar-item.fi-active.fi-sidebar-item-has-url .fi-sidebar-item-icon,
    .fi-sidebar-item.fi-active.fi-sidebar-item-has-url a,
    .fi-sidebar-item.fi-active.fi-sidebar-item-has-url span,
    .fi-sidebar-item.fi-active.fi-sidebar-item-has-url svg {
        color: white !important;
    }

    /* Group Labels */
    .fi-sidebar-group-label {
        color: #26A69A !important;
        font-size: 0.7rem !important;
        text-transform: uppercase !important;
        letter-spacing: 0.05em !important;
    }

    /* Top Bar - Cream */
    .fi-topbar {
        background-color: #FFF8E7 !important;
        border-bottom: 1px solid #E0F2F1 !important;
    }

    /* Brand Logo */
    .fi-brand {
        color: #00695C !important;
    }

    /* Cards & Sections - Cream Background */
    .fi-section {
        background-color: #FFF8E7 !important;
        border: 1px solid #E0F2F1 !important;
        box-shadow: 0 1px 3px rgba(0, 105, 92, 0.08) !important;
    }

    .fi-section-header {
        background-color: #FFF8E7 !important;
        border-bottom: 1px solid #E0F2F1 !important;
    }

    .fi-section-content-ctn {
        background-color: #FFF8E7 !important;
    }

    /* Tables */
    .fi-ta-table {
        background-color: white !important;
    }

    .fi-ta-header-cell {
        color: #00695C !important;
        font-weight: 600 !important;
    }

    .fi-ta-row:hover {
        background-color: #FFF8E7 !important;
    }

    .fi-ta-row:nth-child(even) {
        background-color: #FAFAFA !important;
    }

    /* Action Buttons in Table */
    .fi-ta-actions-btn {
        color: #00695C !important;
    }

    .fi-ta-actions-btn:hover {
        background-color: #E0F2F1 !important;
    }

    /* Primary Buttons */
    .fi-btn-color-primary {
        background-color: #00695C !important;
        border-color: #00695C !important;
    }

    .fi-btn-color-primary:hover {
        background-color: #004D40 !important;
        border-color: #004D40 !important;
    }

    /* Danger Buttons */
    .fi-btn-color-danger {
        background-color: #ee8358 !important;
        border-color: #ee8358 !important;
    }

    .fi-btn-color-danger:hover {
        background-color: #E64A19 !important;
        border-color: #E64A19 !important;
    }

    /* Form Inputs Focus */
    .fi-input-wrp:focus-within {
        border-color: #00695C !important;
        box-shadow: 0 0 0 2px rgba(0, 105, 92, 0.15) !important;
    }

    /* Select Inputs */
    .fi-select-option.fi-select-option-is-selected {
        background-color: #00695C !important;
    }

    /* Badges */
    .fi-badge-color-success {
        background-color: #00695C !important;
    }

    .fi-badge-color-warning {
        background-color: #ee8358 !important;
    }

    .fi-badge-color-info {
        background-color: #26A69A !important;
    }

    /* Links */
    .fi-link {
        color: #00695C !important;
    }

    .fi-link:hover {
        color: #004D40 !important;
        text-decoration: underline !important;
    }

    /* Pagination */
    .fi-pagination-item-btn.fi-pagination-item-btn-active {
        background-color: #00695C !important;
        color: white !important;
    }

    /* Tabs */
    .fi-tabs-tab[aria-selected="true"] {
        border-color: #00695C !important;
        color: #00695C !important;
    }

    /* Breadcrumbs */
    .fi-breadcrumbs-item-link {
        color: #00695C !important;
    }

    /* Notifications */
    .fi-notification.fi-notification-color-success {
        background-color: #00695C !important;
    }

    /* Widget Stats */
    .fi-wi-stats-overview-stat-value {
        color: #00695C !important;
    }

    /* Toggle/Switch Active */
    .fi-toggle-on {
        background-color: #00695C !important;
    }

    /* Create/New/Export Button - Emerald (primary and success colored buttons) */
    [class*="fi-btn"][class*="create"],
    .fi-header-actions .fi-btn,
    .fi-ac-btn-action.fi-color-primary,
    .fi-ac-btn-action.fi-color-success,
    a.fi-btn.fi-color-primary,
    button.fi-btn.fi-color-success,
    .fi-header-actions-ctn .fi-btn.fi-color-primary,
    .fi-header-actions-ctn .fi-btn.fi-color-success {
        background-color: #00695C !important;
        border-color: #00695C !important;
        color: white !important;
    }

    /* SVG icons inside primary/success action buttons - white */
    .fi-ac-btn-action.fi-color-primary svg,
    .fi-ac-btn-action.fi-color-success svg,
    .fi-header-actions-ctn .fi-btn.fi-color-primary svg,
    .fi-header-actions-ctn .fi-btn.fi-color-success svg,
    a.fi-btn.fi-color-primary svg,
    button.fi-btn.fi-color-success svg {
        color: white !important;
    }

    [class*="fi-btn"][class*="create"]:hover,
    .fi-header-actions .fi-btn:hover,
    .fi-ac-btn-action.fi-color-primary:hover,
    .fi-ac-btn-action.fi-color-success:hover,
    a.fi-btn.fi-color-primary:hover,
    button.fi-btn.fi-color-success:hover,
    .fi-header-actions-ctn .fi-btn.fi-color-primary:hover,
    .fi-header-actions-ctn .fi-btn.fi-color-success:hover {
        background-color: #004D40 !important;
        border-color: #004D40 !important;
    }

    /* Cancel/Gray buttons - keep gray style (buttons without primary or success color) */
    .fi-ac-btn-action:not(.fi-color-primary):not(.fi-color-success):not(.fi-color-danger) {
        background-color: #6B7280 !important;
        border-color: #6B7280 !important;
        color: white !important;
    }

    .fi-ac-btn-action:not(.fi-color-primary):not(.fi-color-success):not(.fi-color-danger):hover {
        background-color: #4B5563 !important;
        border-color: #4B5563 !important;
    }

    /* Search Input */
    .fi-global-search-field:focus-within {
        border-color: #00695C !important;
    }

    /* Modal - Clean White Design */
    .fi-modal-header {
        background-color: #ffffff !important;
        border-bottom: none !important;
    }

    .fi-modal-heading {
        color: #00695C !important;
    }

    .fi-modal-description {
        color: #6B7280 !important;
    }

    .fi-modal-content {
        background-color: #ffffff !important;
    }

    .fi-modal-footer,
    .fi-ac-modal-footer,
    .fi-modal-footer-actions,
    .fi-ac-footer {
        background-color: #ffffff !important;
    }

    /* Delete Modal Icon - Softer Red */
    .fi-modal-icon-container.fi-color-danger {
        background-color: #FEE2E2 !important;
    }

    .fi-modal-icon-container.fi-color-danger svg {
        color: #DC2626 !important;
    }

    /* Modal Cancel Button - Gray Style */
    .fi-modal-footer .fi-btn.fi-color-gray,
    .fi-modal-footer .fi-ac-btn-action:not(.fi-color-danger) {
        background-color: #6B7280 !important;
        border-color: #6B7280 !important;
        color: white !important;
    }

    .fi-modal-footer .fi-btn.fi-color-gray:hover,
    .fi-modal-footer .fi-ac-btn-action:not(.fi-color-danger):hover {
        background-color: #4B5563 !important;
        border-color: #4B5563 !important;
    }

    /* Modal Delete Button - More Subtle Red */
    .fi-modal-footer .fi-btn.fi-color-danger,
    .fi-modal-footer .fi-ac-btn-action.fi-color-danger {
        background-color: #DC2626 !important;
        border-color: #DC2626 !important;
        color: white !important;
    }

    .fi-modal-footer .fi-btn.fi-color-danger:hover,
    .fi-modal-footer .fi-ac-btn-action.fi-color-danger:hover {
        background-color: #B91C1C !important;
        border-color: #B91C1C !important;
    }

    /* Modal Close Button */
    .fi-modal-close-btn {
        color: #00695C !important;
    }

    .fi-modal-close-btn:hover {
        background-color: #E0F2F1 !important;
    }

    /* Loading Indicator */
    .fi-loading-indicator {
        color: #00695C !important;
    }
</style>