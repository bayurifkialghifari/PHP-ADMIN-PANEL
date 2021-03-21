<?php
	
	namespace App\Controllers\Admin;

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

			view('admin/bread/index', [
				'title' => 'BREAD',
				'plugin' => 'datatables',
				'records' => $table,

				'breadcrumb_1' => 'Dashboard',
				'breadcrumb_2' => 'BREAD',
				'breadcrumb_1_url' => base_url . 'admin/dashboard',
				'breadcrumb_2_url' => '#',
			]);
		}

		/**
		* @param
		* 
		* Generate bread
		* 
		*/
		public function generate($table)
		{
			/**
			* 
			* Get table rows
			* 
			*/
			$model = new Model;
			$field_table = $model->raw('describe ' . $table)
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
	}