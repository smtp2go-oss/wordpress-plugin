<div class="wrap smtp2go">
    <h1>Sender Domain Validation for <?php echo $this_host ?></h1>
    <div class="notice">
        <p>
            <a target="_blank" href="https://support.smtp2go.com/hc/en-gb/articles/115004408567-Sender-Domains">What is
                Sender Domain Validation?</a>
        </p>
    </div>
    <br />
    <?php if (!empty($result->domains)) : ?>
    <table class="widefat">
        <thead>
            <tr>
                <th><strong>Domain</strong></th>
                <th><strong>Status</strong></th>
                <th><strong>Tracking Domain</strong></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <a target="_blank" title="View this sender domain in your SMTP2GO account" href="https://app.smtp2go.com/settings/sender_domains/#edit/<?php echo $this_host ?>"><?php echo $this_host ?></a>
                </td>
                <td>
                    <span class="smtp2go-domain-status-badge <?php echo $domain_status_good ? 'green' : 'rose' ?>"><?php echo $domain_status_good ? 'Verified' : 'Unverified' ?></span>
                </td>
                <td>
                    <span class="smtp2go-domain-status-badge <?php echo $tracker_status_good ? 'green' : 'grey' ?>"><?php echo $tracker_status_enabled ? 'Enabled' : 'Disabled' ?></span>
                </td>
            </tr>
        </tbody>
    </table>
    <?php else : ?>
    <div class="error">Unable to retrieve domain validation information.
        <strong><?php echo $result->error ?? '' ?></strong></div>
    <?php endif?>
</div>
