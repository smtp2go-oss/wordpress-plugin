<?php

namespace SMTP2GO\App;

use SMTP2GOWPPlugin\SMTP2GO\ApiClient;
use SMTP2GOWPPlugin\SMTP2GO\Service\Mail\Send;

class Logger
{
    public static function logEmail(ApiClient $apiClient, Send $mailSendService)
    {
        if (!get_option('smtp2go_enable_api_logs')) {
            return;
        }

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
}
