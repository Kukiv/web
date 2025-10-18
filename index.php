<?php
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>GoodXchanger</title>
    <link rel="icon" type="image/png" href="logo.png">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <nav class="navbar">
        <div class="navbar-content">
            <img src="logo.png" alt="Логотип" class="logo">
            <div class="navbar-right">
                <button class="help-btn" onclick="openHelpModal()" id="help-btn">Помощь</button>
                <button class="review-btn" onclick="openReviewModal()" id="review-btn">Оставить отзыв</button>
                <div class="language-switcher">
                    <button class="lang-btn active" onclick="switchLanguage('ru')" id="lang-ru">RU</button>
                    <button class="lang-btn" onclick="switchLanguage('en')" id="lang-en">EN</button>
                </div>
            </div>
        </div>
    </nav>

    <div id="reviewModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeReviewModal()">&times;</span>
            <h2 class="modal-title" id="modal-title">Оставить отзыв</h2>
            <form id="reviewForm" onsubmit="submitReview(event)">
                <div class="form-group">
                    <label class="form-label" id="name-label">Имя:</label>
                    <input type="text" class="form-input" id="reviewName" required>
                </div>
                <div class="form-group">
                    <label class="form-label" id="telegram-label">Telegram:</label>
                    <input type="text" class="form-input" id="reviewTelegram" placeholder="@username">
                </div>
                <div class="form-group">
                    <label class="form-label" id="review-label">Отзыв:</label>
                    <textarea class="form-textarea" id="reviewText" required></textarea>
                </div>
                <button type="submit" class="submit-btn" id="submit-btn">Отправить отзыв</button>
            </form>
        </div>
    </div>

    <div id="helpModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeHelpModal()">&times;</span>
            <h2 class="modal-title" id="help-modal-title">Помощь</h2>
            <div class="help-content">
                <p id="help-text">Для консультации и решения любых вопросов обращайтесь к нашим специалистам в Telegram.</p>
                <a href="https://t.me/Goodxchangermanager" target="_blank" class="help-telegram-btn">
                    <img src="tg.png" alt="Telegram" class="telegram-icon">
                    <span id="help-telegram-text">Telegram</span>
                </a>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="main-content">
            <div class="left-column">
                <div class="info-text">
                    Наша служба обмена работает во многих городах и странах. Чтобы мы могли оперативно проверить наличие пункта в вашем городе и помочь с оформлением заявки, напишите нам в Telegram.
                </div>
                
                <div class="exchanger-section">
                    <h2 class="section-title">Обменник валют</h2>
                
                <div class="exchanger-form">
                    <div class="currency-input-group">
                        <div class="input-field">
                            <label class="input-label">Отдаете</label>
                            <select class="currency-select" id="fromCurrency">
                                <option value="">Выберите валюту</option>
                            </select>
                        </div>

                        <div class="input-field">
                            <label class="input-label">Получаете</label>
                            <select class="currency-select" id="toCurrency">
                                <option value="">Выберите валюту</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="currency-input-group">
                        <div class="input-field">
                            <label class="input-label">Сумма</label>
                            <input type="number" class="amount-input" id="fromAmount" placeholder="0.00" oninput="calculateExchangeDebounced()">
                        </div>

                        <div class="input-field">
                            <label class="input-label">К получению</label>
                            <input type="number" class="amount-input" id="toAmount" placeholder="0.00" readonly>
                        </div>
                    </div>
                    
                    <div class="exchange-info" id="exchangeInfo" style="display: none;">
                        <div class="info-row">
                            <span>Курс обмена:</span>
                            <span id="exchangeRate">-</span>
                        </div>
                    </div>
                    
                    <div class="button-container">
                        <a href="https://t.me/Goodxchangermanager" target="_blank" class="exchange-button">
                            <img src="tg.png" alt="Telegram" class="telegram-icon">
                            Telegram
                        </a>
                    </div>
                </div>
                </div>
                
                <div class="advantages-section">
                    <h3 class="advantages-title">Почему выбирают GoodXchanger?</h3>
                    <div class="advantage-intro">
                        GoodXchanger — это не просто обменник. Это ваш надежный партнер в мире криптовалют, который сочетает в себе скорость, безопасность и выгоду. Вот что делает нас лучшим выбором для тысяч пользователей по всему миру:
                    </div>
                    
                    <div class="advantages-grid">
                        <div class="advantage-item">
                            <div class="advantage-title">Скорость</div>
                            <div class="advantage-subtitle">Мгновенные транзакции</div>
                            <div class="advantage-text">Мы понимаем: в криптомире каждая минута имеет значение. Наш автоматизированный сервис проводит большинство операций за 5–15 минут, а не часы. Ваше время — это ваши деньги, и мы это ценим.</div>
                        </div>
                        
                        <div class="advantage-item">
                            <div class="advantage-title">Безопасность</div>
                            <div class="advantage-subtitle">Ваши средства — в максимальной надежности</div>
                            <div class="advantage-text">GoodXchanger работает по принципу "без доверия" (trustless): Все операции защищены современным шифрованием; Мы не храним ваши средства дольше необходимого; Работаем напрямую, без посредников. Ваша безопасность — наш приоритет №1.</div>
                        </div>
                        
                        <div class="advantage-item">
                            <div class="advantage-title">Выгодный курс</div>
                            <div class="advantage-subtitle">Прозрачность без скрытых комиссий</div>
                            <div class="advantage-text">GoodXchanger предлагает одни из самых конкурентных курсов на рынке. Все комиссии указаны заранее; Никаких сюрпризов перед обменом; Мы экономим ваши деньги, а не скрываем условия. Максимальная выгода для вас — наша философия.</div>
                        </div>
                        
                        <div class="advantage-item">
                            <div class="advantage-title">Доступность</div>
                            <div class="advantage-subtitle">Работаем по всему миру 24/7</div>
                            <div class="advantage-text">Криптовалюты не спят — и мы тоже. Обменивайте активы в любое время суток, из любой точки планеты. GoodXchanger всегда там, где нужны вам.</div>
                        </div>
                        
                        <div class="advantage-item">
                            <div class="advantage-title">Поддержка</div>
                            <div class="advantage-subtitle">Помощь всегда рядом</div>
                            <div class="advantage-text">Наша команда поддержки отвечает в Telegram в среднем за 2–3 минуты. Мы решаем вопросы любой сложности — от статуса заявки до консультации по первым шагам в крипто. Мы не просто служба поддержки — мы ваши крипто-навигаторы.</div>
                        </div>
                        
                        <div class="advantage-item">
                            <div class="advantage-title">Простота</div>
                            <div class="advantage-subtitle">Интуитивно и понятно</div>
                            <div class="advantage-text">Наш интерфейс продуман до мелочей. Справится даже тот, кто никогда раньше не менял криптовалюту.</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="rates-section">
                <div class="rates-header">
                    <h3 class="rates-title">Курсы обмена</h3>
                </div>
                
                <div id="crypto-container" class="crypto-grid">
                    <div class="loading">Загрузка данных...</div>
                </div>
                
                <div class="last-update" id="last-update"></div>
            </div>
        </div>
    </div>

    <script>
        let currentLanguage = 'ru';
        
        const translations = {
            ru: {
                infoText: 'Наша служба обмена работает во многих городах и странах. Чтобы мы могли оперативно проверить наличие пункта в вашем городе и помочь с оформлением заявки, напишите нам в Telegram.',
                exchangerTitle: 'Обменник валют',
                ratesTitle: 'Курсы обмена',
                fromLabel: 'Отдаете',
                toLabel: 'Получаете',
                amountLabel: 'Сумма',
                receiveLabel: 'К получению',
                selectCurrency: 'Выберите валюту',
                exchangeRate: 'Курс обмена:',
                telegramBtn: 'Telegram',
                lastUpdate: 'Последнее обновление:',
                loading: 'Загрузка данных...',
                advantagesTitle: 'Почему выбирают GoodXchanger?',
                advantageIntro: 'GoodXchanger — это не просто обменник. Это ваш надежный партнер в мире криптовалют, который сочетает в себе скорость, безопасность и выгоду. Вот что делает нас лучшим выбором для тысяч пользователей по всему миру:',
                speedTitle: 'Скорость',
                speedSubtitle: 'Мгновенные транзакции',
                speedText: 'Мы понимаем: в криптомире каждая минута имеет значение. Наш автоматизированный сервис проводит большинство операций за 5–15 минут, а не часы. Ваше время — это ваши деньги, и мы это ценим.',
                securityTitle: 'Безопасность',
                securitySubtitle: 'Ваши средства — в максимальной надежности',
                securityText: 'GoodXchanger работает по принципу "без доверия" (trustless): Все операции защищены современным шифрованием; Мы не храним ваши средства дольше необходимого; Работаем напрямую, без посредников. Ваша безопасность — наш приоритет №1.',
                rateTitle: 'Выгодный курс',
                rateSubtitle: 'Прозрачность без скрытых комиссий',
                rateText: 'GoodXchanger предлагает одни из самых конкурентных курсов на рынке. Все комиссии указаны заранее; Никаких сюрпризов перед обменом; Мы экономим ваши деньги, а не скрываем условия. Максимальная выгода для вас — наша философия.',
                availabilityTitle: 'Доступность',
                availabilitySubtitle: 'Работаем по всему миру 24/7',
                availabilityText: 'Криптовалюты не спят — и мы тоже. Обменивайте активы в любое время суток, из любой точки планеты. GoodXchanger всегда там, где нужны вам.',
                supportTitle: 'Поддержка',
                supportSubtitle: 'Помощь всегда рядом',
                supportText: 'Наша команда поддержки отвечает в Telegram в среднем за 2–3 минуты. Мы решаем вопросы любой сложности — от статуса заявки до консультации по первым шагам в крипто. Мы не просто служба поддержки — мы ваши крипто-навигаторы.',
                simplicityTitle: 'Простота',
                simplicitySubtitle: 'Интуитивно и понятно',
                simplicityText: 'Наш интерфейс продуман до мелочей. Справится даже тот, кто никогда раньше не менял криптовалюту.',
                reviewBtn: 'Оставить отзыв',
                modalTitle: 'Оставить отзыв',
                nameLabel: 'Имя:',
                telegramLabel: 'Telegram:',
                reviewLabel: 'Отзыв:',
                submitBtn: 'Отправить отзыв',
                footerTelegram: 'Telegram',
                footerHelp: 'Помощь',
                footerReview: 'Оставить отзыв',
                helpBtn: 'Помощь',
                helpTitle: 'Помощь',
                helpText: 'Для консультации и решения любых вопросов обращайтесь к нашим специалистам в Telegram.',
                maxPrice: 'Макс:',
                minPrice: 'Мин:',
                sameCurrency: 'Нельзя обменивать одинаковые валюты'
            },
            en: {
                infoText: 'Our exchange service operates in many cities and countries. To quickly check the availability of a location in your city and help with your application, contact us on Telegram.',
                exchangerTitle: 'Currency Exchange',
                ratesTitle: 'Exchange Rates',
                fromLabel: 'You Send',
                toLabel: 'You Get',
                amountLabel: 'Amount',
                receiveLabel: 'You Receive',
                selectCurrency: 'Select Currency',
                exchangeRate: 'Exchange Rate:',
                telegramBtn: 'Telegram',
                lastUpdate: 'Last Update:',
                loading: 'Loading data...',
                advantagesTitle: 'Why Choose GoodXchanger?',
                advantageIntro: 'GoodXchanger is not just an exchange. It\'s your reliable partner in the world of cryptocurrencies, combining speed, security, and profitability. Here\'s what makes us the best choice for thousands of users worldwide:',
                speedTitle: 'Speed',
                speedSubtitle: 'Instant Transactions',
                speedText: 'We understand: in the crypto world, every minute matters. Our automated service processes most operations in 5-15 minutes, not hours. Your time is your money, and we value that.',
                securityTitle: 'Security',
                securitySubtitle: 'Your Funds in Maximum Safety',
                securityText: 'GoodXchanger operates on a "trustless" principle: All operations are protected by modern encryption; We don\'t store your funds longer than necessary; We work directly, without intermediaries. Your security is our #1 priority.',
                rateTitle: 'Competitive Rates',
                rateSubtitle: 'Transparency Without Hidden Fees',
                rateText: 'GoodXchanger offers some of the most competitive rates in the market. All fees are stated upfront; No surprises before exchange; We save your money, not hide conditions. Maximum benefit for you is our philosophy.',
                availabilityTitle: 'Availability',
                availabilitySubtitle: 'Working Worldwide 24/7',
                availabilityText: 'Cryptocurrencies don\'t sleep — and neither do we. Exchange assets anytime, from anywhere on the planet. GoodXchanger is always where you need us.',
                supportTitle: 'Support',
                supportSubtitle: 'Help Always Near',
                supportText: 'Our support team responds on Telegram in an average of 2-3 minutes. We solve issues of any complexity — from order status to consultation on first steps in crypto. We\'re not just support — we\'re your crypto navigators.',
                simplicityTitle: 'Simplicity',
                simplicitySubtitle: 'Intuitive and Clear',
                simplicityText: 'Our interface is thought out to the smallest detail. Even someone who has never exchanged cryptocurrency before can handle it.',
                reviewBtn: 'Leave Review',
                modalTitle: 'Leave Review',
                nameLabel: 'Name:',
                telegramLabel: 'Telegram:',
                reviewLabel: 'Review:',
                submitBtn: 'Submit Review',
                footerTelegram: 'Telegram',
                footerHelp: 'Help',
                footerReview: 'Leave Review',
                helpBtn: 'Help',
                helpTitle: 'Help',
                helpText: 'For consultation and solving any questions, contact our specialists in Telegram.',
                maxPrice: 'Max:',
                minPrice: 'Min:',
                sameCurrency: 'Cannot exchange the same currencies'
            }
        };
        
        function switchLanguage(lang) {
            currentLanguage = lang;
            
            document.querySelectorAll('.lang-btn').forEach(btn => btn.classList.remove('active'));
            document.getElementById('lang-' + lang).classList.add('active');
            
            updateTexts();
        }
        
        function updateTexts() {
            const t = translations[currentLanguage];
            
            document.querySelector('.info-text').textContent = t.infoText;
            document.querySelector('.section-title').textContent = t.exchangerTitle;
            document.querySelector('.rates-title').textContent = t.ratesTitle;
            document.querySelector('.advantages-title').textContent = t.advantagesTitle;
            document.querySelector('.advantage-intro').textContent = t.advantageIntro;
            
            const labels = document.querySelectorAll('.input-label');
            if (labels[0]) labels[0].textContent = t.fromLabel;
            if (labels[1]) labels[1].textContent = t.toLabel;
            if (labels[2]) labels[2].textContent = t.amountLabel;
            if (labels[3]) labels[3].textContent = t.receiveLabel;
            
            const advantages = document.querySelectorAll('.advantage-item');
            const advantageKeys = ['speed', 'security', 'rate', 'availability', 'support', 'simplicity'];
            
            advantages.forEach((item, index) => {
                const key = advantageKeys[index];
                const titleEl = item.querySelector('.advantage-title');
                const subtitleEl = item.querySelector('.advantage-subtitle');
                const textEl = item.querySelector('.advantage-text');
                
                if (titleEl) titleEl.textContent = t[key + 'Title'];
                if (subtitleEl) subtitleEl.textContent = t[key + 'Subtitle'];
                if (textEl) textEl.textContent = t[key + 'Text'];
            });
            
            const selectDisplays = document.querySelectorAll('.custom-select-display');
            selectDisplays.forEach(display => {
                const span = display.querySelector('span');
                if (span && (span.textContent.includes('валюту') || span.textContent.includes('Currency') || span.textContent === translations.ru.selectCurrency || span.textContent === translations.en.selectCurrency)) {
                    display.innerHTML = `<span>${t.selectCurrency}</span>`;
                }
            });
            
            const telegramBtn = document.querySelector('.exchange-button');
            if (telegramBtn) {
                telegramBtn.innerHTML = `
                    <img src="tg.png" alt="Telegram" class="telegram-icon">
                    ${t.telegramBtn}
                `;
            }
            
            const reviewBtn = document.getElementById('review-btn');
            const modalTitle = document.getElementById('modal-title');
            const nameLabel = document.getElementById('name-label');
            const telegramLabel = document.getElementById('telegram-label');
            const reviewLabel = document.getElementById('review-label');
            const submitBtn = document.getElementById('submit-btn');
            
            if (reviewBtn) reviewBtn.textContent = t.reviewBtn;
            if (modalTitle) modalTitle.textContent = t.modalTitle;
            if (nameLabel) nameLabel.textContent = t.nameLabel;
            if (telegramLabel) telegramLabel.textContent = t.telegramLabel;
            if (reviewLabel) reviewLabel.textContent = t.reviewLabel;
            if (submitBtn) submitBtn.textContent = t.submitBtn;
            
            const helpBtn = document.getElementById('help-btn');
            const helpModalTitle = document.getElementById('help-modal-title');
            const helpText = document.getElementById('help-text');
            const helpTelegramText = document.getElementById('help-telegram-text');
            
            if (helpBtn) helpBtn.textContent = t.helpBtn;
            if (helpModalTitle) helpModalTitle.textContent = t.helpTitle;
            if (helpText) helpText.textContent = t.helpText;
            if (helpTelegramText) helpTelegramText.textContent = t.telegramBtn;
            
            const footerTelegramText = document.getElementById('footer-telegram-text');
            const footerHelpText = document.getElementById('footer-help-text');
            const footerReviewText = document.getElementById('footer-review-text');
            
            if (footerTelegramText) footerTelegramText.textContent = t.footerTelegram;
            if (footerHelpText) footerHelpText.textContent = t.footerHelp;
            if (footerReviewText) footerReviewText.textContent = t.footerReview;
            
            const fromSelect = document.getElementById('fromCurrency');
            const toSelect = document.getElementById('toCurrency');
            if (fromSelect && fromSelect.options[0] && fromSelect.options[0].value === '') {
                fromSelect.options[0].textContent = t.selectCurrency;
            }
            if (toSelect && toSelect.options[0] && toSelect.options[0].value === '') {
                toSelect.options[0].textContent = t.selectCurrency;
            }
            
            if (currentCurrencies.length > 0) {
                displayCryptoData(currentCurrencies);
            }
            
            updateLastUpdateText();
        }
        
        function openReviewModal() {
            document.getElementById('reviewModal').style.display = 'block';
        }
        
        function closeReviewModal() {
            document.getElementById('reviewModal').style.display = 'none';
            document.getElementById('reviewForm').reset();
        }
        
        function openHelpModal() {
            document.getElementById('helpModal').style.display = 'block';
        }
        
        function closeHelpModal() {
            document.getElementById('helpModal').style.display = 'none';
        }
        
        function submitReview(event) {
            event.preventDefault();
            
            const name = document.getElementById('reviewName').value;
            const telegram = document.getElementById('reviewTelegram').value;
            const review = document.getElementById('reviewText').value;
            
            console.log('Отзыв:', { name, telegram, review });
            
            closeReviewModal();
        }

        function showNotification(message, type = 'error') {
            const existingNotification = document.querySelector('.notification');
            if (existingNotification) {
                existingNotification.remove();
            }
            
            const notification = document.createElement('div');
            notification.className = `notification ${type}`;
            notification.textContent = message;
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.classList.add('show');
            }, 100);
            
            setTimeout(() => {
                notification.classList.remove('show');
                setTimeout(() => {
                    if (notification.parentNode) {
                        notification.remove();
                    }
                }, 300);
            }, 3000);
        }

        window.onclick = function(event) {
            const reviewModal = document.getElementById('reviewModal');
            const helpModal = document.getElementById('helpModal');
            
            if (event.target === reviewModal) {
                closeReviewModal();
            }
            
            if (event.target === helpModal) {
                closeHelpModal();
            }
        }

        async function fetchCryptoData() {
            try {
                const response = await fetch('api.php', {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'Cache-Control': 'no-cache'
                    }
                });
                
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                
                const data = await response.json();
                
                if (data.success) {
                    displayCryptoData(data.data);
                    updateLastUpdateText();
                } else {
                    document.getElementById('crypto-container').innerHTML = 
                        '<div class="loading">Ошибка загрузки данных</div>';
                }
            } catch (error) {
                console.error('Ошибка:', error);
                document.getElementById('crypto-container').innerHTML = 
                    '<div class="loading">Ошибка соединения</div>';
            }
        }

        function getCryptoIcon(symbol) {
            const cryptoSymbol = symbol.split('/')[0].toLowerCase();
            
            const iconMap = {
                'btc': 'https://assets.coingecko.com/coins/images/1/small/bitcoin.png',
                'eth': 'https://assets.coingecko.com/coins/images/279/small/ethereum.png',
                'bnb': 'https://assets.coingecko.com/coins/images/825/small/bnb-icon2_2x.png',
                'ada': 'https://assets.coingecko.com/coins/images/975/small/cardano.png',
                'sol': 'https://assets.coingecko.com/coins/images/4128/small/solana.png',
                'xrp': 'https://assets.coingecko.com/coins/images/44/small/xrp-symbol-white-128.png',
                'doge': 'https://assets.coingecko.com/coins/images/5/small/dogecoin.png',
                'dot': 'https://assets.coingecko.com/coins/images/12171/small/polkadot.png'
            };
            
            const iconUrl = iconMap[cryptoSymbol];
            if (iconUrl) {
                const img = new Image();
                img.onerror = () => {
                    console.warn(`Failed to load icon for ${cryptoSymbol}`);
                };
                img.src = iconUrl;
            }
            
            return iconUrl || null;
        }

        function getFiatIcon(symbol) {
            return null;
        }

        function getUSDTIcon(symbol) {
            const usdtIconMap = {
                'usdt trc20': 'https://assets.coingecko.com/coins/images/325/small/Tether.png',
                'usdt ton': 'https://assets.coingecko.com/coins/images/17980/small/ton_symbol.png',
                'usdt erc20': 'https://assets.coingecko.com/coins/images/279/small/ethereum.png',
                'usdt bep20': 'https://assets.coingecko.com/coins/images/825/small/bnb-icon2_2x.png'
            };
            
            return usdtIconMap[symbol.toLowerCase()] || 'https://assets.coingecko.com/coins/images/325/small/Tether.png';
        }

        function getCurrencyIcon(symbol, type) {
            if (type === 'crypto') {
                return getCryptoIcon(symbol);
            } else if (type === 'usdt') {
                return getUSDTIcon(symbol);
            } else {
                return getFiatIcon(symbol);
            }
        }

        function displayCryptoData(currencies) {
            currentCurrencies = currencies;
            
            const container = document.getElementById('crypto-container');
            container.innerHTML = '';

            const cryptoOnly = currencies.filter(currency => currency.type === 'crypto');

            cryptoOnly.forEach(currency => {
                const iconUrl = getCryptoIcon(currency.symbol);
                
                const changeClass = parseFloat(currency.price_24h_pcnt) >= 0 ? 'positive' : 'negative';
                const changeSymbol = parseFloat(currency.price_24h_pcnt) >= 0 ? '+' : '';
                
                const priceDisplay = '$' + parseFloat(currency.last_price).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 6});
                
                let changeDisplayText = '';
                if (currency.price_24h_pcnt !== '0.00') {
                    changeDisplayText = `${changeSymbol}${parseFloat(currency.price_24h_pcnt).toFixed(2)}%`;
                }
                
                let maxDisplay = '';
                let minDisplay = '';
                if (currency.high_24h && currency.low_24h) {
                    const highPrice = '$' + parseFloat(currency.high_24h).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 4});
                    const lowPrice = '$' + parseFloat(currency.low_24h).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 4});
                    maxDisplay = `${translations[currentLanguage].maxPrice} ${highPrice}`;
                    minDisplay = `${translations[currentLanguage].minPrice} ${lowPrice}`;
                }
                
                const card = document.createElement('div');
                card.className = 'crypto-card';
                card.innerHTML = `
                    ${iconUrl ? `<img src="${iconUrl}" alt="${currency.symbol}" class="currency-icon" onerror="this.style.display='none'">` : ''}
                    <div class="crypto-info">
                        <div class="crypto-symbol">${currency.symbol}</div>
                        <div class="crypto-main-row">
                            <div class="crypto-price">${priceDisplay}</div>
                            <div class="crypto-stats">
                                <div class="crypto-change ${changeClass}">${changeDisplayText}</div>
                                <div class="crypto-max">${maxDisplay}</div>
                                <div class="crypto-min">${minDisplay}</div>
                            </div>
                        </div>
                    </div>
                `;
                container.appendChild(card);
            });
        }

        let currentRates = {};
        let currentCurrencies = [];
        let calculateTimeout = null;

        function createCustomSelect(selectId, currencies) {
            const select = document.getElementById(selectId);
            const wrapper = document.createElement('div');
            wrapper.className = 'custom-select-wrapper';
            wrapper.style.position = 'relative';
            
            const displayDiv = document.createElement('div');
            displayDiv.className = 'custom-select-display';
            displayDiv.style.cssText = `
                width: 100%;
                padding: 12px;
                border: 2px solid #e0e0e0;
                border-radius: 10px;
                font-size: 16px;
                background: white;
                cursor: pointer;
                display: flex;
                align-items: center;
                gap: 8px;
                min-height: 44px;
            `;
            displayDiv.innerHTML = `<span>${translations[currentLanguage].selectCurrency}</span>`;
            
            const dropdown = document.createElement('div');
            dropdown.className = 'custom-select-dropdown';
            dropdown.style.cssText = `
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background: white;
                border: 2px solid #e0e0e0;
                border-top: none;
                border-radius: 0 0 10px 10px;
                max-height: 200px;
                overflow-y: auto;
                z-index: 1000;
                display: none;
            `;
            
            currencies.forEach(currency => {
                const option = document.createElement('div');
                option.className = 'custom-select-option';
                option.style.cssText = `
                    padding: 10px 12px;
                    cursor: pointer;
                    display: flex;
                    align-items: center;
                    gap: 8px;
                    transition: background-color 0.2s;
                `;
                option.addEventListener('mouseenter', () => option.style.backgroundColor = '#f5f5f5');
                option.addEventListener('mouseleave', () => option.style.backgroundColor = 'white');
                
                const iconUrl = getCurrencyIcon(currency.symbol, currency.type);
                if (iconUrl && !iconUrl.startsWith('data:')) {
                    option.innerHTML = `
                        <img src="${iconUrl}" alt="${currency.symbol}" style="width: 20px; height: 20px; border-radius: 50%;" onerror="this.parentElement.innerHTML='<span>${currency.symbol}</span>'">
                        <span>${currency.symbol}</span>
                    `;
                } else if (iconUrl && iconUrl.startsWith('data:')) {
                    option.innerHTML = `
                        <img src="${iconUrl}" alt="${currency.symbol}" style="width: 20px; height: 20px; border-radius: 50%;">
                        <span>${currency.symbol}</span>
                    `;
                } else {
                    option.innerHTML = `<span>${currency.symbol}</span>`;
                }
                
                option.addEventListener('click', () => {
                    select.value = currency.symbol;
                    displayDiv.innerHTML = option.innerHTML;
                    dropdown.style.display = 'none';
                    
                    const changeEvent = new Event('change', { bubbles: true });
                    select.dispatchEvent(changeEvent);
                    
                    calculateExchangeDebounced();
                });
                
                dropdown.appendChild(option);
            });
            
            displayDiv.addEventListener('click', () => {
                dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
            });
            
            document.addEventListener('click', (e) => {
                if (!wrapper.contains(e.target)) {
                    dropdown.style.display = 'none';
                }
            });
            
            wrapper.appendChild(displayDiv);
            wrapper.appendChild(dropdown);
            
            select.style.display = 'none';
            select.parentNode.insertBefore(wrapper, select);
        }

        function populateCurrencySelects(currencies) {
            const fromSelect = document.getElementById('fromCurrency');
            const toSelect = document.getElementById('toCurrency');
            
            const currentFromValue = fromSelect.value;
            const currentToValue = toSelect.value;
            
            fromSelect.innerHTML = `<option value="">${translations[currentLanguage].selectCurrency}</option>`;
            toSelect.innerHTML = `<option value="">${translations[currentLanguage].selectCurrency}</option>`;
            
            currencies.forEach(currency => {
                currentRates[currency.symbol] = {
                    rate: parseFloat(currency.last_price),
                    type: currency.type
                };
                
                const option1 = document.createElement('option');
                option1.value = currency.symbol;
                option1.textContent = currency.symbol;
                fromSelect.appendChild(option1);
                
                const option2 = document.createElement('option');
                option2.value = currency.symbol;
                option2.textContent = currency.symbol;
                toSelect.appendChild(option2);
            });
            
            if (currentFromValue && fromSelect.querySelector(`option[value="${currentFromValue}"]`)) {
                fromSelect.value = currentFromValue;
            }
            if (currentToValue && toSelect.querySelector(`option[value="${currentToValue}"]`)) {
                toSelect.value = currentToValue;
            }
            
            if (!document.querySelector('.custom-select-wrapper')) {
                createCustomSelect('fromCurrency', currencies);
                createCustomSelect('toCurrency', currencies);
                
                setTimeout(() => {
                    if (document.getElementById('fromAmount').value) {
                        calculateExchange();
                    }
                }, 100);
            } else {
                const customSelects = document.querySelectorAll('.custom-select-display');
                if (customSelects[0] && currentFromValue) {
                    updateCustomSelectDisplayValue(customSelects[0], currentFromValue);
                }
                if (customSelects[1] && currentToValue) {
                    updateCustomSelectDisplayValue(customSelects[1], currentToValue);
                }
            }
            

        }
        
        function updateCustomSelectDisplayValue(display, value) {
            if (!value) return;
            
            const wrapper = display.parentElement;
            const dropdown = wrapper.querySelector('.custom-select-dropdown');
            if (dropdown) {
                const options = dropdown.querySelectorAll('.custom-option');
                const targetOption = Array.from(options).find(option => {
                    const span = option.querySelector('span');
                    return span && span.textContent === value;
                });
                
                if (targetOption) {
                    display.innerHTML = targetOption.innerHTML;
                }
            }
        }

        function updateLastUpdateText() {
            const lastUpdateEl = document.getElementById('last-update');
            if (lastUpdateEl) {
                const t = translations[currentLanguage];
                const locale = currentLanguage === 'ru' ? 'ru-RU' : 'en-US';
                lastUpdateEl.textContent = t.lastUpdate + ' ' + new Date().toLocaleString(locale);
            }
        }

        function calculateExchangeDebounced() {
            if (calculateTimeout) {
                clearTimeout(calculateTimeout);
            }
            
            calculateTimeout = setTimeout(() => {
                calculateExchange();
            }, 100);
        }

        function formatSmartNumber(num) {
            if (num === 0) return '0';
            
            if (Math.abs(num) >= 1) {
                return num.toFixed(6).replace(/\.?0+$/, '');
            }
            
            const str = num.toFixed(20);
            const decimalPart = str.split('.')[1] || '';
            
            let firstSignificantIndex = -1;
            for (let i = 0; i < decimalPart.length; i++) {
                if (decimalPart[i] !== '0') {
                    firstSignificantIndex = i;
                    break;
                }
            }
            
            if (firstSignificantIndex === -1) return '0';
            
            const precision = firstSignificantIndex + 4;
            return num.toFixed(Math.min(precision, 15)).replace(/\.?0+$/, '');
        }

        function calculateExchange() {
            const fromCurrencyEl = document.getElementById('fromCurrency');
            const toCurrencyEl = document.getElementById('toCurrency');
            const fromAmountEl = document.getElementById('fromAmount');
            const toAmountEl = document.getElementById('toAmount');
            const exchangeInfoEl = document.getElementById('exchangeInfo');
            
            if (!fromCurrencyEl || !toCurrencyEl || !fromAmountEl || !toAmountEl || !exchangeInfoEl) {
                return;
            }
            
            const fromCurrency = fromCurrencyEl.value;
            const toCurrency = toCurrencyEl.value;
            const fromAmount = parseFloat(fromAmountEl.value) || 0;
            
            if (!fromCurrency || !toCurrency || fromAmount <= 0) {
                toAmountEl.value = '';
                exchangeInfoEl.style.display = 'none';
                return;
            }
            
            if (fromCurrency === toCurrency) {
                toAmountEl.value = '';
                exchangeInfoEl.style.display = 'none';
                showNotification(translations[currentLanguage].sameCurrency || 'Нельзя обменивать одинаковые валюты', 'warning');
                return;
            }
            
            const fromRateData = currentRates[fromCurrency];
            const toRateData = currentRates[toCurrency];
            
            if (!fromRateData || !toRateData) {
                return;
            }
            
            const fromRate = fromRateData.rate;
            const toRate = toRateData.rate;
            
            if (!fromRate || !toRate || fromRate <= 0 || toRate <= 0) {
                toAmountEl.value = '';
                exchangeInfoEl.style.display = 'none';
                return;
            }
            
            let usdAmount;
            if (fromRateData.type === 'fiat') {
                usdAmount = fromAmount * fromRate;
            } else if (fromRateData.type === 'usdt') {
                usdAmount = fromAmount;
            } else if (fromCurrency.includes('/USDT')) {
                usdAmount = fromAmount * fromRate;
            } else {
                usdAmount = fromAmount;
            }
            
            let finalAmount;
            if (toRateData.type === 'fiat') {
                finalAmount = usdAmount / toRate;
            } else if (toRateData.type === 'usdt') {
                finalAmount = usdAmount;
            } else if (toCurrency.includes('/USDT')) {
                finalAmount = usdAmount / toRate;
            } else {
                finalAmount = usdAmount;
            }
            
            const amountAfterCommission = finalAmount * 0.985;
            
            if (!isFinite(amountAfterCommission) || amountAfterCommission <= 0) {
                toAmountEl.value = '';
                exchangeInfoEl.style.display = 'none';
                return;
            }
            
            toAmountEl.value = formatSmartNumber(amountAfterCommission);
            
            const exchangeRateEl = document.getElementById('exchangeRate');
            if (exchangeRateEl) {
                const rate = amountAfterCommission / fromAmount;
                const formattedRate = formatSmartNumber(rate);
                exchangeRateEl.textContent = `1 ${fromCurrency} = ${formattedRate} ${toCurrency}`;
            }
            
            exchangeInfoEl.style.display = 'block';
        }


        
        function updateCustomSelectDisplay(display, select) {
            if (select.value && select.value !== '') {
                const wrapper = display.parentElement;
                const dropdown = wrapper.querySelector('.custom-select-dropdown');
                if (dropdown) {
                    const options = dropdown.querySelectorAll('.custom-option');
                    const matchingOption = Array.from(options).find(option => {
                        const span = option.querySelector('span');
                        return span && span.textContent === select.value;
                    });
                    
                    if (matchingOption) {
                        display.innerHTML = matchingOption.innerHTML;
                    } else {
                        display.innerHTML = `<span>${select.value}</span>`;
                    }
                } else {
                    display.innerHTML = `<span>${select.value}</span>`;
                }
            } else {
                display.innerHTML = `<span>${translations[currentLanguage].selectCurrency}</span>`;
            }
        }

        function performExchange() {
            const fromCurrency = document.getElementById('fromCurrency').value;
            const toCurrency = document.getElementById('toCurrency').value;
            const fromAmount = document.getElementById('fromAmount').value;
            
            if (!fromCurrency || !toCurrency || !fromAmount || fromAmount <= 0) {
                alert('Пожалуйста, заполните все поля корректно');
                return;
            }
            
            alert(`Обмен выполнен!\n${fromAmount} ${fromCurrency} → ${document.getElementById('toAmount').value} ${toCurrency}\n\nЭто демо-версия обменника.`);
        }

        const originalDisplayCryptoData = displayCryptoData;
        displayCryptoData = function(currencies) {
            originalDisplayCryptoData(currencies);
            populateCurrencySelects(currencies);
        };

        document.getElementById('fromCurrency').addEventListener('change', calculateExchangeDebounced);
        document.getElementById('toCurrency').addEventListener('change', calculateExchangeDebounced);

        fetchCryptoData();

        setInterval(fetchCryptoData, 30000);
    </script>

    <footer class="footer">
        <div class="footer-content">
            <img src="logo.png" alt="GoodXchanger" class="footer-logo">
            
            <div class="footer-buttons">
                <a href="https://t.me/Goodxchangermanager" target="_blank" class="footer-btn" id="footer-telegram">
                    <img src="tg.png" alt="Telegram" class="footer-telegram-icon">
                    <span id="footer-telegram-text">Telegram</span>
                </a>
                
                <button class="footer-btn" onclick="openHelpModal()" id="footer-help">
                    <span id="footer-help-text">Помощь</span>
                </button>
                
                <button class="footer-btn" onclick="openReviewModal()" id="footer-review">
                    <span id="footer-review-text">Оставить отзыв</span>
                </button>
            </div>
        </div>
    </footer>
</body>
</html>