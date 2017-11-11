<?php

class Controller_Public extends Controller_Template
{
	public function before()
	{
		parent::before();
		$this->response = Response::forge();
		$this->response->set_header('X-FRAME-OPTIONS', 'SAMEORIGIN');
		//header.phpをテンプレートの$headerとbindさせる。
		$this->template->header = View::forge('parts/header');
		//footer.phpをテンプレートの$footerとbindさせる。
		$this->template->footer = View::forge('parts/footer');
	}

	public function after($response)
	{
		$response = parent::after($response);
		// $response = $this->response;
		$response->body = $this->template;
		return parent::after($response);
	}
}
