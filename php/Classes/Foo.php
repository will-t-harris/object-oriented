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
	 * string value to verify author's password
	 * @var string $authorHash;
	 */
	private $authorHash;
	/**
	 * string value for author's username
	 * @var string $authorUsername;
	 */
	private $authorUsername;
}
