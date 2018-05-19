
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
                                    <tr>
                                        <th><?= lang('approved_by_manager') ?>: </th>
                                        <td><?php echo $reimbursement->approved_manager ?></td>
                                    </tr>
                                    <tr>
                                        <th><?= lang('manager_comment') ?>: </th>
                                        <td><?php echo $reimbursement->manager_comment ?></td>
                                    </tr>
                                    <tr>
                                        <th><?= lang('approved_by_admin') ?>: </th>
                                        <td><?php echo $reimbursement->approved_admin ?></td>
                                    </tr>
                                    <tr>
                                        <th><?= lang('admin_comment') ?>: </th>
                                        <td><?php echo $reimbursement->admin_comment ?></td>
                                    </tr>

                                </table>



                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div></section>


