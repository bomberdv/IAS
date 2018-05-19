
<div class="row">
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border bg-primary-dark">
                <h3 class="box-title"><?= lang('create_admin_user') ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php echo $form->open(); ?>

            <div class="box-body">

                <br/>
                <br/>
                <!-- View massage -->
                <?php echo $form->messages(); ?>

                <div class="row">
                    <div class="col-md-6 col-sm-12 col-xs-12 col-md-push-1">

                        <?php echo $form->bs3_text(lang('username'), 'username'); ?>
                        <?php echo $form->bs3_text(lang('first_name'), 'first_name'); ?>
                        <?php echo $form->bs3_text(lang('last_name'), 'last_name'); ?>
                        <?php echo $form->bs3_email(lang('email'), 'email'); ?>
                        <?php echo $form->bs3_password(lang('password'), 'password'); ?>
                        <?php echo $form->bs3_password(lang('retype_password'), 'retype_password'); ?>

                        <?php if ( !empty($groups) ): ?>
                            <div class="form-group">
                                <label for="groups"><?= lang('group') ?> </label>
                                <div>
                                    <select class="form-control" name="groups[]">
                                        <option value=""><?= lang('select_group') ?>...</option>
                                    <?php foreach ($groups as $group): ?>
                                        <option value="<?php echo $group->id; ?>"><?php echo $group->description; ?></option>
                                    <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        <?php endif; ?>
						
						<?php if ( !empty($branchs) ): ?>
                            <div class="form-group">
                                <label for="groups"><?= lang('branch') ?></label>
                                <div>
                                    <select class="form-control" name="branchs[]">
                                        <option value=""><?= lang('select_branch') ?>...</option>
                                    <?php foreach ($branchs as $branch): ?>
                                        <option value="<?php echo $branch->id; ?>"><?php echo $branch->description; ?></option>
                                    <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        <?php endif; ?>
						
                        <button class="btn btn-primary col-md-push-1" type="submit" value="Submit"><i class="fa fa-save"></i> <?= lang('save').' '.lang('admin_user') ?></button>

                    </div>



                </div>

                <br/>
                <br/>
            </div>
            <!-- /.box-body -->


            <?php echo $form->close(); ?>

        </div>
        <!-- /.box -->

    </div>
</div>