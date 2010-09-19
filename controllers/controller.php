<?php

class PageNotFoundException extends Exception {}
class LoginException extends Exception {}

class Controller
{    
    private $services;
    function __construct($services)
    {
        $this->services = $services; 
    }
    
    protected function abs_url($method, array $args = array())
    {
        return 'http://'.$_SERVER['HTTP_HOST'].$this->abs_path($method,$args);
    }
    
    protected function abs_path($method, array $args = array())
    {
        array_unshift($args, $method);
        array_walk($args, function(&$arg){$arg = rawurlencode($arg);});
        
        return '/'.$this->controller_name().'/'.implode('/',$args);
    }
    
    protected function db()
    {
        return $this->services->db();
    }
    
    protected function session()
    {
        return $this->services->session();
    }
    
    public static function run(Services $services = NULL, $uri)
    {
        if (preg_match('!^/([a-z_]+)(?:/([a-z_]*)(?:/([^?]+))?)?/?(?:\?.*)?$!', $uri, $m)) {
            $controller_name = $m[1];
            $method_name = !empty($m[2]) ? $m[2] : 'index';
            $arguments = isset($m[3]) ? explode('/',$m[3]) : array();
            array_walk($arguments, function(&$arg){
                $arg = rawurldecode($arg);
            });                
        }
        else
        {
            $controller_name = 'index';
            $method_name = 'index';
            $arguments = array();
        }
        
        return self::run_controller($services, $controller_name, $method_name, $arguments);
    }    
    
    public static function run_controller(Services $services = NULL, $controller_name, $method_name, array $arguments)
    {
        $controller_class = strtolower($controller_name).'controller';

        try {
            $exists = class_exists($controller_class); // silly spl throws instead of returning false
        }
        catch(LogicException $e) {
            $exists = false;
        }
        
        if (!$exists) {
            throw new PageNotFoundException("can't find class $controller_class: ".$e->getMessage());
        }

        if (!method_exists($controller_class, $method_name)) {
            throw new PageNotFoundException("Class $controller_class lacks method $method_name");
        }

        $controller = new $controller_class($services);
        return $controller->run_method($method_name, $arguments);    
    }
    
    protected function run_method($method_name, array $arguments)
    {
        $result = call_user_func_array(array($this,$method_name), $arguments);

        if (!isset($result['template'])) $result['template'] = $method_name;
        if (!isset($result['controller_name'])) $result['controller_name'] = $this->controller_name();

        $result['current_user'] = $this->is_logged_in() ? $this->logged_in_user() : NULL;
        
        return $result;
    }
    
    protected function controller_name()
    {
        return strtolower(substr(get_class($this),0,-10));
    }


    ///////////////// user
    
    protected function login_user(User $user)
    {        
        $this->session()->user_id = $user->id;        
    }
    
    protected function is_logged_in()
    {
        return !!$this->session()->user_id;
    }
    
    protected function logged_in_user()
    {
        $id = $this->session()->user_id;
        if (!$id) throw new Exception("no id in session");
        
        $user = User::find_by_id($id);
        if (!$user) {
            $this->logout();
            throw new LoginException("Can't find user");     
        }
        
        return $user;       
    }
    
    protected function logout()
    {
        $this->session()->user_id = NULL;
    }
    
    //////////
    
    protected function return_to()
    {
        $returnto = $this->session()->get('return_to','/');
        $this->session()->set('return_to','/');
        
        return array(
            'redirect'=> $returnto,
        );        
    }
    
    protected function set_return_to($uri)
    {
        $this->session()->return_to = $uri;
    }
}
