<?php
// GoodXchanger.online - Cryptocurrency Exchange Platform
session_start();

// Language handling
$lang = $_GET['lang'] ?? $_SESSION['lang'] ?? 'en';
$_SESSION['lang'] = $lang;

// Language translations
$translations = [
    'en' => [
        'title' => 'GoodXchanger.online - Reliable Cryptocurrency Exchange',
        'tagline' => 'Reliable cryptocurrency exchange',
        'start_exchange' => 'Start an exchange',
        'you_send' => 'You send',
        'you_get' => 'You get',
        'discount' => 'Discount',
        'at_rate' => 'At the rate',
        'reserve' => 'Reserve',
        'exchange' => 'Exchange',
        'agree_rules' => 'I agree with the rules of the exchange. With politics AML/KYC agree.',
        'agree_newsletter' => 'I agree to receive newsletters about news and promotions',
        'maximum_safety' => 'Maximum safety',
        'multilevel_protection' => 'Multilevel server side system protections',
        'payments_checked' => 'All payments checked',
        'payments_security' => 'All payments checked by operators for security',
        'quality_control' => 'Quality control',
        'quality_system' => 'Control system processing quality applications'
    ],
    'ru' => [
        'title' => 'GoodXchanger.online - Надежный обменник криптовалют',
        'tagline' => 'Надежный обменник криптовалют',
        'start_exchange' => 'Начать обмен',
        'you_send' => 'Вы отправляете',
        'you_get' => 'Вы получаете',
        'discount' => 'Скидка',
        'at_rate' => 'По курсу',
        'reserve' => 'Резерв',
        'exchange' => 'Обменять',
        'agree_rules' => 'Я согласен с правилами обмена. С политикой AML/KYC согласен.',
        'agree_newsletter' => 'Я согласен получать рассылки о новостях и акциях',
        'maximum_safety' => 'Максимальная безопасность',
        'multilevel_protection' => 'Многоуровневая система защиты сервера',
        'payments_checked' => 'Все платежи проверены',
        'payments_security' => 'Все платежи проверены операторами на безопасность',
        'quality_control' => 'Контроль качества',
        'quality_system' => 'Система контроля качества обработки заявок'
    ]
];

$t = $translations[$lang];
$page_title = $t['title'];
$current_page = "home";

// Include configuration
require_once 'config.php';

// Sample exchange rates (in real app, these would come from API)
$exchange_rates = [
    'BTC' => ['USDT' => 104627.47, 'ETH' => 15.2, 'LTC' => 1250.5],
    'ETH' => ['BTC' => 0.065, 'USDT' => 3450.2, 'LTC' => 82.1],
    'USDT' => ['BTC' => 0.0000096, 'ETH' => 0.00029, 'LTC' => 0.012],
    'LTC' => ['BTC' => 0.0008, 'ETH' => 0.012, 'USDT' => 83.2]
];

// Process exchange calculation
$from_currency = $_POST['from_currency'] ?? 'BTC';
$to_currency = $_POST['to_currency'] ?? 'USDT';
$amount = floatval($_POST['amount'] ?? 1);
$calculated_amount = 0;

