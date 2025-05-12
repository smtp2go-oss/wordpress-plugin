
const { test, expect } = require('@wordpress/e2e-test-utils-playwright');

test.describe('SMTP2GO Plugin', () => {
    test.beforeEach(async ({ page, admin }) => {
        await admin.visitAdminPage('admin.php', 'page=smtp2go-wordpress-plugin', 'tab=settings&nocache=1');
    });

    test('Check constants are applied', async ({ page, admin }) => {
        //resaving the settings makes the correct content display
        await page.getByRole('button', { name: 'Save Settings' }).click();
        await expect(page.getByText('Settings SavedDismiss this')).toBeVisible();
        await expect(page.getByText('The API key is defined as a')).toBeVisible();
    });
});
