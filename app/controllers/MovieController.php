<?php

class MovieController extends BaseController {

	private $pagination_num = 18;

	public function index()
	{
		$Movies = Movie::orderBy('name')->paginate($this->pagination_num);
		
		$popular_count = Movie::where('popular', '=', '1')->count();
		$carousel_num = mt_rand(1, $popular_count-3);
		$Carousel_Movies = Movie::where('popular', '=', '1')->skip($carousel_num)->take(3)->get();

		return View::make('movie.index')
			->with(compact('Movies', 'Carousel_Movies'));
	}

	public function search()
	{
		$query = Input::get('query');

		$Movies = Movie::whereRaw(
			"MATCH(name) AGAINST(? IN BOOLEAN MODE)",
			array($query)
		)->paginate($this->pagination_num);

		$field = Input::get('query');

		return View::make('movie.filter')
			->with(compact('Movies', 'field'));
	}

	public function filter($field, $param)
	{
		$Movies = Movie::where($field, 'like', '%'.$param.'%')
			->orderBy('name')
			->paginate($this->pagination_num);

		$field = ucwords($field);
		if($param !== '1') {
			$field = ucwords($param);
		}

		return View::make('movie.filter')
			->with(compact('Movies', 'field'));
	}

	public function description($movie_link)
	{
		$Movies = Movie::where('link', '=', $movie_link)->orderBy('name')->first();

		if($Movies->year === '') {
			$movie_year = '';
		} else {
			$movie_year = '('.$Movies->year.')';
		}

		return View::make('movie.description')
			->with(compact('Movies', 'movie_year'));
	}

	public function preview($movie_link)
	{
		$Movies = Movie::where('link', '=', $movie_link)->orderBy('name')->first();

		if($Movies->year === '') {
			$movie_year = '';
		} else {
			$movie_year = '('.$Movies->year.')';
		}

		return View::make('movie.preview')
			->with(compact('Movies', 'movie_year'));
	}

}
