<?php
namespace Abishekrsrikaanth\Mailto;

use Abishekrsrikaanth\Mailto\Providers\Mandrill\Mandrill;

class Mailto
{
	public function Mandrill()
	{
		return new Mandrill();
	}
}