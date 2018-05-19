
<div class="row">



    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header with-border bg-primary-dark">
                <h3 class="box-title"><?= lang('employee_profile') ?></h3>
            </div>
            <div class="box-body">
				
				<!--<a class="btn bg-navy btn-flat btn-md" href="<?php //echo site_url('employee/profile/employeeDetails/'. str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($employee->id)) ) ?>" ><i class="fa fa-pencil-square-o"></i> Edit Profile </a>-->
                <table class="table table-bordered">
                    <tr>
                        <th style="width:120px"><?= lang('employee_id') ?>: </th>
                        <td><?php echo $employee->employee_id; ?></td>
                    </tr>
                    <tr>
                        <th><?= lang('first_name') ?>: </th>
                        <td><?php echo $employee->first_name; ?></td>
                    </tr>
                    <tr>
                        <th><?= lang('last_name') ?>: </th>
                        <td><?php echo $employee->last_name; ?></td>
                    </tr>
                    <tr>
                        <th><?= lang('department') ?>: </th>
                        <td><?php echo $employee->department_name ?></td>
                    </tr>
                    <tr>
                        <th><?= lang('job_title') ?>: </th>
                        <td><?php echo $employee->job_title_name ?></td>
                    </tr>
                    <tr>
                        <th><?= lang('job_category') ?>: </th>
                        <td><?php echo $employee->category_name ?></td>
                    </tr>
                    <tr>
                        <th><?= lang('status') ?>: </th>
                        <td><?php echo $employee->status_name ?></td>
                    </tr>
                    <tr>
                        <th><?= lang('work_shift') ?>: </th>
                        <td><?php echo $employee->shift_name ?></td>
                    </tr>

                </table>

            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header with-border bg-primary-dark">
                <h3 class="box-title"><?= lang('update_password') ?> </h3>
            </div>
            <div class="box-body">
                <!-- View massage -->
                <?php echo message_box('success'); ?>
                <?php echo message_box('error'); ?>

                <?php echo form_open('employee/profile/reset_password'); ?>
                <div class="form-group">
                    <label><?= lang('password') ?><span class="required">*</span></label>
                    <input type="password" class="form-control" name="password">
                </div>

                <div class="form-group">
                    <label><?= lang('retype_password') ?><span class="required">*</span></label>
                    <input type="password" name="retype_password" class="form-control" >
                </div>
                <button id="saveSalary" type="submit" class="btn bg-olive btn-flat"  >
                    <?php echo lang('update_password'); ?>
                </button>
                <?php echo form_close()?>
            </div>
        </div>
    </div>

</div>