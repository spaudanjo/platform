<?php

namespace Ushahidi\Entity;

interface AlertSubscriptionRepository
{
	public function get($id);

	public function getAll();

	// public function search()
}

?>