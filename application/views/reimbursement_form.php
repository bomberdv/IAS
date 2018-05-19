
<section class="content">
    <div class="row">
        <div class="col-sm-12">

            <div class="row">
                <div class="col-sm-12" data-offset="0">

                    <div class="wrap-fpanel">
                        <div class="box box-primary" data-collapsed="0">
                            <div class="box-header with-border bg-primary-dark">
                                <h3 class="box-title"><?= lang('reimbursement_form') ?></h3>
                            </div>

                            <!-- View massage -->
                            <?php echo message_box('success'); ?>
                            <?php echo message_box('error'); ?>

                            <div class="panel-body">
                                <?php echo $form->open(); ?>
                                <?php echo $form->messages(); ?>
                                <table class="table table-bordered">

                                    <tr>
                                        <th style="width:150px"><?= lang('date') ?>: </th>
                                        <td>

                                            <div class="input-group">
                                                <input id="datepicker" type="text" name="date" class="form-control" value="<?php if(!empty($reimbursement))  echo date('d-m-Y', strtotime($reimbursement->date));?>">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                            </div>

                                        </td>
                                    </tr>

                                    <tr>
                                        <th><?= lang('amount') ?>: </th>
                                        <td><input type="number" name="amount" class="form-control"></td>
                                    </tr>
                                    <tr>
                                        <th><?= lang('description') ?>: </th>
                                        <td><textarea class="form-control" name="memo" rows="8"></textarea> </td>
                                    </tr>

                                    <tr>
                                        <th></th>
                                        <td> <button type="submit" id="sbtn" name="sbtn" value="1" class="btn bg-olive btn-flat btn-md"><?= lang('submit') ?></button> </td>
                                    </tr>


                                </table>

                                <?php echo $form->close(); ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div></section>