if (isset($exchange_rates[$from_currency][$to_currency])) {
    $calculated_amount = $amount * $exchange_rates[$from_currency][$to_currency];
}
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
                    <img src="img/logo.png" alt="GoodXchanger.online" class="logo-image">
                    <span class="tagline"><?php echo $t['tagline']; ?></span>
                </div>
                
                <div class="header-actions">
                    <div class="language-selector">
                        <i class="fas fa-globe"></i>
                        <select onchange="changeLanguage(this.value)">
                            <option value="en" <?php echo $lang == 'en' ? 'selected' : ''; ?>>English</option>
                            <option value="ru" <?php echo $lang == 'ru' ? 'selected' : ''; ?>>Русский</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        <div class="container">
            <!-- Exchange Interface -->
            <section class="exchange-section">
                <div class="exchange-container">
                    <h2 class="exchange-title"><?php echo $t['start_exchange']; ?></h2>
                    
                    <form class="exchange-form" method="POST" action="">
                        <div class="exchange-row">
                            <!-- You Send -->
                            <div class="exchange-column">
                                <label class="exchange-label"><?php echo $t['you_send']; ?></label>
                                <div class="currency-selector">
                                    <div class="currency-input-group">
                                        <select name="from_currency" class="currency-select" onchange="updateExchange()">
                                            <option value="BTC" <?php echo $from_currency == 'BTC' ? 'selected' : ''; ?>>Bitcoin</option>
                                            <option value="ETH" <?php echo $from_currency == 'ETH' ? 'selected' : ''; ?>>Ethereum</option>
                                            <option value="USDT" <?php echo $from_currency == 'USDT' ? 'selected' : ''; ?>>USDT TRC20</option>
                                            <option value="LTC" <?php echo $from_currency == 'LTC' ? 'selected' : ''; ?>>Litecoin</option>
                                            <option value="DOGE" <?php echo $from_currency == 'DOGE' ? 'selected' : ''; ?>>Dogecoin</option>
                                            <option value="XRP" <?php echo $from_currency == 'XRP' ? 'selected' : ''; ?>>Ripple</option>
                                        </select>
                                        <input type="number" name="amount" class="amount-input" value="<?php echo $amount; ?>" 
                                               placeholder="0.00" step="0.00000001" onchange="updateExchange()">
                                    </div>
                                </div>
                                
                                <div class="payment-methods">
                                    <h4>Crypto Banks EPS Cash</h4>
                                    <div class="method-tags">
                                        <span class="method-tag">Bitcoin</span>
                                        <span class="method-tag">Ethereum</span>
                                        <span class="method-tag">USDT TRC20</span>
                                        <span class="method-tag">Litecoin</span>
                                        <span class="method-tag">Dogecoin</span>
                                        <span class="method-tag">Ripple</span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Exchange Arrow -->
                            <div class="exchange-arrow">
                                <i class="fas fa-exchange-alt"></i>
                            </div>
                            
                            <!-- You Get -->
                            <div class="exchange-column">
                                <label class="exchange-label"><?php echo $t['you_get']; ?></label>
                                <div class="currency-selector">
                                    <div class="currency-input-group">
                                        <select name="to_currency" class="currency-select" onchange="updateExchange()">
                                            <option value="USDT" <?php echo $to_currency == 'USDT' ? 'selected' : ''; ?>>USDT TRC20</option>
                                            <option value="BTC" <?php echo $to_currency == 'BTC' ? 'selected' : ''; ?>>Bitcoin</option>
                                            <option value="ETH" <?php echo $to_currency == 'ETH' ? 'selected' : ''; ?>>Ethereum</option>
                                            <option value="LTC" <?php echo $to_currency == 'LTC' ? 'selected' : ''; ?>>Litecoin</option>
                                            <option value="DOGE" <?php echo $to_currency == 'DOGE' ? 'selected' : ''; ?>>Dogecoin</option>
                                            <option value="XRP" <?php echo $to_currency == 'XRP' ? 'selected' : ''; ?>>Ripple</option>
                                        </select>
                                        <input type="text" class="amount-input" value="<?php echo number_format($calculated_amount, 8); ?>" readonly>
                                    </div>
                                </div>
                                
                                <div class="exchange-info">
                                    <div class="discount-info">
                                        <span class="discount-label"><?php echo $t['discount']; ?>: 0%</span>
                                    </div>
                                    <div class="rate-info">
                                        <span class="rate-label"><?php echo $t['at_rate']; ?>: 1 <?php echo $from_currency; ?> - <?php echo number_format($exchange_rates[$from_currency][$to_currency] ?? 0, 6); ?> <?php echo $to_currency; ?></span>
                                    </div>
                                    <div class="reserve-info">
                                        <span class="reserve-label"><?php echo $t['reserve']; ?>: <?php echo $to_currency; ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="exchange-actions">
                            <div class="agreement-section">
                                <label class="checkbox-label">
                                    <input type="checkbox" required>
                                    <span class="checkmark"></span>
                                    <?php echo $t['agree_rules']; ?>
                                </label>
                                <label class="checkbox-label">
                                    <input type="checkbox">
                                    <span class="checkmark"></span>
                                    <?php echo $t['agree_newsletter']; ?>
                                </label>
                            </div>
                            
                            <button type="submit" class="btn-exchange">
                                <img src="img/tg.png" alt="Telegram" class="telegram-icon">
                                <?php echo $t['exchange']; ?>
                            </button>
                        </div>
                    </form>
                </div>
            </section>
            
            <!-- Features Section -->
            <section class="features-section">
                <div class="features-grid">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h3><?php echo $t['maximum_safety']; ?></h3>
                        <p><?php echo $t['multilevel_protection']; ?></p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-user-shield"></i>
                        </div>
                        <h3><?php echo $t['payments_checked']; ?></h3>
                        <p><?php echo $t['payments_security']; ?></p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-cogs"></i>
                        </div>
                        <h3><?php echo $t['quality_control']; ?></h3>
                        <p><?php echo $t['quality_system']; ?></p>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-info">
                    <p>&copy; <?php echo date('Y'); ?> GoodXchanger.online. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <script>
        function updateExchange() {
            // In a real app, this would make an AJAX call to get live rates
            document.querySelector('.exchange-form').submit();
        }
        
        function changeLanguage(lang) {
            window.location.href = '?lang=' + lang;
        }
    </script>
</body>
</html>