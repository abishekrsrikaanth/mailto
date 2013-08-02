<?php
namespace Abishekrsrikaanth\Mailto;

use Abishekrsrikaanth\Mailto\Providers\Mandrill\Mandrill;
use Abishekrsrikaanth\Mailto\Providers\PostMark\PostMark;

class Mailto
{
	public function Mandrill($credentials = array())
	{
		return new Mandrill($credentials);
	}

	public function PostMark($credentials = array())
	{
		return new PostMark($credentials);
	}
}