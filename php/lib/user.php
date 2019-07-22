<?php
namespace Wharris21\ObjectOriented;

require_once("../Classes/User.php");

$user = new User("379dae82-5a2b-4c4b-8193-b8e7749a3495", '$argon2i$v=19$m=1024,t=384,p=2$dE55dm5kRm9DTEYxNFlFUA$nNEMItrDUtwnDhZ41nwVm7ncBLrJzjh5mGIjj8RlzVA', "abc123xyz789", "wharris21@cnm.edu", "505-555-5555");

var_dump($user);