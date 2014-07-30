<?php

namespace spec\Ushahidi\Entity;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AlertSubscriptionSpec extends ObjectBehavior
{
	function let()
	{
		$this->beConstructedWith(array(
			'id'          => 1,
			'name'         => 'Alert Subscription Test 1'
			));
	}

	function it_is_initializable()
	{
		$this->shouldHaveType('Ushahidi\Entity\AlertSubscription');
	}

	function it_has_an_id()
	{
		$this->id->shouldBe(1);
	}
	
	function it_has_a_name()
	{
		$this->name->shouldBe("Alert Subscription Test 1");
	}
}