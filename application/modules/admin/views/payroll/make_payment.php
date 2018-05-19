
<?php echo message_box('success'); ?>
<?php echo message_box('error'); ?>


<div class="row">
    <div class="col-sm-12">

        <div class="row">
            <div class="col-sm-12" data-offset="0">
                <div class="wrap-fpanel">
                    <div class="box box-primary" data-collapsed="0">
                        <div class="box-header with-border bg-primary-dark">
                            <h3 class="box-title"><?= lang('make_payment') ?></h3>
                        </div>


                        <div class="panel-body">

                                <?php echo $form->open() ?>



                                <div class="panel_controls">

                                    <div class="row">
                                        <div class="well well-lg col-md-7 col-md-push-2">
                                            <?php if($type == 'Monthly'){ ?>
                                                <h3><?= lang('monthly_salary') ?></h3>
                                            <?php }else{ ?>
                                                <h3><?= lang('hourly_salary') ?></h3>
                                                <div style="background-color: #ffd2bc; padding: 15px">
                                                    <?= lang('hourly_payment_attention') ?>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>



                                        <div class="form-group">
                                            <label for="field-1" class="col-sm-3 control-label"><?= lang('month') ?> </label>
                                            <div style="padding-top: 5px">
                                                <span class="label label-success" style="font-size: 15px"><?php echo $month ?></span>
                                            </div>
                                        </div>

                                    <?php if($type == 'Hourly'){ ?>

                                        <div class="form-group">
                                            <label for="field-1" class="col-sm-3 control-label"><?= lang('date_range') ?> <span class="required" aria-required="true">*</span></label>
                                            <div class="col-sm-6" style="padding-top: 5px">
                                                <div class="input-group">
                                                    <input type="text" name="date_range" class="form-control reservation" value="<?php
                                                    if (!empty($payroll)) {
                                                        echo $payroll->date_range;
                                                    }
                                                    ?>" required >
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>


                                    <div class="form-group">
                                        <label for="field-1" class="col-sm-3 control-label"><?= lang('employee') ?></label>

                                        <div class="col-sm-2" style="padding-top: 5px">
                                            <?php echo $employee->first_name.' '.$employee->last_name ?>
                                        </div>

                                        <label class="col-sm-2 control-label" style="text-align: right"><?= lang('employee_id') ?> </label>

                                        <div class="col-sm-3" style="padding-top: 5px">
                                            <?php echo $employee->employee_id ?>
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <label for="field-1" class="col-sm-3 control-label"><?= lang('department') ?></label>

                                        <div class="col-sm-2" style="padding-top: 5px">
                                            <?php echo $department->department ?>
                                        </div>

                                        <label class="col-sm-2 control-label" style="text-align: right"><?= lang('job_title') ?> </label>

                                        <div class="col-sm-3" style="padding-top: 5px">
                                            <?php echo $employee->job_title ?>
                                        </div>

                                    </div>

                                    <?php if($type == 'Monthly'){ ?>

                                    <div class="form-group">
                                        <label for="field-1" class="col-sm-3 control-label"><?= lang('gross_salary') ?></label>

                                        <div class="col-sm-2" style="padding-top: 5px">
                                            <input type="text" value=" <?php echo $this->localization->currencyFormat($salary->total_payable + $salary->total_deduction) ?>" class="form-control" disabled>
                                        </div>

                                        <label class="col-sm-2 control-label" style="text-align: right"><?= lang('deduction') ?> </label>

                                        <div class="col-sm-2" style="padding-top: 5px">
                                            <input type="text" value=" <?php echo $this->localization->currencyFormat($salary->total_deduction) ?>" class="form-control" disabled>
                                        </div>

                                    </div>


                                    <div class="form-group margin">
                                        <label class="col-sm-3 control-label">UTM</label>

                                        <div class="col-sm-6">
                                            <input type="text" value=" <?php echo $this->localization->currencyFormat((($salary->total_payable*(0.7/100)*21)/21)*$masuk->bnyk) ?>" class="form-control"  disabled>
                                        </div>
                                    </div>

                                    <div class="form-group margin">
                                        <label class="col-sm-3 control-label"><?= lang('net_salary') ?> </label>

                                        <div class="col-sm-6">
                                            <input type="text" value=" <?php echo $this->localization->currencyFormat($salary->total_payable) ?>" class="form-control"  disabled>
                                        </div>
                                    </div>
                                    <?php }else{ ?>
                                        <div class="form-group">
                                            <label for="field-1" class="col-sm-3 control-label"><?= lang('hourly_salary') ?></label>

                                            <div class="col-sm-2" style="padding-top: 5px">
                                                <input type="text" value=" <?php echo $this->localization->currencyFormat($salary->hourly_salary) ?>" class="form-control" disabled>
                                            </div>

                                            <label class="col-sm-2 control-label" style="text-align: right"><?= lang('total_hour') ?> <span class="required" aria-required="true">*</span></label>

                                            <div class="col-sm-2" style="padding-top: 5px">
                                                <input type="text" name="total_hour" value=" <?php if(!empty($payroll->total_hour))echo $payroll->total_hour ?>" class="form-control" id="total_hour" required>
                                            </div>

                                        </div>



                                        <div class="form-group margin">
                                            <label class="col-sm-3 control-label"><?= lang('net_salary') ?> </label>

                                            <div class="col-sm-6">
                                                <input type="text" id="total_net_salary" value="<?php if(!empty($payroll->net_salary)) echo $this->localization->currencyFormat($payroll->net_salary) ?>" class="form-control"  disabled>
                                            </div>
                                        </div>
                                    <?php }?>



                                    <?php if(!empty($award)): $totalAward = 0; foreach($award as $item ): ?>

                                        <?php if ($item->award_amount == '0.00') { // skip even members
                                            continue;
                                        } ?>

                                        <div class="form-group margin">
                                            <label class="col-sm-3 control-label"><?= lang('award') ?> </label>

                                            <div class="col-sm-6">
                                                <input type="text" value=" <?php echo $this->localization->currencyFormat($item->award_amount) ?>" class="form-control" disabled>
                                                <span style="font-size: small"><?= $item->award_name ?></span>
                                            </div>
                                        </div>
                                        <?php $totalAward += $item->award_amount ?>

                                    <?php endforeach; endif ?>

                                    <?php if($type == 'Monthly'){
                                        if(!empty($totalAward)){
                                        $totalPayable =  $totalAward + $salary->total_payable;
                                        }else{
                                            if(!empty($payroll->net_salary)){
                                                $totalPayable = $payroll->net_salary;
                                            }else{
                                                $totalPayable = $salary->total_payable;
                                            }

                                        }
                                    }else{

                                        if(!empty($totalAward)){
                                            $totalPayable =  $totalAward + 0;
                                            $award =  $totalAward;
                                        }else{
                                            $totalPayable = 0;
                                        }

                                     } ?>

<!--                                    --><?php
//                                    if(!empty($totalAward)){
//                                        $totalPayable =  $totalAward + $salary->total_payable;
//                                    }else{
//                                        $totalPayable = $payroll->net_salary;
//                                    }
                                    $totalPayable += ((($salary->total_payable*(0.7/100)*21)/21)*$masuk->bnyk);
//                                    ?>

                                    <?php if($type == 'Monthly'){ ?>
                                    <input type="hidden" value=" <?php echo $totalPayable ?>"  id="net_salary">
                                    <?php }else{ ?>
                                        <input type="hidden" value=" <?php echo $totalPayable ?>"  id="net_salary">
                                        <input type="hidden" value=" <?php if(!empty($award))echo $award ?>"  id="award">
                                        <input type="hidden" value=" <?php echo $salary->hourly_salary ?>"  id="hourly_salary">
                                    <?php } ?>

                                    <div class="form-group margin">
                                        <label class="col-sm-3 control-label"><?= lang('fine_deduction') ?> </label>

                                        <div class="col-sm-6">
                                            <input type="text" value="<?php if(!empty($payroll)) echo $this->localization->currencyFormat($payroll->fine_deduction) ?>" class="form-control" name="fine_deduction" id="fine_deduction">
                                        </div>
                                    </div>

                                    <div class="form-group margin">
                                        <label class="col-sm-3 control-label"><?= lang('bonus') ?> </label>

                                        <div class="col-sm-6">
                                            <input type="text" value="<?php if(!empty($payroll)) echo $this->localization->currencyFormat($payroll->bonus) ?>" class="form-control" name="bonus" id="bonus">
                                        </div>
                                    </div>

                                    <div class="form-group margin">
                                        <label class="col-sm-3 control-label"><?= lang('payment_amount') ?> </label>

                                        <div class="col-sm-6">
                                            <input type="text" value="<?php if(!empty($payroll)){ echo $this->localization->currencyFormat(((($salary->total_payable*(0.7/100)*21)/21)*$masuk->bnyk)+$payroll->net_payment); }else{ echo $this->localization->currencyFormat($totalPayable); }  ?>" class="form-control" id="payment_amount" name="payment_amount" disabled>
                                        </div>
                                    </div>

                                    <div class="form-group margin">
                                        <label class="col-sm-3 control-label"><?= lang('payment_method') ?> </label>

                                        <div class="col-sm-6">
                                            <select class="form-control select2" name="payment_method">
                                                <option value=""><?= lang('please_select') ?>...</option>
                                                <option value="<?= lang('cash') ?>" <?php if(!empty($payroll)) echo $payroll->payment_method == lang('cash')? 'selected':''?>><?= lang('cash') ?></option>
                                                <option value="<?= lang('check') ?>" <?php if(!empty($payroll)) echo $payroll->payment_method == lang('check')? 'selected':''?>><?= lang('check') ?></option>
                                                <option value="<?= lang('electronic_transfer') ?>" <?php if(!empty($payroll)) echo $payroll->payment_method == lang('electronic_transfer')? 'selected':''?>><?= lang('electronic_transfer') ?></option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group margin">
                                        <label class="col-sm-3 control-label"><?= lang('comment') ?> </label>

                                        <div class="col-sm-6">
                                            <input type="text" value="<?php if(!empty($payroll)) echo $payroll->note ?>" name="note" class="form-control">
                                        </div>
                                    </div>

                                    <input type="hidden" name="employee_id" value="<?php echo my_encode($employee->id) ?>" >
                                    <input type="hidden" name="month" value="<?php echo my_encode($month) ?>">
                                    <input type="hidden" name="payroll_id" value="<?php if(!empty($payroll->id))echo my_encode($payroll->id) ?>">

                                    <div class="form-group">
                                        <div class="col-sm-offset-3 col-sm-5">
                                            <button class="btn btn-primary" type="submit" id="sbtn" name="sbtn"  value="1"><i class="fa fa-save"></i> <?= lang('save').' '.lang('salary') ?></button>
                                        </div>
                                    </div>
                                </div>
                           <?php echo $form->close() ?>







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

    $(function () {

        $('.reservation').daterangepicker();
        //Date range picker with time picker

    });
</script>

    <?php if($type == 'Monthly'){ ?>
    <script type="text/javascript">
        $(document).on("change", function() {
            var fine = 0;
            var bonus = 0;
            fine = $("#fine_deduction").val();
            bonus = $("#bonus").val();
            var net_salary = $("#net_salary").val();
            var total =  net_salary - fine + + bonus;
            $("#payment_amount").val(total);
        });
    </script>
    <?php }else{ ?>

        <script type="text/javascript">
            $(document).on("change", function() {
                var fine = 0;
                var bonus = 0;
                var total_hour = $("#total_hour").val();
                var hourly_salary = $("#hourly_salary").val();
                var award = $("#award").val();
                var total_net_salary = total_hour*hourly_salary + + award;

                $("#total_net_salary").val(total_net_salary);


                fine = $("#fine_deduction").val();
                bonus = $("#bonus").val();
                //var net_salary = $("#net_salary").val();
                var total =  total_net_salary - fine + + bonus;
                $("#payment_amount").val(total);
            });
        </script>

    <?php } ?>
