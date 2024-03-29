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
	 * @param string $newUserHash
	 * @throw \InvalidArgumentException if hash value is empty, or using wrong algorithm
	 * @throw \LengthException if hash value is wrong length
	 * @throw \TypeError if hash value is wrong type
	 **/
	public function setUserHash($newUserHash) {
		// trim whitespace and filter string passed in
		$newUserHash = trim($newUserHash);
		$newUserHash = filter_var($newUserHash, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		// if user hash value is empty, or too long, throw length exception
		if(empty($newUserHash) || strlen($newUserHash) !== 97) {
			throw(new \InvalidArgumentException("Password is a required field, please enter a password"));
		}
		if(strlen($newUserHash) !== 97) {
			throw(new \RangeException('Value must be 97 characters'));
		}
		// if hash type is not string, throw type error
		if(!is_string($newUserHash)) {
			throw(new \TypeError('Invalid type, expected type string'));
		}
		// if hash algorithm is incorrect, throw invalid argument exception
		$userHashInfo = password_get_info($newUserHash);
		if($userHashInfo['algoName'] !== 'argon2i') {
			throw(new \InvalidArgumentException('profile hash is invalid'));
		}
		$this->userHash = $newUserHash;
	}

	/**
	 * getter method for user location
	 *
	 * @return string value of user location
	 **/
	public function getUserLocation() : string {
		return $this->userLocation;
	}

	/**
	 * setter method for user location
	 *
	 * @param $newUserLocation
	 * @throw \TypeError if user location is wrong type
	 * @throw \LengthException if location value is too long
	 **/
	public function setUserLocation($newUserLocation) {
		// filter and sanitize string
		$newUserLocation = trim($newUserLocation);
		$newUserLocation = filter_var($newUserLocation, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		// if value is not a string, throw type error
		if(!is_string($newUserLocation)) {
			throw(new \TypeError('Invalid argument type, expected string'));
		}
		// if value is too large, throw length exception
		if(strlen($newUserLocation) > 20) {
			throw(new \LengthException('Value exceeds valid range (20 characters'));
		}
		$this->userLocation = $newUserLocation;
	}

	/**
	 * getter method for user email
	 *
	 * @return string value of user's email address
	 **/
	public function getUserEmail() : string {
		return $this->userEmail;
	}

	/**
	 * setter method for user email
	 *
	 * @param string $newUserEmail
	 * @throw \InvalidArgumentException if email address is not valid
	 * @throw \LengthException if value is empty or too large for database
	 * @throw \TypeError if value is wrong data type
	 **/
	public function setUserEmail($newUserEmail) {
		// trim and sanitize input
		$newUserEmail = trim($newUserEmail);
		$newUserEmail = filter_var($newUserEmail, FILTER_SANITIZE_EMAIL, FILTER_FLAG_EMAIL_UNICODE);
		// if value is wrong length, throw length exception
		if(empty($newUserEmail)) {
			throw(new \LengthException('Invalid length, must be between 0 and 128 characters'));
		}
		if(strlen($newUserEmail) > 128) {
			throw(new \RangeException('Value exceeds valid range (128 characters)'));
		}
		if(!is_string($newUserEmail)) {
			throw(new \TypeError('Invalid type, expected string'));
		}
		if(filter_var($newUserEmail, FILTER_VALIDATE_EMAIL, FILTER_FLAG_EMAIL_UNICODE)) {
			$this->userEmail = $newUserEmail;
		} else {
			throw(new \InvalidArgumentException('Email address not valid, please enter a valid value'));
		}
	}

	/**
	 * getter method for user's phone number
	 *
	 * @return string value of user's phone number
	 **/
	public function getUserPhoneNumber() : string {
		return $this->userPhoneNumber;
	}

	/**
	 *setter method for user's phone number
	 *
	 * @param string $newUserPhoneNumber
	 * @throw \TypeError if value is wrong data type
	 * @throw \LengthException if value is too long for database
	 **/
	public function setUserPhoneNumber($newUserPhoneNumber) {
		// trim and sanitize new phone number
		$newUserPhoneNumber = trim($newUserPhoneNumber);
		$newUserPhoneNumber = filter_var($newUserPhoneNumber, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		// if value is not a string, throw type error
		if(!is_string($newUserPhoneNumber)) {
			throw(new \TypeError('Invalid type, expected type string'));
		}
		// if value is too long for database, throw length exception
		if(strlen($newUserPhoneNumber) > 32) {
			throw(new \LengthException('Value exceeds valid range (32 characters)'));
		}
		$this->userPhoneNumber = $newUserPhoneNumber;
	}

	/**
	 * formats state variables for JSON serialization -- conversion into JSON format
	 *
	 * @return array of resulting variables to serialize
	 **/
	public function jsonSerialize() : array {
		$fields = get_object_vars($this);

		$fields["userId"] = $this->userId->toString();

		return($fields);
	}
}