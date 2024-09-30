require('dotenv').config();

const { test, expect } = require('@wordpress/e2e-test-utils-playwright');

test('test front end form', async ({ page, admin }) => {
  await admin.visitAdminPage('admin.php', 'page=caldera-forms');

  await page.getByRole('button', { name: 'New Form' }).click();
  await page.getByText('Contact FormFirst NameLast').click();
  await page.getByPlaceholder('Form Name').fill('Test Form');
  await page.getByRole('button', { name: 'Create Form ' }).click();
  await page.getByRole('button', { name: 'Save Form' }).click();
  await admin.visitAdminPage('post-new.php', 'post_type=page'); //http://localhost:8888/wp-admin/post-new.php?post_type=page
  await page.getByLabel('Close', { exact: true }).click();
  await page.getByLabel('Add title').click();
  await page.getByLabel('Add title').fill('Test Contact Page');
  await page.getByLabel('Add block').click();
  await page.getByLabel('Browse all. This will open').click();
  await page.getByRole('option', { name: ' Caldera Form' }).click();
  let selectElement = await page.locator('#inspector-select-control-0');
  await selectElement.selectOption({ label: 'Test Form' });
  await page.getByRole('button', { name: 'Publish', exact: true }).click();
  await page.getByLabel('Editor publish').getByRole('button', { name: 'Publish', exact: true }).click();
  await page.getByText('View Page').nth(0).click();
  const currentUrl = page.url();
  //we want to log out of teh admin area and test the form
  await page.goto('wp-login.php?action=logout');
  await page.getByRole('link', { name: 'log out' }).click();
  await page.goto(currentUrl);
  await page.getByLabel('First Name *').click();
  await page.getByLabel('First Name *').fill('Test');
  await page.getByLabel('First Name *').press('Tab');
  await page.getByLabel('Last Name *').fill('User');
  await page.getByLabel('Last Name *').press('Tab');
  await page.getByLabel('Email Address *').fill('test@user.com');
  await page.getByLabel('Comments / Questions *').click();
  await page.getByLabel('Comments / Questions *').fill('Test message');
  await page.getByRole('button', { name: 'Send Message' }).click();
  await expect(page.getByText('Form has been successfully')).toBeVisible();
});