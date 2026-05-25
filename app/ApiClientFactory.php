<?php

namespace SMTP2GO\App;


use SMTP2GO\App\SettingsHelper;
use SMTP2GO\App\SecureApiKeyHelper;
use SMTP2GOWPPlugin\SMTP2GO\ApiClient;

class ApiClientFactory
{

    /**
     * Create a new SMTP2GO ApiClient instance
     * @return null|ApiClient 
     */
    public static function create()
    {
        $apiKey = SettingsHelper::getOption('smtp2go_api_key');

        
        if (empty($apiKey)) {
            return null;
        }

        $apiKey = (new SecureApiKeyHelper())->decryptKey($apiKey);

        $client = new ApiClient($apiKey);
        if ($region = SettingsHelper::getApiRegion()) {
            $client->setApiRegion($region);
        }

        return $client;
    }
}
