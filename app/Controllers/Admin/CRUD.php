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
			* Search menu by slug
			* 
			*/
			$slug = self::get_slug();
			$model = new Model;
			$menu = $model->select('*')
			->from('menu')
			->where('slug', $slug)
			->get();

			/**
			* 
			* Cek menu
			* 
			*/
			if($menu->num_rows > 0)
			{
				$menu_data = $menu->fetch_assoc();

				/**
				* 
				* Search table data
				* 
				*/
				$table = $model->select('*')
				->from($menu_data['table_name'])
				->get();

				if($menu->num_rows > 0)
				{
					/**
					* 
					* BREAD data
					* 
					*/
					$bread = $model->select('*')
					->from('menu_row')
					->where('menu_id', $menu_data['id'])
					->orderBy('orderr', 'ASC')
					->get();


					view('admin/crud/index', [
						'title' => 'CRUD',
						'plugin' => 'datatables',
						'records' => $table,
						'bread' => $bread,

						'breadcrumb_1' => 'Dashboard',
						'breadcrumb_2' => 'CRUD',
						'breadcrumb_1_url' => base_url . 'admin/dashboard',
						'breadcrumb_2_url' => '#',
					]);
				}
				else
				{
					echo 'Table found 404';

					exit;				
				}

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
		* GET SLUG
		* 
		*/
		public function get_slug()
		{
			return $_GET['url'];
		}
	}