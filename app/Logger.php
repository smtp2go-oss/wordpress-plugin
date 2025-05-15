<?php

namespace SMTP2GO\App;

use SMTP2GO\App\Migrations\CreateApiLogsTable;
use SMTP2GOWPPlugin\SMTP2GO\ApiClient;
use SMTP2GOWPPlugin\SMTP2GO\Service\Mail\Send;

require_once dirname(__FILE__) . '/migrations/CreateApiLogsTable.php';

class Logger
{
    public static function logEmail(ApiClient $apiClient, Send $mailSendService)
    {
        if (!\SMTP2GO\App\SettingsHelper::getOption('smtp2go_enable_api_logs')) {
            return;
        }
        CreateApiLogsTable::run();

        $insertData = [
            'site_id'    => get_current_blog_id(),
            'to'         => json_encode($mailSendService->getRecipients()),
            'from'       => $mailSendService->getSender(),
            'subject'    => $mailSendService->getSubject(),
            'response'   => $apiClient->getResponseBody(false),
            'created_at' => current_time('mysql'),
        ];
        global $wpdb;
        $wpdb->insert($wpdb->prefix . 'smtp2go_api_logs', $insertData);

        if ($wpdb->last_error) {
            error_log('SMTP2GO: Error while logging email: ' . $wpdb->last_error);
        }

        $totalLogs = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}smtp2go_api_logs");
        if ($totalLogs > 5000) {
            $wpdb->query("DELETE FROM `{$wpdb->prefix}smtp2go_api_logs` 
            ORDER BY created_at 
            ASC LIMIT 1");
        }

        return;
    }

    /**
     * Log error messages to debug.log if WP_DEBUG is enabled
     *
     * @param string|array|object $message
     * @return void
     */
    public static function errorLog($message)
    {
        if (!is_string($message) && !is_array($message) && !is_object($message)) {
            return;
        }
        if (defined('WP_DEBUG') && WP_DEBUG === true) {
            $apiKey = \SMTP2GO\App\SettingsHelper::getOption('smtp2go_api_key');
            $keyHelper = new SecureApiKeyHelper();
            $apiKey = $keyHelper->decryptKey($apiKey);

            if (!is_string($message)) {
                $message = print_r($message, true);
            }

            $message = str_replace($apiKey, 'api-' , $message);

            error_log('SMTP2GO: ' . $message);
        }
    }
}
