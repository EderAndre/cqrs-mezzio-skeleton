<?php
declare(strict_types = 1);
namespace Com\Incoders\SampleMS\Middleware\Service;

class ApiTools
{

    public function consumeExternalApi($url, $customHeader = null)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        if (!is_null($customHeader)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $customHeader);
        }

        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($result == "" || $httpCode != 200) {
            $result = [];
            $result = json_encode($result);
        }

        curl_close($ch);
        return [
            'content' => json_decode($result, true),
            'httpCode' => $httpCode
        ];
    }
}
