<?php

if(@$page =='')
{
	$page='';
}

if(isset($result['page']))
{
	$page=$result['page'];
}

?>
<div class="clearfix">
</div>
<div class="container">
	<div class="page-container">
		<div class="page-sidebar-wrapper">
			<div class="page-sidebar navbar-collapse collapse">
				<ul class="page-sidebar-menu page-sidebar-menu-hover-submenu " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
					<li class="start <?php if($page ==''){ echo 'active'; }?> ">
						<a href="<?php echo site_url();?>Superadmin/index">
						<i class="icon-home"></i>
						<span class="title">Admin Dashboard</span>
						<span class="selected"></span>
						</a>
					</li>
					<li class="<?php if($page =='add_faculty' || $page =='faculties'){ echo 'active'; }?>">
						<a href="javascript:;">
					
						<i class="icon-user"></i>
						<span class="title">Faculty</span>
						<span class="arrow "></span>
						</a>
						<ul class="sub-menu">
							<li>
								<a href="<?php echo site_url('Superadmin/addFaculty_pg')?>">
								<i class="icon-user-follow"></i>
								Add Faculty</a>
							</li>

                            <li>
								<a href="<?php echo site_url('Superadmin/facultyList')?>">
								<i class="icon-list"></i>
								List Of Faculty</a>
							</li>							
						</ul>
					</li>
					<li class="<?php if($page =='students'){ echo 'active'; }?>">
						<a href="<?php echo site_url('Superadmin/studentList')?>">
						<i class="icon-users"></i>
						<span class="title">Students</span>
						<span class="arrow "></span>
						</a>
					</li>
					<li class="<?php if($page =='export-excel'){ echo 'active'; }?>">
						<a href="<?php echo site_url();?>Superadmin/invoice">
						<i class="icon-wallet"></i>
						<span class="title">Invoice</span>
						<span class="arrow "></span>
						</a>
					</li>
					
					<li class="<?php if($page =='post_admin' || $page =='posts'){ echo 'active'; }?>">
						<a href="javascript:;">
						<i class="icon-bell"></i>
						<span class="title">Post</span>
						<span class="arrow "></span>
						</a>
						
						<ul class="sub-menu">
						
						    <li>
								<a href="<?php echo site_url('Superadmin/postAdmin')?>">
								<i class="icon-bell"></i>
								Add Post</a>
							</li>
							<li>
								<a href="<?php echo site_url('Superadmin/postList')?>">
								<i class="icon-list"></i>
								List Of Post</a>
							</li>
						</ul>
					</li>
					<li class="<?php if($page =='query_list'){ echo 'active'; }?>">
						<a href="<?php echo site_url();?>Superadmin/querylist">
						<i class="icon-wallet"></i>
						<span class="title">Query</span>
						<span class="arrow "></span>
						</a>
					</li>
					<li class="">
						<a href="<?php echo site_url();?>Superadmin/category">
						<i class="icon-list"></i>
						<span class="title">Category</span>
						<span class="arrow "></span>
						</a>
					</li>
						<li class="<?php if($page =='orvidio'){ echo 'active'; }?>">
						<a href="<?php echo site_url();?>Superadmin/oriantvidioList">
						<i class="icon-wallet"></i>
						<span class="title">Orientation and Motivation</span>
						<span class="arrow "></span>
						</a>
					</li>
				</ul>
			</div>
		</div>