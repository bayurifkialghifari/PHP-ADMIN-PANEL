@extends('admin.main-page')
@section('content')
	
	@php
		
		use App\Core\Model;

		$model = new Model;
		$bread = $model->select('*')
		->from('bread')
		->where('table_name', $table)
		->get();
		$bread = $bread->fetch_assoc();

		$bread_field = $model->select('*')
		->from('bread_field')
		->where('bread_id', $bread['id'])
		->get();

	@endphp

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
		<div class="jarviswidget" id="wid-id-1" data-widget-editbutton="false" data-widget-custombutton="false">
			<!-- widget options:
				usage: <div class="jarviswidget" id="wid-id-0" data-widget-editbutton="false">
				
				data-widget-colorbutton="false"	
				data-widget-editbutton="false"
				data-widget-togglebutton="false"
				data-widget-deletebutton="false"
				data-widget-fullscreenbutton="false"
				data-widget-custombutton="false"
				data-widget-collapsed="true" 
				data-widget-sortable="false"
				
			-->
			<header>
				<span class="widget-icon"> <i class="fa fa-edit"></i> </span>
				<h2>BREAD </h2>				
				
			</header>

			<!-- widget div-->
			<div>
				
				<!-- widget edit box -->
				<div class="jarviswidget-editbox">
					<!-- This area used as dropdown edit box -->
					
				</div>
				<!-- end widget edit box -->
				
				<!-- widget content -->
				<div class="widget-body no-padding">
					
					<form method="post" action="{{ base_url }}bread/generate" id="checkout-form" class="smart-form" novalidate="novalidate">
						@if($bread_field->num_rows > 0)
							<input type="hidden" name="actions" value="update">
						@else
							<input type="hidden" name="actions" value="store">
						@endif
						<fieldset>
							<input type="hidden" name="table_name" value="{{ $table }}">
							<div class="row">
								<section class="col col-6">
									<label>Name</label>
									<input type="text" name="name" class="form-control" placeholder="BREAD Name" value="{{ isset($bread['name']) ? $bread['name'] : ucwords(str_replace('_', ' ', $table)) }}" required>
								</section>
								<section class="col col-6">
									<label>Icon</label>
									<input type="text" name="icon" class="form-control" placeholder="BREAD Icon" value="{!! isset($bread['icon']) ? $bread['icon'] : '' !!}" required>
								</section>
							</div>
							<div class="row">
								<section class="col col-6">
									<label>Display Name Singular</label>
									<input type="text" name="display_name_singular" class="form-control" placeholder="Display Name Singular" value="{!! isset($bread['display_name_singular']) ? $bread['display_name_singular'] : '' !!}" required>
								</section>
								<section class="col col-6">
									<label>Controller</label>
									<input type="text" name="controller" class="form-control" placeholder="Controller Name ( \\App\\Controller\\Controller Name )" value="{!! isset($bread['controller']) ? $bread['controller'] : '' !!}" required>
								</section>
							</div>
							<div class="row">
								<section class="col col-6">
									<label>Description</label>
									<textarea class="form-control" name="description" placeholder="Description" rows="3">{!! isset($bread['description']) ? $bread['description'] : '' !!}</textarea>
								</section>
								<section class="col col-6">
									<label>Server Side</label>
									<input type="checkbox" name="server_side" class="form-control" value="1" checked>
								</section>
							</div>
						</fieldset>

						<fieldset>
							@php
								$no = 1;	
								$no1 = 1;
							@endphp
							@foreach($records as $r)
								@if($r['Key'] != 'PRI' && $r['Field'] != 'created_at' && $r['Field'] != 'updated_at')
									@if($bread_field->num_rows > 0)
										@foreach($bread_field as $f)
											@if($f['field'] == $r['Field'])
												<div class="row">
													<section class="col col-12">
														<b>{{ $no++ }} . {{ strtoupper(str_replace('_', ' ', $r['Field'])) }}</b>
													</section>
												</div>

												<input type="hidden" name="field-{{ $r['Field'] }}" value="{{ $r['Field'] }}">
												
												<div class="row">
													<section class="col col-2">
														<label><b>Action</b></label>
														<br>
														<input type="checkbox" name="browse-{{ $r['Field'] }}" value="1" {{ $f['is_browse'] == 1 ? 'checked' : '' }}> Browse
														<br>
														<input type="checkbox" name="edit-{{ $r['Field'] }}" value="1" {{ $f['is_edit'] == 1 ? 'checked' : '' }}> Edit
														<br>
														<input type="checkbox" name="add-{{ $r['Field'] }}" value="1" {{ $f['is_add'] == 1 ? 'checked' : '' }}> Add
													</section>
													<section class="col col-2">
														<label><b>Input Type</b></label>
														<br>
														<input type="radio" name="type-{{ $r['Field'] }}" value="text" {{ $f['type'] == 'text' ? 'checked' : '' }}> INPUT TYPE TEXT
														<br>
														<input type="radio" name="type-{{ $r['Field'] }}" value="number" {{ $f['type'] == 'number' ? 'checked' : '' }}> INPUT TYPE NUMBER
														<br>
														<input type="radio" name="type-{{ $r['Field'] }}" value="file" {{ $f['type'] == 'file' ? 'checked' : '' }}> INPUT TYPE FILE
													</section>
													<section class="col col-2">
														<label><b>Required</b></label>
														<br>
														<input type="radio" name="required-{{ $r['Field'] }}" value="1" {{ $f['is_required'] == 1 ? 'checked' : '' }}> YES
														<br>
														<input type="radio" name="required-{{ $r['Field'] }}" value="0" {{ $f['is_required'] == 0 ? 'checked' : '' }}> NO
													</section>
													<section class="col col-2">
														<label><b>Display Name</b></label>
														<br>
														<input type="text" class="form-control" placeholder="Display Name" name="display-{{ $r['Field'] }}" value="{{ $f['display_name'] }}">
													</section>
													<section class="col col-2">
														<label><b>Description</b></label>
														<br>
														<textarea class="form-control" name="description-{{ $r['Field'] }}" placeholder="Description" rows="3">{{ $f['details'] }}</textarea>
													</section>
													<section class="col col-2">
														<label><b>Order</b></label>
														<br>
														<input type="number" name="orderr-{{ $r['Field'] }}" value="{{ $f['orderr'] }}">
													</section>
												</div>
											@endif
										@endforeach
									@else
										<div class="row">
											<section class="col col-12">
												<b>{{ $no++ }} . {{ strtoupper(str_replace('_', ' ', $r['Field'])) }}</b>
											</section>
										</div>

										<input type="hidden" name="field-{{ $r['Field'] }}" value="{{ $r['Field'] }}">
										
										<div class="row">
											<section class="col col-2">
												<label><b>Action</b></label>
												<br>
												<input type="checkbox" name="browse-{{ $r['Field'] }}" value="1" checked> Browse
												<br>
												<input type="checkbox" name="edit-{{ $r['Field'] }}" value="1" checked> Edit
												<br>
												<input type="checkbox" name="add-{{ $r['Field'] }}" value="1" checked> Add
											</section>
											<section class="col col-2">
												<label><b>Input Type</b></label>
												<br>
												<input type="radio" name="type-{{ $r['Field'] }}" value="text" checked> INPUT TYPE TEXT
												<br>
												<input type="radio" name="type-{{ $r['Field'] }}" value="number"> INPUT TYPE NUMBER
												<br>
												<input type="radio" name="type-{{ $r['Field'] }}" value="file"> INPUT TYPE FILE
											</section>
											<section class="col col-2">
												<label><b>Required</b></label>
												<br>
												<input type="radio" name="required-{{ $r['Field'] }}" value="1"> YES
												<br>
												<input type="radio" name="required-{{ $r['Field'] }}" value="0" checked> NO
											</section>
											<section class="col col-2">
												<label><b>Display Name</b></label>
												<br>
												<input type="text" class="form-control" placeholder="Display Name" name="display-{{ $r['Field'] }}" value="{{ strtoupper(str_replace('_', ' ', $r['Field'])) }}">
											</section>
											<section class="col col-2">
												<label><b>Description</b></label>
												<br>
												<textarea class="form-control" name="description-{{ $r['Field'] }}" placeholder="Description" rows="3"></textarea>
											</section>
											<section class="col col-2">
												<label><b>Order</b></label>
												<br>
												<input type="number" name="orderr-{{ $r['Field'] }}" value="{{ $no1++ }}">
											</section>
										</div>
									@endif
								@endif
							@endforeach
							<div class="text-left">
								<button class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Add Relation</button>
							</div>
							<br>
							<div class="text-center">
								<a href="{{ base_url }}bread" class="btn btn-lg btn-danger">Cancel</a>
								<button type="submit" class="btn btn-lg btn-success">Save</button>
							</div>
						</fieldset>
					</form>

				</div>
				<!-- end widget content -->
				
			</div>
			<!-- end widget div -->
			
		</div>
		<!-- end widget grid -->

	</div>
	<!-- END MAIN CONTENT -->
@endsection