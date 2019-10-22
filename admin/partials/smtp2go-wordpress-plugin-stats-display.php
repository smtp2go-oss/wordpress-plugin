<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap smtp2go">
    <h1><?php _e('SMTP2GO Stats', $this->plugin_name)?></h1>

    <?php if (!empty($stats)): ?>

    <?php foreach ($stats as $label => $value): ?>

    <dl class="smtp2go-datalist">
        <dt><?php echo ucwords(str_replace('_', ' ', $label)) ?></dt>
        <dd><?php echo $value ?></dd>
    </dl>
    <?php endforeach;?>

    <?php else: ?>

    <h3>Unable to retrieve stats. Please wait a minute and try again.</h3>
    <?php endif;?>
</div>