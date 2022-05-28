<?php
	if($page_act == 'dashboard'){$dashboard_active = 'active';}else{$dashboard_active = '';}
	if($page_act == 'club'){$club_active = 'active';}else{$club_active = '';}
	if($page_act == 'fixture'){$fixture_active = 'active';}else{$fixture_active = '';}
	if($page_act == 'predict'){$predict_active = 'active';}else{$predict_active = '';}
?>

<!-- wrapper -->
<div class="wrapper">
    <div class="leftside">
        <div class="sidebar">
            <ul class="sidebar-menu">
                <li class="title">Navigation</li>
                <li class="<?php echo $dashboard_active; ?>">
                    <a href="<?php echo base_url(); ?>dashboard">
                        <i class="fa fa-home"></i> <span>Dashboard</span>
                    </a>
                </li>
                <?php if($this->session->userdata('itc_user_role') == 'Admin'){ ?>
                <li class="<?php echo $club_active; ?>">
                    <a href="<?php echo base_url(); ?>club">
                        <i class="fa fa-truck"></i> <span>Clubs</span>
                    </a>
                </li>
                <li class="<?php echo $fixture_active; ?>">
                    <a href="<?php echo base_url(); ?>fixture">
                        <i class="fa fa-users"></i> <span>Fixtures</span>
                    </a>
                </li>
                <?php } ?>
                <li class="<?php echo $predict_active; ?>">
                    <a href="<?php echo base_url(); ?>predict">
                        <i class="fa fa-globe"></i> <span>Predictions</span>
                    </a>
                </li>
            </ul>
         </div>
    </div>