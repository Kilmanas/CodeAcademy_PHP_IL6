<?php

namespace Model;

use Core\AbstractModel;
use Helper\DBHelper;
use Helper\FormHelper;
use Model\City;

class User extends AbstractModel
{


    private $name;

    private $lastName;

    private $email;

    private $password;

    private $phone;

    private $cityId;

    private $city;

    private $active;

    public function __construct()
    {
        $this->table = 'users';


    }
    protected function assignData()
    {
        $this->data =  [
            'name' => $this->name,
            'last_name' => $this->lastName,
            'email' => $this->email,
            'password' => $this->password,
            'phone' => $this->phone,
            'city_id' => $this->cityId,
            'active' => $this->active

        ];
    }

    /**
     * @return mixed
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param mixed $active
     */
    public function setActive($active): void
    {
        $this->active = $active;
    }



    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    public function getCityId()
    {
        return $this->cityId;
    }

    public function getCity()
    {
        return $this->city;
    }


    public function setCityId($id)
    {
        $this->cityId = $id;
    }

    public function load($id)
    {
        $db = new DBHelper();
        $data = $db->select()->from('users')->where('id',$id)->getOne();
        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->lastName = $data['last_name'];
        $this->phone = $data['phone'];
        $this->email = $data['email'];
        $this->password = $data['password'];
        $this->cityId = $data['city_id'];
        $city = new City();
        $this->city = $city->load($this->cityId);
        $this->active = $data['active'];
        return $this;
    }



    public static function checkLoginCredentials($email, $pass)
    {
        $db = new DBHelper();
        $rez = $db
            ->select('id')
            ->from('users')
            ->where('email', $email)
            ->andWhere('password', $pass)
            ->andWhere('active', 1)
            ->getOne();

        if(isset($rez['id']) ){
            return $rez['id'];
            } else {
                return false;
            }

    }

    public static function getAllUsers()
    {
        $db = new DBHelper();
        $data = $db->select('id')->from('users')->get();
        $users = [];
        foreach ($data as $element){
            $user = new User();
            $user->load($element['id']);
            $users[] = $user;
        }

        return $users;
    }



}