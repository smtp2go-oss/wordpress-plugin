// require('dotenv').config();

// const { test, expect } = require('@wordpress/e2e-test-utils-playwright');


// test('Setup woocommerce and place an order', async ({ page, admin }) => {
//   // await page.goto('http://localhost:8888/wp-login.php?redirect_to=http%3A%2F%2Flocalhost%3A8888%2Fwp-admin%2Fadmin.php%3Fpage%3Dwc-admin%26path%3D%252Fsetup-wizard&reauth=1');
//   // await page.getByLabel('Username or Email Address').fill('admin');
//   // await page.getByLabel('Username or Email Address').press('Tab');
//   // await page.getByLabel('Password', { exact: true }).fill('password');
//   // await page.getByLabel('Password', { exact: true }).press('Enter');
//   //page=wc-admin&path=%2Fsetup-wizard
  
//   await admin.visitAdminPage('admin.php', 'page=wc-admin&path=%2Fsetup-wizard');

//   await page.getByRole('button', { name: 'Set up my store' }).click();
//   await page.getByRole('button', { name: 'Continue' }).click();
//   await page.locator('#woocommerce-select-control-0__help svg').click();
//   await page.getByRole('option', { name: 'Clothing and accessories' }).click();
//   await page.getByPlaceholder('wordpress@example.com').click();
//   await page.getByPlaceholder('wordpress@example.com').fill('test@2050.nz');
//   await page.getByRole('button', { name: 'Continue' }).click();
//   await page.locator('#inspector-checkbox-control-2').uncheck();
//   await page.locator('#inspector-checkbox-control-4').uncheck();
//   await page.locator('#inspector-checkbox-control-6').uncheck();
//   await page.locator('div:nth-child(6) > .woocommerce-profiler-plugin-card-top > .components-base-control > .components-base-control__field').click();
//   await page.locator('#inspector-checkbox-control-7').uncheck();
//   await page.locator('#inspector-checkbox-control-5').uncheck();
//   await page.locator('#inspector-checkbox-control-3').uncheck();
//   await page.getByRole('button', { name: 'Continue' }).click();
//   await page.getByRole('button', { name: 'Add your products' }).click();
//   await page.getByRole('menuitem', { name: 'Physical product A tangible' }).click();
//   await page.getByLabel('Product name').fill('Widget');
//   await page.frameLocator('#content_ifr').locator('#tinymce').click();
//   await page.frameLocator('#content_ifr').locator('#tinymce').fill('widget');
//   await page.getByLabel('Regular price ($)').click();
//   await page.getByLabel('Regular price ($)').fill('10');
//   await page.frameLocator('#excerpt_ifr').getByRole('paragraph').click();
//   await page.frameLocator('#excerpt_ifr').locator('#tinymce').fill('short description.');
  
//   await page.getByRole('button', { name: 'Publish', exact: true }).click();
//   await page.locator('#toplevel_page_woocommerce').getByRole('link', { name: 'Settings' }).click();
//   await page.getByRole('link', { name: 'Payments' }).click();
//   await page.getByRole('link', { name: 'The "Cash on delivery" payment method is currently disabled' }).click();
//   await page.getByLabel('Set up the "Cash on delivery').click();

//   await page.getByRole('link', { name: 'http://localhost:8888/?' }).click();
//   await page.getByRole('button', { name: 'Add to cart' }).click();
//   await page.getByRole('link', { name: 'View cart' }).click();
//   await page.getByRole('link', { name: 'Proceed to Checkout' }).click();
//   await page.getByLabel('Email address').click();
//   await page.getByLabel('Email address').press('Meta+a');
//   await page.getByLabel('Email address').fill('test@2050.nz');
//   await page.getByLabel('Email address').press('Tab');
//   await page.getByLabel('First name').fill('Test');
//   await page.getByLabel('First name').press('Tab');
//   await page.getByLabel('Last name').fill('User');
//   await page.getByLabel('Last name').press('Tab');
//   await page.getByLabel('Address', { exact: true }).fill('76a great south road manurewa');
//   await page.getByLabel('Address', { exact: true }).press('Tab');
//   await page.getByLabel('Apartment, suite, etc. (').press('Tab');
//   await page.getByLabel('New Zealand, Country/Region').fill('auckland');
//   await page.getByLabel('Australia, Country/Region').fill('new zealand');
//   await page.getByLabel('City').fill('Auckland');
//   await page.getByLabel('Region (optional)').fill('Manukau City');
//   await page.getByLabel('Region (optional)').press('Tab');
//   await page.getByLabel('Postcode').fill('2012');
//   await page.getByLabel('Postcode').press('Tab');
//   await page.getByLabel('Phone (optional)').fill('1234567');
//   await page.getByText('Cash on delivery').click();
//   await page.getByRole('button', { name: 'Place Order' }).click();
//   await expect(page.getByText('Thank you. Your order has')).toBeVisible();
// });