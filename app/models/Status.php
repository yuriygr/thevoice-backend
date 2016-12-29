<?php

class Status extends ModelBase
{
	
	public $id;

	public $name;

	public function initialize()
	{
		$this->belongsTo('id', 'Requests', 'status_id');
	}
}
