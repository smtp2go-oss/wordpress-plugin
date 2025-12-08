require('dotenv').config();

const { test, expect } = require('@wordpress/e2e-test-utils-playwright');

test('Update WP Config to use SMTP2GO constants', async ({ page, admin }) => {
    // Example: Write to a file
    const { execSync } = require('child_process');
    execSync('wp-env run tests-cli sed -i "s/\'SMTP2GO_USE_CONSTANTS\', false/\'SMTP2GO_USE_CONSTANTS\', true/g" /var/www/html/wp-config.php');
    execSync('wp-env run tests-cli sed -i "s/\'SMTP2GO_API_KEY\', \'\'/\'SMTP2GO_API_KEY\', \'' + process.env.SMTP2GO_API_KEY + '\'/g" /var/www/html/wp-config.php');
});