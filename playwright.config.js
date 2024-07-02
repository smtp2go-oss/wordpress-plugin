import { defineConfig, devices } from '@playwright/test';
const baseConfig = require('@wordpress/scripts/config/playwright.config');
// baseConfig.use.headless = false;
export default defineConfig({
  ...baseConfig,
  // Look for test files in the "tests" directory, relative to this configuration file.
  testDir: 'tests',
 
});