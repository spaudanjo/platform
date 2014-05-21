<?php defined('SYSPATH') OR die('No direct access allowed.');

class Controller_OAuth extends Koauth_Controller_OAuth {

	/**
	 * @var  View  page template
	 */
	public $template = 'template';

	/**
	 * @var  View  page layout template
	 */
	public $layout = 'layout';

	/**
	 * @var  View  page header template
	 */
	public $header = 'header';

	/**
	 * @var  View  page footer template
	 */
	public $footer = 'footer';

	/**
	 * Authorize Requests
	 */
	public function action_get_authorize()
	{
		// Check for login first?
		$request = Koauth_OAuth2_Request::createFromRequest($this->request);
		$response = new OAuth2\Response();

		if (!$this->_oauth2_server->validateAuthorizeRequest($request, $response)) {
			$this->redirect('user/login');
		}

		// Don't do oauth response handling
		$this->_skip_oauth_response = TRUE;

		$auth = A1::instance();

		// Not logged in: rendirect to login
		if (! $auth->logged_in())
		{
			$this->redirect('user/login' . URL::query(array('from_url' => 'oauth/authorize'. URL::query()), FALSE));
		}
		// Logged in: Ask for authorization
		else
		{
			// Load the content template
			$this->template = $view = View::factory('oauth/authorize')
				->set('scopes', explode(' ', $this->request->query('scope')))
				->set('client_id', $this->request->query('client_id'));

			// Load the header/footer/layout
			$this->header = View::factory($this->header);
			$this->header->set('logged_in', $auth->logged_in());
			$this->footer = View::factory($this->footer);
			$this->layout = View::factory($this->layout)
				->bind('content', $this->template)
				->bind('header', $this->header)
				->bind('footer', $this->footer);

			$this->response->body($this->layout->render());
		}
	}

	/**
	 * Authorize Requests
	 */
	public function action_post_authorize()
	{
		$auth = A1::instance();

		// Not logged in: rendirect to login
		if (! $auth->logged_in())
		{
			// Redirect for GET request
			$this->redirect('oauth/authorize' . URL::query());
		}
		else
		{
			$user = $auth->get_user();
			// @todo CSRF validation
			$authorized = (bool) $this->request->post('authorize');
			$this->_oauth2_server->handleAuthorizeRequest(Koauth_OAuth2_Request::createFromRequest($this->request), new OAuth2\Response(), $authorized, $user->id);
		}
	}

	/**
	 * Token Requests
	 */
	public function action_post_token()
	{
		$server = service('oauth.server.auth');

		try
		{
			$response = $server->issueAccessToken();
		}
		catch (League\OAuth2\Server\Exception\ClientException $e)
		{

			// Throw an exception because there was a problem with the client's request
			$response = array(
				'error' =>  $server::getExceptionType($e->getCode()),
				'error_description' => $e->getMessage()
			);
			$this->response->headers($server::getExceptionHttpHeaders($server::getExceptionType($e->getCode())));
		}
		catch (Exception $e)
		{
			// Throw an error when a non-library specific exception has been thrown
			$response = array(
				'error' =>  'undefined_error',
				'error_description' => $e->getMessage()
			);
		}

		$this->response->headers('Content-Type', 'application/json');
		$this->response->body(json_encode($response));
	}

}
