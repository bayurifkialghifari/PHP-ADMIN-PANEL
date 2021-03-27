<?php
	
	namespace App\Controllers\Admin;

	use App\Core\Controller;
	use App\Core\Model;

	Class CRUD extends Controller
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
			* Search BREAD by slug
			* 
			*/
			$slug = self::get_slug();
			$model = new Model;
			$bread = $model->select('*')
			->from('bread')
			->where('slug', $slug)
			->get();


			/**
			* 
			* Cek BREAD
			* 
			*/
			if($bread->num_rows > 0)
			{
				$bread_data = $bread->fetch_assoc();

				/**
				* 
				* Search table data
				* 
				*/
				$table = $model->select('*')
				->from($bread_data['table_name']);
				$table = $table->get();

				/**
				* 
				* BREAD rows data
				* 
				*/
				$bread = $model->select('*')
				->from('bread_field')
				->where('bread_id', $bread_data['id'])
				->orderBy('orderr', 'ASC')
				->get();


				view('admin/crud/index', [
					'title' => $bread_data['display_name_singular'],
					'plugin' => 'datatables',
					'records' => $table,
					'bread' => $bread_data,
					'bread_field' => $bread,
					'slug' => $slug,

					'breadcrumb_1' => 'Dashboard',
					'breadcrumb_2' => 'CRUD',
					'breadcrumb_3' => $bread_data['display_name_singular'],
					'breadcrumb_1_url' => base_url . 'admin/dashboard',
					'breadcrumb_2_url' => '#',
					'breadcrumb_3_url' => '#',
				]);

			}
			else
			{
				echo 'Menu not found 404';

				exit;
			}
		}

		/**
		* @param
		* 
		* Create function
		* 
		*/
		public function create()
		{
			/**
			* 
			* Search BREAD by slug
			* 
			*/
			$slug = self::get_slug();
			$slug = explode('-', $slug)[0];
			$model = new Model;
			$bread = $model->select('*')
			->from('bread')
			->where('slug', $slug)
			->get();
			$bread = $bread->fetch_assoc();

			// Get all data
			$data = parent::all();

			// Create data
			$exe = $model->store($bread['table_name'], $data);

			echo json_encode($bread['table_name']);
		}

		/**
		* @param
		* 
		* Update function
		* 
		*/
		public function update()
		{
			/**
			* 
			* Search BREAD by slug
			* 
			*/
			$slug = self::get_slug();
			$slug = explode('-', $slug)[0];
			$model = new Model;
			$bread = $model->select('*')
			->from('bread')
			->where('slug', $slug)
			->get();
			$bread = $bread->fetch_assoc();

			// Get all data
			$data = parent::all();
			$id = array(array_keys($data)[0] => array_values($data)[0]);

			// Create data
			$exe = $model->update($id, $bread['table_name'], $data);

			echo json_encode($exe);
		}

		/**
		* @param
		* 
		* Delete function
		* 
		*/
		public function delete()
		{
			/**
			* 
			* Search BREAD by slug
			* 
			*/
			$slug = self::get_slug();
			$slug = explode('-', $slug)[0];
			$model = new Model;
			$bread = $model->select('*')
			->from('bread')
			->where('slug', $slug)
			->get();
			$bread = $bread->fetch_assoc();

			// Get all data
			$data = parent::all();

			// Create data
			$exe = $model->delete($data, $bread['table_name']);

			echo json_encode($exe);
		}

		/**
		* @param
		* 
		* GET SLUG
		* 
		*/
		public function get_slug()
		{
			return explode('/', $_GET['url'])[1];
		}
	}