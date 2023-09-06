<?php
class Home extends controller{

    public $province, $data;

    public function __construct() {
        $this->province = $this->model('HomeModel');       
    }

    public function index() {
        /*Sử dụng trong trường hợp có queryBuillder*/
        // $data = $this->province->getListProvince();
        // echo '<pre>';
        // print_r($data);
        // echo '</pre>';

        // echo '<hr/>';

        // $detail = $this->province->getDetailProvince('Hà Nội');
        // echo '<pre>';
        // print_r($detail);
        // echo '</pre>';

        // echo '<hr/>';
        
        /*Sử dụng trong trường hợp không có queryBuillder*/
        // $data = $this->province->all();
        // echo '<pre>';
        // print_r($data);
        // echo '</pre>';

        // echo '<hr/>';
        // $data = $this->province->find(2);
        // echo '<pre>';
        // print_r($data);
        // echo '</pre>';

        $data = [
            'email' => 'huyguyen@gmail.com',
            'password' => md5('3456'),
            'fullname' => 'Buy Nguyen'
        ];

        $check = $this->db->table('users')->insert($data);
        

        // $this->province->insertusers($data);
        // $data = $this->db->table('province')->get();
        // echo '<pre>';
        // print_r($data);
        // echo '</pre>';

    }   

    public function get_user() {
        $request = new Request();
        $data = $request->getFields();
        $this->render('users/add');
    }

    public function post_user() {
        $request = new Request();
       
        /**Set rules */
        $request->rules([
            'fullname' => 'required|min:5|max:30',
            'email' => 'required|email|min:6',
            'password' => 'required|min:3',
            'confirm_password' => 'required|match:password',            
        ]);

        //Set message
        $request->message([
            'fullname.required'=> 'Họ tên không được để trống',
            'fullname.min' => 'Họ tên phải lớn hơn 5 ký tự',
            'fullname.max' => 'Họ tên phải nhỏ hơn 30 ký tự',
            'email.required' => 'Email không được để trống',
            'email.email' => 'Định dạng email không hợp lệ',
            'email.min' => 'Email phải lớn hơn 6 ký tự',
            'password.required' => 'Mật khẩu không được để trống',
            'password.min' => 'Mật khẩu phải lớn hơn 3 ký tự',
            'confirm_password.required' => 'Nhập lại mật khẩu không được để trống',
            'confirm_password.match' => 'Mật khẩu nhập lại không khớp'
        ]);


        $validate = $request->validate();
        
        if (!$validate) {
            $this->data['errors'] = $request->errors();
        }

        $this->render('users/add', $this->data);
    }

}