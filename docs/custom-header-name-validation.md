# Custom header name validation in smtp2go-php 1.3

## Background

Testing the 1.18.0 prerelease on the php84 test site found the following. If a custom header name with a space in it, such as `X Bad Header`, is saved in the plugin settings, **every `wp_mail()` call fatals**:

```
PHP Fatal error: Uncaught InvalidArgumentException: Invalid header name "X Bad Header".
A header name must consist of printable ASCII characters excluding the colon.
in .../build/vendor/smtp2go-oss/smtp2go-php/src/SMTP2GO/Types/Mail/CustomHeader.php:58
#1 .../app/SMTP2GOMailer.php(191): CustomHeader->__construct('X Bad Header', '1')
#2 .../app/SMTP2GOMailer.php(64): SMTP2GOMailer->processCustomHeaders(...)
```

The validation arrived with the smtp2go-php 1.3 update (commit e66a9ba). Neither `master` nor 1.17.1 has it. Any existing install with an invalid header name saved would start fataling on every email after upgrading, with no settings change.

RFC 5322 (§2.2, §3.6.8) limits header field names to printable US-ASCII excluding the colon (`ftext = %d33-57 / %d59-126`). A space, tab, colon or non-ASCII character is invalid.

## Arguments for relaxing the library

- **It's a breaking change in a minor version.** `new CustomHeader()` used to accept any name and can now throw. Under semver that belongs in 2.0, not 1.3. Anyone upgrading the library, not just this plugin, can start crashing with no code changes.
- **The library should be as strict as the API it wraps.** If the API accepts a header name, the client shouldn't reject it before the request is even sent.

## Questions for the API developer

1. What does the API actually do with `X Bad Header`? Pass it through as is, rewrite it, or drop it? A direct curl to `/v3/email/send`, plus the raw source of the delivered email, will show this.
2. If it passes it through, the API is sending mail that breaks RFC 5322, and Gmail or other receivers may reject it or lose the headers that follow it. It may be better for the **API** to validate and return a clear error, or to drop and rename invalid headers. A single rule in the API is better than different rules in each client.
3. How will the fix be released? A 1.3.1 that removes the throw, or turns it into a warning or a skipped header, would be cleanest. The plugin would then update the library and rebuild the scoped copy in `build/vendor` before 1.18.0 goes out.

## Plugin-side changes (planned regardless)

- **We can't rely on a library version.** The plugin ships its own scoped copy, and a future library update could add stricter checks again. A try/catch in `SMTP2GOMailer::processCustomHeaders()` that skips the bad header and logs it means one bad header can never stop every email the site sends.
- **We'd stop saving names that will never work.** A settings error in `WordpressPluginAdmin::cleanCustomHeaderOptions()` is worth adding even if the API accepts these names, since a header with a space in its name isn't valid email.

Both changes are small and don't depend on what the API developer decides.
