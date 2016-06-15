<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
        	<div class="page-header users-header">
            <h2>User Management
            	<a class="btn btn-success" href="<?= site_url('user/get_insert')?>"> Create</a>
        	</h2>
            </div>
        </div>
    </div>
    <div class="row">
    	<div class="col-lg-12">
    		<table class="table table-striped" id="table">
				<thead>
					<tr>
						<th>#</th>
						<th>Nama</th>
						<th>Email</th>
						<th>Status</th>
						<th><i class="glyphicon glyphicon-pencil"></i></th>
						<th><i class="glyphicon glyphicon-remove"></i></th>
					</tr>
				</thead>
				<tbody>
							<?php $no=1;?>
					<?php foreach($user as $user) {?>
						<tr>
							<td><a href=""><?= $no ?></a></td>
							<td><?= $user->NAMA_USER ?></td>
							<td><?= $user->EMAIL ?></td>
							<?php if ($user->STATUS == 1) $status='Aktif'; else $status='Tidak aktif';?>
							<td><?= $status ?></td>
							<td>
								<a href="<?= site_url('')?>/user/get_update/<?= $user->ID_USER?>" class="btn btn-warning btn-mini pull-left">Edit</a>
							</td>
							<td>
								<?php 
									$delete = site_url().'/user/delete/'.$user->ID_USER;
									$attributes=array( 'method' => 'delete', 'data-confirm' => 'Are you sure?');
									form_open($delete);//Form::open(array('route' => array('admin.user.destroy', $user->id), 'method' => 'delete', 'data-confirm' => 'Are you sure?')) ?>
									<button type="submit" href="<?= $delete;?>" class="btn btn-danger btn-mini">Delete</button>
								<?php form_close(); ?>
							</td>
						</tr>
						<?php $no=$no+1;
					}?>
				</tbody>
			</table>
    	</div>
    </div>
</div>