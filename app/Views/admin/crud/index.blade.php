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

								<div class="pull-right">
									<button class="btn btn-success btn-sm" id="tambah">
										<i class="fa fa-plus"></i> Add
									</button>
								</div>
					
								<table id="dt_basic" class="table table-striped table-bordered table-hover" width="100%">
									<thead>			                
										<tr>
											@foreach($bread as $br)
												<th {{ $br['orderr'] == 1 ? 'data-class="expand"' : 'data-hide="phone"' }} >
													{{ $br['display'] }}
												</th>
											@endforeach
											<th data-hide="phone">Action</th>
										</tr>
									</thead>
									<tbody>
										@foreach($records as $q)
											@php
												$keys = array();
												$keyss = array_keys($q);

												foreach($keyss as $keyss)
												{
													array_push($keys, $keyss);
												}
											@endphp
											<tr data-id="{{$q['id']}}">

												@foreach($bread as $brd)
													
													@foreach($keys as $key)
														
														@if($key == $brd['field'] && $brd['is_browse'] == 1)
																	
															<td>{{$q['name']}}</td>
														
														@endif
													
													@endforeach
												
												@endforeach
												<td>
													<button class="btn btn-primary btn-sm" onclick="Update({
														@foreach($bread as $brd)
															@foreach($keys as $key)
																@if($key == $brd['field'] && $brd['is_edit'] == 1)
																	{{$key}} : `{{$q['name']}}`,
																@endif
															@endforeach
														@endforeach
													})">
														<i class="fa fa-edit"></i> Update
													</button>
													<button class="btn btn-danger btn-sm" onclick="Delete({{$q['id']}})">
														<i class="fa fa-trash"></i> Delete
													</button>
												</td>
											</tr>
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

	<!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<form id="form">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
							&times;
						</button>
						<h4 class="modal-title" id="myModalLabel"></h4>
					</div>
					<div class="modal-body">
						<input type="hidden" name="id" id="id">
						@foreach($bread as $brad)
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label for="{{ $brad['field'] }}"> 
											{{ $brad['display'] }}
										</label>

										@if($brad['type'] != 'description' || $brad['type'] != 'select-option' || $brad['type'] == 'checkbox' || $brad['type'] == 'option')
											<input 
												type="{{ $brad['type'] }}" 
												class="form-control" 
												id="{{ $brad['field'] }}" 
												name="{{ $brad['field'] }}"
												placeholder="{{ $brad['display'] }}" 
												{{ $brad['is_required'] > 0 ? 'required' : '' }} 
											/>
										@elseif($brad['type'] == 'select-option')
											<select class="form-control" {{ $brad['is_required'] > 0 ? 'required' : '' }}>
												
											</select>
										@else

											<textarea 
												class="form-control" 
												id="{{ $brad['field'] }}"
												name="{{ $brad['field'] }}"
												placeholder="{{ $brad['display'] }}" 
												rows="3" 
												{{ $brad['is_required'] > 0 ? 'required' : '' }}></textarea>
										@endif
									</div>
								</div>
							</div>
						@endforeach						
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary">
							Submit
						</button>
						<button type="button" class="btn btn-danger" data-dismiss="modal">
							Cancel
						</button>
					</div>
				</div><!-- /.modal-content -->
			</form>
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
	<script type="text/javascript">
	    let type

	    $(() =>
	    {
		    // Submit
		    $('#form').submit(ev =>
		    {
		    	ev.preventDefault()

		    	$('#myModal').modal('hide')

		    	let id = $('#id').val()
		    	let name = $('#name').val()
		    	let description = $('#description').val()
		    	let status = $('#status').val()

		    	// Add data function
		    	if(type == 'ADD')
		    	{
			    	// Done message add data
		    		$.doneMessage('Add data success.','{{ $title }}')

			    	// Execute add data
		    		$.ajax({
		    			method: 'post',
		    			url: '{{ base_url }}admin/setting/level-create',
		    			data: {
		    				lev_name: name,
		    				lev_description: description,
		    				lev_status: status,
		    			}
		    		})
		    		.then(data => JSON.parse(data))
		    		.then(data =>
		    		{
			    		setInterval(() => { location.reload() }, 300)
		    		})
		    	}
		    	// Update data function
		    	else
		    	{
			    	// Done message update data
		    		$.doneMessage('Update data success.','{{ $title }}')

			    	// Execute update data
		    		$.ajax({
		    			method: 'put',
		    			url: '{{ base_url }}admin/setting/level-update',
		    			data: {
		    				lev_id: id,
		    				lev_name: name,
		    				lev_description: description,
		    				lev_status: status,
		    			}
		    		})
		    		.then(data => JSON.parse(data))
		    		.then(data =>
		    		{
			    		setInterval(() => { location.reload() }, 300)
		    		})	
		    	}
		    })

	    	// Delete Execute Function
	    	$('#OkCheck').on('click', ev => 
	    	{ 
	    		ev.preventDefault()

		    	$('#ModalCheck').modal('hide')
				
				// Done message delete data
	    		$.doneMessage('Delete data success.','{{ $title }}')

	    		// Id value
	    		let id = $('#idCheck').val()

		    	// Execute delete data
		    	$.ajax({
	    			method: 'delete',
	    			url: '{{ base_url }}admin/setting/level-delete',
	    			data: {
	    				lev_id: id
	    			}
	    		})
	    		.then(data =>
	    		{
			    	setInterval(() => { location.reload() }, 300)
	    		})
	    	})

	    })

		// Add button click
	    $('#tambah').on('click', ev =>
	    {
	    	ev.preventDefault()

	    	type = 'ADD'
	    	$('#id').val('')
	    	$('#name').val('')
	    	$('#description').val('')
	    	$('#status').val('')
	    	$('#myModalLabel').html('Add Data {{ $title }}')
	    	$('#myModal').modal('show')
	    })

		// Update button click
	    const Update = (id, name, description, status) =>
	    {
	    	type = 'UPDATE'
	    	$('#id').val(id)
	    	$('#name').val(name)
	    	$('#description').val(description)
	    	$('#status').val(status)
		    $('#myModalLabel').html('Update Data {{ $title }}')
	    	$('#myModal').modal('show')
	    }

	    // Delete button click
	    const Delete = (id) =>
	    {
	    	$('#LabelCheck').html('Form Delete {{ $title }}')
	    	$('#ContentCheck').html('Are you sure to delete this item ?')
	    	$('#ModalCheck').modal('show')
	    	$('#idCheck').val(id)
	    }
	</script>
@endsection