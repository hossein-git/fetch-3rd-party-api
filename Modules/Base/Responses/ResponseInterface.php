<?php

namespace Modules\Base\Responses;


interface ResponseInterface
{
    public function tokenNotFound();

    public function loggedIn(string $mode,array $user);

    public function youShouldBeGuest();

    public function emailNotValid();

    public function blockedUser();

    public function tokenSent();

    public function userNotFound();

    public function created();

    public function createdFailed();

}
