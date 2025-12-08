const { execSync } = require('child_process');

module.exports = async (config) => {
    // Restore wp-config.php from backup
    execSync('wp-env run tests-cli cp /var/www/html/wp-config-backup.php /var/www/html/wp-config.php');

    // Optionally, remove the backup file
    execSync('wp-env run tests-cli rm /var/www/html/wp-config-backup.php');

};