<?php

namespace SMTP2GO\App;

use SMTP2GOWPPlugin\SMTP2GO\ApiClient;

class SettingsHelper
{

    private static $fieldToConstantMapping = array(
        'smtp2go_api_key'    => 'SMTP2GO_API_KEY',
        'smtp2go_api_region' => 'SMTP2GO_API_REGION',
    );

    /**
     * Allowed values for the smtp2go_api_region option.
     * Empty string means "use the default global endpoint".
     */

    public static function settingHasDefinedConstant($field)
    {
        if (
            !defined('SMTP2GO_USE_CONSTANTS')
            || defined('SMTP2GO_USE_CONSTANTS') && constant('SMTP2GO_USE_CONSTANTS') === false
        ) {
            return false;
        }

        if (
            isset(static::$fieldToConstantMapping[$field])
            && defined(static::$fieldToConstantMapping[$field])
        ) {
            return true;
        }

        return false;
    }

    public static function getOption($field)
    {
        if (static::settingHasDefinedConstant($field)) {
            return constant(static::$fieldToConstantMapping[$field]);
        }
        return get_option($field);
    }

    /**
     * Resolve the API region to use for outbound requests.
     *
     * Reads the smtp2go_api_region option and runs it through the
     * `smtp2go_api_region` filter so developers can override per-environment
     * (e.g. staging vs production) without touching the database.
     *
     * @return string One of '', 'us', 'eu', 'au'. Empty string = global endpoint.
     */
    public static function getApiRegion(): string
    {
        $region = (string) static::getOption('smtp2go_api_region');
        $region = (string) apply_filters('smtp2go_api_region', $region);

        return in_array($region, ApiClient::VALID_REGIONS, true) ? $region : '';
    }


}
