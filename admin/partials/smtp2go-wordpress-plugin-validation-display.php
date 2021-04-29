<div class="wrap smtp2go">
<h1>Sender Domain Validation for <?php echo $this_host ?></h1>

<a href="https://support.smtp2go.com/hc/en-gb/articles/115004408567-Sender-Domains">What is Sender Domain Validation?</a>

<?php if (!empty($result->domains)) : ?>

<?php foreach ($result->domains as $domain) : ?>

<pre><?php echo print_r($domain, 1); ?></pre>

<?php endforeach; ?>

<?php else : ?>

<div class="error">Unable to retrieve domain validation information. <strong><?php echo $result->error ?? '' ?></strong></div>
<?php endif ?>

</div>
