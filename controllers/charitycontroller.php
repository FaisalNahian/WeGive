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
    
    function challenge($charity_id=0) {
        $user = $this->logged_in_user();
        
        $charity = Charity::find_by_id($charity_id);
        if (!$charity) throw new PageNotFoundException();
        
        return array(
            'charity'=>$charity,
        );
    }
    
    function donate($challenge_id) {
        $challenge = Challenge::find_by_id($challenge_id);
        if (!$challenge) throw new PageNotFoundException();
        
        return array(
            'challenge'=>$challenge,
            'charity'=>$challenge->charity,
            'challenger'=>$challenge->user,
        );
    }
    
    function show($id)
    {
        $c = Charity::find_by_id($id);
        if (!$c) throw new PageNotFoundException();
        
        return array(
            'charity'=>$c,
        );
    }
    
    function listing()
    {
        return array(
            'charities'=>Charity::find('all'),
            'hide_sidebar'=>true,
        );
    }
}