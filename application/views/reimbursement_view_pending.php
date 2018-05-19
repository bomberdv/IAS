
<section class="content">
    <div class="row">
        <div class="col-sm-12">

            <div class="row">
                <div class="col-sm-12" data-offset="0">

                    <div class="wrap-fpanel">
                        <div class="box box-primary" data-collapsed="0">
                            <div class="box-header with-border bg-primary-dark">
                                <h3 class="box-title"><?= lang('reimbursement') ?></h3>
                            </div>

                            <!-- View massage -->
                            <?php echo message_box('success'); ?>
                            <?php echo message_box('error'); ?>

                            <div class="panel-body">

                            <?php echo form_open('employee/reimbursement/update_manager') ?>
                                <table class="table table-bordered">
                                    <tr>
                                        <th style="width:250px"><?= lang('date') ?>: </th>
                                        <td><?php echo date(get_option('date_format'), strtotime($reimbursement->date)) ?></td>
                                    </tr>
                                    <tr>
                                        <th><?= lang('amount') ?>: </th>
                                        <td><?php echo $reimbursement->amount; ?></td>
                                    </tr>
                                    <tr>
                                        <th><?= lang('description') ?>: </th>
                                        <td><?php echo $reimbursement->memo ?></td>
                                    </tr>
                                    <?php echo $reimbursement->approved_manager ?>
                                    <tr>
                                        <th><?= lang('approved_by_manager') ?>: </th>
                                        <td>
                                            <select class="form-control" name="approved_manager">
                                                <option value="Pending"  <?php echo $reimbursement->approved_manager == 'Pending'? 'selected':'' ?>><?= lang('pending') ?></option>
                                                <option value="Approved" <?php echo $reimbursement->approved_manager == 'Approved'? 'selected':'' ?>><?= lang('approved') ?></option>
                                                <option value="Reject"   <?php echo $reimbursement->approved_manager == 'Reject'? 'selected':'' ?>><?= lang('reject') ?></option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th><?= lang('manager_comment') ?>: </th>
                                        <td><textarea class="form-control" name="manager_comment"><?php echo $reimbursement->manager_comment ?></textarea></td>
                                    </tr>
                                    <tr>
                                        <th><?= lang('approved_by_admin') ?>: </th>
                                        <td><?php echo lang($reimbursement->approved_admin); ?></td>
                                    </tr>
                                    <tr>
                                        <th><?= lang('admin_comment') ?>: </th>
                                        <td><?php echo $reimbursement->admin_comment ?></td>
                                    </tr>

                                    <tr>
                                        <th></th>
                                        <td><button type="submit" id="sbtn" name="sbtn" value="1" class="btn bg-olive btn-flat btn-md"><?= lang('update') ?></button></td>
                                    </tr>

                                    <input type="hidden" name="id" value="<?php echo my_encode($reimbursement->id) ?>" >

                                </table>
                            <?php echo form_close()?>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div></section>


