
<?php echo message_box('success'); ?>
<?php echo message_box('error'); ?>


<div class="row">
    <div class="col-sm-12">

        <div class="row">
            <div class="col-sm-12" data-offset="0">
                <div class="wrap-fpanel">
                    <div class="box box-primary" data-collapsed="0">
                        <div class="box-header with-border bg-primary-dark">
                            <h3 class="box-title"><?= lang('salary_list') ?></h3>
                        </div>
                        <div class="panel-body">

                            <?php if(!empty($payroll_list)){ ?>
                                <table id="datatable" class="table table-striped table-bordered datatable-buttons">
                                    <thead ><!-- Table head -->
                                    <tr>
                                        <th><?= lang('month') ?></th>
                                        <th><?= lang('employee_id') ?></th>
                                        <th><?= lang('employee_name') ?></th>
                                        <th><?= lang('job_title') ?></th>
                                        <th><?= lang('gross_salary') ?> / <br><?= lang('hourly_salary'); ?></th>
                                        <th><?= lang('payment_amount') ?></th>
                                        <th><?= lang('type') ?></th>
                                        <th style="width:125px;"><?= lang('actions') ?></th>

                                    </tr>
                                    </thead><!-- / Table head -->
                                    <tbody><!-- / Table body -->

                                    <?php foreach ($payroll_list as $item) : ?>
                                    <tr class="custom-tr">
                                        <td class="vertical-td">
                                            <?php echo date("F, Y", strtotime($item->month));  ?>
                                            <?php if($item->type == 'Hourly'){ ?>
                                                <small>(<?php echo $item->date_range ?>)</small>
                                            <?php } ?>
                                        </td>
                                        <td class="vertical-td"><?php echo $item->termination == 0 ? '<span class="label bg-red">'.$item->employee_id .'</span>':$item->employee_id ?></td>
                                        <td class="vertical-td"><?php echo $item->first_name. $item->last_name ?></td>

                                        <td class="vertical-td"><?php echo $item->job_title ?></td>
                                        <?php if($item->type == 'Monthly'){ ?>
                                            <td class="vertical-td"><?php echo $this->localization->currencyFormat($item->gross_salary) ?></td>
                                        <?php }else{ ?>
                                            <td class="vertical-td"><?php echo $this->localization->currencyFormat($item->gross_salary) ?> x <?php echo $item->total_hour ?><small> (<?= lang('hour') ?>)</small></td>
                                        <?php } ?>

                                        <td class="vertical-td"><?php echo $this->localization->currencyFormat($item->net_payment) ?></td>

                                        <td class="vertical-td"><?php echo $item->type;  ?></td>

                                        <td class="vertical-td">

                                            <div class="btn-group">

                                                <div class="btn-group">
                                                    <a class="btn btn-xs btn-default" href="<?php echo base_url().'employee/payroll/view/'. my_encode($item->id) ?>"><i class="fa fa-eye"></i></a>
                                                </div>
                                            </div>
                                        </td>

                                    </tr>
                                    <?php endforeach;  ?><!--get all sub category if not this empty-->

                                    </tbody><!-- / Table body -->
                                </table> <!-- / Table -->

                            <?php } ?>





                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(function() {
            $('#date').datepicker({
                autoclose: true,
                format: "yyyy-mm-dd",
            });
        });
    </script>
