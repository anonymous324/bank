<?php
// Load accounts.json file
$accountsData = json_decode(file_get_contents("data/accounts.json"), true);
$accounts = $accountsData["accounts"];  

// Auto current time
date_default_timezone_set("Asia/Kolkata");
$currentTime = date("Y-m-d H:i:s");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Form</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        :root {
            --primary-color: #4CAF50;
            --secondary-color: #263238;
            --background-color: #f4f7f6;
            --card-background: #ffffff;
            --border-color: #e0e0e0;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--background-color);
            margin: 0;
            padding: 0;
        }

        /* Navbar Styling */
        .custom-navbar {
            background-color: white;
            border-bottom: 1px solid #e5e5e5;
        }

        .logo-text {
            font-size: 1.25rem;
            font-weight: 700;
            color: #003057;
        }

        .navbar-nav .nav-link {
            color: #003057;
        }

        .navbar-nav .nav-link:hover,
        .navbar-nav .active-link {
            color: #0076a8;
        }



        /* Form Styling */
        #body {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 20px;
            min-height: calc(100vh - 70px);
        }

        form {
            background: var(--card-background);
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        input[type="text"],
        input[type="number"],
        input[type="datetime-local"],
        select {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 16px;
            color: var(--secondary-color);
        }

        select {
            appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' fill='%234CAF50'%3E%3Cpath d='M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 15px center;
            background-size: 16px;
            padding-right: 40px;
        }

        button[type="submit"] {
            background-color: var(--primary-color);
            color: white;
            padding: 15px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 18px;
            font-weight: 600;
        }

        button[type="submit"]:hover {
            background-color: #43A047;
        }
        @media (max-width: 992px) {
  .main-content-padding {
    padding-left: 1rem !important;
    padding-right: 1rem !important;
  }

  .custom-nav-icons {
    /* REQUIRED: Overrides 'display: none' from the complete stylesheet
       to ensure the icons are visible on mobile */
    display: flex !important;
    
    /* Make the items stack vertically (in a column) */
    flex-direction: column !important; 
    
    /* Align links to the left edge of the mobile menu */
    align-items: flex-start !important; 
    
    /* Ensure the container takes up the full width */
    width: 100%;
    
    /* Add vertical padding and a separator line */
    padding: 0.5rem 0; 
    border-top: 1px solid var(--db-border-color); 
    margin-top: 0.5rem;
  }

  /* Style adjustment for the individual links/profile text */
  .custom-nav-icons a.nav-link,
  .custom-nav-icons span.profile-icon {
    margin: 0 !important; /* Remove all margins to prevent horizontal conflicts */
    margin-bottom: 0.25rem !important; /* Add small margin for vertical spacing */
    padding-left: 0 !important; /* Align to the left edge */
  }

  .navbar-collapse {
    margin-top: 0;
    border-top: none; 
  }
}
    </style>
</head>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light custom-navbar sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand logo-text" href="#">
                <i class="bi bi-bank me-2"></i>Bank Name
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="financial-overview.html">My Finances</a></li>
                    <li class="nav-item"><a class="nav-link" href="payment-overview.html">Transfer</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Invest</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Products</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Services</a></li>
                </ul>
                <div class="d-flex align-items-center custom-nav-icons">
                    <a class="nav-link me-3" href="#"><i class="bi bi-chat-dots"></i> Messages</a>
                    <a class="nav-link me-3" href="#"><i class="bi bi-question-circle"></i> Help</a>
                    <span class="profile-icon me-3"><a href="#">M. Mustermann</a></span>
                    <a class="nav-link" href="#"><i class="bi bi-box-arrow-right"></i> Logout</a>
                </div>
            </div>
        </div>
    </nav>


<div class="bg-gray-50 min-h-screen font-sans">
        <div id="app" class="container mx-auto p-4 md:p-8">
        <header class="mb-8">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-800 flex items-center">
                <i class="bi bi-gear-fill text-primary mr-3"></i>
                Account Settings
            </h1>
            <p id="userIdDisplay" class="text-sm text-gray-500 mt-1">Storage method: Simulated `accounts.json` Update</p>
        </header>

        <div id="loadingIndicator" class="text-center p-8">
            <i class="bi bi-arrow-clockwise animate-spin text-4xl text-primary"></i>
            <p class="mt-2 text-gray-600">Loading your data...</p>
        </div>
        <div id="errorMessage" class="hidden bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg" role="alert">
            <p class="font-bold">Error:</p>
            <p id="errorText"></p>
        </div>
        
        <main id="settingsContent" class="hidden">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl shadow-lg p-4">
                        <nav class="space-y-2">
                            <button id="tab-profile" data-tab="profile" class="w-full text-left p-3 rounded-lg text-white bg-primary font-semibold hover:bg-blue-800 transition duration-150">
                                <i class="bi bi-person-fill mr-2"></i> Profile & Name
                            </button>
                            <button id="tab-accounts" data-tab="accounts" class="w-full text-left p-3 rounded-lg text-gray-700 hover:bg-gray-100 transition duration-150">
                                <i class="bi bi-bank mr-2"></i> Financial Accounts
                            </button>
                            <button id="tab-security" data-tab="security" class="w-full text-left p-3 rounded-lg text-gray-700 hover:bg-gray-100 transition duration-150">
                                <i class="bi bi-shield-lock-fill mr-2"></i> Security (Mock)
                            </button>
                        </nav>
                    </div>
                </div>

                <div class="lg:col-span-2">
                    <div id="tab-content-profile" class="tab-content">
                        <div class="bg-white card rounded-xl shadow-lg p-6">
                            <h2 class="text-2xl font-semibold mb-4 border-b pb-2 text-primary">Profile Information</h2>
                            <form id="profileForm" class="space-y-4">
                                <div>
                                    <label for="displayName" class="block text-sm font-medium text-gray-700 mb-1">Display Name (Editable)</label>
                                    <input type="text" id="displayName" name="displayName" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary transition duration-150" placeholder="Enter your display name">
                                    <p class="text-xs text-gray-500 mt-1">This name updates the simulated JSON data.</p>
                                </div>

                                <div>
                                    <label for="fullNameJson" class="block text-sm font-medium text-gray-700 mb-1">Official Account Name (Simulated JSON Source)</label>
                                    <input type="text" id="fullNameJson" class="w-full p-3 border border-gray-200 bg-gray-100 rounded-lg" disabled>
                                    <p class="text-xs text-red-500 mt-1">This is your legal name linked to the bank.</p>
                                </div>

                                <button type="submit" id="saveButton" class="w-full md:w-auto px-6 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition duration-150 shadow-md">
                                    <i class="bi bi-save mr-2"></i> Simulate JSON Update
                                </button>
                                <p id="saveStatus" class="text-sm mt-2"></p>
                            </form>
                        </div>
                    </div>

                    <div id="tab-content-accounts" class="tab-content hidden">
                        <div class="bg-white card rounded-xl shadow-lg p-6">
                            <h2 class="text-2xl font-semibold mb-4 border-b pb-2 text-primary">Financial Accounts (from accounts.json)</h2>
                            <div id="accountsList" class="space-y-4">
                                </div>
                        </div>
                    </div>

                    <div id="tab-content-security" class="tab-content hidden">
                        <div class="bg-white card rounded-xl shadow-lg p-6">
                            <h2 class="text-2xl font-semibold mb-4 border-b pb-2 text-primary">Security & Privacy</h2>
                            <p class="text-gray-500 mb-4">These settings are mock for demonstration purposes.</p>
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border">
                                <span class="font-medium text-gray-700">Two-Factor Authentication (2FA)</span>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" value="" class="sr-only peer" checked>
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    </div>



    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script type="module">
        // Global variable to hold the current official name, simulating the data source
        let currentOfficialName = "Erika Mustermann"; 

        // UI Elements
        const loadingIndicator = document.getElementById('loadingIndicator');
        const settingsContent = document.getElementById('settingsContent');
        const errorMessage = document.getElementById('errorMessage');
        const errorText = document.getElementById('errorText');
        const displayNameInput = document.getElementById('displayName');
        const fullNameJsonInput = document.getElementById('fullNameJson');
        const profileForm = document.getElementById('profileForm');
        const saveStatus = document.getElementById('saveStatus');
        const accountsList = document.getElementById('accountsList');

        /**
         * Utility function to display errors
         */
        function displayError(message) {
            loadingIndicator.classList.add('hidden');
            settingsContent.classList.add('hidden');
            errorMessage.classList.remove('hidden');
            errorText.textContent = message;
            console.error(message);
        }

        /**
         * 1. Fetch financial data and initialize fields using the global currentOfficialName
         */
        async function fetchAndDisplayData() {
            try {
                // Fetch JSON data (only to load accounts list, not for the name)
                const response = await fetch('data/accounts.json?v=' + Date.now()); 
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                const data = await response.json();
                
                // Initialize both fields with the name from the global variable (simulated JSON source)
                displayNameInput.value = currentOfficialName;
                fullNameJsonInput.value = currentOfficialName;
                
                // Display accounts data
                renderAccounts(data.accounts);

                // Hide loading spinner and show content
                loadingIndicator.classList.add('hidden');
                settingsContent.classList.remove('hidden');

            } catch (e) {
                // Modified error message since Local Storage is removed
                displayError("Failed to load data (accounts.json or initialization error): " + e.message);
            }
        }

        /**
         * 2. Save the Display Name by simulating an update to the JSON data
         */
        profileForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const newName = displayNameInput.value.trim();
            if (!newName) {
                showMessage("Please enter a name.", 'text-red-500');
                return;
            }

            showMessage("Simulating update to accounts.json data...", 'text-yellow-600');
            
            // --- SIMULATED ASYNC OPERATION ---
            await new Promise(resolve => setTimeout(resolve, 500)); 
            
            try {
                // 1. Update the in-memory global variable (Simulating JSON update)
                currentOfficialName = newName;

                // 2. Update the visual content of both fields
                fullNameJsonInput.value = newName; 
                displayNameInput.value = newName; 

                showMessage("Name updated successfully in simulated data source!", 'text-green-600');
            } catch (error) {
                // This catch block is mostly theoretical in this client-side simulation
                showMessage("Error during simulated update: " + error.message, 'text-red-600');
                console.error("Error during simulated update: ", error);
            }
        });

        function showMessage(message, className) {
            saveStatus.textContent = message;
            saveStatus.className = `text-sm mt-2 ${className}`;
            setTimeout(() => {
                saveStatus.textContent = '';
                saveStatus.className = 'text-sm mt-2';
            }, 5000);
        }

        /**
         * 3. Render Financial Accounts (Unchanged)
         */
        function renderAccounts(accounts) {
            accountsList.innerHTML = ''; // Clear previous content
            accounts.forEach(account => {
                const isSaving = account.account_type.toLowerCase().includes('saving');
                const accentColor = isSaving ? 'green' : 'blue';
                const currency = account.currency || 'EUR';
                
                const balanceFormatted = new Intl.NumberFormat('de-DE', { 
                    style: 'currency', 
                    currency: currency 
                }).format(account.balance);
                
                const ibanShort = account.iban ? account.iban.substring(0, 4) + ' **** **** ' + account.iban.slice(-4) : 'N/A';
                
                let detailItems = `
                    <li class="flex justify-between py-2 border-b">
                        <span class="text-gray-500">Account Type:</span>
                        <span class="font-medium text-${accentColor}-700">${account.account_type}</span>
                    </li>
                    <li class="flex justify-between py-2 border-b">
                        <span class="text-gray-500">Current Balance:</span>
                        <span class="font-bold text-lg">${balanceFormatted}</span>
                    </li>
                    <li class="flex justify-between py-2 border-b">
                        <span class="text-gray-500">IBAN:</span>
                        <span class="font-mono text-sm">${ibanShort}</span>
                    </li>
                `;

                if (!isSaving) {
                    const overdraftUsedFormatted = new Intl.NumberFormat('de-DE', { 
                        style: 'currency', 
                        currency: currency 
                    }).format(account.overdraft_used || 0);
                    detailItems += `
                        <li class="flex justify-between py-2 ${account.overdraft_used > 0 ? 'text-red-600' : 'text-gray-700'}">
                            <span class="text-gray-500">Overdraft Used:</span>
                            <span class="font-medium">${overdraftUsedFormatted}</span>
                        </li>
                    `;
                } else if (account.interest_rate) {
                    detailItems += `
                        <li class="flex justify-between py-2">
                            <span class="text-gray-500">Interest Rate:</span>
                            <span class="font-medium">${account.interest_rate}%</span>
                        </li>
                    `;
                }

                const accountCard = `
                    <div class="bg-${accentColor}-50 border-l-4 border-${accentColor}-500 rounded-lg p-4 shadow-sm">
                        <h3 class="text-xl font-semibold mb-2 text-${accentColor}-800 flex justify-between items-center">
                            ${account.account_type} 
                            <span class="text-sm font-normal bg-${accentColor}-200 text-${accentColor}-800 px-3 py-1 rounded-full">${account.status.toUpperCase()}</span>
                        </h3>
                        <ul class="divide-y divide-gray-200">
                            ${detailItems}
                        </ul>
                    </div>
                `;
                accountsList.insertAdjacentHTML('beforeend', accountCard);
            });
        }

        /**
         * 4. Tab switching logic (Unchanged)
         */
        document.querySelectorAll('[data-tab]').forEach(button => {
            button.addEventListener('click', () => {
                const targetTab = button.getAttribute('data-tab');

                // Update button styles
                document.querySelectorAll('[data-tab]').forEach(btn => {
                    btn.classList.remove('bg-primary', 'text-white', 'font-semibold');
                    btn.classList.add('text-gray-700', 'hover:bg-gray-100');
                });
                button.classList.add('bg-primary', 'text-white', 'font-semibold');
                button.classList.remove('text-gray-700', 'hover:bg-gray-100');

                // Update content visibility
                document.querySelectorAll('.tab-content').forEach(content => {
                    content.classList.add('hidden');
                });
                document.getElementById('tab-content-' + targetTab).classList.remove('hidden');
            });
        });

        // Start the application
        fetchAndDisplayData();
    </script>


</body>
</html>
