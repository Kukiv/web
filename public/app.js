class BybitRatesApp {
    constructor() {
        this.socket = null;
        this.rates = {};
        this.containerElement = document.getElementById('rates-container');
        this.fromAmountInput = document.getElementById('fromAmount');
        this.toAmountInput = document.getElementById('toAmount');
        this.exchangeResult = document.getElementById('exchangeResult');

        this.fromCurrencyValue = 'USD';
        this.toCurrencyValue = 'USD';

        this.currentLang = localStorage.getItem('language') || 'en';

        this.commission = 0.015; // 1.5%
        this.fiatRates = {};

        this.translations = {
            ru: {
                'rates-title': 'Курсы валют',
                'exchange-title': 'Обмен валют',
                'you-send': 'Отдаете',
                'you-get': 'Получаете',
                'enter-amount': 'Введите сумму',
                'result': 'Результат',
                'enter-amount-calc': 'Введите сумму для расчета',
                'loading-rates': 'Загрузка курсов валют...',
                'rate-unavailable': 'Курс недоступен',
                'max': 'Макс',
                'min': 'Мин',
                'leave-feedback': 'Оставьте отзыв',
                'info-title': 'GoodXchanger - надежный обмен криптовалют',
                'info-description': 'GoodXchanger - сервис для обмена цифровых активов, где вы можете быстро и выгодно обменять криптовалюту. Мы предлагаем простой и безопасный способ работы с цифровыми валютами.',
                'advantages-title': 'Наши преимущества:',
                'advantage-speed-title': 'Оперативность',
                'advantage-speed-text': 'Автоматизированный процесс обмена. Большинство операций выполняется за 5-15 минут.',
                'advantage-rates-title': 'Честные курсы',
                'advantage-rates-text': 'Мы предлагаем выгодные курсы без скрытых комиссий.',
                'advantage-security-title': 'Безопасность',
                'advantage-security-text': 'Ваши средства защищены современными системами шифрования.',
                'advantage-support-title': 'Поддержка',
                'advantage-support-text': 'Наша служба поддержки работает круглосуточно и готова помочь по любым вопросам.',
                'currencies-title': 'Доступные валюты',
                'currencies-text': 'Работаем с Bitcoin, Ethereum, USDT, USDC, Litecoin и другими криптовалютами.',
                'feedback-title': 'Оставить отзыв',
                'feedback-name-label': 'Ваше имя:',
                'feedback-name-placeholder': 'Введите ваше имя',
                'feedback-telegram-label': 'Telegram (необязательно):',
                'feedback-telegram-placeholder': '@username или ссылка',
                'feedback-text-label': 'Ваш отзыв:',
                'feedback-text-placeholder': 'Поделитесь своим опытом с нами...',
                'cancel': 'Отмена',
                'submit-feedback': 'Отправить отзыв',
                'feedback-error': 'Пожалуйста, заполните все поля',
                'cities-info': 'Мы работаем во многих городах. Узнайте, есть ли в вашем городе пункт обмена, и оформите заявку, написав нам в Telegram.'
            },
            en: {
                'rates-title': 'Exchange Rates',
                'exchange-title': 'Currency Exchange',
                'you-send': 'You Send',
                'you-get': 'You Get',
                'enter-amount': 'Enter amount',
                'result': 'Result',
                'enter-amount-calc': 'Enter amount to calculate',
                'loading-rates': 'Loading exchange rates...',
                'rate-unavailable': 'Rate unavailable',
                'max': 'High',
                'min': 'Low',
                'leave-feedback': 'Leave Feedback',
                'info-title': 'GoodXchanger - Reliable Cryptocurrency Exchange',
                'info-description': 'GoodXchanger is a digital asset exchange service where you can quickly and profitably exchange cryptocurrency. We offer a simple and secure way to work with digital currencies.',
                'advantages-title': 'Our Advantages:',
                'advantage-speed-title': 'Speed',
                'advantage-speed-text': 'Automated exchange process. Most operations are completed within 5-15 minutes.',
                'advantage-rates-title': 'Fair Rates',
                'advantage-rates-text': 'We offer competitive rates without hidden fees.',
                'advantage-security-title': 'Security',
                'advantage-security-text': 'Your funds are protected by modern encryption systems.',
                'advantage-support-title': 'Support',
                'advantage-support-text': 'Our support team works 24/7 and is ready to help with any questions.',
                'currencies-title': 'Available Currencies',
                'currencies-text': 'We work with Bitcoin, Ethereum, USDT, USDC, Litecoin and other cryptocurrencies.',
                'feedback-title': 'Leave Feedback',
                'feedback-name-label': 'Your Name:',
                'feedback-name-placeholder': 'Enter your name',
                'feedback-telegram-label': 'Telegram (optional):',
                'feedback-telegram-placeholder': '@username or link',
                'feedback-text-label': 'Your Feedback:',
                'feedback-text-placeholder': 'Share your experience with us...',
                'cancel': 'Cancel',
                'submit-feedback': 'Submit Feedback',
                'feedback-error': 'Please fill in all fields',
                'cities-info': 'We operate in many cities. Find out if there is an exchange point in your city and place an order by writing to us on Telegram.'
            }
        };

        this.currencies = [
            { code: 'USD', icon: 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHZpZXdCb3g9IjAgMCAyMCAyMCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHJlY3Qgd2lkdGg9IjIwIiBoZWlnaHQ9IjIwIiBmaWxsPSIjNjY2Ii8+Cjx0ZXh0IHg9IjEwIiB5PSIxNCIgZm9udC1mYW1pbHk9IkFyaWFsIiBmb250LXNpemU9IjEwIiBmaWxsPSIjZmZmIiB0ZXh0LWFuY2hvcj0ibWlkZGxlIj4kPC90ZXh0Pgo8L3N2Zz4K' },
            { code: 'EUR', icon: 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHZpZXdCb3g9IjAgMCAyMCAyMCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHJlY3Qgd2lkdGg9IjIwIiBoZWlnaHQ9IjIwIiBmaWxsPSIjMDA0Q0ZGIi8+Cjx0ZXh0IHg9IjEwIiB5PSIxNCIgZm9udC1mYW1pbHk9IkFyaWFsIiBmb250LXNpemU9IjEwIiBmaWxsPSIjZmZmIiB0ZXh0LWFuY2hvcj0ibWlkZGxlIj7igqw8L3RleHQ+Cjwvc3ZnPgo=' },
            { code: 'UAH', icon: 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHZpZXdCb3g9IjAgMCAyMCAyMCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHJlY3Qgd2lkdGg9IjIwIiBoZWlnaHQ9IjIwIiBmaWxsPSIjMDA1N0I3Ii8+Cjx0ZXh0IHg9IjEwIiB5PSIxNCIgZm9udC1mYW1pbHk9IkFyaWFsIiBmb250LXNpemU9IjEwIiBmaWxsPSIjRkZENzAwIiB0ZXh0LWFuY2hvcj0ibWlkZGxlIj7igbQ8L3RleHQ+Cjwvc3ZnPgo=' },
            { code: 'RUB', icon: 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHZpZXdCb3g9IjAgMCAyMCAyMCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHJlY3Qgd2lkdGg9IjIwIiBoZWlnaHQ9IjIwIiBmaWxsPSIjRkZGRkZGIi8+Cjx0ZXh0IHg9IjEwIiB5PSIxNCIgZm9udC1mYW1pbHk9IkFyaWFsIiBmb250LXNpemU9IjEwIiBmaWxsPSIjMDAwIiB0ZXh0LWFuY2hvcj0ibWlkZGxlIj7igr08L3RleHQ+Cjwvc3ZnPgo=' },
            { code: 'BTC', icon: 'https://assets.coingecko.com/coins/images/1/large/bitcoin.png' },
            { code: 'ETH', icon: 'https://assets.coingecko.com/coins/images/279/large/ethereum.png' },
            { code: 'BNB', icon: 'https://assets.coingecko.com/coins/images/825/large/bnb-icon2_2x.png' },
            { code: 'ADA', icon: 'https://assets.coingecko.com/coins/images/975/large/cardano.png' },
            { code: 'SOL', icon: 'https://assets.coingecko.com/coins/images/4128/large/solana.png' },
            { code: 'XRP', icon: 'https://assets.coingecko.com/coins/images/44/large/xrp-symbol-white-128.png' },
            { code: 'DOGE', icon: 'https://assets.coingecko.com/coins/images/5/large/dogecoin.png' },
            { code: 'DOT', icon: 'https://assets.coingecko.com/coins/images/12171/large/polkadot.png' },
            { code: 'MATIC', icon: 'https://assets.coingecko.com/coins/images/4713/large/matic-token-icon.png' },
            { code: 'LTC', icon: 'https://assets.coingecko.com/coins/images/2/large/litecoin.png' }
        ];

        this.coinIcons = {
            'BTCUSDT': 'https://assets.coingecko.com/coins/images/1/large/bitcoin.png',
            'ETHUSDT': 'https://assets.coingecko.com/coins/images/279/large/ethereum.png',
            'BNBUSDT': 'https://assets.coingecko.com/coins/images/825/large/bnb-icon2_2x.png',
            'ADAUSDT': 'https://assets.coingecko.com/coins/images/975/large/cardano.png',
            'SOLUSDT': 'https://assets.coingecko.com/coins/images/4128/large/solana.png',
            'XRPUSDT': 'https://assets.coingecko.com/coins/images/44/large/xrp-symbol-white-128.png',
            'DOGEUSDT': 'https://assets.coingecko.com/coins/images/5/large/dogecoin.png',
            'DOTUSDT': 'https://assets.coingecko.com/coins/images/12171/large/polkadot.png',
            'MATICUSDT': 'https://assets.coingecko.com/coins/images/4713/large/matic-token-icon.png',
            'LTCUSDT': 'https://assets.coingecko.com/coins/images/2/large/litecoin.png',
            'EURUSD': 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMzIiIGhlaWdodD0iMzIiIHZpZXdCb3g9IjAgMCAzMiAzMiIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHJlY3Qgd2lkdGg9IjMyIiBoZWlnaHQ9IjMyIiBmaWxsPSIjMDA0Q0ZGIi8+Cjx0ZXh0IHg9IjE2IiB5PSIyMCIgZm9udC1mYW1pbHk9IkFyaWFsIiBmb250LXNpemU9IjE0IiBmaWxsPSIjZmZmIiB0ZXh0LWFuY2hvcj0ibWlkZGxlIj7igqw8L3RleHQ+Cjwvc3ZnPgo=',
            'UAHUSD': 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMzIiIGhlaWdodD0iMzIiIHZpZXdCb3g9IjAgMCAzMiAzMiIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHJlY3Qgd2lkdGg9IjMyIiBoZWlnaHQ9IjMyIiBmaWxsPSIjMDA1N0I3Ii8+Cjx0ZXh0IHg9IjE2IiB5PSIyMCIgZm9udC1mYW1pbHk9IkFyaWFsIiBmb250LXNpemU9IjE0IiBmaWxsPSIjRkZENzAwIiB0ZXh0LWFuY2hvcj0ibWlkZGxlIj7igbQ8L3RleHQ+Cjwvc3ZnPgo=',
            'RUBUSD': 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMzIiIGhlaWdodD0iMzIiIHZpZXdCb3g9IjAgMCAzMiAzMiIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHJlY3Qgd2lkdGg9IjMyIiBoZWlnaHQ9IjMyIiBmaWxsPSIjRkZGRkZGIi8+Cjx0ZXh0IHg9IjE2IiB5PSIyMCIgZm9udC1mYW1pbHk9IkFyaWFsIiBmb250LXNpemU9IjE0IiBmaWxsPSIjMDAwIiB0ZXh0LWFuY2hvcj0ibWlkZGxlIj7igr08L3RleHQ+Cjwvc3ZnPgo='
        };

        this.init();
        this.initFeedbackModal();
    }

    init() {
        this.initLanguage();
        this.initCustomSelects();
        this.connectSocket();
        this.setupEventListeners();
    }

    connectSocket() {
        this.socket = io();

        this.socket.on('connect', () => {
            // Подключено к серверу
        });

        this.socket.on('disconnect', () => {
            // Отключено от сервера
        });

        this.socket.on('rates-update', (rates) => {
            this.updateRates(rates);
        });

        this.socket.on('fiat-rates-update', (fiatRates) => {
            this.fiatRates = fiatRates;
        });

        this.socket.on('connect_error', (error) => {
            // Ошибка подключения к серверу
        });
    }

    setupEventListeners() {
        this.fromAmountInput.addEventListener('input', () => this.calculateExchange());

        document.querySelectorAll('.lang-btn, .footer-lang-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const lang = e.target.dataset.lang;
                this.switchLanguage(lang);
            });
        });
    }

    initFeedbackModal() {
        const modal = document.getElementById('feedbackModal');
        const feedbackBtns = document.querySelectorAll('.feedback-btn, .footer-feedback-btn');
        const closeBtn = document.querySelector('.close-btn');
        const cancelBtn = document.querySelector('.btn-cancel');
        const form = document.getElementById('feedbackForm');

        feedbackBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                modal.style.display = 'block';
                document.body.style.overflow = 'hidden';
            });
        });

        const closeModal = () => {
            modal.style.display = 'none';
            document.body.style.overflow = 'auto';
            form.reset();
        };

        closeBtn.addEventListener('click', closeModal);
        cancelBtn.addEventListener('click', closeModal);

        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                closeModal();
            }
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && modal.style.display === 'block') {
                closeModal();
            }
        });

        form.addEventListener('submit', (e) => {
            e.preventDefault();
            this.handleFeedbackSubmit();
        });
    }

    handleFeedbackSubmit() {
        const nameInput = document.getElementById('feedbackName');
        const telegramInput = document.getElementById('feedbackTelegram');
        const textInput = document.getElementById('feedbackText');
        const submitBtn = document.querySelector('.btn-submit');

        const name = nameInput.value.trim();
        const telegram = telegramInput.value.trim();
        const feedback = textInput.value.trim();

        if (!name || !feedback) {
            alert(this.t('feedback-error'));
            return;
        }

        submitBtn.disabled = true;
        submitBtn.textContent = '...';

        setTimeout(() => {
            document.getElementById('feedbackModal').style.display = 'none';
            document.body.style.overflow = 'auto';

            document.getElementById('feedbackForm').reset();
            submitBtn.disabled = false;
            submitBtn.textContent = this.t('submit-feedback');
        }, 1000);
    }

    updateRates(newRates) {
        this.rates = newRates;
        this.renderRates();
    }

    renderRates() {
        if (Object.keys(this.rates).length === 0) {
            this.containerElement.innerHTML = `<div class="loading" data-i18n="loading-rates">${this.t('loading-rates')}</div>`;
            return;
        }

        const ratesHtml = Object.values(this.rates)
            .sort((a, b) => a.symbol.localeCompare(b.symbol))
            .map(rate => this.createRateCard(rate))
            .join('');

        this.containerElement.innerHTML = ratesHtml;

        setTimeout(() => {
            document.querySelectorAll('.rate-card').forEach(card => {
                card.classList.add('updated');
                setTimeout(() => card.classList.remove('updated'), 1000);
            });
        }, 100);
    }

    createRateCard(rate) {
        const changeClass = rate.change24h >= 0 ? 'positive' : 'negative';
        const changeSymbol = rate.change24h >= 0 ? '+' : '';
        const iconUrl = this.coinIcons[rate.symbol] || 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMzIiIGhlaWdodD0iMzIiIHZpZXdCb3g9IjAgMCAzMiAzMiIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHJlY3Qgd2lkdGg9IjMyIiBoZWlnaHQ9IjMyIiBmaWxsPSIjNDQ0Ii8+Cjx0ZXh0IHg9IjE2IiB5PSIyMCIgZm9udC1mYW1pbHk9IkFyaWFsIiBmb250LXNpemU9IjEyIiBmaWxsPSIjZmZmIiB0ZXh0LWFuY2hvcj0ibWlkZGxlIj4/PC90ZXh0Pgo8L3N2Zz4K';

        return `
            <div class="rate-card" data-symbol="${rate.symbol}">
                <div class="rate-left">
                    <img src="${iconUrl}" alt="${rate.symbol}" class="coin-icon" 
                         onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMzIiIGhlaWdodD0iMzIiIHZpZXdCb3g9IjAgMCAzMiAzMiIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHJlY3Qgd2lkdGg9IjMyIiBoZWlnaHQ9IjMyIiBmaWxsPSIjNDQ0Ii8+Cjx0ZXh0IHg9IjE2IiB5PSIyMCIgZm9udC1mYW1pbHk9IkFyaWFsIiBmb250LXNpemU9IjEyIiBmaWxsPSIjZmZmIiB0ZXh0LWFuY2hvcj0ibWlkZGxlIj4/PC90ZXh0Pgo8L3N2Zz4K'">
                    <div class="coin-info">
                        <div class="symbol">${rate.symbol}</div>
                        <div class="price">${this.formatPrice(rate.price)}</div>
                    </div>
                </div>
                <div class="rate-right">
                    <div class="change ${changeClass}">
                        ${changeSymbol}${rate.change24h.toFixed(2)}%
                    </div>
                    <div class="high-low">${this.t('max')}: ${this.formatPrice(rate.high24h)}</div>
                    <div class="high-low">${this.t('min')}: ${this.formatPrice(rate.low24h)}</div>
                </div>
            </div>
        `;
    }

    formatPrice(price) {
        if (price >= 1) {
            return price.toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        } else {
            return price.toFixed(6);
        }
    }

    formatVolume(volume) {
        if (volume >= 1000000) {
            return (volume / 1000000).toFixed(1) + 'M';
        } else if (volume >= 1000) {
            return (volume / 1000).toFixed(1) + 'K';
        }
        return volume.toFixed(0);
    }

    formatTime(timestamp) {
        return new Date(timestamp).toLocaleTimeString('ru-RU');
    }

    async checkServerStatus() {
        try {
            const response = await fetch('/api/status');
            const status = await response.json();
        } catch (error) {
        }
    }

    calculateExchange() {
        const fromCurrency = this.fromCurrencyValue;
        const toCurrency = this.toCurrencyValue;
        const fromAmount = parseFloat(this.fromAmountInput.value);

        if (!fromAmount || fromAmount <= 0) {
            this.toAmountInput.value = '';
            this.exchangeResult.textContent = this.t('enter-amount-calc');
            return;
        }

        if (fromCurrency === toCurrency) {
            // Если валюты одинаковые, применяем только комиссию
            const resultWithCommission = fromAmount * (1 - this.commission);
            this.toAmountInput.value = resultWithCommission.toFixed(8);
            this.exchangeResult.textContent = `${fromAmount} ${fromCurrency} = ${resultWithCommission.toFixed(8)} ${toCurrency}`;
            return;
        }

        const fromRate = this.getCurrencyRate(fromCurrency);
        const toRate = this.getCurrencyRate(toCurrency);

        if (!fromRate || !toRate) {
            this.toAmountInput.value = '';
            this.exchangeResult.textContent = this.t('rate-unavailable');
            return;
        }

        // Конвертируем через USD как базовую валюту
        // 1. Конвертируем исходную валюту в USD
        const usdAmount = fromAmount * fromRate;

        // 2. Конвертируем USD в целевую валюту
        const result = usdAmount / toRate;

        // 3. Применяем комиссию
        const resultWithCommission = result * (1 - this.commission);

        this.toAmountInput.value = resultWithCommission.toFixed(8);
        this.exchangeResult.textContent = `${fromAmount} ${fromCurrency} = ${resultWithCommission.toFixed(8)} ${toCurrency}`;
    }

    getCurrencyRate(currency) {
        if (currency === 'USD') {
            return 1;
        }

        // Получаем курсы фиатных валют с сервера
        if (this.fiatRates[currency]) {
            return this.fiatRates[currency];
        }

        // Для криптовалют получаем курс с Bybit
        const symbol = currency + 'USDT';
        const rate = this.rates[symbol];
        return rate ? rate.price : null;
    }

    initCustomSelects() {
        this.setupCustomSelect('fromCurrency', 'USD');
        this.setupCustomSelect('toCurrency', 'USD');
    }

    setupCustomSelect(selectId, defaultValue) {
        const selectElement = document.getElementById(selectId + 'Select');
        const displayElement = selectElement.querySelector('.select-display');
        const dropdownElement = selectElement.querySelector('.select-dropdown');
        const iconElement = document.getElementById(selectId + 'Icon');
        const textElement = document.getElementById(selectId + 'Text');

        dropdownElement.innerHTML = this.currencies.map(currency => `
            <div class="currency-option" data-value="${currency.code}">
                <img src="${currency.icon}" class="currency-icon-small" 
                     onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHZpZXdCb3g9IjAgMCAyMCAyMCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHJlY3Qgd2lkdGg9IjIwIiBoZWlnaHQ9IjIwIiBmaWxsPSIjNjY2Ii8+Cjx0ZXh0IHg9IjEwIiB5PSIxNCIgZm9udC1mYW1pbHk9IkFyaWFsIiBmb250LXNpemU9IjEwIiBmaWxsPSIjZmZmIiB0ZXh0LWFuY2hvcj0ibWlkZGxlIj4/PC90ZXh0Pgo8L3N2Zz4K'">
                <span>${currency.code}</span>
            </div>
        `).join('');

        this.setCurrencyValue(selectId, defaultValue);

        displayElement.addEventListener('click', () => {
            dropdownElement.style.display = dropdownElement.style.display === 'block' ? 'none' : 'block';
        });

        document.addEventListener('click', (e) => {
            if (!selectElement.contains(e.target)) {
                dropdownElement.style.display = 'none';
            }
        });

        dropdownElement.addEventListener('click', (e) => {
            const option = e.target.closest('.currency-option');
            if (option) {
                const value = option.dataset.value;
                this.setCurrencyValue(selectId, value);
                dropdownElement.style.display = 'none';
                this.calculateExchange();
            }
        });
    }

    setCurrencyValue(selectId, value) {
        const currency = this.currencies.find(c => c.code === value);
        if (!currency) return;

        const iconElement = document.getElementById(selectId + 'Icon');
        const textElement = document.getElementById(selectId + 'Text');

        iconElement.src = currency.icon;
        iconElement.onerror = () => {
            iconElement.src = 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHZpZXdCb3g9IjAgMCAyMCAyMCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHJlY3Qgd2lkdGg9IjIwIiBoZWlnaHQ9IjIwIiBmaWxsPSIjNjY2Ii8+Cjx0ZXh0IHg9IjEwIiB5PSIxNCIgZm9udC1mYW1pbHk9IkFyaWFsIiBmb250LXNpemU9IjEwIiBmaWxsPSIjZmZmIiB0ZXh0LWFuY2hvcj0ibWlkZGxlIj4/PC90ZXh0Pgo8L3N2Zz4K';
        };
        textElement.textContent = value;

        if (selectId === 'fromCurrency') {
            this.fromCurrencyValue = value;
        } else {
            this.toCurrencyValue = value;
        }
    }

    initLanguage() {
        this.updateLanguageButtons();
        this.updateTexts();
    }

    switchLanguage(lang) {
        this.currentLang = lang;
        localStorage.setItem('language', lang);
        this.updateLanguageButtons();
        this.updateTexts();
        this.renderRates();
    }

    updateLanguageButtons() {
        document.querySelectorAll('.lang-btn, .footer-lang-btn').forEach(btn => {
            btn.classList.toggle('active', btn.dataset.lang === this.currentLang);
        });
    }

    updateTexts() {
        document.querySelectorAll('[data-i18n]').forEach(element => {
            const key = element.dataset.i18n;
            element.textContent = this.t(key);
        });

        document.querySelectorAll('[data-i18n-placeholder]').forEach(element => {
            const key = element.dataset.i18nPlaceholder;
            element.placeholder = this.t(key);
        });

        if (this.exchangeResult.textContent.includes('Введите сумму') ||
            this.exchangeResult.textContent.includes('Enter amount')) {
            this.exchangeResult.textContent = this.t('enter-amount-calc');
        }

        const submitBtn = document.querySelector('.btn-submit');
        if (submitBtn && !submitBtn.disabled) {
            submitBtn.textContent = this.t('submit-feedback');
        }
    }

    t(key) {
        return this.translations[this.currentLang][key] || key;
    }
}

document.addEventListener('DOMContentLoaded', () => {
    new BybitRatesApp();
});