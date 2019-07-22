<?php
namespace Wharris21\ObjectOriented;

require_once("autoload.php");
require_once(dirname(__DIR__) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;

/**
 * Post Status class
 *
 * this class will contain all the state variables and methods for the post status class
 *
 * @package Wharris21\ObjectOriented
 **/
class PostStatus implements \JsonSerializable {
	use ValidateUuid;

	/**
	 * id for this instance of post status; this is the primary key
	 * @var Uuid | string postStatusId
	 */
	private $postStatusId;
	/**
	 * state value for this instance of post status (active, deleted, etc)
	 * @var string postStatusState
	 */
	private $postStatusState;
}