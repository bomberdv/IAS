
<div class="row">
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border bg-primary-dark">
                <h3 class="box-title"><?= lang('update_admin_user_profile') ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php echo $form->open(); ?>

            <div class="box-body">
                <br/>
                <br/>
                <!-- View massage -->
                <?php echo $form->messages(); ?>
                <?php echo message_box('success'); ?>
                <?php echo message_box('error'); ?>

                <div class="row">
                    <div class="col-md-6 col-sm-12 col-xs-12 col-md-push-1">
                        <?php echo $form->bs3_text(lang('username'), 'username', $admin_user->username); ?>
                        <?php echo $form->bs3_text(lang('first_name'), 'first_name', $admin_user->first_name); ?>
                        <?php echo $form->bs3_text(lang('last_name'), 'last_name', $admin_user->last_name); ?>
                        <?php echo $form->bs3_email(lang('email'), 'email', $admin_user->email); ?>
                        <input type="hidden" name="id" value="<?php echo str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($admin_user->id)) ?>">

                        <?php if ( !empty($groups) ): ?>
                            <div class="form-group">
                                <label for="groups"><?= lang('group') ?></label>
                                <div>
                                    <select class="form-control" name="groups">
                                    <?php foreach ($groups as $group): ?>
                                        <option value="<?php echo $group->id; ?>" <?php echo $group->id == $admin_user->admin_groups_id ? 'selected':'' ?>><?php echo $group->description; ?></option>
                                    <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        <?php endif; ?>
						
						<?php if ( !empty($branchs) ): ?>
                            <div class="form-group">
                                <label for="groups"><?= lang('branch') ?></label>
                                <div>
                                    <select class="form-control" name="branchs">
                                    <?php foreach ($branchs as $branch): ?>
                                        <option value="<?php echo $branch->id; ?>" <?php echo $branch->id == $admin_user->admin_branch_id ? 'selected':'' ?>><?php echo $branch->description; ?></option>
                                    <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="col-xs-6">
                            <label class="css-input css-radio css-radio-success push-10-r">
                                <input name="active" <?php echo $admin_user->active == TRUE ? 'checked':'' ?> value="1" type="radio"><span></span> <?= lang('active') ?>
                            </label>
                            <label class="css-input css-radio css-radio-success">
                                <input name="active" <?php echo $admin_user->active == FALSE ? 'checked':'' ?> value="0" type="radio"><span></span> <?= lang('inactive') ?>
                            </label>
                        </div>
<br/>
<br/>
<br/>
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