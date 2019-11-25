<?php
$bar_width = 580;
?>
<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap smtp2go">

    <?php if (!empty($stats)): ?>
        <div class="smtp2go-stat-box">

        <div class="smtp2go-usage-bar">
        <!-- a bar showing their current billing period's usage -->
        <?php

$progress_bar_width = ($stats->cycle_used / $stats->cycle_max) * $bar_width;
if ($progress_bar_width < 10) {
    $progress_bar_width = 10;
} else if ($progress_bar_width > $bar_width) {
    $progress_bar_width = $bar_width;
}
?>

        <div class="smtp2go-progress-bar" style="width:<?php echo $progress_bar_width; ?>px">

        </div>
        <p><?php echo $stats->cycle_used ?> / <?php echo $stats->cycle_max ?></p>
        </div>
        <p>Emails Sent This Billing Month. Resets <?php echo date('F jS', strtotime($stats->cycle_end)); ?>.</p>

        </div>
        <div class="smtp2go-spam-rate smtp2go-stat-box">
        <?php $spam_stat = $this->spamRating($stats->spam_percent);?>
            <div class="smtp2go-stat-box-top-row">
            <h3><?php echo $stats->spam_percent ?><sup>%</sup></h3>
            <div class="stat-badge <?php echo $spam_stat['css_class'] ?>"><?php echo $spam_stat['label']; ?></div>
            </div>
            <h5><?php echo __('SPAM RATE') ?></h5>

        </div>
        
        <div class="smtp2go-bounce-rate smtp2go-stat-box">
        <?php $bounce_stat = $this->bounceRating($stats->bounce_percent);?>
        <div class="smtp2go-stat-box-top-row">

            <h3><?php echo $stats->bounce_percent ?><sup>%</sup></h3>
            <div class="stat-badge <?php echo $bounce_stat['css_class'] ?>"><?php echo $bounce_stat['label']; ?></div>
        </div>
        <h5><?php echo __('BOUNCE RATE') ?></h5>

       </div>
        <!--
        //a visual representation of their bounce rate and spam rate
        //Tag the bounce rate and spam rate as either Poor, Fair or Good depending on their values as shown in the tables on this page:
        https://support.smtp2go.com/hc/en-gb/articles/223087727-Bounce-Spam-Percentages-and-Ratings
    -->
       <?php else: ?>

    <h3>Unable to retrieve stats. Please wait a minute and try again.</h3>
    <?php endif;?>
</div>