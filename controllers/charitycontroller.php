<?php

class CharityController extends Controller
{
    function add()
    {
        if (!empty($_POST['name'])) {
            $c = new Charity();
            $c->name = $_POST['name'];
            $c->description = $_POST['description'];
            $c->image_url = $_POST['image_url'];
            $c->missionfish_id = $_POST['missionfish_id'];
            $c->save();
            return array(
                'added'=>$c,
            );
        }
        return array(
        );
    }
    
    function listing()
    {
        return array(
            'charities'=>Charity::find('all'),
        );
    }
}