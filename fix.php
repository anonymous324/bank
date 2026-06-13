<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Financial Settings</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        /* ===== General Styles ===== */
        :root {
            --primary: #1D4ED8;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f9fafb;
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }

        .container {
            max-width: 1200px;
            margin: auto;
            padding: 16px;
        }

        h1, h2, h3 {
            margin: 0;
        }

        /* ===== Header ===== */
        header h1 {
            font-size: 2rem;
            font-weight: bold;
            color: #1f2937;
            display: flex;
            align-items: center;
        }

        header h1 i {
            color: var(--primary);
            margin-right: 8px;
        }

        #userIdDisplay {
            font-size: 0.875rem;
            color: #6b7280;
            margin-top: 4px;
        }

        /* ===== Loading & Error ===== */
        #loadingIndicator {
            text-align: center;
            padding: 32px;
        }

        #loadingIndicator i {
            font-size: 2.5rem;
            color: var(--primary);
            animation: spin 1s linear infinite;
        }

        #loadingIndicator p {
            margin-top: 8px;
            color: #4b5563;
        }

        #errorMessage {
            display: none;
            background-color: #fee2e2;
            border-left: 4px solid #f87171;
            color: #b91c1c;
            padding: 16px;
            border-radius: 8px;
        }

        /* ===== Tabs ===== */
        .tabs-nav button {
            display: block;
            width: 100%;
            padding: 12px 16px;
            text-align: left;
            font-weight: 600;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            margin-bottom: 8px;
            transition: all 0.2s ease;
        }

        .tabs-nav button.active {
            background-color: var(--primary);
            color: #fff;
        }

        .tabs-nav button:not(.active):hover {
            background-color: #f3f4f6;
        }

        /* ===== Grid Layout ===== */
        .grid {
            display: flex;
            flex-wrap: wrap;
            gap: 24px;
        }

        .col-1 {
            flex: 1 1 100%;
        }

        .col-2 {
            flex: 2 1 100%;
        }

        @media (min-width: 1024px) {
            .col-1 {
                flex: 1 1 30%;
            }

            .col-2 {
                flex: 2 1 65%;
            }
        }

        /* ===== Cards ===== */
        .card {
            background-color: #fff;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05);
        }

        /* ===== Form Elements ===== */
        form label {
            display: block;
            font-size: 0.875rem;
            margin-bottom: 4px;
            color: #374151;
            font-weight: 500;
        }

        form input, form select {
            width: 100%;
            padding: 12px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.2s ease;
        }

        form input:focus, form select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 2px rgba(29, 78, 216, 0.3);
        }

        form input[disabled] {
            background-color: #f3f4f6;
            border-color: #e5e7eb;
        }

        button#saveButton {
            background-color: #16a34a;
            color: #fff;
            font-weight: 600;
            padding: 12px 24px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        button#saveButton:hover {
            background-color: #15803d;
        }

        #saveStatus {
            margin-top: 8px;
            font-size: 0.875rem;
        }

        /* ===== Account Cards ===== */
        .account-card {
            border-left: 4px solid;
            padding: 16px;
            border-radius: 8px;
            background-color: #f0fdf4; /* default green-50 */
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            margin-bottom: 16px;
        }

        .account-card.green {
            background-color: #dcfce7;
            border-color: #22c55e;
            color: #15803d;
        }

        .account-card.blue {
            background-color: #dbeafe;
            border-color: #3b82f6;
            color: #1e40af;
        }

        .account-card h3 {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
            font-size: 1.125rem;
            font-weight: 600;
        }

        .account-card ul {
            list-style: none;
            padding: 0;
            margin: 0;
            border-top: 1px solid #e5e7eb;
        }

        .account-card li {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #e5e7eb;
        }

        .status-badge {
            padding: 2px 8px;
            font-size: 0.75rem;
            border-radius: 9999px;
            background-color: #bfdbfe;
            color: #1e40af;
            font-weight: 500;
        }

        /* ===== Security Toggle ===== */
        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 44px;
            height: 24px;
        }

        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #e5e7eb;
            transition: 0.4s;
            border-radius: 24px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 20px;
            width: 20px;
            left: 2px;
            bottom: 2px;
            background-color: white;
            transition: 0.4s;
            border-radius: 50%;
        }

        input:checked + .slider {
            background-color: var(--primary);
        }

        input:checked + .slider:before {
            transform: translateX(20px);
        }

        /* ===== Hidden / Show ===== */
        .hidden {
            display: none;
        }

        /* ===== Spinner animation ===== */
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

    </style>
