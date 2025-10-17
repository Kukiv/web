const express = require('express');
const http = require('http');
const socketIo = require('socket.io');
const cors = require('cors');
const path = require('path');
const BybitService = require('./services/bybitService');
const CurrencyService = require('./services/currencyService');

const app = express();
const server = http.createServer(app);
const io = socketIo(server, {
    cors: {
        origin: "*",
        methods: ["GET", "POST"]
    }
});

const PORT = process.env.PORT || 3000;

app.use(cors());
app.use(express.json());
app.use(express.static(path.join(__dirname, 'public')));

// Обслуживание index.html из корня
app.get('/', (req, res) => {
    res.sendFile(path.join(__dirname, 'index.html'));
});

const bybitService = new BybitService();
const currencyService = new CurrencyService();

let allRates = {};
currencyService.fiatDisplayRates = {};

io.on('connection', (socket) => {
    socket.emit('rates-update', allRates);
    socket.emit('fiat-rates-update', currencyService.getFiatRates());

    socket.on('disconnect', () => {
    });
});

bybitService.on('rates-update', (cryptoRates) => {
    // Объединяем криптовалютные курсы с фиатными, сохраняя фиатные курсы
    allRates = { ...currencyService.fiatDisplayRates, ...cryptoRates };
    io.emit('rates-update', allRates);
});

currencyService.on('fiat-rates-update', (data) => {
    currencyService.fiatDisplayRates = data.display;
    // Объединяем фиатные курсы с криптовалютными, сохраняя криптовалютные курсы
    allRates = { ...data.display, ...bybitService.getCurrentRates() };
    io.emit('rates-update', allRates);
    io.emit('fiat-rates-update', data.rates);
});

app.get('/api/rates', (req, res) => {
    res.json(allRates);
});

app.get('/api/fiat-rates', (req, res) => {
    res.json(currencyService.getFiatRates());
});

app.get('/api/status', (req, res) => {
    res.json({
        status: 'online',
        connected: bybitService.isConnected(),
        timestamp: new Date().toISOString()
    });
});

server.listen(PORT, () => {
    bybitService.connect();
    currencyService.start();
});

process.on('SIGTERM', () => {
    bybitService.disconnect();
    currencyService.stop();
    server.close(() => {
        process.exit(0);
    });
});