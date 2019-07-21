<?php
namespace Wharris21\ObjectOriented;

require_once("../Classes/Author.php");

$will = new Author("379dae82-5a2b-4c4b-8193-b8e7749a3495", "http://blog.eu.playstation.com/files/avatars/avatar_166315.jpg", "abc123xyz789", "wharris21@cnm.edu", '$argon2i$v=19$m=1024,t=384,p=2$dE55dm5kRm9DTEYxNFlFUA$nNEMItrDUtwnDhZ41nwVm7ncBLrJzjh5mGIjj8RlzVA', "wharris21");

var_dump($will);
