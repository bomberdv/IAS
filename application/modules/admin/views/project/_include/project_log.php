<!--<h3>--><?//= lang('activity_log') ?><!--</h3>-->
<br/>
<?php if(!empty($logs)){ ?>
    <?php foreach ($logs as $item){ ?>
        - <?= $item->employee ?> [<?= $item->activity ?>] <?= $item->title ?> @ <?= $item->date_time ?> <br/><br/>
    <?php } ?>
<?php } ?>
