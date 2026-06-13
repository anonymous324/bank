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

    <div id="body">

        <!-- JS Alert -->
        <?php if (isset($_GET['msg'])): ?>
            <script>
                alert("<?php echo addslashes($_GET['msg']); ?>");
                if (window.history.replaceState) {
                    const cleanURL = window.location.protocol + "//" + window.location.host + window.location.pathname;
                    window.history.replaceState({}, document.title, cleanURL);
                }
            </script>
        <?php endif; ?>

        <form action="transaction.php" method="POST">
            <input type="hidden" name="redirect" value="1">

            <!-- Account Dropdown -->
            <div class="form-item">
                <label class="form-label fw-bold">Select Account</label>
                <select name="account_id" required>
                    <option value="">-- Select Account --</option>
                    <?php foreach ($accounts as $acc): ?>
                        <option value="<?php echo $acc['account_id']; ?>">
                            <?php echo $acc['account_id'] . " — " . $acc['account_holder']['full_name']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Credit/Debit -->
            <div class="form-item">
                <label class="form-label fw-bold">Transaction Type</label>
                <select name="type" required>
                    <option value="credit">Credit</option>
                    <option value="debit">Debit</option>
                </select>
            </div>

            <!-- Amount -->
            <div class="form-item">
                <input type="number" name="amount" placeholder="Amount" required min="0.01" step="any">
            </div>

            <!-- Description -->
            <div class="form-item">
                <input type="text" name="description" placeholder="Description (Optional)">
            </div>

            <!-- Time Mode -->
            <div class="form-item">
                <label class="form-label fw-bold">Transaction Time</label>
                <select name="time_mode" id="time_mode" onchange="toggleTimeField()">
                    <option value="auto">Auto Time (Now)</option>
                    <option value="manual">Manual Time</option>
                </select>
            </div>

            <input type="hidden" name="auto_time" value="<?php echo $currentTime; ?>">

            <div class="form-item" id="manual_time_box" style="display:none;">
                <input type="datetime-local" name="manual_time">
            </div>

            <button type="submit">Submit Transaction</button>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function toggleTimeField() {
            document.getElementById("manual_time_box").style.display =
                document.getElementById("time_mode").value === "manual" ? "block" : "none";
        }
    </script>

</body>
</html>
