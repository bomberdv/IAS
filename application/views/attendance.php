<style>
    .dataTables_filter {
        display: none;
    }
    .dataTables_info{
        display: none;
    }
</style>
<style type="text/css" media="print">
    @page { size: landscape; }
</style>
<?php echo message_box('success'); ?>
<?php echo message_box('error'); ?>

<?php if (!empty($period)): ?>
    <div class="row">
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border bg-primary-dark">
                    <h3 class="box-title"><?= lang('attendance_report') ?></h3>
<!--                    <div class="box-tools" style="padding-top: 5px">-->
<!--                        <div class="input-group input-group-sm">-->
<!--                            <a id="printButton" class="btn btn-default"><i class="fa fa-print"></i> --><?//= lang('print') ?><!--</a>-->
<!--                        </div>-->
<!--                    </div>-->
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <?php echo form_open('employee/home/attendance', $attribute= array('class'=>'form-inline'))?>
                    <div class="row">
                        <div class="col-sm-1">
                            <label><?= lang('year') ?> </label>
                        </div>
                        <div class="col-sm-4">
                            <div class="input-group">

                                <input type="text" id="year" class="form-control years input-lg" name="year" value="<?php echo $year; ?>">
                                <span class="input-group-btn">
                                        <button type="submit" class="btn bg-olive" type="button"><?= lang('go') ?>!</button>
                                      </span>
                            </div><!-- /input-group -->

                        </div>
                    </div>
                    <?php echo form_close() ?>
                    <br/>


                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="print-attendance">

                                <link href="<?php echo base_url(); ?>assets/css/AdminLTE.css" media="print" rel="stylesheet" type="text/css"  />
                                <link href="<?php echo base_url(); ?>assets/css/bootstrap/css/bootstrap.css" media="print" rel="stylesheet" type="text/css" />

                                <div class="table-responsive">
                                <table class="table table-bordered cart-buttons" width="100%">
                                    <thead>
                                    <tr>
                                        <th class="active" colspan="32"><?php echo $employee->first_name.' '.$employee->last_name?></th>
                                    </tr>

                                    </thead>

                                    <tbody>

                                    <?php foreach ($period as $item){ ?>
                                        <tr>
                                            <?php $date = $item->format("Y-m") ?>
                                            <td rowspan="2" valign="middle"><strong><?= $date ?></strong></td>

                                            <?php foreach ($dateSl[$date] as $item){?>
                                                <td><?= $item ?></td>
                                            <?php } ?>
                                        </tr>

                                        <tr>
                                            <?php foreach ($attendance[$date] as $item){?>
                                                <td>
                                                    <?php
                                                    if ($item[0]->attendance_status == 1) {
                                                        echo '<small class="label bg-olive">P</small>';
                                                    }if ($item[0]->attendance_status == '0') {
                                                        echo '<small class="label bg-red">A</small>';
                                                    }if($item[0]->attendance_status == '3'){
                                                        echo '<small class="label bg-yellow">L</small>';
                                                    }if ($item[0]->attendance_status == 'H') {
                                                        echo '<small class="label btn-default">H</small>';
                                                    }
                                                    ?>
                                                </td>
                                            <?php } ?>
                                        </tr>
                                    <?php } ?>

                                    </tbody>
                                </table>

                                </div>
                            </div>


                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

<?php endif ?>

<script>
    $(document).ready(function(){
        $("#printButton").click(function(){
            var mode = 'iframe'; // popup
            var close = mode == "popup";
            var options = { mode : mode, popClose : close};
            $("div.print-attendance").printArea( options );
        });
    });

</script>