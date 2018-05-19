<!-- Main content -->
<section class="content">
    <div class="row">
        <!-- /.col -->
        <div class="col-md-12">

            <!-- View massage -->
            <?php echo message_box('success'); ?>
            <?php echo message_box('error'); ?>

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo $title ?></h3>
                    <!-- /.box-tools -->
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="box-body">

                            <div class="mailbox-controls pull-right">
                                <!-- Check all button -->
                                <a href="<?php echo base_url('admin/employee/reimbursementForm') ?>" class="btn bg-green-active"><i class="fa fa-plus" aria-hidden="true"></i> <?= lang('new_reimbursement_form') ?></a>
                                <!-- /.pull-right -->
                            </div>

                            <!-- /.mail-box-messages -->
                        </div>
                    </div>
                </div>
                <!-- /.box-header -->
                <?php
                foreach($crud->css_files as $file): ?>
                    <link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
                <?php endforeach; ?>

                <?php foreach($crud->js_files as $file): ?>
                    <script src="<?php echo $file; ?>"></script>
                <?php endforeach; ?>


                <div class="box-body ">
                    <?php   echo $crud->output; ?>
                </div>
            </div>
            <!-- /. box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>
<!-- /.content -->
