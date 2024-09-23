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
            'request'    => $apiClient->getLastRequest(),
            'response'   => $apiClient->getResponseBody(false),
            'created_at' => current_time('mysql'),
            'updated_at' => current_time('mysql'),
        ];

        global $wpdb;
        $wpdb->insert($wpdb->prefix . 'smtp2go_api_logs', $insertData);

        if ($wpdb->last_error) {
            SMTP2GO_dd('SMTP2GO: Error while logging email: ' . $wpdb->last_error);
        }

        return;
    }
}
