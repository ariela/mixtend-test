<?php
namespace MixtendTest;

/**
 * カレンダーデータ取得クラス
 */
class Calendar {

    /**
     * Loggerインスタンスを保持
     * @var \Monolog\Logger
     */
    private $logger;

    /**
     * HTTPクライアントを保持
     * @var \GuzzleHttp\Client
     */
    private $httpClient;

    /**
     * コンストラクタ
     * @param string $logPath 出力ログパス
     */
    public function __construct(string $logPath) {
        // Logger configuration
        $this->logger = new \Monolog\Logger('Calendar');
        $this->logger->pushHandler(
            new \Monolog\Handler\StreamHandler($logPath, \Monolog\Logger::INFO)
        );

        // HTTP Client configuration
        $headers = ['User-Agent' => 'Mixtend Coding Test'];
        $this->httpClient = new \GuzzleHttp\Client(['headers' => $headers]);
    } 

    /**
     * リクエスト発行
     * @param string $uri リクエスト先URI
     */
    public function sendRequest(string $uri) {
        // @TODO If-Modified-Since対応
        // @TODO キャッシュ対応
        // Request
        $httpResponse = $this->httpClient->request('GET', $uri);
        $this->requestInfoLog($uri, $httpResponse);
        // Json Data Decode
        $body = json_decode($httpResponse->getBody());
        return $body;
    }

    /**
     * レスポンスログ出力
     * @param string $uri リクエスト先URI
     * @param $response レスポンス内容
     */
    private function requestInfoLog(string $uri, $response) {
        // LogOutput
        $this->logger->info(json_encode([
            'url' => $uri,
            'status' => $response->getStatusCode(),
            'headers' => $response->getHeaders(),
        ]));
    }
}
