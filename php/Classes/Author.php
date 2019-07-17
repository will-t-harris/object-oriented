<?php
namespace Wharris21\ObjectOriented;

require_once("autoload.php");
require_once(dirname(__DIR__) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;

/**
 * Class Author
 * This class will contain all of the state variables and methods for any instance of Author
 * @package Wharris21\ObjectOriented
 **/
class Author implements \JsonSerializable {
	use ValidateDate;
	use ValidateUuid;
	/**
	 * id for this Author; this is the primary key
	 * @var Uuid $authorId
	 **/
	private $authorId;
	/**
	 * url for the author's avatar image
	 * @var string $authorAvatarUrl;
	 **/
	private $authorAvatarUrl;
	/**
	 * string value for author's account activation/verification
	 * @var string $authorActivationToken;
	 **/
	private $authorActivationToken;
	/**
	 * string value for author's email address
	 * @var string $authorEmail;
	 **/
	private $authorEmail;
	/**
	 * string value for author's password
	 * @var string $authorHash;
	 **/
	private $authorHash;
	/**
	 * string value for author's username
	 * @var string $authorUsername;
	 **/
	private $authorUsername;

	/**
	 * constructor for Author class
	 *
	 * @param Uuid $authorId id of this author
	 * @param string $authorAvatarUrl url for author's avatar image
	 * @param string $authorActivationToken value for author account verification/recovery
	 * @param string $authorEmail value for author's email address
	 * @param string $authorHash value of author's password
	 * @param string $authorUsername value of author's username
	 * @throw \InvalidArgumentException if data types are not valid
	 * @throw \RangeException if data values are out of bounds (strings too long, negative integers for CHAR
	 * @throw \TypeError if data types violate type hints
	 * @throw \Exception if some other error occurs
	 **/
	public function __construct($authorId, $authorAvatarUrl, $authorActivationToken, $authorEmail, $authorHash, $authorUsername) {
		try {
			$this->setAuthorId($authorId);
			$this->setAuthorAvatarUrl($authorAvatarUrl);
			$this->setAuthorActivationToken($authorActivationToken);
			$this->setAuthorEmail($authorEmail);
			$this->setAuthorHash($authorHash);
			$this->setAuthorUsername($authorUsername);
		}
			// figure out what exception type was thrown
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * getter/accessor method for author id
	 *
	 * @return Uuid value of author id
	 **/
	public function getAuthorId() : Uuid {
		return($this->authorId);
	}

	/**
	 * setter/mutator method for author id
	 *
	 * @param Uuid | string $newAuthorId new value of author id
	 * @throw \InvalidArgumentException if data types are not valid
	 * @throw \RangeException if data values are out of bounds (strings too long, negative integers for CHAR)
	 **/
	public function setAuthorId($newAuthorId) {
		try {
			// validate uuid for author id
			$uuid = self::validateUuid($newAuthorId);
		} catch(\InvalidArgumentException | \RangeException $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		// store author id
		$this->authorId = $uuid;
	}

	/**
	 * getter/accessor method for author avatar url
	 *
	 * @return string value for author avatar url
	 **/
	public function getAuthorAvatarUrl() : string {
		return($this->authorAvatarUrl);
	}

	/**
	 * setter/mutator method for author avatar url
	 *
	 * @param string $newAuthorAvatarUrl new value for author avatar url
	 * @throw \RangeException if string exceeds database limit
	 * @throw \TypeError if value type is not string
	 **/
	public function setAuthorAvatarUrl($newAuthorAvatarUrl) {
		// verify url is correct
		$newAuthorAvatarUrl = trim($newAuthorAvatarUrl);
		$newAuthorAvatarUrl = filter_var($newAuthorAvatarUrl, FILTER_SANITIZE_URL);
		// verify url will fit in database
		if(strlen($newAuthorAvatarUrl) > 255) {
			throw(new \RangeException("URL exceeds valid range (255 characters)"));
		}
		// verify url is a string
		if(!is_string($newAuthorAvatarUrl)) {
			throw(new \TypeError("Invalid type, expected type string"));
		}
		// store the avatar url content
		if(filter_var($newAuthorAvatarUrl, FILTER_VALIDATE_URL)) {
			$this->authorAvatarUrl = $newAuthorAvatarUrl;
		} else {
			throw(new \InvalidArgumentException("Invalid URL, please try again"));
		}
	}

	/**
	 * getter/accessor method for author activation token
	 *
	 * @return string value for author activation token
	 **/
	public function getAuthorActivationToken() : string {
		return $this->authorActivationToken;
	}

	/**
	 * setter/mutator method for author verification/recovery token
	 *
	 * @param string $newAuthorActivationToken new value of author activation token
	 * @throw \RangeException if value exceed database limit
	 * @throw \TypeError if value type is not string
	 **/
	public function setAuthorActivationToken($newAuthorActivationToken) {
		// trim whitespace and sanitize string passed in
		$newAuthorActivationToken = trim($newAuthorActivationToken);
		$newAuthorActivationToken = filter_var($newAuthorActivationToken, FILTER_SANITIZE_STRING);
		// if length of string is too large, throw range exception
		if(strlen($newAuthorActivationToken) > 32) {
			throw(new \RangeException("value exceeds valid range(32 characters)"));
		}
		// if argument is not a string, throw type exception
		if(!is_string($newAuthorActivationToken)) {
			throw(new \TypeError("Invalid type, expected type string"));
		}
		$this->authorActivationToken = $newAuthorActivationToken;
	}

	/**
	 * getter/accessor method for author email address
	 *
	 * @return string value for author email address
	 **/
	public function getAuthorEmail() {
		return $this->authorEmail;
	}

	/**
	 * setter/mutator method for author email address
	 *
	 * @param string $newAuthorEmail new value of author email address
	 * @throw \RangeException if value exceed database limit
	 * @throw \TypeError if value type is not string
	 **/
	public function setAuthorEmail($newAuthorEmail) {
		// trim whitespace and sanitize string passed in
		$newAuthorEmail = trim($newAuthorEmail);
		$newAuthorEmail = filter_var($newAuthorEmail, FILTER_SANITIZE_STRING);
		// if email value is too large, throw range exception
		if(strlen($newAuthorEmail) > 128) {
			throw(new \RangeException("Value exceeds valid range (128 characters)"));
		}
		// if email value is not a string, throw type error
		if(!is_string($newAuthorEmail)) {
			throw(new \TypeError("Invalid type, expected type string"));
		}
		$this->authorEmail = $newAuthorEmail;
	}

	/**
	 * getter/accessor method for author hash/password
	 *
	 * @return string value for author hash/password
	 **/
	public function getAuthorHash() {
		return $this->authorHash;
	}

	/**
	 * setter/mutator method for author hash/password
	 *
	 * @param string $newAuthorHash new value of author hash/password
	 *	@throw \RangeException if value exceed database limit
	 * @throw \TypeError if value type is not string
	 **/
	public function setAuthorHash($newAuthorHash) {
		// trim whitespace and sanitize string passed in
		$newAuthorHash = trim($newAuthorHash);
		$newAuthorHash = filter_var($newAuthorHash, FILTER_SANITIZE_STRING);
		// if hash value is too large, throw range exception
		if(strlen($newAuthorHash) > 97) {
			throw(new \RangeException("Value exceeds valid range (97 characters)"));
		}
		// if hash value is not a string, throw type error
		if(!is_string($newAuthorHash)) {
			throw(new \TypeError("Invalid type, expected type string"));
		}
		$this->authorHash = $newAuthorHash;
	}

	/**
	 * getter/accessor for author username
	 *
	 * @return string value for author user name
	 **/
	public function getAuthorUserName() {
		return $this->authorUsername;
	}

	/**
	 * setter/mutator method for author user name
	 *
	 * @param string $newAuthorUserName new value for author username
	 *	@throw \RangeException if value exceed database limit
	 * @throw \TypeError if value type is not string
	 **/
	public function setAuthorUserName($newAuthorUserName) {
		// trim whitespace and sanitize string passed in
		$newAuthorUserName = trim($newAuthorUserName);
		$newAuthorUserName = filter_var($newAuthorUserName, FILTER_SANITIZE_STRING);
		// if username is too long, throw range exception
		if(strlen($newAuthorUserName) > 32) {
			throw(new \RangeException("Value exceeds valid range (32 characters)"));
		}
		// if username is not a string, throw type error
		if(!is_string($newAuthorUserName)) {
			throw(new \TypeError("Invalid type, expected type string"));
		}
		$this->authorUsername = $newAuthorUserName;
	}

	/**
	 * Inserts this Author into MySQL database
	 **/
	public function insert(\PDO $pdo) : void {
		// create query template
		$query = "INSERT INTO author(authorId, authorAvatarUrl, authorActivationToken, authorEmail, authorHash, authorUsername) VALUES(:authorId, :authorAvatarUrl, :authorActivationToken, :authorEmail, :authorHash, :authorUsername)";
		$statement = $pdo->prepare($query);
	}

	/**
	 * formats state variables for JSON serialization -- conversion into JSON format
	 *
	 * @return array of resulting variables to serialize
	 **/
	public function jsonSerialize() : array {
		$fields = get_object_vars($this);

		$fields["authorId"] = $this->authorId->toString();
		$fields["authorAvatarUrl"] = $this->authorAvatarUrl;
		$fields["authorActivationToken"] = $this->authorActivationToken;
		$fields["authorEmail"] = $this->authorEmail;
		$fields["authorHash"] = $this->authorHash;
		$fields["authorUsername"] = $this->authorUsername;

		return($fields);
	}
}
