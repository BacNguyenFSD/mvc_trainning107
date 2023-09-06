b<?php
class App {

    private $__controller, $__action, $__params, $__routes, $__db;

    static public $app;

    function __construct() {
        global $routes, $config;

        self::$app = $this;

        $this->__routes = new Route();

        if (!empty($routes['default_controller'])) {
            $this->__controller = $routes['default_controller'];
        }

        $this->__action = 'index';
        $this->__params = [];

        if (class_exists('DB')) {
            $dbObject = new DB();
            $this->__db = $dbObject->db;
        }

        /**
         * $this->db->table('province)->get();
         */

        $this->handleUrl();
    }

    function getUrl() {
        /**
         * Lưu ý biến $_SERVER['PATH_INFO'] chỉ có giá trị khi
         * đằng sau đường dẫn chứa Folder project có các tham số
         * VD:
         *      http://localhost/php_unicode/PHP_advanced/Module5/mvc_trainning/ --> Không có PATH_INFO
         *      http://localhost/php_unicode/PHP_advanced/Module5/mvc_trainning/123/a --> Có PATH_INFO là 123/a
         */
        if (!empty($_SERVER['PATH_INFO'])) {
            $url = $_SERVER['PATH_INFO'];
        } else {
            $url = '/';
        }

        return $url;
    }

    /**
     * Tách url ra thành các thành phần tử của mảng:
     * Nếu url là: /home/index/a/b/c
     *   home 	--> Tương ứng với controller
     *   index	--> Tương ứng với các phương thức bên trong controller (còn gọi là action)
     *   a,b,c	--> Là các tham số
     */
    public function handleUrl() {
  
        $url = $this->getUrl();

        $url = $this->__routes->handleRoute($url);//Xử lý đường dẫn ảo thành đường dẫn thật


        $urlArr = array_filter(explode('/',$url));
        $urlArr = array_values($urlArr);

        $urlCheck = '';

        if (!empty($urlArr)) {
            foreach ($urlArr as $key => $item) {
                $urlCheck.= $item.'/';
                $fileCheck = rtrim($urlCheck, '/');
                $fileArr = explode('/',$fileCheck);
                $fileArr[count($fileArr)-1] = ucfirst($fileArr[count($fileArr)-1]);
                $fileCheck = implode('/', $fileArr);
                
                if (!empty($urlArr[$key-1])) {
                    unset($urlArr[$key-1]);
                }
        
                if (file_exists('app/controllers/'.($fileCheck).'.php')) {
                    $urlCheck = $fileCheck;
                    break;
                }
            }

            $urlArr = array_values($urlArr);
        }

        


        //Xử lý Controller
        if (!empty($urlArr[0])) {
            
            $this->__controller = ucfirst($urlArr[0]);   
        } else {
            $this->__controller = ucfirst($this->__controller);//Nếu url không tồn tại thì $this__controller = giá trị mặc định là home
        }

        //Xử lý khi $urlCheck rỗng
        if (empty($urlCheck)) {
            $urlCheck = $this->__controller;
        }

        if (file_exists('app/controllers/'.$urlCheck.'.php')) {
            require_once 'app/controllers/'.$urlCheck.'.php';

            //Kiểm tra class->__controller tồn tại
            if (class_exists($this->__controller)) {
                $this->__controller = new $this->__controller(); //Ở đây $this->__controller = Home ==> new $this->__controller() = new Home();
                unset($urlArr[0]); //Loại bỏ phần tử khỏi mảng sau khi đãn gán phần tử đó cho __controller

                if (!empty($this->__db)) {
                    $this->__controller->db = $this->__db;
                }
            } else {
                $this->loadError();
            }
        } else {
            $this->loadError();
        }

        if (!empty($urlArr[1])) { //Kiểm tra xem action có tồn tại hay không
            //Xử lý action
            $this->__action = $urlArr[1];
            unset($urlArr[1]); //Loại bỏ phần tử khỏi mảng sau khi đãn gán phần tử đó cho __action
        }

        //Xử lý params
        $this->__params = array_values($urlArr);//Qua các hàm unset ở trên thì các giá trị còn lại trong mảng chỉ còn lại các tham số

        //Kiểm tra method tồn tại
        if (method_exists($this->__controller, $this->__action)) {
            call_user_func_array([$this->__controller, $this->__action], $this->__params);
        } else {
            $this->loadError();
        }
    }

    public function loadError($name='404', $data = []) {
        extract($data);
        require_once 'errors/'.$name.'.php';
    }
}