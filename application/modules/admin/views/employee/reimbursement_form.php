
<div class="row">
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border bg-primary-dark">
                <h3 class="box-title"><?= lang('new_reimbursement_form') ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php echo $form->open(); ?>

            <div class="panel-body">
                <!-- View massage -->
                <?php echo $form->messages(); ?>
                <div class="panel_controls">
                    <div class="form-group margin">
                        <label class="col-sm-2 control-label"><?= lang('date') ?><span class="required">*</span></label>

                        <div class="col-sm-7">
                            <div class="input-group">
                                <input id="datepicker" type="text" name="date" class="form-control input-lg" value="<?php if(!empty($reimbursement))  echo date('m/d/Y', strtotime($reimbursement->date));?>">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="field-1" class="col-sm-2 control-label"><?= lang('department') ?> <span class="required">*</span></label>

                        <div class="col-sm-7">
                            <select name="department_id" id="department" class="form-control input-lg" onchange="get_employee(this.value)">
                                <option value="" ><?= lang('select_department') ?>...</option>
                                <?php foreach ($all_department as $v_department) : ?>
                                    <option value="<?php echo $v_department->id ?>" <?php if(!empty($reimbursement)) echo $reimbursement->department_id == $v_department->id ? 'selected':'' ?>>
                                        <?php echo $v_department->department ?></option>
                                <?php endforeach; ?>

                            </select>
                        </div>
                    </div>



                    <div class="form-group">
                        <label for="field-1" class="col-sm-2 control-label"><?= lang('employee') ?> <span class="required">*</span></label>

                        <div class="col-sm-7">
                            <select class="form-control select2 input-lg" name="employee_id" id="employee" >
                                <option value=""><?= lang('please_select') ?></option>
                                <?php foreach($employee as $item){ ?>
                                    <option value="<?php echo $item->id ?>" <?php if(!empty($reimbursement)) echo $reimbursement->employee_id == $item->id ? 'selected':'' ?>>
                                        <?php echo  $item->first_name.' '.$item->last_name ?>
                                    </option>
                                <?php } ?>

                            </select>
                        </div>
                    </div>


                    <div class="form-group margin">
                        <label class="col-sm-2 control-label"><?= lang('amount') ?><span class="required">*</span></label>

                        <div class="col-sm-7">
                            <input type="number" class="form-control input-lg" name="amount" value="<?php if(!empty($reimbursement)) echo $reimbursement->amount ?>">
                        </div>
                    </div>

                    <div class="form-group margin">
                        <label class="col-sm-2 control-label"><?= lang('description') ?><span class="required">*</span></label>

                        <div class="col-sm-7">
                            <textarea class="form-control input-lg" rows="8" name="memo"><?php if(!empty($reimbursement)) echo $reimbursement->memo ?></textarea>
                        </div>
                    </div>

                    <?php if($reimbursement){ ?>

                    <div class="form-group margin">
                        <label class="col-sm-2 control-label"><?= lang('approved_by_manager') ?></label>

                        <div class="col-sm-7">
                            <input type="text" class="form-control input-lg" value="<?php if(!empty($reimbursement)) echo $reimbursement->approved_manager ?>" readonly>
                        </div>
                    </div>

                    <div class="form-group margin">
                        <label class="col-sm-2 control-label"><?= lang('manager_comment') ?></label>

                        <div class="col-sm-7" style="margin-top: 5px">
                            <?php if(!empty($reimbursement)) echo $reimbursement->manager_comment ?>
                        </div>
                    </div>

                    <div class="form-group margin">
                        <label class="col-sm-2 control-label"><?= lang('approved_by_admin') ?></label>

                        <div class="col-sm-7">
                            <select class="form-control input-lg" name="approved_admin">
                                <option value="Pending"  <?php echo $reimbursement->approved_admin == 'Pending'? 'selected':'' ?>>Pending</option>
                                <option value="Approved" <?php echo $reimbursement->approved_admin == 'Approved'? 'selected':'' ?>>Approved</option>
                                <option value="Reject"   <?php echo $reimbursement->approved_admin == 'Reject'? 'selected':'' ?>>Reject</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group margin">
                        <label class="col-sm-2 control-label"><?= lang('admin_comment') ?></label>

                        <div class="col-sm-7">
                            <td><textarea class="form-control input-lg" name="admin_comment"><?php if(!empty($reimbursement)) echo $reimbursement->admin_comment ?></textarea></td>
                        </div>
                    </div>
                    <?php } ?>


                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-5" >
<!--                            <button type="submit" id="sbtn" name="sbtn" value="1" class="btn bg-olive btn-flat btn-md">--><?//= lang('submit') ?><!--</button>-->
                            <button class="btn btn-primary" type="submit" id="sbtn" name="sbtn" value="1" ><i class="fa fa-save"></i> <?= lang('save').' '.lang('reimbursement') ?></button>
                        </div>
                    </div>
                </div>

            </div>

            <input type="hidden" name="id" value="<?php if(!empty($reimbursement)) echo $reimbursement->id ?>">
            
            <?php echo $form->close(); ?>

        </div>
        <!-- /.box -->

    </div>
</div>