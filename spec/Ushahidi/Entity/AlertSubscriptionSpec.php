<?php

namespace spec\Ushahidi\Entity;

use PhpSpec\ObjectBehavior;
use Phrophecy\Argument;

class AlertSubscriptionSpec extends ObjectBehavior
{

	function let()
	{
		$this->beConstructedWith(array(
			'id' => 1,
			'name' => 'Alert Subscription Spec Dummy 1'
		));
	}

	function it_has_an_id()
	{
		$this->id->shouldBe(1);
	}

	function it_has_an_name()
	{
		$this->name->shouldBe('Alert Subscription Spec Dummy 1');
	}
}







?>