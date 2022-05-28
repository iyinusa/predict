    <div class="rightside">
        <div class="page-head">
            <h1>Clubs</h1>
            <ol class="breadcrumb">
                <li>You are here:</li>
                <li><a href="<?php echo base_url(); ?>">Home</a></li>
                <li class="active">Clubs</li>
            </ol>
        </div>

        <div class="content">
            <div class="row">
                <div class="col-xs-12">
                    <?php echo form_open_multipart('club'); ?>
                        <div class="box">
                            <div class="box-title">
                                <i class="fa fa-upload"></i>
                                <h3>New Club</h3>
                                <div class="pull-right box-toolbar">
                                    <a href="#" class="btn btn-link btn-xs remove-box"><i class="fa fa-times"></i></a>
                                </div>          
                            </div>
                            <div class="box-body">
                                <?php if(!empty($err_msg)){echo $err_msg;} ?>
                                <div class="form-group">
                                    <input type="hidden" name="club_id" value="<?php if(!empty($e_id)){echo $e_id;} ?>" />
                                    <input type="hidden" name="pics" value="<?php if(!empty($e_pics)){echo $e_pics;} ?>" />
                                    <input type="hidden" name="pics_square" value="<?php if(!empty($e_pics_square)){echo $e_pics_square;} ?>" />
                                    <input type="hidden" name="pics_small" value="<?php if(!empty($e_pics_small)){echo $e_pics_small;} ?>" />
                                    <label>Club Name</label>
                                    <input type="text" name="name" placeholder="Club Name" class="form-control" value="<?php if(!empty($e_name)){echo $e_name;} ?>" required="required" />
                                </div>
                                <div class="form-group">
                                    <label>Select Badge</label>
                                    <input type="file" name="up_file" class="btn btn-info file-inputs" title="Select file">
                                    <?php
                                        if(!empty($e_pics_square)){
                                            echo '<br /><br /><img alt="" src="'.base_url($e_pics_square).'" />';	
                                        }
                                    ?>
                                </div>
                            </div>
                            <div class="box-footer clearfix">
                                <button type="submit" name="submit" class="pull-left btn btn-success">Update Record <i class="fa fa-arrow-circle-right"></i></button>
                            </div>
                        </div>
                    <?php echo form_close(); ?>
                </div>
                
                
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-title">
                            <i class="fa fa-upload"></i>
                            <h3>Club Directory</h3>
                            <div class="pull-right box-toolbar">
                                <a href="#" class="btn btn-link btn-xs remove-box"><i class="fa fa-times"></i></a>
                            </div>          
                        </div>
                        <div class="box-body">
                            <?php
								$dir_list = '';
								if(!empty($allup)){
									foreach($allup as $up){
										$dir_list .= '
											<tr>
												<td align="center"><img alt="" src="'.base_url($up->pics_square).'" width="50" class="img img-circle" /></td>
												<td>'.$up->name.'</td>
												<td align="center">
													<a href="'.base_url().'club?edit='.$up->id.'" class="btn btn-primary btn"><i class="fa fa-pencil"></i> Edit</a>
													<a href="'.base_url().'club?del='.$up->id.'" class="btn btn-danger btn"><i class="fa fa-times"></i> Delete</a>
												</td>
											</tr>
										';	
									}
								}
							?>	
                            
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                    	<th width="60">Badge</th>
                                        <th>Club</th>
                                        <th width="150">Manage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                	<?php echo $dir_list; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th width="60">Badge</th>
                                        <th>Club</th>
                                        <th width="150">Manage</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>