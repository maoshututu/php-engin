<?php

namespace Maoshu\Engine;

class Request
{
    /**
     * 获取所有请求参数，包括 GET 和 POST (Raw JSON)
     *
     * @return array
     */
    public static function getParams(): array
    {
        $params = [];
        // 获取 GET 参数
        if (!empty($_GET)) {
            $params = array_merge($params, $_GET);
        }
        // 获取 POST 原始 JSON 数据
        $input = file_get_contents('php://input');
        if (!empty($input)) {
            $postParams = json_decode($input, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $params = array_merge($params, $postParams);
            }
        }
        return $params;
    }

    public static function toJson(array $data): string
    {
        header('Content-Type: application/json');
        return json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
}
