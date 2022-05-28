    <div class="rightside">
        <div class="page-head">
            <h1>Prediction</h1>
            <ol class="breadcrumb">
                <li>You are here:</li>
                <li><a href="<?php echo base_url(); ?>">Home</a></li>
                <li class="active">Prediction</li>
            </ol>
        </div>
        
        <?php
			$ins =& get_instance();
			$ins->load->model('mclub');
		?>

        <div class="content">
            <div class="row">
                <div class="col-xs-12">
                    <?php echo form_open_multipart('predict'); ?>
                        <?php if(!empty($analyse)){ ?>
                        <div class="box">
                            <div class="box-title">
                                <i class="fa fa-trunk"></i>
                                <h3>Prediction Analysis</h3>
                                <div class="pull-right box-toolbar">
                                    <a href="#" class="btn btn-link btn-xs remove-box"><i class="fa fa-times"></i></a>
                                </div>          
                            </div>
                            <div class="box-body">
                                <?php if(!empty($err_msg)){echo $err_msg;} ?>
                                
                                <div class="row" style="font-size:x-large;">
                                	<div class="col-lg-6">
                                    	<div class="col-lg-7 text-right">
                                        	<?php if(!empty($get_home_team_name)){echo $get_home_team_name;} ?>
                                        </div>
                                        <div class="col-lg-3 text-center">
                                        	<img alt="" src="<?php echo base_url($get_home_team_img); ?>" width="40" class="img img-circle" />
                                        </div>
                                        <div class="col-lg-2 text-center">
                                        	<?php if(!empty($get_home_score)){echo $get_home_score;} else {echo 0;} ?>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                    	<div class="col-lg-2 text-center">
                                        	<?php if(!empty($get_away_score)){echo $get_away_score;} else {echo 0;} ?>
                                        </div>
                                        <div class="col-lg-3 text-center">
                                        	<img alt="" src="<?php echo base_url($get_away_team_img); ?>" width="40" class="img img-circle" />
                                        </div>
                                        <div class="col-lg-7 text-left">
                                        	<?php if(!empty($get_away_team_name)){echo $get_away_team_name;} ?>
                                        </div>
                                    </div>
                                </div>
                                
                                <hr />
                                
                                <div class="row">
                                	<div class="col-lg-12 text-center text-muted">
                                    	<h3>Prediction Analysis Using Bayesian Network To Suggest Likely Winner<br />Between <b><?php if(!empty($get_home_team_name)){echo $get_home_team_name;} ?></b> and <b><?php if(!empty($get_away_team_name)){echo $get_away_team_name;} ?></b></h3>
                                        <div class="text-left">
                                        	<table class="table table-bordered table-striped">
                                            	<tr>
                                                	<td></td>
                                                    <td><h3><?php if(!empty($get_home_team_name)){echo $get_home_team_name;} ?></h3></td>
                                                    <td><h3><?php if(!empty($get_away_team_name)){echo $get_away_team_name;} ?></h3></td>
                                                </tr>
                                                <tr>
                                                	<td><b>Winning History</b></td>
                                                    <td><?php if(!empty($home_win)){echo $home_win;} else {echo 0;} ?></td>
                                                    <td><?php if(!empty($away_win)){echo $away_win;} else {echo 0;} ?></td>
                                                </tr>
                                                <tr>
                                                	<td><b>Draw History</b></td>
                                                    <td><?php if(!empty($home_draw)){echo $home_draw;} else {echo 0;} ?></td>
                                                    <td><?php if(!empty($away_draw)){echo $away_draw;} else {echo 0;} ?></td>
                                                </tr>
                                                <tr>
                                                	<td><b>Lose History</b></td>
                                                    <td><?php if(!empty($home_lose)){echo $home_lose;} else {echo 0;} ?></td>
                                                    <td><?php if(!empty($away_lose)){echo $away_lose;} else {echo 0;} ?></td>
                                                </tr>
                                                <tr style="font-size:x-large; background-color:#0CF;">
                                                	<td><b>Prediction</b></td>
                                                    <td colspan="2">
                                                    	<?php
															if(!empty($winner)){
																if($winner == $get_home_team_name){
																	echo $get_home_team_name.' is likely to Win the match';
																} else if($winner == $get_away_team_name){
																	echo $get_away_team_name.' is likely to Win the match';
																} else {
																	echo 'This is likely to be a Draw match';
																}
															}
														?>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="box-footer clearfix">
                                <button type="submit" name="submit" class="pull-left btn btn-warning"><i class="fa fa-arrow-circle-left"></i> Close</button>
                            </div>
                        </div>
                        <?php } ?>
                    <?php echo form_close(); ?>
                </div>
                
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-title">
                            <i class="fa fa-upload"></i>
                            <h3>Latest Fixtures</h3>
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
										if($up->played == 0) {
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
											
											$dir_list .= '
												<tr>
													<td width="50">'.$up->match_date.'</td>
													<td align="right">'.$home_team_name.'</td>
													<td align="center"><img alt="" src="'.base_url($home_team_img).'" width="40" class="img img-circle" /></td>
													<td align="center">'.$up->home_score.'</td>
													<td align="center">'.$up->away_score.'</td>
													<td align="center"><img alt="" src="'.base_url($away_team_img).'" width="40" class="img img-circle" /></td>
													<td>'.$away_team_name.'</td>
													<td align="center">
														<a href="'.base_url().'predict?analyse='.$up->id.'" class="btn btn-success btn"><i class="fa fa-arrow-up"></i> Predict Match</a>
													</td>
												</tr>
											';	
										}
									}
								}
							?>	
                            
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th width="70">Date</th>
                                        <th colspan="3" style="text-align:center;">Home Team</th>
                                        <th colspan="3" style="text-align:center;">Away Team</th>
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