<?php

class Movie extends Eloquent {

	protected $fillable = ['name', 'description', 'year', 'link', 'drive_link', 'category', 'latest', 'popular', 'language'];

}