</head>
<body>

    <div id="app" class="container">
        <header class="mb-8">
            <h1>
                <i class="bi bi-gear-fill"></i>
                Account Settings
            </h1>
            <p id="userIdDisplay">Storage method: Server-side `accounts.json` update</p>
        </header>

        <div id="loadingIndicator">
            <i class="bi bi-arrow-clockwise"></i>
            <p>Loading your data...</p>
        </div>
        <div id="errorMessage">
            <p class="font-bold">Error:</p>
            <p id="errorText"></p>
        </div>
        
        <main id="settingsContent" class="hidden">
            <div class="grid">
                <div class="col-1">
                    <div class="card tabs-nav">
                        <button id="tab-profile" data-tab="profile" class="active">
                            <i class="bi bi-person-fill"></i> Profile & Name
                        </button>
                        <button id="tab-accounts" data-tab="accounts">
                            <i class="bi bi-bank"></i> Financial Accounts
                        </button>
                        <button id="tab-security" data-tab="security">
                            <i class="bi bi-shield-lock-fill"></i> Security (Mock)
                        </button>
                    </div>
                </div>

                <div class="col-2">
                    <div id="tab-content-profile" class="tab-content">
                        <div class="card">
                            <h2>Profile Information</h2>
                            <form id="profileForm">
                                <div>
                                    <label for="accountSelect">Select Account to Edit Name</label>
                                    <select id="accountSelect"></select>
                                    <p style="font-size:0.75rem; color:#6b7280;">Changing the selection updates the current name fields.</p>
                                </div>
                                <div>
                                    <label for="displayName">Display Name (Editable)</label>
                                    <input type="text" id="displayName" placeholder="Enter your display name">
                                    <p style="font-size:0.75rem; color:#6b7280;">This name updates the backend JSON data for the selected account.</p>
                                </div>
                                <div>
                                    <label for="fullNameJson">Official Account Name (From JSON)</label>
                                    <input type="text" id="fullNameJson" disabled>
                                    <p style="font-size:0.75rem; color:#b91c1c;">This is the official name linked to the bank.</p>
                                </div>
                                <button type="submit" id="saveButton"><i class="bi bi-save"></i> Save Name to JSON</button>
                                <p id="saveStatus"></p>
                            </form>
                        </div>
                    </div>

                    <div id="tab-content-accounts" class="tab-content hidden">
                        <div class="card">
                            <h2>Financial Accounts (from accounts.json)</h2>
                            <div id="accountsList"></div>
                        </div>
                    </div>

                    <div id="tab-content-security" class="tab-content hidden">
                        <div class="card">
                            <h2>Security & Privacy</h2>
                            <p style="color:#6b7280; margin-bottom:12px;">These settings are mock for demonstration purposes.</p>
                            <div style="display:flex; justify-content:space-between; align-items:center; padding:12px; background:#f9fafb; border-radius:8px; border:1px solid #d1d5db;">
                                <span>Two-Factor Authentication (2FA)</span>
                                <label class="toggle-switch">
                                    <input type="checkbox" checked>
                                    <span class="slider"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script type="module">
        // Your JavaScript code can remain mostly unchanged
        // Just ensure tab switching and fetching JSON still works
    </script>
</body>
</html>
