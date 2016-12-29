<?php

class Requests extends ModelBase
{

	public $id;

	public $status_id;

	public $text;

	public $type;

	public $timestamp;

	public $userIp;

	public function initialize()
	{
		$this->hasOne('status_id', 'Status', 'id');

		$this->hasMany('id', 'Vote', 'request_id', [
			'alias' => 'vote',
			'foreignKey' => [
				'action' => \Phalcon\Mvc\Model\Relation::ACTION_CASCADE,
			]
		]);
	}

	public function getObject()
	{
		return [
			'id' 			=> $this->id,
			'status' 		=> $this->getStatusName(),
			'vote'			=> $this->countVote(),
			'text' 			=> $this->text,
			'type' 			=> $this->type
		];
	}

	public function getStatusName()
	{
		if ($this->status_id != 0) {
			return $this->getStatus()->name;
		} else {
			return '';
		}
	}

	public function countVote()
	{
		return $this->getVote()->count();
	}
}
