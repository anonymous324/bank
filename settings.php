<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Financial Settings</title>
    <!-- Tailwind CSS for modern, responsive styling -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Bootstrap Icons for quick utility icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <style>

    .card-hover:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 15px rgba(0,0,0,0.1);
      transition: 0.3s;
    }
    .tab-button.active {
      background-color: #0d6efd;
      color: white !important;
      font-weight: 600;
    }
    .status-badge {
      font-size: 0.75rem;
      font-weight: 500;
      padding: 0.25em 0.5em;
      border-radius: 0.5rem;
    }
    .overdraft {
      color: #dc3545;
    }
    .interest-rate {
      color: #198754;
    }
  </style>
</head>
<body>

  <div class="container py-4">
    <header class="mb-4">
      <h1 class="h3 text-primary d-flex align-items-center">
        <i class="bi bi-gear-fill me-2"></i> Account Settings
      </h1>
    </header>

    <div id="loadingIndicator" class="text-center py-5">
      <i class="bi bi-arrow-clockwise spinner-border text-primary" style="font-size: 3rem;"></i>
      <p class="mt-2 text-muted">Loading your data...</p>
    </div>

    <div id="errorMessage" class="alert alert-danger d-none" role="alert">
      <strong>Error:</strong> <span id="errorText"></span>
    </div>

    <div id="settingsContent" class="d-none">
      <div class="row">
        <!-- Sidebar Tabs -->
        <div class="col-lg-3 mb-4">
          <div class="card shadow-sm">
            <div class="list-group list-group-flush">
              <button class="list-group-item list-group-item-action tab-button active" data-tab="profile">
                <i class="bi bi-person-fill me-2"></i> Profile & Name
              </button>
              <button class="list-group-item list-group-item-action tab-button" data-tab="accounts">
                <i class="bi bi-bank me-2"></i> Financial Accounts
              </button>
              <button class="list-group-item list-group-item-action tab-button" data-tab="security">
                <i class="bi bi-shield-lock-fill me-2"></i> Security (Mock)
              </button>
            </div>
          </div>
        </div>

        <!-- Tab Content -->
        <div class="col-lg-9">
          <!-- Profile Tab -->
          <div id="tab-content-profile" class="tab-content">
            <div class="card card-hover shadow-sm mb-4">
              <div class="card-body">
                <h5 class="card-title text-primary border-bottom pb-2 mb-3">Profile Information</h5>
                <form id="profileForm">
                  <div class="mb-3">
                    <label for="accountSelect" class="form-label">Select Account to Edit Name</label>
                    <select id="accountSelect" class="form-select"></select>
                    <div class="form-text">Changing the selection updates the current name fields.</div>
                  </div>

                  <div class="mb-3">
                    <label for="displayName" class="form-label">Display Name (Editable)</label>
                    <input type="text" id="displayName" name="displayName" class="form-control" placeholder="Enter your display name">
                    <div class="form-text">This name updates the backend JSON data for the selected account.</div>
                  </div>

                  <div class="mb-3">
                    <label for="fullNameJson" class="form-label">Official Account Name (From JSON)</label>
                    <input type="text" id="fullNameJson" class="form-control" disabled>
                    <div class="form-text text-danger">This is the official name linked to the bank.</div>
                  </div>

                  <button type="submit" class="btn btn-success">
                    <i class="bi bi-save me-1"></i> Save Name to JSON
                  </button>
                  <p id="saveStatus" class="mt-2"></p>
                </form>
              </div>
            </div>
          </div>

          <!-- Accounts Tab -->
          <div id="tab-content-accounts" class="tab-content d-none">
            <div class="card card-hover shadow-sm mb-4">
              <div class="card-body">
                <h5 class="card-title text-primary border-bottom pb-2 mb-3">Financial Accounts (from accounts.json)</h5>
                <div id="accountsList" class="row g-3"></div>
              </div>
            </div>
          </div>

          <!-- Security Tab -->
          <div id="tab-content-security" class="tab-content d-none">
            <div class="card card-hover shadow-sm mb-4">
              <div class="card-body">
                <h5 class="card-title text-primary border-bottom pb-2 mb-3">Security & Privacy</h5>
                <p class="text-muted mb-3">These settings are mock for demonstration purposes.</p>
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" id="twoFA" checked>
                  <label class="form-check-label" for="twoFA">Two-Factor Authentication (2FA)</label>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>

  <script>
    // Tab switching
    document.querySelectorAll('.tab-button').forEach(btn => {
      btn.addEventListener('click', () => {
        document.querySelectorAll('.tab-button').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        document.querySelectorAll('.tab-content').forEach(tab => tab.classList.add('d-none'));
        document.getElementById('tab-content-' + btn.dataset.tab).classList.remove('d-none');
      });
    });

    // Fetch & render data (same as your previous logic)
    let accountsData = [];
    const loadingIndicator = document.getElementById('loadingIndicator');
    const settingsContent = document.getElementById('settingsContent');
    const errorMessage = document.getElementById('errorMessage');
    const errorText = document.getElementById('errorText');
    const accountSelect = document.getElementById('accountSelect');
    const displayNameInput = document.getElementById('displayName');
    const fullNameJsonInput = document.getElementById('fullNameJson');
    const accountsList = document.getElementById('accountsList');
    const saveStatus = document.getElementById('saveStatus');

    function displayError(message) {
      loadingIndicator.classList.add('d-none');
      settingsContent.classList.add('d-none');
      errorMessage.classList.remove('d-none');
      errorText.textContent = message;
      console.error(message);
    }

    function populateAccountSelect(accounts) {
      accountSelect.innerHTML = '';
      accounts.forEach((account, index) => {
        const option = document.createElement('option');
        option.value = account.account_id;
        const idSuffix = account.account_id.slice(-4);
        option.textContent = `${account.account_type} (***${idSuffix})`;
        if(index===0) option.selected=true;
        accountSelect.appendChild(option);
      });
      accountSelect.addEventListener('change', updateNameFieldsBasedOnSelection);
      updateNameFieldsBasedOnSelection();
    }

    function updateNameFieldsBasedOnSelection() {
      const selectedId = accountSelect.value;
      const selectedAccount = accountsData.find(a=>a.account_id===selectedId);
      if(selectedAccount){
        displayNameInput.value = selectedAccount.account_holder.full_name;
        fullNameJsonInput.value = selectedAccount.account_holder.full_name;
      } else {
        displayNameInput.value = 'N/A';
        fullNameJsonInput.value = 'N/A';
      }
    }

    function renderAccounts(accounts){
      accountsList.innerHTML='';
      accounts.forEach(account=>{
        const isSaving = account.account_type.toLowerCase().includes('saving');
        const currency = account.currency || 'EUR';
        const balanceFormatted = new Intl.NumberFormat('de-DE',{style:'currency',currency:currency}).format(account.balance);
        const ibanShort = account.iban ? account.iban.substring(0,4)+' **** **** '+account.iban.slice(-4) : 'N/A';
        let cardHTML = `
          <div class="col-md-6">
            <div class="card shadow-sm p-3 h-100 card-hover border-start border-4 ${isSaving?'border-success':'border-primary'}">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <h6 class="mb-0">${account.account_type}</h6>
                <span class="status-badge ${isSaving?'bg-success text-white':'bg-primary text-white'}">${account.status.toUpperCase()}</span>
              </div>
              <ul class="list-unstyled mb-0">
                <li class="d-flex justify-content-between border-bottom py-1">
                  <span>Current Balance:</span>
                  <span class="fw-bold">${balanceFormatted}</span>
                </li>
                <li class="d-flex justify-content-between border-bottom py-1">
                  <span>IBAN:</span>
                  <span class="text-monospace">${ibanShort}</span>
                </li>
                ${!isSaving && account.overdraft_used>0?`
                  <li class="d-flex justify-content-between py-1 overdraft">
                    <span>Overdraft Used:</span>
                    <span>${new Intl.NumberFormat('de-DE',{style:'currency',currency:currency}).format(account.overdraft_used)}</span>
                  </li>
                `:''}
                ${isSaving && account.interest_rate?`
                  <li class="d-flex justify-content-between py-1 interest-rate">
                    <span>Interest Rate:</span>
                    <span>${account.interest_rate}%</span>
                  </li>
                `:''}
              </ul>
            </div>
          </div>
        `;
        accountsList.insertAdjacentHTML('beforeend', cardHTML);
      });
    }

    async function fetchAndDisplayData(){
      try{
        const response = await fetch('data/accounts.json?v=' + Date.now());
        if(!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
        const data = await response.json();
        accountsData = data.accounts;
        populateAccountSelect(accountsData);
        renderAccounts(accountsData);
        loadingIndicator.classList.add('d-none');
        settingsContent.classList.remove('d-none');
      }catch(e){
        displayError("Failed to load data: "+e.message);
      }
    }

    fetchAndDisplayData();
  </script>
</body>
</html>