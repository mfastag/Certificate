<!-- Sidebar -->
<ul  class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion toggled" id="accordionSidebar">
	
	<!-- Sidebar - Brand -->
<li>	
	<a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
		<div class="sidebar-brand-icon rotate-n-15">
		<!--<i class="fas fa-laugh-wink">&nbsp;</i>-->
		Chemco
		</div>
		<div class="sidebar-brand-text mx-3"><!-- sidebar top label -->&nbsp;</div>
	</a>
</li>	

@guest
<li class="nav-item active">
	<a class="nav-link" href="/login">
	<i class="fas fa-fw fa-user">&nbsp;</i><span>Login</span></a>
</li>
@endguest


@auth

	<!-- Divider -->
	<li><hr class="sidebar-divider my-0"></li>
	
	<!-- Nav Item - Dashboard -->
	<li class="nav-item active">
	<a class="nav-link" href="/">
	<i class="fas fa-fw fa-tachometer-alt">&nbsp;</i><span>Dashboard</span></a>
	</li>
	
	<li class="nav-item active">
	<a class="nav-link" href="/active">
	<i class="fas fa-fw fa-shower">&nbsp;</i><span>Active</span></a>
	</li>
	
	<li class="nav-item active">
	<a class="nav-link" href="/exception">
	<i class="fas fa-fw fa-exclamation-triangle" >&nbsp;</i><span>Deviation</span></a>
	</li>


	

	<!-- Divider -->
	<li><hr class="sidebar-divider"></li>
	
	<!-- Heading -->
	<!--<li><div class="sidebar-heading">SECTIONS</div></li>-->
	

	<li class="nav-item active">
	<a class="nav-link" href="/hist">
	<i class="fas fa-fw fa-calendar" >&nbsp;</i><span>Wash History</span></a>
	</li>

	<li class="nav-item active">
	<a class="nav-link" href="/chemical">
	<i class="fas fa-fw fa-flask" >&nbsp;</i><span>Chemical Usage</span></a>
	</li>

	<li class="nav-item active">
	<a class="nav-link" href="/facility">
	<i class="fas fa-fw fa-city" >&nbsp;</i><span>Facility Usage</span></a>
	</li>

	@if(in_array("Inventory",Auth::user()->roles()))
		<li class="nav-item active">
		<a class="nav-link" href="/inventory/dos">
		<i class="fas fa-fw fa-dolly" >&nbsp;</i><span>Days Of Supply</span></a>
		</li>

		<li class="nav-item active">
		<a class="nav-link" href="/inventory">
		<i class="fas fa-fw fa-boxes" >&nbsp;</i><span>Inventory</span></a>
		</li>

		<li class="nav-item active">
		<a class="nav-link" href="/barcode">
		<i class="fas fa-fw fa-barcode" >&nbsp;</i><span>Barcode</span></a>
		</li>
	@endif

<!--
	<li class="nav-item active">
	<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
		<i class="fas fa-fw fa-folder">&nbsp;</i>
		<span>Pages</span>
	</a>
	<div id="collapsePages" class="collapse"  data-parent="#accordionSidebar">
	<div class="bg-white py-2 collapse-inner rounded">
	<h6 class="collapse-header">Pages</h6>
		<a class="collapse-item" href="/inventory">Inventory</a>
		<a class="collapse-item" href="/chemical">Chemical Usage</a>
		<a class="collapse-item" href="/exception">Deviations</a>
		<a class="collapse-item" href="/active">Active</a>
	</div>
	</div>
	</li>
-->
	<!-- Divider -->
	<li><hr class="sidebar-divider"></li>
	
	<!-- Heading -->
	<!--<li><div class="sidebar-heading">
	Interface
	</div></li>-->
	
	<!-- Nav Item - Utilities Collapse Menu -->
	<li class="nav-item active">
		<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
		<i class="fas fa-fw fa-wrench">&nbsp;</i>
		<span>Documents</span>
		</a>
		<div id="collapseUtilities" class="collapse" data-parent="#accordionSidebar">
 			<div class="bg-white py-2 collapse-inner rounded">
				<h6 class="collapse-header">Downloads</h6>
				<a class="collapse-item" href="/docs/Reporting_featues_09_19_2022.docx">Reporting Features</a>
				<a class="collapse-item" href="/docs/ElemcoIntelligence_09_19_2022.pptx">Powerpoint</a>
			</div>
		</div>
		</li>
	
@endauth


	<!-- Divider -->
	<li><hr class="sidebar-divider d-none d-md-block"></li>

	<li class="nav-item active">
		<a class="nav-link" href="/logout">
		<i class="fas fa-fw fa-walking" >&nbsp;</i><span>Logout</span></a>
		</li>
	
		<li><hr class="sidebar-divider d-none d-md-block"></li>

	<!-- Sidebar Toggler (Sidebar) -->
	<li><div class="text-center d-none d-md-inline">
	<button class="rounded-circle border-0" id="sidebarToggle">&nbsp;</button>
	</div></li>
	




	</ul>
	<!-- End of Sidebar -->
