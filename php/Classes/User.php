<?php
namespace Wharris21\ObjectOriented;

require_once("autoload.php");
require_once(dirname(__DIR__) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;

/**
 * User class
 * this class will contain all of the state variables and methods for any instance of the User class
 *
 *
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
}