<?php
/**
 *  S   T   A   C   H       F R A M E W O R K
 *  i   i   g   l   e
 *  m   n   i   e   l
 *  p   y   l   v   p
 *  l       e   e   f
 *  e           r   u
 *                  l
 */

    class Init
    {
        public function __construct()
        {
        /**
         * ROUTING
         */
            //READ REQUEST
            $request = new Request();
            //CREATE ROUTE
            $r = new Route($request);
            //REQUIRE list of routes in "app/config/routes.php"
            require_once __CONFIGDIR__ . 'routes.php';
            //RESOLVE ROUTE
            $r->resolve();
            //IF ROUTE IS NOT RESOLVED PLACE 404 file
            if(!$r->set){
                die('404');
            }
            $middleware = $r->set['middleware'];
            $controller = $r->set['controller'];
            $method = $r->set['method'];
            $attribute = isset($r->set['attribute']) ? $r->set['attribute'] : null;

        /**
         * Start Session
         */
            //TODO

        /**
         *  Handle middleware :)
         */
            try {
                // If middlewares are success run controller
                if(Middleware::check($middleware)){
                    $controller = $this->runController($controller, $method, $attribute, $request);
                }
            } catch (Exception $e) { // catch (\Throwable $th)
                //ob_clean();
                echo $e->getMessage();
            } catch (BadMethodCallException $e){
                echo $e->getMessage();
            }

        }

        /**
         * Run Controller
         */
        private function runController($controller, $method, $attribute, $request){
            if(!file_exists(APPROOT.__CDIR__.$controller.'.php')) throw new BadMethodCallException("Controller don't exist");
            require_once(APPROOT.__CDIR__.$controller.'.php');
            $controller = explode('/', $controller);
            $controller = end($controller);
            //$controller = strstr($controller, '/')? ltrim(strstr($controller, '/'), '/') : $controller;
            $controller = new $controller();
            $controller->setRequest($request);

            if(!method_exists ($controller, $method)) throw new BadMethodCallException('Bad Controller method call');
            if($attribute!==null) return $controller->$method($attribute);

            return $controller->$method();
        }

    }