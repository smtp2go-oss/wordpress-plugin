const wpGlobalSetup = require('@wordpress/scripts/config/playwright/global-setup');
const { execSync } = require('child_process');

module.exports = async (config) => {
    // Your setup code BEFORE WordPress setup
    //   execSync('echo "Custom setup before WordPress global setup"');

    // Call the original WordPress global setup
    await wpGlobalSetup(config);

    //make sure we have a backup of wp-config.php since we will be modifying it
    execSync('wp-env run tests-cli cp /var/www/html/wp-config.php /var/www/html/wp-config-backup.php');
};