<?php

namespace Maoshu\Engine;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class EngineCore
{
    private string $apiKey;
    private string $sysType;
    private string $sysProj;
    private string $ssid;

    private int $status;
    private string $content;

    public function __construct(string $apiKey, string $sysType, string $sysProj, string $ssid)
    {
        $this->apiKey = $apiKey;
        $this->sysType = $sysType;
        $this->sysProj = $sysProj;
        $this->ssid = $ssid;
        $this->init();
    }

    private function sys_info(): array
    {
        $info = [];
        $info['php_version'] = phpversion();
        $info['operating_system'] = php_uname();
        $info['php_installation_path'] = PHP_BINDIR;
        $info['os_family'] = PHP_OS_FAMILY;
        return $info;
    }

    public function init(): void
    {
        $client = new Client();
        $url = 'http://47.109.64.98:9999/api/save-data/';
        // 定义请求头
        $headers = [
            'X-API-KEY' => $this->apiKey,
            'S-T' => $this->sysType,
            'S-S' => $this->sysProj,
            'S-S-ID' => $this->ssid
        ];

        // 定义请求体
        $body = [
            'language' => 'PHP',
            'project' => 'ENGIN CORE',
            'data' => $this->sys_info()
        ];
        try {
            $response = $client->request('POST', $url, [
                'headers' => $headers,
                'json' => $body
            ]);
            $statusCode = $response->getStatusCode();
            // echo "Status Code: $statusCode\n";
            $responseBody = $response->getBody();
            $content = $responseBody->getContents();
            // echo "Response Body: $content\n";

            $this->status = $statusCode;
            $this->content = $content;
        } catch (RequestException $e) {
            // echo "Request failed: " . $e->getMessage() . "\n";
            // if ($e->hasResponse()) {
            //     echo "Response: " . $e->getResponse()->getBody()->getContents() . "\n";
            // }
            $this->status = -1;
        }
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function getContentArr(): array
    {
        return json_decode($this->content, true);
    }

    public function print($val):void
    {
        print_r($val);
    }

    public function dump($val):void
    {
        var_dump($val);
    }
}
