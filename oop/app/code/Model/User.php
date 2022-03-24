<?php

namespace Model;

use Core\AbstractModel;
use Core\Interfaces\ModelInterface;
use Helper\DBHelper;
use Helper\FormHelper;
use Model\City;

class User extends AbstractModel implements ModelInterface
{


    private string $name;

    private string $lastName;

    private string $email;

    private string $password;

    private string $phone;

    private int $cityId;

    private \Model\City $city;

    private bool $active;

    private int $role_id;

    protected const TABLE = 'users';

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName)
    {
        $this->lastName = $lastName;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(string $phone)
    {
        $this->phone = $phone;
    }

    public function getCityId(): int
    {
        return $this->cityId;
    }

    public function getCity(): \Model\City
    {
        return $this->city;
    }


    public function setCityId(int $id)
    {
        $this->cityId = $id;
    }
    /**
     * @return mixed
     */
    public function getRoleId(): int
    {
        return $this->role_id;
    }

    /**
     * @param mixed $role_id
     */
    public function setRoleId(int $role_id): void
    {
        $this->role_id = $role_id;
    }

    public function __construct($id = null)
    {

        if ($id !== null) {
            $this->load($id);
        }
    }
    public function assignData(): void
    {
        $this->data =  [
            'name' => $this->name,
            'last_name' => $this->lastName,
            'email' => $this->email,
            'password' => $this->password,
            'phone' => $this->phone,
            'city_id' => $this->cityId,
            'active' => $this->active,
            'role_id' => $this->role_id
        ];
    }

    /**
     * @return mixed
     */
    public function getActive(): bool
    {
        return $this->active;
    }

    /**
     * @param mixed $active
     */
    public function setActive(bool $active): void
    {
        $this->active = $active;
    }





    public function load(int $id): User
    {
        $db = new DBHelper();
        $data = $db->select()->from(self::TABLE)->where('id',$id)->getOne();
        $this->id = (int)$data['id'];
        $this->name = (string)$data['name'];
        $this->lastName = (string)$data['last_name'];
        $this->phone = (string)$data['phone'];
        $this->email = (string)$data['email'];
        $this->password = (string)$data['password'];
        $this->cityId = (int)$data['city_id'];
        $city = new City();
        $this->city = $city->load($this->cityId);
        $this->active = (bool)$data['active'];
        $this->role_id = (int)$data['role_id'];
        return $this;
    }



    public static function checkLoginCredentials(string $email, string $pass): ?int
    {
        $db = new DBHelper();
        $rez = $db
            ->select('id')
            ->from(self::TABLE)
            ->where('email', $email)
            ->andWhere('password', $pass)
            ->andWhere('active', 1)
            ->getOne();

        if(isset($rez['id']) ){

            } return $rez['id'];



    }

    public static function getAllUsers(): array
    {
        $db = new DBHelper();
        $data = $db->select('id')->from(self::TABLE)->get();
        $users = [];
        foreach ($data as $element){
            $user = new User();
            $user->load($element['id']);
            $users[] = $user;
        }

        return $users;
    }



}