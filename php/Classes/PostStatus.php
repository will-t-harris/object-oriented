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

	/**
	 * constructor method for PostStatus class
	 *
	 * @param Uuid | string $newPostStatusId new value for post status id
	 * @param string $newPostStatusState new value for post status state
	 * @throw \InvalidArgumentException if data types are not valid
	 * @throw \RangeException if data values are out of bounds (values too long)
	 * @throw \TypeError if data types violate type hints
	 * @throw \Exception if some other error occurs
	 **/
	public function __construct($newPostStatusId, $newPostStatusState) {
		try {
			$this->postStatusId = $newPostStatusId;
			$this->postStatusState = $newPostStatusState;
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * getter method for post status id
	 *
	 * @return Uuid | string value for post status id
	 **/
	public function getPostStatusId() : Uuid {
		return $this->postStatusId;
	}

	/**
	 * setter method for post status id
	 *
	 * @param Uuid | string $newPostStatusId
	 * @throw \InvalidArgumentException if data type is not valid
	 * @throw \RangeException if argument is wrong length
	 **/
	public function setPostStatusId($newPostStatusId) {
		try{
			// validate Uuid for user id
			$uuid = self::validateUuid($newPostStatusId);
		} catch(\InvalidArgumentException | \RangeException $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		$this->postStatusId = $uuid;
	}

	/**
	 * getter method for post status state
	 *
	 * @return string value of post status state
	 **/
	public function getPostStatusState() : string {
		return $this->postStatusState;
	}
	
	/**
	 * setter method for post status state
	 * 
	 * @param string $newPostStatusState new value of post status' state
	 **/
	public function setPostStatusState($newPostStatusState) {
		
	}
}
