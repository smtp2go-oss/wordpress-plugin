require('dotenv').config();

const { test, expect } = require('@wordpress/e2e-test-utils-playwright');

test('Setup SMTP2GO Plugin', async ({ page, admin }) => {
    await admin.visitAdminPage('admin.php', 'page=smtp2go-wordpress-plugin');
    //todo fill in teh api key with process.env.SMTP2GO_API_KEY
    await page.locator('#toplevel_page_wp_file_manager').getByRole('list').getByRole('link', { name: 'WP File Manager' }).click();
    await page.getByRole('button', { name: 'No Thanks' }).click();
    await page.getByText('Code Editor').click();
    await page.getByText('define( \'SMTP2GO_USE_CONSTANTS\', false );').click();
    await page.locator('#edit-elfinder-wp_file_manager-l1_d3AtY29uZmlnLnBocA').getByRole('textbox').press('ArrowRight');
    await page.locator('#edit-elfinder-wp_file_manager-l1_d3AtY29uZmlnLnBocA').getByRole('textbox').press('ArrowRight');
    await page.locator('#edit-elfinder-wp_file_manager-l1_d3AtY29uZmlnLnBocA').getByRole('textbox').press('ArrowRight');
    await page.locator('#edit-elfinder-wp_file_manager-l1_d3AtY29uZmlnLnBocA').getByRole('textbox').press('ArrowRight');
    await page.locator('#edit-elfinder-wp_file_manager-l1_d3AtY29uZmlnLnBocA').getByRole('textbox').press('ArrowRight');
    await page.locator('#edit-elfinder-wp_file_manager-l1_d3AtY29uZmlnLnBocA').getByRole('textbox').press('ArrowRight');
    await page.locator('#edit-elfinder-wp_file_manager-l1_d3AtY29uZmlnLnBocA').getByRole('textbox').press('ArrowRight');
    await page.locator('#edit-elfinder-wp_file_manager-l1_d3AtY29uZmlnLnBocA').getByRole('textbox').press('ArrowRight');
    await page.locator('#edit-elfinder-wp_file_manager-l1_d3AtY29uZmlnLnBocA').getByRole('textbox').press('ArrowRight');
    await page.locator('#edit-elfinder-wp_file_manager-l1_d3AtY29uZmlnLnBocA').getByRole('textbox').press('ArrowRight');
    await page.locator('#edit-elfinder-wp_file_manager-l1_d3AtY29uZmlnLnBocA').getByRole('textbox').press('ArrowRight');
    await page.locator('#edit-elfinder-wp_file_manager-l1_d3AtY29uZmlnLnBocA').getByRole('textbox').press('ArrowRight');
    await page.locator('#edit-elfinder-wp_file_manager-l1_d3AtY29uZmlnLnBocA').getByRole('textbox').press('ArrowRight');
    await page.locator('#edit-elfinder-wp_file_manager-l1_d3AtY29uZmlnLnBocA').getByRole('textbox').press('ArrowLeft');
    await page.locator('#edit-elfinder-wp_file_manager-l1_d3AtY29uZmlnLnBocA').getByRole('textbox').press('Shift+ArrowRight');
    await page.locator('#edit-elfinder-wp_file_manager-l1_d3AtY29uZmlnLnBocA').getByRole('textbox').press('Shift+ArrowRight');
    await page.locator('#edit-elfinder-wp_file_manager-l1_d3AtY29uZmlnLnBocA').getByRole('textbox').press('Shift+ArrowRight');
    await page.locator('#edit-elfinder-wp_file_manager-l1_d3AtY29uZmlnLnBocA').getByRole('textbox').press('Shift+ArrowRight');
    await page.locator('#edit-elfinder-wp_file_manager-l1_d3AtY29uZmlnLnBocA').getByRole('textbox').press('Shift+ArrowRight');
    await page.locator('#edit-elfinder-wp_file_manager-l1_d3AtY29uZmlnLnBocA').getByRole('textbox').fill('true');
    await page.getByRole('button', { name: 'Save & Close' }).click();
    await page.getByRole('link', { name: 'SMTP2GO' }).click();
    await page.getByText('The API key is defined as a').click();

});