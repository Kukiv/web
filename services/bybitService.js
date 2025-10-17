const WebSocket = require('ws');
const EventEmitter = require('events');
const https = require('https');

class BybitService extends EventEmitter {
  constructor() {
    super();
    this.ws = null;
    this.rates = {};
    this.isConnectedFlag = false;
    this.reconnectInterval = 5000;
    this.reconnectTimer = null;
    this.updateInterval = 30000;
    this.lastUpdateTime = 0;
    
    this.symbols = [
      'BTCUSDT',
      'ETHUSDT', 
      'BNBUSDT',
      'ADAUSDT',
      'SOLUSDT',
      'XRPUSDT',
      'DOGEUSDT',
      'DOTUSDT',
      'MATICUSDT',
      'LTCUSDT'
    ];
  }

  connect() {
    // Сначала получаем все курсы через REST API
    this.fetchInitialRates();
    
    try {
      this.ws = new WebSocket('wss://stream.bybit.com/v5/public/spot');
      
      this.ws.on('open', () => {
        this.isConnectedFlag = true;
        this.subscribeToTickers();
        
        if (this.reconnectTimer) {
          clearTimeout(this.reconnectTimer);
          this.reconnectTimer = null;
        }
      });

      this.ws.on('message', (data) => {
        try {
          const message = JSON.parse(data);
          this.handleMessage(message);
        } catch (error) {
        }
      });

      this.ws.on('close', () => {
        this.isConnectedFlag = false;
        this.scheduleReconnect();
      });

      this.ws.on('error', (error) => {
        this.isConnectedFlag = false;
      });

    } catch (error) {
      this.scheduleReconnect();
    }
  }

  subscribeToTickers() {
    if (!this.ws || this.ws.readyState !== WebSocket.OPEN) {
      return;
    }

    const subscribeMessage = {
      op: 'subscribe',
      args: this.symbols.map(symbol => `tickers.${symbol}`)
    };

    this.ws.send(JSON.stringify(subscribeMessage));
  }

  handleMessage(message) {
    if (message.topic && message.topic.startsWith('tickers.')) {
      const symbol = message.topic.replace('tickers.', '');
      const data = message.data;
      
      if (data && data.lastPrice) {
        this.rates[symbol] = {
          symbol: symbol,
          price: parseFloat(data.lastPrice),
          change24h: parseFloat(data.price24hPcnt || 0),
          volume24h: parseFloat(data.volume24h || 0),
          high24h: parseFloat(data.highPrice24h || 0),
          low24h: parseFloat(data.lowPrice24h || 0),
          timestamp: Date.now()
        };
        
        const now = Date.now();
        if (now - this.lastUpdateTime >= this.updateInterval) {
          this.lastUpdateTime = now;
          this.emit('rates-update', this.rates);
        }
      }
    }
  }

  scheduleReconnect() {
    if (this.reconnectTimer) {
      return;
    }
    
    this.reconnectTimer = setTimeout(() => {
      this.reconnectTimer = null;
      this.connect();
    }, this.reconnectInterval);
  }

  getCurrentRates() {
    return this.rates;
  }

  isConnected() {
    return this.isConnectedFlag;
  }

  async fetchInitialRates() {
    try {
      // Получаем курсы всех символов через REST API (все спотовые тикеры)
      const url = 'https://api.bybit.com/v5/market/tickers?category=spot';
      
      const response = await this.makeHttpRequest(url);
      const data = JSON.parse(response);
      
      if (data.result && data.result.list) {
        // Фильтруем только нужные нам символы
        data.result.list.forEach(ticker => {
          if (this.symbols.includes(ticker.symbol)) {
            this.rates[ticker.symbol] = {
              symbol: ticker.symbol,
              price: parseFloat(ticker.lastPrice),
              change24h: parseFloat(ticker.price24hPcnt || 0),
              volume24h: parseFloat(ticker.volume24h || 0),
              high24h: parseFloat(ticker.highPrice24h || 0),
              low24h: parseFloat(ticker.lowPrice24h || 0),
              timestamp: Date.now()
            };
          }
        });
        

        // Эмитим начальные курсы
        this.emit('rates-update', this.rates);
      }
    } catch (error) {
      // Ошибка получения начальных курсов
    }
  }

  makeHttpRequest(url) {
    return new Promise((resolve, reject) => {
      https.get(url, (res) => {
        let data = '';
        res.on('data', (chunk) => {
          data += chunk;
        });
        res.on('end', () => {
          resolve(data);
        });
      }).on('error', (err) => {
        reject(err);
      });
    });
  }

  disconnect() {
    if (this.reconnectTimer) {
      clearTimeout(this.reconnectTimer);
      this.reconnectTimer = null;
    }
    
    if (this.ws) {
      this.ws.close();
      this.ws = null;
    }
    
    this.isConnectedFlag = false;
  }
}

module.exports = BybitService;