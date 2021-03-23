<?php
	
	namespace App\Controllers\Admin;

	use Cocur\Slugify\Slugify;
	use App\Core\Controller;
	use App\Core\Model;

	Class BREAD extends Controller
	{

		/**
		* @param
		* 
		* Main function
		* 
		*/
		public function index()
		{
			/**
			* 
			* Get list table from database
			* 
			*/
			$model = new Model;
			$table = $model->raw('SHOW TABLES')
			->get();
			$get_bread = $model->select('table_name')
			->from('bread')
			->get();

			view('admin/bread/index', [
				'title' => 'BREAD',
				'plugin' => 'datatables',
				'records' => $table,
				'bread_exist' => $get_bread,

				'breadcrumb_1' => 'Dashboard',
				'breadcrumb_2' => 'BREAD',
				'breadcrumb_1_url' => base_url . 'admin/dashboard',
				'breadcrumb_2_url' => '#',
			]);
		}

		/**
		* @param
		* 
		* BREAD table detail
		* 
		*/
		public function detail($table)
		{
			/**
			* 
			* Get table rows
			* 
			*/
			$model = new Model;
			$field_table = $model->raw('DESCRIBE ' . $table)
			->get();

			/**
			* 
			* Cek table
			* 
			*/
			if($field_table->num_rows > 0)			
			{
				view('admin/bread/add-edit', [
					'title' => 'BREAD ' . strtoupper(str_replace('_', ' ', $table)),
					'plugin' => 'datatables',
					'records' => $field_table,
					'table' => $table,

					'breadcrumb_1' => 'Dashboard',
					'breadcrumb_2' => 'BREAD',
					'breadcrumb_3' => ucfirst(str_replace('_', ' ', $table)),
					'breadcrumb_1_url' => base_url . 'admin/dashboard',
					'breadcrumb_2_url' => base_url . 'bread',
					'breadcrumb_3_url' => '#',
				]);
			}
			else
			{
				echo 'Table found 404';

				exit;				
			}
		}

		/**
		* @param
		* 
		* Generate BREAD
		* 
		*/
		public function generate()
		{
			// Slug
			$slug = new Slugify();

			/**
			* 
			* Get request
			* 
			*/
			$request = parent::post_all();
			$table = $request['table_name'];
			$name = $request['name']; 
			$icon = $request['icon']; 
			$controller = $request['controller'];
			$description = $request['description'];
			$server_side = $request['server_side'];
			$display_name = $request['display_name_singular'];

			/**
			* 
			* Get table rows
			* 
			*/
			$model = new Model; 
			$field_table = $model->raw('DESCRIBE ' . $table)
			->get();

			// Cek Action
			if($request['actions'] == 'store')
			{
				/**
				* 
				* Generate bread
				* 
				*/ 
				$create_bread = $model->store('bread', [
					'name' => $name,
					'slug' => $slug->slugify($name),
					'display_name_singular' => $display_name,
					'display_name_plural' => $display_name,
					'icon' => $icon,
					'table_name' => $table,
					'controller' => $controller,
					'description' => $description,
					'server_side' => $server_side,
				]);
				$get_bread = $model->select('id')
				->from('bread')
				->orderBy('id', 'DESC')
				->limit('1')
				->get();
				$get_bread = $get_bread->fetch_assoc();
				$bread_id = $get_bread['id'];

				/**
				* 
				* Generate bread rows
				* 
				*/ 
				foreach($field_table as $ft)
				{
					if($ft['Field'] != 'created_at' && $ft['Field'] != 'updated_at' && $ft['Key'] != 'PRI')
					{
						$model->store('bread_field', [
							'bread_id' => $bread_id,
							'field' => $request['field-' . $ft['Field']],
							'type' => $request['type-' . $ft['Field']],
							'display_name' => $request['display-' . $ft['Field']],
							'is_required' => $request['required-' . $ft['Field']],
							'is_browse' => $request['browse-' . $ft['Field']],
							'is_edit' => $request['edit-' . $ft['Field']],
							'is_add' => $request['add-' . $ft['Field']],
							'details' => $request['description-' . $ft['Field']],
							'orderr' => $request['orderr-' . $ft['Field']],
						]);
					}
				}
			}
			else
			{
				/**
				* 
				* Get bread data
				* 
				*/ 
				$get_bread = $model->select('id')
				->from('bread')
				->where('table_name', $table)
				->limit('1')
				->get();
				$get_bread = $get_bread->fetch_assoc();
				$bread_id = $get_bread['id'];
				$get_bread_field = $model->select('field, id')
				->from('bread_field')
				->where('bread_id', $bread_id)
				->get();

				/**
				* 
				* Update bread
				* 
				*/
				$update = $model->update(['id' => $bread_id], 'bread', [
					'name' => $name,
					'slug' => $slug->slugify($name),
					'display_name_singular' => $display_name,
					'display_name_plural' => $display_name,
					'icon' => $icon,
					'table_name' => $table,
					'controller' => $controller,
					'description' => $description,
					'server_side' => $server_side,
				]);

				foreach($field_table as $ft)
				{
					if($ft['Field'] != 'created_at' && $ft['Field'] != 'updated_at' && $ft['Key'] != 'PRI')
					{
						foreach($get_bread_field as $bf)
						{
							if($ft['Field'] == $bf['field'])
							{
								$model->update(['id' => $bf['id']], 'bread_field', [
									'bread_id' => $bread_id,
									'field' => $request['field-' . $ft['Field']],
									'type' => $request['type-' . $ft['Field']],
									'display_name' => $request['display-' . $ft['Field']],
									'is_required' => $request['required-' . $ft['Field']],
									'is_browse' => $request['browse-' . $ft['Field']],
									'is_edit' => $request['edit-' . $ft['Field']],
									'is_add' => $request['add-' . $ft['Field']],
									'details' => $request['description-' . $ft['Field']],
									'orderr' => $request['orderr-' . $ft['Field']],
								]);
							}
						}
					}
				}
			}

			redirect_back();
		}
	}