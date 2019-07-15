<?php
namespace Wharris21\ObjectOriented;

require_once("autoload.php");
require_once("");

/**
 * Class Author
 * This class will contain all of the state variables and methods for any instance of Author
 * @package Wharris21\ObjectOriented
 */
class Author {
	use ValidateDate.php;
	use ValidateUuid.php;
	/**
	 * id for this Author; this is the primary key
	 * @var Uuid $authorId
	 */
	private $authorId;
	/**
	 * url for the author's avatar image
	 * @var string $authorAvatarUrl;
	 */
	private $authorAvatarUrl;
	/**
	 * string value for author's account activation/verification
	 * @var string $authorActivationToken;
	 */
	private $authorActivationToken;
	/**
	 * string value for author's email address
	 * @var string $authorEmail;
	 */
	private $authorEmail;
	/**
	 * string value for author's password
	 * @var string $authorHash;
	 */
	private $authorHash;
	/**
	 * string value for author's username
	 * @var string $authorUsername;
	 */
	private $authorUsername;

	/**
	 * constructor for Author class
	 *
	 * @param Uuid $authorId id of this author
	 * @param string $authorAvatarUrl url for author's avatar image
	 * @param string $authorActivationToken value for author account activation/verification
	 * @param string $authorEmail value for author's email address
	 * @param string $authorHash value of author's password
	 * @param string $authorUsername value of author's username
	 */
	public function __construct($authorId, $authorAvatarUrl, $authorActivationToken, $authorEmail, $authorHash, $authorUsername) {
	$this->setAuthorId($authorId);
	$this->setAuthorAvatarUrl($authorAvatarUrl);
	$this->setAuthorActivationToken($authorActivationToken);
	$this->setAuthorEmail($authorEmail);
	$this->setAuthorHash($authorHash);
	$this->setAuthorUsername($authorUsername);
	}
}
