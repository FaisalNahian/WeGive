<?php

class UserController extends Controller
{
    /**
     * Profile page
     */
    function show($id)
    {
        $user = User::find_by_id($id);
        if (!$user) throw new PageNotFoundException();
        return array('user'=>$user);
    }
}