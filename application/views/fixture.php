    <div class="rightside">
        <div class="page-head">
            <h1>Fixtures</h1>
            <ol class="breadcrumb">
                <li>You are here:</li>
                <li><a href="<?php echo base_url(); ?>">Home</a></li>
                <li class="active">Fixtures</li>
            </ol>
        </div>

        <div class="content">
            <div class="row">
                <div class="col-xs-12">
                    <?php echo form_open_multipart('fixture'); ?>
                        <div class="box">
                            <div class="box-title">
                                <i class="fa fa-trunk"></i>
                                <h3>New Fixture</h3>
                                <div class="pull-right box-toolbar">
                                    <a href="#" class="btn btn-link btn-xs remove-box"><i class="fa fa-times"></i></a>
                                </div>          
                            </div>
                            <div class="box-body">
                                <?php if(!empty($err_msg)){echo $err_msg;} ?>
                                <?php
									$ins =& get_instance();
									$ins->load->model('mclub');
									
									$home_list = '';
									$away_list = '';
									if(!empty($allclub)){
										foreach($allclub as $club){
											if(!empty($e_home_team)){
												if($e_home_team == $club->id){
													$h_sel = 'selected="selected"';
												} else {$h_sel = '';}
											} else {$h_sel = '';}
											
											if(!empty($e_away_team)){
												if($e_away_team == $club->id){
													$a_sel = 'selected="selected"';
												} else {$a_sel = '';}
											} else {$a_sel = '';}
											
											$home_list .= '<option value="'.$club->id.'" '.$h_sel.'>'.$club->name.'</option>';
											$away_list .= '<option value="'.$club->id.'" '.$a_sel.'>'.$club->name.'</option>';
										}
									}
								?>
                                
                                <div class="form-group">
                                    <input type="hidden" name="fixture_id" value="<?php if(!empty($e_id)){echo $e_id;} ?>" />
                                    <label>Match Date</label>
                                    <input type="text" name="match_date" placeholder="DD/MM/YYYY" class="form-control" value="<?php if(!empty($e_match_date)){echo $e_match_date;} ?>" required="required" />
                                </div> 
                                <div class="row">
                                	<div class="col-lg-5 text-center">
                                        <b>HOME TEAM</b><br /><br />
                                        <div class="form-group">
                                        	<select name="home_team" class="form-control" required>
                                            	<option></option>
                                                <?php echo $home_list ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                        	<input type="text" name="home_score" class="form-control text-center" placeholder="0" value="<?php if(!empty($e_home_score)){echo $e_home_score;} ?>" />
                                        </div>
                                    </div>
                                    <div class="col-lg-2 text-center">
                                        <h2 class="text-muted"><br />Vs</h2>
                                    </div>
                                    <div class="col-lg-5 text-center">
                                        <b>AWAY TEAM</b><br /><br />
                                         <div class="form-group">
                                        	<select name="away_team" class="form-control" required>
                                            	<option></option>
                                                <?php echo $away_list ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                        	<input type="text" name="away_score" class="form-control text-center" placeholder="0" value="<?php if(!empty($e_away_score)){echo $e_away_score;} ?>" />
                                        </div>
                                    </div>
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
                            <h3>Fixtures Directory</h3>
                            <div class="pull-right box-toolbar">
                                <a href="#" class="btn btn-link btn-xs remove-box"><i class="fa fa-times"></i></a>
                            </div>          
                        </div>
                        <div class="box-body">
                            <?php
								$dir_list = '';
								$home_team_name = '';
								$home_team_img = '';
								$away_team_name = '';
								$away_team_img = '';
								if(!empty($allup)){
									foreach($allup as $up){
										//get home details
										$ghome = $this->mclub->query_club_id($up->home_team);
										if(!empty($ghome)){
											foreach($ghome as $home){
												$home_team_name = $home->name;
												$home_team_img = $home->pics_square;
											}
										}
										
										//get away details
										$gaway = $this->mclub->query_club_id($up->away_team);
										if(!empty($gaway)){
											foreach($gaway as $away){
												$away_team_name = $away->name;
												$away_team_img = $away->pics_square;
											}
										}
										
										if($up->played == 1){$status = '<span class="label label-success">Played</span>';} else {$status = '';}
										
										$dir_list .= '
											<tr>
												<td width="50">'.$up->match_date.'</td>
												<td align="right">'.$home_team_name.'</td>
												<td align="center"><img alt="" src="'.base_url($home_team_img).'" width="40" class="img img-circle" /></td>
												<td align="center">'.$up->home_score.'</td>
												<td align="center">'.$up->away_score.'</td>
												<td align="center"><img alt="" src="'.base_url($away_team_img).'" width="40" class="img img-circle" /></td>
												<td>'.$away_team_name.'</td>
												<td align="center" width="50">'.$status.'</td>
												<td align="center">
													<a href="'.base_url().'fixture?edit='.$up->id.'" class="btn btn-primary btn"><i class="fa fa-pencil"></i> Edit</a>
													<a href="'.base_url().'fixture?del='.$up->id.'" class="btn btn-danger btn"><i class="fa fa-times"></i> Delete</a>
												</td>
											</tr>
										';	
									}
								}
							?>	
                            
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th width="70">Date</th>
                                        <th colspan="3" style="text-align:center;">Home Team</th>
                                        <th colspan="3" style="text-align:center;">Away Team</th>
                                        <th align="center" width="50">Status</th>
                                        <th width="150" align="center">Manage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                	<?php echo $dir_list; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th width="70">Date</th>
                                        <th colspan="3" style="text-align:center;">Home Team</th>
                                        <th colspan="3" style="text-align:center;">Away Team</th>
                                        <th align="center" width="50">Status</th>
                                        <th width="150" align="center">Manage</th>
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