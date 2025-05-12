<?php

namespace SMTP2GO\App\Migrations;

require_once(ABSPATH.'wp-admin/includes/upgrade.php');


final class CreateApiLogsTable
{

    public static function run()
    {
        global $wpdb;

        $table = $wpdb->prefix . 'smtp2go_api_logs';

        if (!empty($wpdb->get_results("SHOW TABLES LIKE '$table'"))) {
            return;
        }

        $charsetCollate = $wpdb->get_charset_collate();
        $sql = "CREATE TABLE $table (
            `id` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
            `site_id` INT UNSIGNED NULL,
            `to` VARCHAR(255),
            `from` VARCHAR(255),
            `subject` VARCHAR(255) NULL,
            `response` LONGTEXT NULL,
            `created_at` TIMESTAMP NULL
        ) $charsetCollate;";

        \dbDelta($sql);
    }
}
