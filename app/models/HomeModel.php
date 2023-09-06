<?php
/**
 * Kế thừa từ class Model
 */
class HomeModel extends Model{
    // private $__table = 'province';

    function tableFill() {
        return 'province';
    }

    function fieldFill() {
        return '*';
    }

    function primaryKey() {
        return 'id';
    }

    // public function getList() {
    //     $data = $this->db->query("SELECT * FROM $this->__table")->fetchAll(PDO::FETCH_ASSOC);
    //     return $data;
    // }

    public function getDetail($id) {
        $data = [
            'Item 1',
            'Item 2',
            'Item 3'
        ];
        return $data[$id];
    }

    public function getListProvince() {
        // $data = $this->db->table('province')->whereLike('_name', '%Hà%')->select('*')->limit(2)->orderBy('id', 'ASC')->get();
        // $data = $this->db->table('products as p')->join('categories as c', 'p.cate_id=c.id')->join('users as u', 'c.users_id=u.id')->get();
        // $data = $this->db->table('province')
        // ->join('district', 'province.id=district._province_id')
        // ->select('province._name as ten_tinh, district._name as ten_huyen')
        // ->get();
        // return $data;
    }

    public function getDetailProvince($name) {
        $data = $this->db->table('province')->where('_name', '=', $name)->first();
        return $data;
    }

    public function insertUser($data) {
        // $this->db->table('users')->delete($id);
        $this->db->table('users')->insert($data);
        return $this->db->lastId();
    }
}