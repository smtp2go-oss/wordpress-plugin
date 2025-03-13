
const { test, expect } = require('@wordpress/e2e-test-utils-playwright');
test('Check constants are applied', async ({ page, admin }) => {
    await admin.visitAdminPage('admin.php', 'page=smtp2go-wordpress-plugin','nocache=1');
    await expect(page.getByRole('cell', { name: 'The API key is defined as a' })).toBeVisible({ timeout: 10000 });
});