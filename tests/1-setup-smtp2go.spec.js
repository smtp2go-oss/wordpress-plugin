require('dotenv').config();

const { test, expect } = require('@wordpress/e2e-test-utils-playwright');

test('Setup SMTP2GO Plugin', async ({ page, admin }) => {
  await admin.visitAdminPage('admin.php', 'page=smtp2go-wordpress-plugin');

  await page.locator('input[name="smtp2go_enabled"]').click();
  await page.locator('input[name="smtp2go_api_key"]').fill(process.env.SMTP2GO_API_KEY);

  // await page.getByPlaceholder('john@example.com').click();
  await page.getByPlaceholder('john@example.com').fill('kris@2050.nz');
  await page.getByPlaceholder('John Example').fill('Kris Johansen');

  
  
  await page.getByRole('button', { name: 'Save Settings' }).click();
  await expect(page.getByText('Settings SavedDismiss this')).toBeVisible();
  //Go to the "test" tab
  await page.getByRole('link', { name: 'Test' }).click();
  await page.getByPlaceholder('john@example.com').click();
  await page.getByPlaceholder('john@example.com').fill('kris+recipient@2050.nz');
  await page.getByPlaceholder('john@example.com').press('Tab');
  await page.getByPlaceholder('John Example').fill('Kris Recipient');
  await page.getByRole('button', { name: 'Send Test Email' }).click();
  await page.getByText('Success! The test message was').click();
  await page.getByText('Success! The test message was').click();
  await expect(page.getByText('Success! The test message was')).toBeVisible();
});