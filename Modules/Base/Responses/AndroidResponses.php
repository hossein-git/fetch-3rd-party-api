<?php

namespace Modules\Base\Responses;


use Illuminate\Http\Response;

class AndroidResponses implements ResponseInterface
{
    public function tokenNotFound()
    {
        return response()->json(['message' => 'Token is not valid']);
    }

    public function loggedIn($mode,$user)
    {
        return response()->json(['message' => 'You are logged in']);
    }

    public function youShouldBeGuest()
    {
        return response()->json(
            [
                'error' => 'you are logged in',
                Response::HTTP_BAD_REQUEST,
            ]
        );
    }

    public function emailNotValid()
    {
        return response()->json(
            [
                'error' => 'your email is not valid',
                Response::HTTP_BAD_REQUEST,
            ]
        );
    }

    public function blockedUser()
    {
        return response()->json(
            ['error' => 'You are blocked'],
            Response::HTTP_BAD_REQUEST
        );
    }

    public function tokenSent()
    {
        return response()->json(['message' => 'token was sent.']);
    }

    public function userNotFound()
    {
        return response()->json(
            ['error' => 'Email Does not Exist'],
            Response::HTTP_BAD_REQUEST
        );
    }

    public function created()
    {
        return response()->json(
            ['message' => 'Created Successfully'],
            Response::HTTP_CREATED
        );
    }

    public function createdFailed()
    {
        return response()->json(
            ['error' => 'Created failed'],
            Response::HTTP_INTERNAL_SERVER_ERROR
        );
    }
}






