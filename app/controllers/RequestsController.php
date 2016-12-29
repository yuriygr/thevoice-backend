<?php

use Phalcon\Mvc\Controller;

class RequestsController extends Controller
{
    public function getByType()
    {
		// Отчищаем тип от скверны
		$type = $this->request->get('type', 'striptags');

		// Проверка на наличие типа
		if (!$type) {
			throw new \Phalcon\Exception('Необходим тип');
		}

		// Ищем реквести с нужным статусом
		$requests = Requests::find([
			'type = :type:',
			'order' => 'timestamp DESC',
			'bind' => [
				'type' => $type
			]
		]);

		// Наполняем массив с реквестами
		$return_request = [];
		foreach($requests as $request)
			$return_request[] = $request->getObject();

		// Успешно возвращаем массив
		$res = [
			'status' => 'success',
			'requests' => $return_request
		];
		return $this->response->setJsonContent($res);
    }

    public function addReuqest()
    {
		// Отчищаем текст от скверны
		$request_text = $this->request->getPost('request_text', 'striptags');

		// Проверка на наличие текста
		if (!$request_text) {
			throw new \Phalcon\Exception('Введите текст');
		}

		// Создаём новую запись
		$request = new Requests();
		$request->text = $request_text;
		$request->timestamp = time();
		$request->userIp = $this->request->getClientAddress();

		// Сохраняем реквеста
		if (!$request->save()) {
			throw new \Phalcon\Exception('Реквест не добавился. ' . $request->getMessages()[0]);
		}

		// Выдаём новый реквест
		$res = [
			'status' => 'success',
			'request' => $request->getObject()
		];
		return $this->response->setJsonContent($res);
    }

    public function addVote()
    {
		// Отчищаем id от скверны
		$request_id = $this->request->getPost('request_id', 'int');

		// Проверка на наличие id
		if (!$request_id) {
			throw new \Phalcon\Exception('За что голосуешь, фраерок?');
		}	

		// Проверка на наличие реквеста
		$request = Requests::findFirstById($request_id);
		if (!$request) {
			throw new \Phalcon\Exception('Некуда голосовать, фраер');
		}

		// Самолайки
		if ($request->userIp === $this->request->getClientAddress() ) {
			throw new \Phalcon\Exception('Самолайк - плохо');
		}

		// Ищем лайки этого пидора за данный реквест
		$tmp_vote = Vote::findFirst([
			'request_id = :request_id: AND userIp = :userIp:',
			'bind' => [
				'request_id' => $request->id,
				'userIp' => $this->request->getClientAddress()
			]
		]);
		if ($tmp_vote) {
			throw new \Phalcon\Exception('Слыш, фраер, перебор');
		}

		// Создаём новую запись
		$vote = new Vote();
		$vote->request_id = $request->id;
		$vote->timestamp = time();
		$vote->userIp = $this->request->getClientAddress();

		// Сохраняем голос
		if (!$vote->save()) {
			throw new \Phalcon\Exception('Голос не добавился. ' . $vote->getMessages()[0]);
		}

		// Выдаём новый реквест
		$res = [
			'status' => 'success',
			'request' => $request->getObject()
		];
		return $this->response->setJsonContent($res);
    }
}