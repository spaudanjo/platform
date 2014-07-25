<?php

namespace Ushahidi\Entity;

use Ushahidi\Entity;

class AlertSubscription extends Entity
{
	public $id;
	public $name;

	public function getResource()
	{
		return 'AlertSubscription';
	}
}


?>