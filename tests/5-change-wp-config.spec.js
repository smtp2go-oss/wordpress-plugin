require('dotenv').config();

const { test, expect } = require('@wordpress/e2e-test-utils-playwright');

test('Update WP Config to use SMTP2GO constants', async ({ page, admin }) => {
    await admin.visitAdminPage('admin.php', 'page=wp_file_manager');

    await page.getByRole('link', { name: 'WP File Manager' }).first().click();

    await page.getByRole('button', { name: 'No Thanks' }).click();
    await page.getByText('wp-config.php').click({ button: 'right' });
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
    await page.locator('#edit-elfinder-wp_file_manager-l1_d3AtY29uZmlnLnBocA').getByRole('textbox').press('ArrowRight');
    await page.locator('#edit-elfinder-wp_file_manager-l1_d3AtY29uZmlnLnBocA').getByRole('textbox').press('ArrowLeft');
    await page.locator('#edit-elfinder-wp_file_manager-l1_d3AtY29uZmlnLnBocA').getByRole('textbox').press('Shift+ArrowRight');
    await page.locator('#edit-elfinder-wp_file_manager-l1_d3AtY29uZmlnLnBocA').getByRole('textbox').press('Shift+ArrowRight');
    await page.locator('#edit-elfinder-wp_file_manager-l1_d3AtY29uZmlnLnBocA').getByRole('textbox').press('Shift+ArrowRight');
    await page.locator('#edit-elfinder-wp_file_manager-l1_d3AtY29uZmlnLnBocA').getByRole('textbox').press('Shift+ArrowRight');
    await page.locator('#edit-elfinder-wp_file_manager-l1_d3AtY29uZmlnLnBocA').getByRole('textbox').press('Shift+ArrowRight');
    await page.locator('#edit-elfinder-wp_file_manager-l1_d3AtY29uZmlnLnBocA').getByRole('textbox').fill('true');
    await page.getByText('define( \'SMTP2GO_API_KEY\', \'\' );').click();
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
    await page.locator('#edit-elfinder-wp_file_manager-l1_d3AtY29uZmlnLnBocA').getByRole('textbox').fill(process.env.SMTP2GO_API_KEY );
    await page.getByRole('button', { name: 'Save & Close' }).click({ delay: 1000 });
});

