
<?php echo message_box('success'); ?>
<?php echo message_box('error'); ?>


<div class="row">
    <div class="col-sm-12">

        <div class="row">
            <div class="col-sm-12" data-offset="0">
                <div class="wrap-fpanel">
                    <div class="box box-primary" data-collapsed="0">
                        <div class="box-header with-border bg-primary-dark">
                            <h3 class="box-title"><?= lang('monthly_salary_generate') ?></h3>
                        </div>
                        <div class="panel-body">





                                <div class="panel_controls" id="payRoll">
                                    <?php echo form_open('admin/payroll/save_batch_employee_payslip') ?>
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th><input id="checkAll" type="checkbox"></th>
                                            <th><?= lang('employee_id');?></th>
                                            <th><?= lang('name') ?></th>
                                            <th><?= lang('job_title') ?></th>
                                            <th><?= lang('gross_salary') ?></th>
                                            <th><?= lang('deduction') ?></th>
                                            <th><?= lang('net_salary') ?></th>
                                            <th><?= lang('fine_deduction') ?></th>
                                            <th><?= lang('bonus') ?></th>
                                            <th><?= lang('payment_method') ?></th>
                                            <th><?= lang('note') ?></th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        <?php $i = 0; ?>
                                        <?php if(!empty($employees)){ foreach ($employees as $item){ ?>
                                            <?php if($item->salary_id == '') continue; ?>

                                        <tr>
                                            <td><input id="checkItem" name="sl[]" type="checkbox" value="<?= $i ?>"></td>
                                            <input type="hidden" name="employee_id[]" value="<?php echo $item->id ?>">
                                            <td><?= $item->employee_id ?></td>
                                            <td><?= $item->first_name.' '.$item->last_name ?></td>
                                            <td><?= $item->job_title ?></td>
                                            <td><?php echo $this->localization->currencyFormat($item->total_payable + $item->total_deduction) ?></td>
                                            <td><?php echo $this->localization->currencyFormat($item->total_deduction) ?></td>
                                            <td><?php echo $this->localization->currencyFormat($item->total_payable) ?></td>
                                            <td><input type="text" class="form-control" name="fine[]" ></td>
                                            <td><input type="text" class="form-control" name="bonus[]"></td>
                                            <td>
                                                <select class="form-control" name="payment_method[]">
                                                    <option value=""><?= lang('please_select') ?>...</option>
                                                    <option value="<?= lang('cash') ?>"><?= lang('cash') ?></option>
                                                    <option value="<?= lang('check') ?>"><?= lang('check') ?></option>
                                                    <option value="<?= lang('electronic_transfer') ?>"><?= lang('electronic_transfer') ?></option>
                                                </select>
                                            </td>
                                            <td><input type="text" class="form-control" name="note[]"></td>

                                        </tr>
                                        <?php $i++ ; }; } ?>


                                        <tr>
                                            <td colspan="8"></td>
                                            <td colspan="3">
                                                <button class="btn btn-primary btn-block" type="submit" id="sbtn" name="sbtn"  value="1"><i class="fa fa-save"></i> <?= lang('save').' '.lang('salary') ?></button>

                                            </td>
                                        </tr>

                                        </tbody>

                                    </table>
                                    <input type="hidden" name="month" value="<?php echo $month ?>">
                                    <input type="hidden" name="department_id" value="<?php echo $department ?>">
                                    <?php echo form_close() ?>
                                </div>

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

    <script type="text/javascript">
        $("#checkAll").click(function () {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });

        $(function(){
            $('#payRoll input:checkbox').attr('checked', 'checked');
        });
    </script>
