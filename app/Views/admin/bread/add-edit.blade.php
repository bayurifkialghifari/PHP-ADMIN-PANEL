@extends('admin.main-page')
@section('content')
	
	@php
		
		use App\Core\Model;

		$model = new Model;
		$talbe_now = $model->select('*')
		->from('menu')
		->where('table_name', $table)
		->get();

		$table_now_data = $talbe_now->fetch_assoc();

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
					
					<form id="checkout-form" class="smart-form" novalidate="novalidate">

						<fieldset>
							@php
								$no = 1	
							@endphp
							@foreach($records as $r)
								@if($r['Key'] != 'PRI' && $r['Field'] != 'created_at' && $r['Field'] != 'updated_at')
									<div class="row">
										<section class="col col-12">
											<b>{{ $no++ }} . {{ strtoupper(str_replace('_', ' ', $r['Field'])) }}</b>
										</section>
									</div>

									<input type="hidden" name="field[{{ $r['Field'] }}]" value="{{ $r['Field'] }}">
									
									<div class="row">
										<section class="col col-2">
											<label><b>Action</b></label>
											<br>
											<input type="checkbox" name="browse[{{ $r['Field'] }}]" value="1" checked> Browse
											<br>
											<input type="checkbox" name="edit[{{ $r['Field'] }}]" value="1" checked> Edit
											<br>
											<input type="checkbox" name="add[{{ $r['Field'] }}]" value="1" checked> Add
										</section>
										<section class="col col-2">
											<label><b>Input Type</b></label>
											<br>
											<input type="radio" name="type[{{ $r['Field'] }}]" value="text" checked> INPUT TYPE TEXT
											<br>
											<input type="radio" name="type[{{ $r['Field'] }}]" value="number"> INPUT TYPE NUMBER
											<br>
											<input type="radio" name="type[{{ $r['Field'] }}]" value="file"> INPUT TYPE FILE
										</section>
										<section class="col col-2">
											<label><b>Required</b></label>
											<br>
											<input type="radio" name="required[{{ $r['Field'] }}]" value="1"> YES
											<br>
											<input type="radio" name="required[{{ $r['Field'] }}]" value="0" checked> NO
										</section>
										<section class="col col-2">
											<label><b>Display Name</b></label>
											<br>
											<input type="text" class="form-control" placeholder="Display Name" name="display[{{ $r['Field'] }}]" value="{{ strtoupper(str_replace('_', ' ', $r['Field'])) }}">
										</section>
										<section class="col col-2">
											<label><b>Description</b></label>
											<br>
											<textarea class="form-control" name="description[{{ $r['Field'] }}]" placeholder="Description" rows="3"></textarea>
										</section>
									</div>
								@elseif($r['Key'] == 'PRI')
									<input type="hidden" name="field[{{ $r['field'] }}]" value="{{ $r['field'] }}">
								@else
								@endif
							@endforeach
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