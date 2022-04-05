<?php

namespace Model;

use Core\ModelAbstract;

class User extends ModelAbstract
{
    private int $id;
    private string $name;
    private string $lastName;
    private string $email;
    private string $password;
    private int $roleId;
    private string $nickname;
    private int $active;
    private string $createdAt;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }


    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return int
     */
    public function getRoleId(): int
    {
        return $this->roleId;
    }

    /**
     * @param int $roleId
     */
    public function setRoleId(int $roleId): void
    {
        $this->roleId = $roleId;
    }

    /**
     * @return string
     */
    public function getNickname(): string
    {
        return $this->nickname;
    }

    /**
     * @param string $nickname
     */
    public function setNickname(string $nickname): void
    {
        $this->nickname = $nickname;
    }

    /**
     * @return int
     */
    public function getActive(): int
    {
        return $this->active;
    }

    /**
     * @param int $active
     */
    public function setActive(int $active): void
    {
        $this->active = $active;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    /**
     * @param string $createdAt
     */
    public function setCreatedAt(string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function checkEmail($email)
    {
        $sql = $this->select();
        $sql->cols(['*'])->from('users')->where('email = :email');
        $sql->bindValue('email', $email);
        $rez = $this->db->get($sql);
        return empty($rez);
    }
    public function checkNickname($nickname)
    {
        $sql = $this->select();
        $sql->cols(['*'])->from('users')->where('nickname = :nickname');
        $sql->bindValue('nickname', $nickname);
        $rez = $this->db->get($sql);
        return empty($rez);
    }
    public function save()
    {
        if (!isset($this->id)) {
            $this->create();
        } else {
            $this->update();
        }
    }

    private function create(): void
    {
        $data = [
            'name' => $this->name,
            'last_name' => $this->lastName,
            'email' => $this->email,
            'password' => $this->password,
            'role_id' => $this->roleId,
            'nickname' => $this->nickname,
            'active' => $this->active,

        ];

        $sql = $this->insert()->into('users')->cols($data);
        $this->db->execute($sql);
    }

    public function checkLoginCredentials(string $email, string $hash): ?int
    {
        $sql = $this->select();
        $sql->cols(['id'])->from('users')->where('email = :email')->where('password = :password');
        $sql->bindValues(['email' => $email, 'password' => $hash]);

        if ($rez = $this->db->get($sql)) {
            return $rez['id'];
        } return null;
    }
    public function load(int $id): User
    {
        $sql = $this->select();
        $sql->cols(['*'])->from('users')->where('id = :id');
        $sql->bindValue('id', $id);
        if ($data = $this->db->get($sql)) {
            $this->id = (int)$data['id'];
            $this->name = (string)$data['name'];
            $this->lastName = (string)$data['last_name'];
            $this->email = (string)$data['email'];
            $this->nickname = (string)$data['nickname'];
            $this->password = (string)$data['password'];
            $this->active = (bool)$data['active'];
            $this->roleId = (int)$data['role_id'];
            $this->createdAt = (string)$data['created_at'];

        } return $this;
    }
}