
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
                    <h3 class="box-title">
                        <?= lang('add_new_customer') ?>
                    </h3>
                    <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->

                <?php echo $form->open(); ?>

<!--                --><?php //echo form_open_multipart('admin/product/save_product')?>

                <div class="box-body">

                    <!-- View massage -->
                    <?php echo $form->messages(); ?>
                    <!-- View massage -->
                    <?php echo message_box('success'); ?>
                    <?php echo message_box('error'); ?>

                    <div class="row">
                        <div class="col-md-8 col-sm-12 col-xs-12 col-md-push-1">
                            <div id="msg"></div>
                            <div class="row">
                                <div class="col-md-12">

                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><?= lang('customer_name') ?><span class="required" aria-required="true">*</span></label>
                                                <input type="text" name="name" value="<?php if(!empty($customer->name))echo $customer->name ?>" class="form-control input-lg">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <!-- /.Start Date -->
                                            <div class="form-group form-group-bottom">
                                                <label><?= lang('company_name') ?></label>
                                                <input type="text" name="company_name" class="form-control input-lg" value="<?php if(!empty($customer->company_name))echo $customer->company_name ?>">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <!-- /.Start Date -->
                                            <div class="form-group form-group-bottom">
                                                <label><?= lang('phone') ?></label>
                                                <input type="text" name="phone" class="form-control input-lg" value="<?php if(!empty($customer->phone))echo $customer->phone ?>">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <!-- /.Start Date -->
                                            <div class="form-group form-group-bottom">
                                                <label><?= lang('fax') ?></label>
                                                <input type="text" name="fax" class="form-control input-lg" value="<?php if(!empty($customer->fax))echo $customer->fax ?>">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <!-- /.Start Date -->
                                            <div class="form-group form-group-bottom">
                                                <label><?= lang('email') ?></label>
                                                <input type="text" name="email" class="form-control input-lg" value="<?php if(!empty($customer->email))echo $customer->email ?>">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <!-- /.Start Date -->
                                            <div class="form-group form-group-bottom">
                                                <label><?= lang('website') ?></label>
                                                <input type="text" name="website" class="form-control input-lg" value="<?php if(!empty($customer->website))echo $customer->website ?>">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><?= lang('billing_address') ?></label>
                                                <textarea class="form-control" name="b_address"><?php if(!empty($customer->b_address))echo $customer->b_address ?></textarea>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><?= lang('shipping_address') ?></label>
                                                <textarea class="form-control" name="s_address"><?php if(!empty($customer->s_address))echo $customer->s_address ?></textarea>
                                            </div>
                                        </div>



                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label><?= lang('customer_note') ?></label>
                                        <textarea class="form-control" name="note"><?php if(!empty($customer->note))echo $customer->note ?></textarea>
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" name="id" value="<?php if(!empty($customer->id))echo $customer->id ?>">

<!--                            <a href="javascript::" class="btn bg-navy btn-flat" onclick="save_product()" >--><?//= lang('save') ?><!--</a>-->
                            <button class="btn btn-primary" type="submit" value="Submit"><i class="fa fa-save"></i> <?= lang('save').' '.lang('customer') ?></button>


                        </div>
                    </div>


                </div>
                <!-- /.box-body -->

                <div class="box-footer">

                </div>
                <?php echo $form->close(); ?>

            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>
<!-- /.content -->


