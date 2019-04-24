<div class="clearfix">
</div>
<!-- BEGIN CONTAINER -->
<div class="container">
	<div class="page-container">
		<!-- BEGIN SIDEBAR -->
		<div class="page-sidebar-wrapper">
			<div class="page-sidebar navbar-collapse collapse">
				<ul class="page-sidebar-menu page-sidebar-menu-hover-submenu " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
					<li class="start active ">
						<a href="<?php echo site_url();?>Medi_varsity/index">
						<i class="icon-home"></i>
						<span class="title">User Dashboard</span>
						<span class="selected"></span>
						</a>
					</li>
					<li>
						<a href="javascript:;">
					
						<i class="icon-user"></i>
						<span class="title">Faculty</span>
						<span class="arrow "></span>
						</a>
						<ul class="sub-menu">
							<li>
								<a href="<?php echo site_url('Medi_varsity/facultyList')?>">
								<i class="icon-list"></i>
								List Of Faculty</a>
							</li>
							<li>
								<a href="<?php echo site_url('Medi_varsity/addFaculty_pg')?>">
								<i class="icon-user-follow"></i>
								Add Faculty</a>
							</li>	
						</ul>
					</li>
					<li>
						<a href="<?php echo site_url('Medi_varsity/studentList')?>">
						<i class="icon-users"></i>
						<span class="title">Students</span>
						<span class="arrow "></span>
						</a>
					</li>
					<li>
						<a href="<?php echo site_url();?>Medi_varsity/invoice">
						<i class="icon-wallet"></i>
						<span class="title">Invoice</span>
						<span class="arrow "></span>
						</a>
					</li>
					
					<li>
						<a href="javascript:;">
						<i class="icon-bell"></i>
						<span class="title">Post</span>
						<span class="arrow "></span>
						</a>
						
						<ul class="sub-menu">
						
						    <li>
								<a href="<?php echo site_url('Medi_varsity/postAdmin')?>">
								<i class="icon-bell"></i>
								Add Post</a>
							</li>
							<li>
								<a href="<?php echo site_url('Medi_varsity/postList')?>">
								<i class="icon-list"></i>
								List Of Post</a>
							</li>
						</ul>
					</li>
					<!--<li>
						<a href="<?php echo site_url('Medi_varsity/faq')?>">
						<i class="icon-info"></i>
						<span class="title">FAQ</span>
						<span class="arrow "></span>
						</a>
					</li>-->
				
				</ul>
				<!-- END SIDEBAR MENU -->
			</div>
		</div>