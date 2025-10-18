<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$cryptoSymbols = [
    'BTCUSDT',
    'ETHUSDT', 
    'BNBUSDT',
    'ADAUSDT',
    'SOLUSDT',
    'XRPUSDT',
    'DOGEUSDT',
    'DOTUSDT'
];

$fiatSymbols = [
    'RUBUSD',
    'UAHUSD', 
    'EURUSD',
    'USDUSD'
];

try {
    $allData = [];
    
    $cryptoUrl = 'https://api.bybit.com/v5/market/tickers?category=spot';
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $cryptoUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 15);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36');
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    
    $cryptoResponse = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($httpCode === 200 && $cryptoResponse) {
        $cryptoData = json_decode($cryptoResponse, true);
        
        if ($cryptoData && $cryptoData['retCode'] === 0) {
            // Фильтруем криптовалюты
            foreach ($cryptoData['result']['list'] as $ticker) {
                if (in_array($ticker['symbol'], $cryptoSymbols)) {
                    $allData[] = [
                        'symbol' => str_replace('USDT', '/USDT', $ticker['symbol']),
                        'last_price' => $ticker['lastPrice'],
                        'price_24h_pcnt' => $ticker['price24hPcnt'],
                        'high_24h' => $ticker['highPrice24h'],
                        'low_24h' => $ticker['lowPrice24h'],
                        'type' => 'crypto'
                    ];
                }
            }
        }
    }
    
    $fiatUrl = 'https://api.exchangerate-api.com/v4/latest/USD';
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $fiatUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36');
    
    $fiatResponse = curl_exec($ch);
    $fiatHttpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($fiatHttpCode === 200 && $fiatResponse) {
        $fiatData = json_decode($fiatResponse, true);
        
        if ($fiatData && isset($fiatData['rates'])) {
            $fiatRates = [
                'RUB/USD' => isset($fiatData['rates']['RUB']) ? 1 / $fiatData['rates']['RUB'] : 0,
                'UAH/USD' => isset($fiatData['rates']['UAH']) ? 1 / $fiatData['rates']['UAH'] : 0,
                'EUR/USD' => isset($fiatData['rates']['EUR']) ? 1 / $fiatData['rates']['EUR'] : 0,
                'USD/USD' => 1.00
            ];
            
            foreach ($fiatRates as $symbol => $rate) {
                if ($rate > 0) {
                    $allData[] = [
                        'symbol' => $symbol,
                        'last_price' => number_format($rate, 6),
                        'price_24h_pcnt' => '0.00',
                        'high_24h' => null,
                        'low_24h' => null,
                        'type' => 'fiat'
                    ];
                }
            }
        }
    }
    
    usort($allData, function($a, $b) use ($cryptoSymbols) {
        if ($a['type'] !== $b['type']) {
            return $a['type'] === 'crypto' ? -1 : 1;
        }
        
        if ($a['type'] === 'crypto') {
            $aPos = array_search(str_replace('/USDT', 'USDT', $a['symbol']), $cryptoSymbols);
            $bPos = array_search(str_replace('/USDT', 'USDT', $b['symbol']), $cryptoSymbols);
            return $aPos - $bPos;
        }
        
        return 0;
    });
    
    echo json_encode([
        'success' => true,
        'data' => $allData,
        'timestamp' => time()
    ]);
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage(),
        'timestamp' => time()
    ]);
}
?>