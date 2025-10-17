const EventEmitter = require('events');

class CurrencyService extends EventEmitter {
    constructor() {
        super();
        this.fiatRates = {};
        this.updateInterval = 30000; // 30 секунд
        this.timer = null;
        
        // Базовые курсы на случай если API недоступно
        this.fallbackRates = {
            'USD': 1,
            'EUR': 1.08,
            'UAH': 0.024,
            'RUB': 0.0105
        };
    }

    start() {
        this.updateFiatRates();
        this.timer = setInterval(() => {
            this.updateFiatRates();
        }, this.updateInterval);
    }

    async updateFiatRates() {
        try {
            // Используем exchangerate-api.com для получения курсов
            const response = await fetch('https://api.exchangerate-api.com/v4/latest/USD');
            const data = await response.json();
            
            if (data && data.rates) {
                // Конвертируем курсы в формат "цена 1 единицы валюты в USD"
                this.fiatRates = {
                    'USD': 1,
                    'EUR': 1 / data.rates.EUR,
                    'UAH': 1 / data.rates.UAH, 
                    'RUB': 1 / data.rates.RUB
                };
                
                // Создаем данные для отображения в блоке курсов
                const ratesForDisplay = {
                    'EURUSD': {
                        symbol: 'EURUSD',
                        price: this.fiatRates.EUR,
                        change24h: 0, // Для фиатных валют изменение не отслеживаем
                        volume24h: 0,
                        high24h: this.fiatRates.EUR,
                        low24h: this.fiatRates.EUR,
                        timestamp: Date.now()
                    },
                    'UAHUSD': {
                        symbol: 'UAHUSD', 
                        price: this.fiatRates.UAH,
                        change24h: 0,
                        volume24h: 0,
                        high24h: this.fiatRates.UAH,
                        low24h: this.fiatRates.UAH,
                        timestamp: Date.now()
                    },
                    'RUBUSD': {
                        symbol: 'RUBUSD',
                        price: this.fiatRates.RUB,
                        change24h: 0,
                        volume24h: 0,
                        high24h: this.fiatRates.RUB,
                        low24h: this.fiatRates.RUB,
                        timestamp: Date.now()
                    }
                };
                

                this.emit('fiat-rates-update', { rates: this.fiatRates, display: ratesForDisplay });
            }
        } catch (error) {
            // Используем резервные курсы при ошибке получения курсов валют
            this.fiatRates = { ...this.fallbackRates };

            this.emit('fiat-rates-update', { rates: this.fiatRates, display: {} });
        }
    }

    getFiatRates() {
        return this.fiatRates;
    }

    stop() {
        if (this.timer) {
            clearInterval(this.timer);
            this.timer = null;
        }
    }
}

module.exports = CurrencyService;