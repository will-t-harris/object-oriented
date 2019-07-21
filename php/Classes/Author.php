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
	 * @throw \RangeException if data values are out of bounds (values too long)
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
	 * @throw \RangeException if data values are out of bounds (values too long)
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
	public function getAuthorEmail() : string {
		return $this->authorEmail;
	}

	/**
	 * setter/mutator method for author email address
	 *
	 * @param string $newAuthorEmail new value of author email address
	 * @throw \InvalidArgumentException if email address field is empty
	 * @throw \RangeException if value exceed database limit
	 * @throw \TypeError if value type is not string
	 **/
	public function setAuthorEmail($newAuthorEmail) {
		// trim whitespace and sanitize string passed in
		$newAuthorEmail = trim($newAuthorEmail);
		$newAuthorEmail = filter_var($newAuthorEmail, FILTER_SANITIZE_STRING);
		// if email field is empty, throw invalid argument exception
		if(empty($newAuthorEmail) === TRUE) {
			throw(new \InvalidArgumentException("Email address is a required field, please enter an email address"));
		}
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
	public function getAuthorHash() : string {
		return $this->authorHash;
	}

	/**
	 * setter/mutator method for author hash/password
	 *
	 * @param string $newAuthorHash new value of author hash/password
	 * @throw \InvalidArgumentException if hash/password field is empty
	 *	@throw \RangeException if value exceed database limit
	 * @throw \TypeError if value type is not string
	 **/
	public function setAuthorHash($newAuthorHash) {
		// trim whitespace and sanitize string passed in
		$newAuthorHash = trim($newAuthorHash);
		$newAuthorHash = filter_var($newAuthorHash, FILTER_SANITIZE_STRING);
		// if hash/password field is empty, throw invalid argument exception
		if(empty($newAuthorHash) === TRUE) {
			throw(new \InvalidArgumentException("Password is a required field, please enter a password"));
		}
		// if hash value is too large, throw range exception
		if(strlen($newAuthorHash) !== 97) {
			throw(new \RangeException("Value must be 97 characters"));
		}
		// if hash value is not a string, throw type error
		if(!is_string($newAuthorHash)) {
			throw(new \TypeError("Invalid type, expected type string"));
		}
		$authorHashInfo = password_get_info($newAuthorHash);
		if($authorHashInfo["algoName"] !== "argon2i") {
			throw(new \InvalidArgumentException("profile hash is not a valid hash"));
		}
		$this->authorHash = $newAuthorHash;
	}

	/**
	 * getter/accessor for author username
	 *
	 * @return string value for author user name
	 **/
	public function getAuthorUserName() : string{
		return $this->authorUsername;
	}

	/**
	 * setter/mutator method for author user name
	 *
	 * @param string $newAuthorUserName new value for author username
	 * @throw \InvalidArgumentException if user name field is empty
	 *	@throw \RangeException if value exceed database limit
	 * @throw \TypeError if value type is not string
	 **/
	public function setAuthorUserName($newAuthorUserName) {
		// trim whitespace and sanitize string passed in
		$newAuthorUserName = trim($newAuthorUserName);
		$newAuthorUserName = filter_var($newAuthorUserName, FILTER_SANITIZE_STRING);
		if(empty($newAuthorUserName) === TRUE) {
			throw(new \InvalidArgumentException("Username is a required field, please enter a username value"));
		}
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
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throw \PDOException when MySQL errors occur
	 * @throw \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo) : void {
		// create query template
		$query = "INSERT INTO author(authorId, authorAvatarUrl, authorActivationToken, authorEmail, authorHash, authorUsername) VALUES(:authorId, :authorAvatarUrl, :authorActivationToken, :authorEmail, :authorHash, :authorUsername)";
		$statement = $pdo->prepare($query);

		// bind the state variables to the place holders in the template
		$parameters = ["authorId" => $this->authorId->getBytes(), "authorAvatarUrl" => $this->authorAvatarUrl, "authorActivationToken" => $this->authorActivationToken, "authorEmail" => $this->authorEmail, "authorHash" => $this->authorHash, "authorUsername" => $this->authorUsername];
		$statement->execute($parameters);
	}

	/**
	 * Updates this Author in MySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throw \PDOException when MySQL errors occur
	 * @throw \TypeError if $pdo is not a PDO connection object
	 **/
	public function update(\PDO $pdo) : void {
		// create query template
		$query = "UPDATE author SET authorId = :authorId, authorAvatarUrl = :authorAvatarUrl, authorActivationToken = :authorActivationToken, authorEmail = :authorEmail, authorHash = :authorHash, authorUsername = :authorUsername";
		$statement = $pdo->prepare($query);

		$parameters = ["authorId" => $this->authorId->getBytes(), "authorAvatarUrl" => $this->authorAvatarUrl, "authorActivationToken" => $this->authorActivationToken, "authorEmail" => $this->authorEmail, "authorHash" => $this->authorHash, "authorUsername" => $this->authorUsername];
		$statement->execute($parameters);
	}

	/**
	 * Deletes this Author from MySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throw \PDOException when MySQL related errors occur
	 * @throw \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo) : void {
		// create query template
		$query = "DELETE FROM author WHERE authorId = :authorId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the placeholder in the template
		$parameters = ["authorId" => $this->authorId->getBytes()];
		$statement->execute($parameters);
	}

	/**
	 * Gets a single Author by authorId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid | string $authorId author id to search for
	 * @return Author | null Author found or null if not found
	 * @throw \PDOException when MySQL related errors occur
	 * @throw \TypeError when a variable is not the correct data type
	 **/
	public static function getAuthorByAuthorId(\PDO $pdo, $authorId) : ?Author {
		// sanitize the authorId before searching
		try {
			$authorId = self::validateUuid($authorId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		// create query template
		$query = "SELECT authorId, authorAvatarUrl, authorActivationToken, authorEmail, authorHash, authorUsername FROM author WHERE authorId = :authorId";
		$statement = $pdo->prepare($query);

		// bind the author id to the placeholder in the template
		$parameters = ["authorId" => $authorId->getBytes()];
		$statement->execute($parameters);

		// grab the author from MySQL
		try {
			// instantiate author variable
			$author = null;
			// set mode to fetch rows ass associative array
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			// fetch rows and store in variable
			$row = $statement->fetch();
			// if row exists
			if($row !== FALSE) {
				// set row
				$author = new Author($row["authorId"], $row["authorAvatarUrl"], $row["authorActivationToken"], $row["authorEmail"], $row["authorHash"], $row["authorUsername"]);
			}
		} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
			// return array
			return($author);
	}

	/**
	 *	Gets all authors matching author user name
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $authorUsername author user name to search for
	 * @return \SplFixedArray SplFixedArray of Authors found
	 * @throw \PDOException when MySQL related errors occur
	 * @throw \TypeError when variables are not the correct data type
	 **/
	public function getAuthorByAuthorUsername(\PDO $pdo, string $authorUsername) : \SplFixedArray {
		// sanitize the username before searching
		$authorUsername = trim($authorUsername);
		$authorUsername = filter_var($authorUsername, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($authorUsername) === TRUE) {
			throw(new \PDOException("Author username is invalid"));
		}

		// escape MySQL wild cards
		$authorUsername = str_replace("_", "\\_", str_replace("%", "\\%", $authorUsername));

		// create query template
		$query = "SELECT authorId, authorAvatarUrl, authorActivationToken, authorEmail, authorHash, authorUsername FROM author WHERE authorUsername LIKE :authorUsername";
		$statement = $pdo->prepare($query);

		// bind the author username to the placeholder in the template
		$authorUsername = "%$authorUsername%";
		$parameters = ["$authorUsername" => $authorUsername];
		$statement->execute($parameters);

		// build an array of author usernames
		$authors = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== FALSE) {
			try {
				$author = new Author($row["authorId"], $row["authorAvatarUrl"], $row["authorActivationToken"], $row["authorEmail"], $row["authorHash"], $row["authorUsername"]);
				$authors[$authors->key()] = $author;
				$authors->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}

		return($authors);
	}

	/**
	 * formats state variables for JSON serialization -- conversion into JSON format
	 *
	 * @return array of resulting variables to serialize
	 **/
	public function jsonSerialize() : array {
		$fields = get_object_vars($this);

		$fields["authorId"] = $this->authorId->toString();

		return($fields);
	}
}
