<?php
// Простой сайт для отображения курса криптовалют и фиатных валют
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GoodXchanger</title>
    <link rel="icon" type="image/png" href="logo.png">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            background-color: rgb(102, 168, 254);
            min-height: 100vh;
        }
        
        .navbar {
            background-color: rgb(102, 168, 254);
            padding: 5px 0;
            margin-bottom: 15px;
        }
        
        .navbar-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .navbar-right {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .review-btn {
            background: rgba(255,255,255,0.2);
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
            transition: background-color 0.2s ease;
        }
        
        .review-btn:hover {
            background: rgba(255,255,255,0.3);
        }
        
        .language-switcher {
            display: flex;
            gap: 10px;
        }
        
        .lang-btn {
            background: rgba(255,255,255,0.2);
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
            transition: background-color 0.2s ease;
        }
        
        .lang-btn:hover {
            background: rgba(255,255,255,0.3);
        }
        
        .lang-btn.active {
            background: rgba(255,255,255,0.4);
        }
        
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
        }
        
        .modal-content {
            background-color: white;
            margin: 5% auto;
            padding: 30px;
            border-radius: 15px;
            width: 90%;
            max-width: 500px;
            position: relative;
        }
        
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            position: absolute;
            right: 15px;
            top: 10px;
        }
        
        .close:hover {
            color: #000;
        }
        
        .modal-title {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #333;
        }
        
        .form-input {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 16px;
            box-sizing: border-box;
        }
        
        .form-textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 16px;
            min-height: 120px;
            resize: vertical;
            box-sizing: border-box;
        }
        
        .submit-btn {
            background: rgb(102, 168, 254);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.2s ease;
        }
        
        .submit-btn:hover {
            background: rgb(82, 148, 234);
        }
        
        .footer {
            background-color: rgb(102, 168, 254);
            padding: 30px 0;
            margin-top: 50px;
        }
        
        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 20px;
        }
        
        .footer-logo {
            height: 60px;
            width: auto;
        }
        
        .footer-buttons {
            display: flex;
            gap: 15px;
            align-items: center;
        }
        
        .footer-btn {
            background: rgba(255,255,255,0.2);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
            transition: background-color 0.2s ease;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .footer-btn:hover {
            background: rgba(255,255,255,0.3);
        }
        
        .footer-telegram-icon {
            width: 18px;
            height: 18px;
        }
        
        @media (max-width: 768px) {
            .footer-content {
                flex-direction: column;
                text-align: center;
            }
        }
        
        .logo {
            height: 100px;
            width: auto;
            margin-right: 15px;
        }
        
        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        .main-content {
            display: flex;
            gap: 30px;
            align-items: flex-start;
        }
        
        .left-column {
            flex: 2;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        
        .exchanger-section {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.1);
        }
        
        .rates-section {
            flex: 1;
            min-width: 280px;
            max-width: 320px;
        }
        
        .section-title {
            font-size: 28px;
            font-weight: bold;
            color: #333;
            margin-bottom: 25px;
            text-align: center;
        }
        
        .info-text {
            color: white;
            font-size: 16px;
            line-height: 1.5;
            text-align: center;
            margin-bottom: 20px;
            padding: 15px;
            min-height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .rates-header {
            background-color: rgba(255,255,255,0.1);
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
            min-height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .rates-title {
            color: white;
            font-size: 20px;
            font-weight: bold;
            text-align: center;
        }
        
        .advantages-section {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.1);
        }
        
        .advantages-title {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .advantage-intro {
            font-size: 16px;
            color: #666;
            line-height: 1.6;
            text-align: center;
            margin-bottom: 30px;
            padding: 0 20px;
        }
        
        .advantages-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            grid-template-rows: repeat(3, 1fr);
            gap: 20px;
        }
        
        .advantage-item {
            text-align: left;
        }
        
        .advantage-title {
            font-size: 16px;
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }
        
        .advantage-subtitle {
            font-size: 14px;
            color: #666;
            font-weight: 600;
            margin-bottom: 8px;
        }
        
        .advantage-text {
            font-size: 14px;
            color: #666;
            line-height: 1.4;
        }
        
        .exchanger-form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        
        .currency-input-group {
            display: flex;
            gap: 15px;
            align-items: end;
        }
        
        .input-field {
            flex: 1;
        }
        
        .input-label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #333;
        }
        
        .currency-select {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 16px;
            background: white;
            cursor: pointer;
        }
        
        .currency-option {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px;
        }
        
        .select-icon {
            width: 20px;
            height: 20px;
            border-radius: 50%;
        }
        
        .amount-input {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 18px;
            font-weight: bold;
        }
        
        .exchange-arrow {
            align-self: center;
            background: rgb(102, 168, 254);
            color: white;
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            cursor: pointer;
            font-size: 18px;
            transition: transform 0.2s ease;
        }
        
        .exchange-arrow:hover {
            transform: rotate(180deg);
        }
        
        .exchange-info {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 15px;
            margin: 20px 0;
        }
        
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }
        
        .info-row:last-child {
            margin-bottom: 0;
            font-weight: bold;
            border-top: 1px solid #e0e0e0;
            padding-top: 8px;
        }
        
        .exchange-button {
            background: rgb(102, 168, 254);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 12px 24px;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            justify-content: center;
            text-decoration: none;
            width: auto;
            margin: 0 auto;
        }
        
        .button-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
        
        .exchange-button:hover {
            background: rgb(82, 148, 234);
        }
        
        .telegram-icon {
            width: 18px;
            height: 18px;
        }
        
        .crypto-grid {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }
        
        .crypto-card {
            background: white;
            border-radius: 8px;
            padding: 8px 12px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            gap: 8px;
            transition: transform 0.2s ease;
            width: 100%;
        }
        
        .crypto-card:hover {
            transform: translateY(-2px);
        }
        
        .currency-icon {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            flex-shrink: 0;
        }
        
        .crypto-info {
            display: flex;
            flex-direction: column;
            gap: 1px;
            flex: 1;
        }
        
        .crypto-symbol {
            font-size: 14px;
            font-weight: bold;
            color: #333;
        }
        
        .crypto-main-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 6px;
        }
        
        .crypto-price {
            font-size: 16px;
            font-weight: bold;
            color: #333;
        }
        
        .crypto-stats {
            display: flex;
            flex-direction: column;
            gap: 1px;
            text-align: right;
            font-size: 10px;
        }
        
        .crypto-change {
            font-size: 11px;
            font-weight: bold;
        }
        
        .crypto-max {
            font-size: 10px;
            color: #666;
        }
        
        .crypto-min {
            font-size: 10px;
            color: #666;
        }
        
        .positive { color: #4CAF50; }
        .negative { color: #f44336; }
        
        .loading {
            text-align: center;
            font-size: 18px;
            color: white;
            background-color: rgba(255,255,255,0.1);
            padding: 20px;
            border-radius: 15px;
            backdrop-filter: blur(10px);
        }
        
        .last-update {
            text-align: center;
            margin-top: 20px;
            color: white;
            font-size: 14px;
            background-color: rgba(255,255,255,0.1);
            padding: 10px;
            border-radius: 10px;
            backdrop-filter: blur(10px);
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="navbar-content">
            <img src="logo.png" alt="Логотип" class="logo">
            <div class="navbar-right">
                <button class="review-btn" onclick="openReviewModal()" id="review-btn">Оставить отзыв</button>
                <div class="language-switcher">
                    <button class="lang-btn active" onclick="switchLanguage('ru')" id="lang-ru">RU</button>
                    <button class="lang-btn" onclick="switchLanguage('en')" id="lang-en">EN</button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Модальное окно для отзывов -->
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

    <div class="container">
        <div class="main-content">
            <!-- Левая колонка: текст + обменник -->
            <div class="left-column">
                <!-- Информационный текст -->
                <div class="info-text">
                    Наша служба обмена работает во многих городах и странах. Чтобы мы могли оперативно проверить наличие пункта в вашем городе и помочь с оформлением заявки, напишите нам в Telegram.
                </div>
                
                <!-- Обменник -->
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
                        <button class="exchange-arrow" onclick="swapCurrencies()" title="Поменять местами">⇄</button>
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
                            <input type="number" class="amount-input" id="fromAmount" placeholder="0.00" oninput="calculateExchange()">
                        </div>
                        <div style="width: 40px;"></div>
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
                
                <!-- Преимущества -->
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
            
            <!-- Курсы валют -->
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
        // Локализация
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
                footerReview: 'Оставить отзыв'
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
                footerReview: 'Leave Review'
            }
        };
        
        function switchLanguage(lang) {
            currentLanguage = lang;
            
            // Обновляем активную кнопку
            document.querySelectorAll('.lang-btn').forEach(btn => btn.classList.remove('active'));
            document.getElementById('lang-' + lang).classList.add('active');
            
            // Обновляем тексты
            updateTexts();
        }
        
        function updateTexts() {
            const t = translations[currentLanguage];
            
            // Обновляем статические тексты
            document.querySelector('.info-text').textContent = t.infoText;
            document.querySelector('.section-title').textContent = t.exchangerTitle;
            document.querySelector('.rates-title').textContent = t.ratesTitle;
            document.querySelector('.advantages-title').textContent = t.advantagesTitle;
            document.querySelector('.advantage-intro').textContent = t.advantageIntro;
            
            // Обновляем лейблы форм
            const labels = document.querySelectorAll('.input-label');
            if (labels[0]) labels[0].textContent = t.fromLabel;
            if (labels[1]) labels[1].textContent = t.toLabel;
            if (labels[2]) labels[2].textContent = t.amountLabel;
            if (labels[3]) labels[3].textContent = t.receiveLabel;
            
            // Обновляем преимущества
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
            
            // Обновляем селекты валют
            const selectDisplays = document.querySelectorAll('.custom-select-display');
            selectDisplays.forEach(display => {
                if (display.querySelector('span') && display.querySelector('span').textContent.includes('валюту') || display.querySelector('span').textContent.includes('Currency')) {
                    display.innerHTML = `<span>${t.selectCurrency}</span>`;
                }
            });
            
            // Обновляем кнопку Telegram
            const telegramBtn = document.querySelector('.exchange-button');
            if (telegramBtn) {
                telegramBtn.innerHTML = `
                    <img src="tg.png" alt="Telegram" class="telegram-icon">
                    ${t.telegramBtn}
                `;
            }
            
            // Обновляем форму отзывов
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
            
            // Обновляем футер
            const footerTelegramText = document.getElementById('footer-telegram-text');
            const footerReviewText = document.getElementById('footer-review-text');
            
            if (footerTelegramText) footerTelegramText.textContent = t.footerTelegram;
            if (footerReviewText) footerReviewText.textContent = t.footerReview;
        }
        
        // Функции для модального окна отзывов
        function openReviewModal() {
            document.getElementById('reviewModal').style.display = 'block';
        }
        
        function closeReviewModal() {
            document.getElementById('reviewModal').style.display = 'none';
            document.getElementById('reviewForm').reset();
        }
        
        function submitReview(event) {
            event.preventDefault();
            
            const name = document.getElementById('reviewName').value;
            const telegram = document.getElementById('reviewTelegram').value;
            const review = document.getElementById('reviewText').value;
            
            // Здесь можно добавить отправку данных на сервер
            console.log('Отзыв:', { name, telegram, review });
            
            closeReviewModal();
        }
        
        // Закрытие модального окна при клике вне его
        window.onclick = function(event) {
            const modal = document.getElementById('reviewModal');
            if (event.target === modal) {
                closeReviewModal();
            }
        }

        // Функция для получения данных о криптовалютах и фиатных валютах
        async function fetchCryptoData() {
            try {
                const response = await fetch('api.php');
                const data = await response.json();
                
                if (data.success) {
                    displayCryptoData(data.data);
                    document.getElementById('last-update').textContent = 
                        'Последнее обновление: ' + new Date().toLocaleString('ru-RU');
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

        // Функция для получения иконки криптовалюты
        function getCryptoIcon(symbol) {
            // Извлекаем символ криптовалюты (например, BTC из BTC/USDT)
            const cryptoSymbol = symbol.split('/')[0].toLowerCase();
            
            // Используем более надежный сервис для иконок криптовалют
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
            
            return iconMap[cryptoSymbol] || null;
        }

        // Функция для получения иконки фиатной валюты
        function getFiatIcon(symbol) {
            const fiatSymbol = symbol.split('/')[0].toLowerCase();
            
            // Иконки фиатных валют - используем иконки с Flagpedia
            const fiatIconMap = {
                'rub': 'https://flagpedia.net/data/currency/webp/c32/rub.webp',
                'uah': 'https://flagpedia.net/data/currency/webp/c32/uah.webp',
                'eur': 'https://flagpedia.net/data/currency/webp/c32/eur.webp',
                'usd': 'https://flagpedia.net/data/currency/webp/c32/usd.webp'
            };
            
            return fiatIconMap[fiatSymbol] || null;
        }

        // Функция для получения иконки валюты (универсальная)
        function getCurrencyIcon(symbol, type) {
            if (type === 'crypto') {
                return getCryptoIcon(symbol);
            } else {
                return getFiatIcon(symbol);
            }
        }

        // Функция для отображения данных
        function displayCryptoData(currencies) {
            const container = document.getElementById('crypto-container');
            container.innerHTML = '';

            // Фильтруем только криптовалюты для отображения в курсах
            const cryptoOnly = currencies.filter(currency => currency.type === 'crypto');

            cryptoOnly.forEach(currency => {
                const iconUrl = getCryptoIcon(currency.symbol);
                
                // Подготавливаем данные для отображения
                const changeClass = parseFloat(currency.price_24h_pcnt) >= 0 ? 'positive' : 'negative';
                const changeSymbol = parseFloat(currency.price_24h_pcnt) >= 0 ? '+' : '';
                
                // Форматируем цену
                const priceDisplay = '$' + parseFloat(currency.last_price).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 6});
                
                // Форматируем изменение цены
                let changeDisplayText = '';
                if (currency.price_24h_pcnt !== '0.00') {
                    changeDisplayText = `${changeSymbol}${parseFloat(currency.price_24h_pcnt).toFixed(2)}%`;
                }
                
                // Форматируем мин/макс
                let maxDisplay = '';
                let minDisplay = '';
                if (currency.high_24h && currency.low_24h) {
                    const highPrice = '$' + parseFloat(currency.high_24h).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 4});
                    const lowPrice = '$' + parseFloat(currency.low_24h).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 4});
                    maxDisplay = `Макс: ${highPrice}`;
                    minDisplay = `Мин: ${lowPrice}`;
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

        // Глобальная переменная для хранения курсов
        let currentRates = {};

        // Функция для создания кастомного селекта с иконками
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
                if (iconUrl) {
                    option.innerHTML = `
                        <img src="${iconUrl}" alt="${currency.symbol}" style="width: 20px; height: 20px; border-radius: 50%;" onerror="this.style.display='none'">
                        <span>${currency.symbol}</span>
                    `;
                } else {
                    option.innerHTML = `<span>${currency.symbol}</span>`;
                }
                
                option.addEventListener('click', () => {
                    select.value = currency.symbol;
                    displayDiv.innerHTML = option.innerHTML;
                    dropdown.style.display = 'none';
                    calculateExchange();
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

        // Функция для заполнения селектов валют
        function populateCurrencySelects(currencies) {
            const fromSelect = document.getElementById('fromCurrency');
            const toSelect = document.getElementById('toCurrency');
            
            // Очищаем селекты
            fromSelect.innerHTML = '<option value="">Выберите валюту</option>';
            toSelect.innerHTML = '<option value="">Выберите валюту</option>';
            
            // Заполняем селекты и сохраняем курсы
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
            
            // Создаем кастомные селекты с иконками только один раз
            if (!document.querySelector('.custom-select-wrapper')) {
                createCustomSelect('fromCurrency', currencies);
                createCustomSelect('toCurrency', currencies);
            }
        }

        // Функция для расчета обмена
        function calculateExchange() {
            const fromCurrency = document.getElementById('fromCurrency').value;
            const toCurrency = document.getElementById('toCurrency').value;
            const fromAmount = parseFloat(document.getElementById('fromAmount').value) || 0;
            
            if (!fromCurrency || !toCurrency || fromAmount <= 0) {
                document.getElementById('toAmount').value = '';
                document.getElementById('exchangeInfo').style.display = 'none';
                return;
            }
            
            if (fromCurrency === toCurrency) {
                document.getElementById('toAmount').value = fromAmount.toFixed(6);
                document.getElementById('exchangeInfo').style.display = 'none';
                return;
            }
            
            // Получаем курсы валют
            const fromRateData = currentRates[fromCurrency];
            const toRateData = currentRates[toCurrency];
            
            if (!fromRateData || !toRateData) return;
            
            const fromRate = fromRateData.rate;
            const toRate = toRateData.rate;
            
            // Конвертируем через USD
            let usdAmount;
            if (fromCurrency.includes('/USD')) {
                usdAmount = fromAmount * fromRate;
            } else if (fromCurrency.includes('/USDT')) {
                usdAmount = fromAmount * fromRate;
            } else {
                usdAmount = fromAmount;
            }
            
            let finalAmount;
            if (toCurrency.includes('/USD')) {
                finalAmount = usdAmount / toRate;
            } else if (toCurrency.includes('/USDT')) {
                finalAmount = usdAmount / toRate;
            } else {
                finalAmount = usdAmount;
            }
            
            // Применяем комиссию 1.5%
            const amountAfterCommission = finalAmount * 0.985; // Вычитаем 1.5%
            
            // Обновляем интерфейс
            document.getElementById('toAmount').value = amountAfterCommission.toFixed(6);
            document.getElementById('exchangeRate').textContent = `1 ${fromCurrency} = ${(amountAfterCommission / fromAmount).toFixed(6)} ${toCurrency}`;
            document.getElementById('exchangeInfo').style.display = 'block';
        }

        // Функция для смены валют местами
        function swapCurrencies() {
            const fromSelect = document.getElementById('fromCurrency');
            const toSelect = document.getElementById('toCurrency');
            
            const temp = fromSelect.value;
            fromSelect.value = toSelect.value;
            toSelect.value = temp;
            
            calculateExchange();
        }

        // Функция для выполнения обмена
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

        // Обновляем функцию отображения данных
        const originalDisplayCryptoData = displayCryptoData;
        displayCryptoData = function(currencies) {
            originalDisplayCryptoData(currencies);
            populateCurrencySelects(currencies);
        };

        // Добавляем обработчики событий
        document.getElementById('fromCurrency').addEventListener('change', calculateExchange);
        document.getElementById('toCurrency').addEventListener('change', calculateExchange);

        // Загрузка данных при загрузке страницы
        fetchCryptoData();

        // Обновление каждые 30 секунд
        setInterval(fetchCryptoData, 30000);
    </script>

    <!-- Футер -->
    <footer class="footer">
        <div class="footer-content">
            <img src="logo.png" alt="GoodXchanger" class="footer-logo">
            
            <div class="footer-buttons">
                <a href="https://t.me/Goodxchangermanager" target="_blank" class="footer-btn" id="footer-telegram">
                    <img src="tg.png" alt="Telegram" class="footer-telegram-icon">
                    <span id="footer-telegram-text">Telegram</span>
                </a>
                
                <button class="footer-btn" onclick="openReviewModal()" id="footer-review">
                    <span id="footer-review-text">Оставить отзыв</span>
                </button>
            </div>
        </div>
    </footer>
</body>
</html>