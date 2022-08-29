<div class="wrap smtp2go smtp2go-stat-box">

    <?php if (!empty($result->domains)) : ?>
        <table class="smtp2go-validation-table">
            <thead>
                <tr>
                    <th><strong>Domain</strong></th>
                    <th><strong>Status</strong></th>
                    <th><strong>Tracking Domain</strong></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result->domains as $domainItem) :

                    $domain_info            = $domainItem->domain ?? null;
                    $tracker_info           = $domainItem->trackers[0] ?? null;

                    $domain_status_good     = !empty($domain_info) && $domain_info->dkim_verified && $domain_info->rpath_verified;
                    $tracker_status_good    = !empty($tracker_info) && $tracker_info->cname_verified;
                    $tracker_status_enabled = !empty($tracker_info) && $tracker_info->enabled;

                ?>
                    <tr>
                        <td>
                            <a target="_blank" title="View this sender domain in your SMTP2GO account" href="https://app.smtp2go.com/settings/sender_domains/"><?php echo $domain_info->fulldomain ?></a>
                        </td>
                        <td>
                            <span class="smtp2go-domain-status-badge <?php echo $domain_status_good ? 'green' : 'rose' ?>"><?php echo $domain_status_good ? 'Verified' : 'Unverified' ?></span>
                        </td>
                        <td>
                            <span class="smtp2go-domain-status-badge <?php echo $tracker_status_good ? 'green' : 'grey' ?>"><?php echo $tracker_status_enabled ? 'Enabled' : 'Disabled' ?></span>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else : ?>
        <div class="error">Unable to retrieve domain validation information.
            <strong><?php echo $result->error ?? '' ?></strong>
        </div>
    <?php endif ?>


</div>
<div class="smtp2go-validation-help-link">
    <a target="_blank" href="https://support.smtp2go.com/hc/en-gb/articles/115004408567-Sender-Domains">What is
        Verified Senders?</a>
</div>
