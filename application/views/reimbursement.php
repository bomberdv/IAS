
<section class="content">
    <div class="row">
        <div class="col-sm-12">

            <div class="row">
                <div class="col-sm-12" data-offset="0">

                    <div class="wrap-fpanel">
                        <div class="box box-primary" data-collapsed="0">
                            <div class="box-header with-border bg-primary-dark">
                                <h3 class="box-title"><?= lang('reimbursement_list') ?></h3>
                            </div>

                            <!-- View massage -->
                            <?php echo message_box('success'); ?>
                            <?php echo message_box('error'); ?>

                            <div class="panel-body">

<!--                               <div class="pull-right">-->
<!--                                   <a href="--><?php //echo base_url()?><!--employee/reimbursement/applicationForm/" class="btn bg-navy btn-md btn-flat">-->
<!--                                       --><?//= lang('new_reimbursement_form') ?><!--</a>-->
<!--                               </div>-->

                                <div class="mailbox-controls pull-right">
                                    <!-- Check all button -->
                                    <a class="btn bg-green-active" href="<?php echo base_url()?>employee/reimbursement/applicationForm/"><i class="fa fa-plus" aria-hidden="true"></i>   <?= lang('new_reimbursement_form') ?></a>
                                    <!-- /.pull-right -->
                                </div>

                                </br>
                                </br>


                                <table id="datatable" class="table" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>

                                        <th><?= lang('date') ?></th>
                                        <th><?= lang('amount') ?></th>
                                        <th><?= lang('description') ?></th>
                                        <th><?= lang('approved_by_manager') ?></th>
                                        <th><?= lang('approved_by_admin') ?></th>

                                        <th><?= lang('actions') ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if(!empty($reimbursements)) { foreach($reimbursements as $item){ ?>
                                        <tr>

                                            <td><?php echo date(get_option('date_format'), strtotime($item->date)) ?></td>
                                            <td><?php echo $item->amount ?></td>
                                            <td><?php echo substr($item->memo, 0, 150).'--'; ?></td>
                                            <td>
                                                <?php
                                                    if($item->approved_manager == 'Pending'){
                                                        echo '<small class="label bg-yellow">'. lang('pending').'</small>';
                                                    }elseif($item->approved_manager == 'Reject'){
                                                        echo '<small class="label bg-red">'. lang('reject').'</small>';
                                                    }else{
                                                        echo '<small class="label bg-success">'. lang('approved').'</small>';
                                                    }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                if($item->approved_admin == 'Pending'){
                                                    echo '<small class="label bg-yellow">'. lang('pending').'</small>';
                                                }elseif($item->approved_admin == 'Reject'){
                                                    echo '<small class="label bg-red">'. lang('reject').'</small>';
                                                }else{
                                                    echo '<small class="label bg-success">'. lang('approved').'</small>';
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <div class="btn-group">

                                                    <a class="btn btn-xs btn-default" href="<?php echo site_url('employee/reimbursement/view/'. my_encode($item->id))?>" ><i class="glyphicon glyphicon-eye-open"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php } } ?>
                                    </tbody>
                                </table>



                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div></section>
