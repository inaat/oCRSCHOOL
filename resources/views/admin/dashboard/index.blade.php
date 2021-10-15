@extends("admin_layouts.app")

	@section("style")
	@endsection

		@section("wrapper")
		<div class="page-wrapper">
			<div class="page-content">
			<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                        <div class="breadcrumb-title pe-3">Home</div>
                        <div class="ps-3">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0 p-0">
                                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                                </ol>
                            </nav>
                        </div>
                        
                    </div>
				<div class="row row-cols-1 row-cols-lg-3">
					<div class="col">
						<div class="card radius-10">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div class="flex-grow-1">
										<p class="mb-0">Total Campuses</p>
										<h4 class="font-weight-bold">1</h4>
										<p class=" mb-0 font-13">All registered campuses</p>
									</div>
									
									<div class="widgets-icons bg-gradient-cosmic text-white"><i class='bx bx-buildings'></i>
									
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card radius-10">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div class="flex-grow-1">
										<p class="mb-0">Total Administrators</p>
										<h4 class="font-weight-bold">16,352</h4>
										<p class="text-secondary mb-0 font-13">Total count of all campuses</p>
									</div>
									<div class="widgets-icons bg-gradient-burning text-white"><i class='bx bx-group'></i>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card radius-10">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div class="flex-grow-1">
										<p class="mb-0">Total Staff</p>
										<h4 class="font-weight-bold">34m 14s</h4>
										<p class="text-secondary mb-0 font-13">Total count including left overs</p>
									</div>
									<div class="widgets-icons bg-gradient-lush text-white"><i class='bx bx-group'></i>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card radius-10">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div class="flex-grow-1">
										<p class="mb-0">Total Students</p>
										<h4 class="font-weight-bold">1,94,2335</h4>
										<p class="text-secondary mb-0 font-13">Total count including alumni & Left Overs</p>
									</div>
									<div class="widgets-icons bg-gradient-kyoto text-white"><i class='bx bxs-group'></i>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card radius-10">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div class="flex-grow-1">
										<p class="mb-0">Awards</p>
										<h4 class="font-weight-bold">58% <small class="text-danger font-13">(-16%)</small></h4>
										<p class="text-secondary mb-0 font-13">Registered awards for students & staff</p>
									</div>
									<div class="widgets-icons bg-gradient-blues text-white"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-award text-primary"><circle cx="12" cy="8" r="7"></circle><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline></svg>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card radius-10">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div class="flex-grow-1">
										<p class="mb-0">Notice's</p>
										<h4 class="font-weight-bold">96% <small class="text-danger font-13">(+54%)</small></h4>
										<p class="text-secondary mb-0 font-13">Registered Notice's for students & staff</p>
									</div>
									<div class="widgets-icons bg-gradient-moonlit text-white"><i class="fadeIn animated bx bx-notepad"></i>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!--end row-->
			
                

			</div>
		</div>
		@endsection
		
	@section("script")
	@endsection