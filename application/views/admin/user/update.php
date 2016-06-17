<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
        	<div class="page-header users-header">
            <h2>Update User
        	</h2>
            </div>
        </div>
    </div>
    <div class="row">
    	<div class="col-lg-12">
    		<?php echo validation_errors(); ?>
            <?php echo form_open('user/set_update'); ?>
    		<fieldset>
                <div class="form-group">                	
                    <input class="form-control" name="id_user" type="hidden" value="<?= $get_user->ID_USER ?>">
                    <input class="form-control" placeholder="NIPP" name="nipp_user" type="text" value="<?= $get_user->NIPP_USER ?>" autofocus>
                </div>
                <div class="form-group">
                    <input class="form-control" placeholder="Nama" name="nama_user" type="text" value="<?= $get_user->NAMA_USER ?>" autofocus>
                </div>
                <div class="form-group">
                    <input class="form-control" placeholder="E-mail" name="email" type="email" value="<?= $get_user->EMAIL ?>" autofocus>
                </div>
                <div class="form-group">
                    <select class="form-control" name="group">
                            <option value="1">Administrator</option>
                            <option value="2">CPC</option>
                            <option value="3">FA</option>
                            <option value="4">GA</option>
                            <option value="5">HC</option>
                            <option value="6">QHSSE</option>
                    </select>
                </div>
                <div class="form-group">
                    <input class="form-control" placeholder="Password" name="password" type="password" value="">
                </div>
                <div class="form-group">
                    <input class="form-control" placeholder="Retype Password" name="password2" type="password" value="">
                </div>
                <!-- Change this to a button or input when using this as a form -->
                <button class="btn btn-lg btn-success btn-block" type="submit" value="login">Save</button>
                <a href="<?= site_url('user');?>" class="btn btn-lg btn-failure btn-block" >Cancel</a>
            </fieldset>
    		<?= form_close();?>
    	</div>
    </div>
</div>