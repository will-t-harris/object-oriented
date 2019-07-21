<?php
namespace Wharris21\ObjectOriented;

require_once("autoload.php");
require_once(dirname(__DIR__) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;

/**
 * User class
 * this class will contain all of the state variables and methods for any instance of the User class
 *
 * @package Wharris21/ObjectOriented
 **/
class User implements \JsonSerializable {
	use ValidateUuid;

	/**
	 * id for this User; this is the primary key
	 * @var Uuid $userId
	 */
	private $userId;
	/**
	 * hash for this User; argon2i string
	 * @var string $userHash
	 */
	private $userHash;
	/**
	 * location for this User
	 * @var string $userLocation
	 **/
	private $userLocation;
	/**
	 * email address for this user
	 * @var string $userEmail
	 */
	private $userEmail;
	/**
	 * string value for user's phone number
	 * @var string $userPhoneNumber
	 */
	private $userPhoneNumber;

	/**
	 * constructor function for the User class
	 *
	 * @param Uuid $newUserId id of this user
	 * @param string $newUserHash password hash of this user
	 * @param string $newUserLocation location for this user
	 * @param string $newUserEmail email address for this user
	 * @param string $newUserPhoneNumber phone number for this user
	 * @throw \InvalidArgumentException if data types are not valid
	 * @throw \RangeException if data values are out of bounds (strings too long)
	 * @throw \TypeError if data types violate type hints
	 * @throw \Exception if some other error occurs
	 **/
	public function __construct($newUserId, $newUserHash, $newUserLocation, $newUserEmail, $newUserPhoneNumber) {
		try {
			$this->setUserId($newUserId);
			$this->setUserHash($newUserHash);
			$this->setUserLocation($newUserLocation);
			$this->setUserEmail($newUserEmail);
			$this->setUserPhoneNumber($newUserPhoneNumber);
		}
		// determine what exception type was thrown
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * getter method for user id
	 *
	 * @return Uuid value of user id
	 **/
	public function getUserId(): Uuid {
		return $this->userId;
	}

	/**
	 * setter method for user id
	 *
	 * @param Uuid $newUserId
	 * @throw \InvalidArgumentException if data type is not valid
	 * @throw \RangeException if data values are out of bounds (values too long)
	 **/
	public function setUserId($newUserId) {
		try {
			// validate Uuid for user id
				$uuid = self::validateUuid($newUserId);
		} catch(\InvalidArgumentException | \RangeException $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		// store user id
		$this->userId = $uuid;
	}

	/**
	 * getter method for user hash
	 * @return string value of user hash
	 **/
	public function getUserHash() : string {
		return $this->userHash;
	}

	/**
	 * setter method for user hash
	 *
	 *
	 **/
	public function setUserHash($newUserHash) {
		// trim whitespace and filter string passed in
		$newUserHash = trim($newUserHash);
		$newUserHash = filter_var($newUserHash, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	}
}