require('dotenv').config();

const { test, expect } = require('@wordpress/e2e-test-utils-playwright');

test('Send Test Email', async ({ page, admin }) => {
    await admin.visitAdminPage('admin.php', 'page=smtp2go-wordpress-plugin');   
    await page.getByRole('link', { name: 'Test' }).click();
    await page.getByPlaceholder('John Example').fill('Test User');
    await page.getByPlaceholder('john@example.com').fill('test@2050.nz');
    await page.getByRole('button', { name: 'Send Test Email' }).click();
    await expect(page.getByText('Success! The test message was')).toBeVisible();
});