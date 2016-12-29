<?php

class Vote extends ModelBase
{
	
	public $id;

	public $request_id;

	public $timestamp;

	public $userIp;

	public function initialize()
	{
		$this->belongsTo('request_id', 'Requests', 'id');
	}
}
