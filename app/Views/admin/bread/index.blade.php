@extends('admin.main-page')
@section('content')
	<!-- MAIN CONTENT -->
	<div id="content">

		<!-- row -->
		<div class="row">
			
			<!-- col -->
			<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
				<h1 class="page-title txt-color-blueDark">
					<!-- PAGE HEADER -->
					<i class="fa-fw fa fa-table"></i> 
					
					{{ $title }}
				</h1>
			</div>
			<!-- end col -->
			
		</div>
		<!-- end row -->
		
		<!--
			The ID "widget-grid" will start to initialize all widgets below 
			You do not need to use widgets if you dont want to. Simply remove 
			the <section></section> and you can use wells or panels instead 
			-->
		
		<!-- widget grid -->
		<section id="widget-grid" class="">
		
			<!-- row -->
			<div class="row">
				
				<!-- NEW WIDGET START -->
				<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					
					<!-- Widget ID (each widget will need unique ID)-->
					<div class="jarviswidget" id="wid-id-0"
						data-widget-colorbutton="false"
						data-widget-editbutton="false"
						data-widget-deletebutton="false">
						<header>
							<span class="widget-icon"> <i class="fa fa-table"></i> </span>
						</header>
		
						<!-- widget div-->
						<div>
							
							<!-- widget edit box -->
							<div class="jarviswidget-editbox">
								<!-- This area used as dropdown edit box -->
								<input class="form-control" type="text">	
							</div>
							<!-- end widget edit box -->
							
							<!-- widget content -->
							<div class="widget-body">
					
								<table id="dt_basic" class="table table-striped table-bordered table-hover" width="100%">
									<thead>			                
										<tr>
											<th data-class="expand">Table</th>
											<th data-hide="phone">Action</th>
										</tr>
									</thead>
									<tbody>
										@foreach($records as $q)
											@php
												
												$field = $q['Tables_in_'.db_name]

											@endphp

											@if($field != 'bread' && $field != 'bread_field')
												<tr data-id="{{$field}}">
													<td>{{ ucwords(str_replace('_', ' ', $field)) }}</td>
													<td>
														<a href="{{ base_url }}bread/generate/{{$field}}" class="btn btn-primary btn-sm">
															<i class="fa fa-edit"></i> Generate BREAD
														</a>
														@foreach($bread_exist as $be)
															@if($be['table_name'] == $field)
																<a href="{{ base_url }}bread/generate/{{$field}}" class="btn btn-default btn-sm">
																	<i class="fa fa-edit"></i> VIEW BREAD
																</a>
																<a href="{{ base_url }}bread/delete/{{$field}}" class="btn btn-danger btn-sm">
																	<i class="fa fa-times"></i> DELETE BREAD
																</a>
															@endif
														@endforeach
													</td>
												</tr>
											@endif
										@endforeach
									</tbody>
								</table>	
							</div>
							<!-- end widget content -->
							
						</div>
						<!-- end widget div -->
						
					</div>
					<!-- end widget -->
		
				</article>
				<!-- WIDGET END -->
				
			</div>
		
			<!-- end row -->
		
			<!-- row -->
		
			<div class="row">
		
				<!-- a blank row to get started -->
				<div class="col-sm-12">
					<!-- your contents here -->
				</div>
					
			</div>
		
			<!-- end row -->
		
		</section>
		<!-- end widget grid -->

	</div>
	<!-- END MAIN CONTENT -->
@endsection