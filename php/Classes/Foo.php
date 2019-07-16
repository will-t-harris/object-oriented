<?php
namespace Wharris21\ObjectOriented;

require_once("autoload.php");
require_once("");

/**
 * Class Author
 * This class will contain all of the state variables and methods for any instance of Author
 * @package Wharris21\ObjectOriented
 **/
class Author {
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
	 * @throw \RangeException if data values are out of bounds (strings too long, negative integers for CHAR
	 * @throw \TypeError if data types violate type hints
	 * @throw \Exception if some other error occurs
	 **/
	public function setAuthorId($newAuthorId) {
		try {
			// validate uuid for author id
			$uuid = self::validateUuid($newAuthorId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
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
	 * @param string $newAuthorAvatarUrl;
	 * @throws \RangeException if string exceeds database limit
	 **/
	public function setAuthorAvatarUrl($newAuthorAvatarUrl) {
		// verify url is correct
		$newAuthorAvatarUrl = trim($newAuthorAvatarUrl);
		$newAuthorAvatarUrl = filter_var($newAuthorAvatarUrl, FILTER_SANITIZE_URL);
		// verify url will fit in database
		if(strlen($newAuthorAvatarUrl) > 255) {
			throw(new \RangeException("URL content is too large!"));
		}
		// store the avatar url content
		$this->authorAvatarUrl = $newAuthorAvatarUrl;
	}

	/**
	 * getter/accessor function for author activation token
	 *
	 * @return string value for author activation token
	 **/
	public function getAuthorActivationToken() : string {
		return $this->authorActivationToken;
	}

	/**
	 * setter/mutator function for author verification/recovery token
	 *
	 * @param string $newAuthorActivationToken;
	 * @throw \RangeException if value exceed database limit
	 **/
	public function setAuthorActivationToken($newAuthorActivationToken) {
		$newAuthorActivationToken = trim($newAuthorActivationToken);
		$newAuthorActivationToken = filter_var($newAuthorActivationToken, FILTER_SANITIZE_STRING);
		if(strlen($newAuthorActivationToken) > 32) {
			throw (new \RangeException("value exceeds valid range(32 characters)"));
		}
		$this->authorActivationToken = $newAuthorActivationToken;
	}

}
