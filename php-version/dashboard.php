<?php
// GoodXchanger.online - User Dashboard
$page_title = "Dashboard - GoodXchanger.online";
$current_page = "dashboard";

// Include configuration
require_once 'config.php';

// Sample user data (in real app, this would come from database)
$user_balance = [
    'BTC' => 0.025,
    'ETH' => 1.5,
    'USDT' => 2500.00,
    'LTC' => 5.2
];

$recent_transactions = [
    ['id' => 'TX001', 'from' => 'BTC', 'to' => 'USDT', 'amount' => 0.01, 'rate' => 104627.47, 'status' => 'completed', 'date' => '2024-01-15 14:30'],
    ['id' => 'TX002', 'from' => 'ETH', 'to' => 'BTC', 'amount' => 0.5, 'rate' => 0.065, 'status' => 'processing', 'date' => '2024-01-15 12:15'],
    ['id' => 'TX003', 'from' => 'USDT', 'to' => 'LTC', 'amount' => 100, 'rate' => 0.012, 'status' => 'completed', 'date' => '2024-01-14 18:45']
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <link rel="stylesheet" href="exchange-styles.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="container">
            <div class="header-content">
                <div class="logo">
                    <h1>GoodXchanger.online</h1>
                    <span class="tagline">Reliable cryptocurrency exchange</span>
                </div>
                
                <nav class="main-nav">
                    <ul>
                        <li><a href="index.php" class="nav-link">Exchange</a></li>
                        <li><a href="dashboard.php" class="nav-link active">Dashboard</a></li>
                        <li><a href="#" class="nav-link">Wallet</a></li>
                        <li><a href="#" class="nav-link">History</a></li>
                        <li><a href="#" class="nav-link">Support</a></li>
                    </ul>
                </nav>
                
                <div class="header-actions">
                    <div class="user-info">
                        <i class="fas fa-user-circle"></i>
                        <span>Welcome, User</span>
                    </div>
                    <button class="btn-auth" onclick="logout()">Logout</button>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        <div class="container">
            <!-- Dashboard Header -->
            <section class="dashboard-header">
                <h2>Dashboard</h2>
                <p>Manage your cryptocurrency portfolio and exchange activities</p>
            </section>
            
            <!-- Balance Cards -->
            <section class="balance-section">
                <h3>Your Balances</h3>
                <div class="balance-grid">
                    <?php foreach ($user_balance as $currency => $amount): ?>
                    <div class="balance-card">
                        <div class="balance-icon">
                            <i class="fas fa-coins"></i>
                        </div>
                        <div class="balance-info">
                            <h4><?php echo $currency; ?></h4>
                            <p class="balance-amount"><?php echo number_format($amount, 8); ?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </section>
            
            <!-- Quick Exchange -->
            <section class="quick-exchange-section">
                <div class="exchange-container">
                    <h3>Quick Exchange</h3>
                    <form class="quick-exchange-form">
                        <div class="quick-exchange-row">
                            <div class="exchange-column">
                                <label>From</label>
                                <select class="currency-select">
                                    <option value="BTC">Bitcoin</option>
                                    <option value="ETH">Ethereum</option>
                                    <option value="USDT">USDT</option>
                                    <option value="LTC">Litecoin</option>
                                </select>
                                <input type="number" class="amount-input" placeholder="0.00" step="0.00000001">
                            </div>
                            
                            <div class="exchange-arrow">
                                <i class="fas fa-exchange-alt"></i>
                            </div>
                            
                            <div class="exchange-column">
                                <label>To</label>
                                <select class="currency-select">
                                    <option value="USDT">USDT</option>
                                    <option value="BTC">Bitcoin</option>
                                    <option value="ETH">Ethereum</option>
                                    <option value="LTC">Litecoin</option>
                                </select>
                                <input type="text" class="amount-input" placeholder="0.00" readonly>
                            </div>
                        </div>
                        <button type="submit" class="btn-exchange">Quick Exchange</button>
                    </form>
                </div>
            </section>
            
            <!-- Recent Transactions -->
            <section class="transactions-section">
                <h3>Recent Transactions</h3>
                <div class="transactions-table">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Amount</th>
                                <th>Rate</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recent_transactions as $tx): ?>
                            <tr>
                                <td><?php echo $tx['id']; ?></td>
                                <td><?php echo $tx['from']; ?></td>
                                <td><?php echo $tx['to']; ?></td>
                                <td><?php echo number_format($tx['amount'], 8); ?></td>
                                <td><?php echo number_format($tx['rate'], 6); ?></td>
                                <td>
                                    <span class="status-badge status-<?php echo $tx['status']; ?>">
                                        <?php echo ucfirst($tx['status']); ?>
                                    </span>
                                </td>
                                <td><?php echo $tx['date']; ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </section>
            
            <!-- Statistics -->
            <section class="stats-section">
                <h3>Exchange Statistics</h3>
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-exchange-alt"></i>
                        </div>
                        <div class="stat-info">
                            <h4>Total Exchanges</h4>
                            <p class="stat-number">47</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <div class="stat-info">
                            <h4>Volume Traded</h4>
                            <p class="stat-number">$12,450</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-percentage"></i>
                        </div>
                        <div class="stat-info">
                            <h4>Average Rate</h4>
                            <p class="stat-number">0.5%</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="stat-info">
                            <h4>Avg. Processing</h4>
                            <p class="stat-number">2.5 min</p>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-links">
                    <a href="#">Exchange rules</a>
                    <a href="#">For partners</a>
                    <a href="#">Reserves</a>
                    <a href="#">Guarantees</a>
                    <a href="#">Reviews</a>
                    <a href="#">Contacts</a>
                    <a href="#">Sitemap</a>
                    <a href="#">AML</a>
                </div>
                <div class="footer-info">
                    <p>&copy; <?php echo date('Y'); ?> GoodXchanger.online. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <script>
        function logout() {
            if (confirm('Are you sure you want to logout?')) {
                window.location.href = 'index.php';
            }
        }
        
        // Add active class to current nav link
        document.querySelectorAll('.nav-link').forEach(link => {
            if (link.textContent === 'Dashboard') {
                link.classList.add('active');
            }
        });
    </script>

    <style>
        /* Dashboard Specific Styles */
        .dashboard-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .dashboard-header h2 {
            font-size: 2.5rem;
            color: #00d4ff;
            margin-bottom: 0.5rem;
        }
        
        .balance-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .balance-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            transition: all 0.3s ease;
        }
        
        .balance-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
        }
        
        .balance-icon {
            font-size: 2.5rem;
            color: #00d4ff;
        }
        
        .balance-info h4 {
            font-size: 1.2rem;
            margin-bottom: 0.5rem;
            color: #fff;
        }
        
        .balance-amount {
            font-size: 1.5rem;
            font-weight: 600;
            color: #00ff88;
        }
        
        .quick-exchange-section {
            margin: 2rem 0;
        }
        
        .quick-exchange-form {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 1.5rem;
        }
        
        .quick-exchange-row {
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            gap: 1rem;
            align-items: end;
            margin-bottom: 1rem;
        }
        
        .transactions-table {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            overflow: hidden;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        th, td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        th {
            background: rgba(0, 0, 0, 0.3);
            color: #00d4ff;
            font-weight: 600;
        }
        
        .status-badge {
            padding: 0.3rem 0.8rem;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .status-completed {
            background: rgba(0, 255, 136, 0.2);
            color: #00ff88;
            border: 1px solid rgba(0, 255, 136, 0.3);
        }
        
        .status-processing {
            background: rgba(255, 193, 7, 0.2);
            color: #ffc107;
            border: 1px solid rgba(255, 193, 7, 0.3);
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-top: 1rem;
        }
        
        .stat-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 1.5rem;
            text-align: center;
            transition: all 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
        }
        
        .stat-icon {
            font-size: 2.5rem;
            color: #00d4ff;
            margin-bottom: 1rem;
        }
        
        .stat-info h4 {
            color: #888;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }
        
        .stat-number {
            font-size: 1.8rem;
            font-weight: 600;
            color: #00ff88;
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #888;
        }
        
        .user-info i {
            font-size: 1.5rem;
            color: #00d4ff;
        }
        
        .nav-link.active {
            background: rgba(0, 212, 255, 0.2);
            color: #00d4ff;
        }
        
        @media (max-width: 768px) {
            .quick-exchange-row {
                grid-template-columns: 1fr;
                gap: 1rem;
            }
            
            .exchange-arrow {
                transform: rotate(90deg);
                margin: 0.5rem 0;
            }
            
            .balance-grid {
                grid-template-columns: 1fr;
            }
            
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            table {
                font-size: 0.9rem;
            }
            
            th, td {
                padding: 0.5rem;
            }
        }
    </style>
</body>
</html>
