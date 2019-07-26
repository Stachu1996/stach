<?php
/**
 * Created by PhpStorm.
 * User: Szymon
 * Date: 10.03.2019
 * Time: 21:59
 */

class UsersModel
{
    private $db;
    /**
     * UsersModel constructor.
     */
    public function lastInsertId(){
        return $this->db->lastInsertId();
    }

    public function __construct(){
        $this->db = new Database();
    }

    /**
     *  CREATE
     */ 
    public function createUser($user_email, $user_pass, $user_name, $user_surname, $user_level = 0){
        if(!$this->emailExist($user_email)){
            $user_registered = date("Y-m-d H:i:s");
            $this->db->query("INSERT INTO
                                    `users`(
                                        `user_email`,
                                        `user_pass`,
                                        `user_registered`,
                                        `user_name`,
                                        `user_surname`,
                                        `user_level`
                                    )
                                VALUES(
                                        :user_email,
                                        :user_pass,
                                        :user_registered,
                                        :user_name,
                                        :user_surname,
                                        :user_level
                                    )");
            $this->db->bind(':user_email', $user_email);
            $this->db->bind(':user_pass', $user_pass);
            $this->db->bind(':user_registered', $user_registered);
            $this->db->bind(':user_name', $user_name);
            $this->db->bind(':user_surname', $user_surname);
            $this->db->bind(':user_level', $user_level);
            return ($this->db->execute()) ? true : false;
        }else{
            throw new Exception(__("USER_ALREADY_CREATED"));
        }
    }

    public function createUserMeta($user_id, $meta_key, $meta_data){
        if(!$this->metaKeyExist($user_id, $meta_key)){
            $this->db->query("INSERT INTO
                `users_meta`(
                    `user_id`,
                    `user_meta_key`,
                    `user_meta_data`
                )
                VALUES(
                    :user_id,
                    :meta_key,
                    :meta_data
                )");
            $this->db->bind(':user_id', $user_id);
            $this->db->bind(':meta_key', $meta_key);
            $this->db->bind(':meta_data', $meta_data);
            return ($this->db->execute()) ? true : false;
        }else{
            throw new Exception(__("META_KEY_EXIST"));
        }
    }
    
    /**
     *  READ
     */
    public function getAllUsers(){
        $this->db->query("SELECT `user_id`, `user_email`, `user_registered`, `user_name`, `user_surname`, `user_level` FROM `users`");
        $results = $this->db->resultSet();
        return $results;
    }

    public function getAllUsersLevelActive(int $level_min=1, int $level_max=10, int $user_deleted=0){
        $this->db->query("SELECT `user_id`, `user_email`, `user_registered`, `user_name`, `user_surname`, `user_level` FROM `users` WHERE `user_level` >=:level_min AND `user_level`<=:level_max AND `user_deleted`=:user_active");
        $this->db->bind(':level_min', $level_min);
        $this->db->bind(':level_max', $level_max);
        $this->db->bind(':user_active', $user_deleted);
        $results = $this->db->resultSet();
        return $results;
    }

    public function getAllUsersLevelActiveOrder(int $level_min=1, int $level_max=10, int $user_deleted=0, $order_column='user_id', $order_type="ASC")
    {
        $this->db->query("SELECT `user_id`, `user_email`, `user_registered`, `user_name`, `user_surname`, `user_level` FROM `users` WHERE `user_level` >=:level_min AND `user_level`<=:level_max AND `user_deleted`=:user_active ORDER BY `$order_column` $order_type");
        $this->db->bind(':level_min', $level_min);
        $this->db->bind(':level_max', $level_max);
        $this->db->bind(':user_active', $user_deleted);
        $results = $this->db->resultSet();
        return $results;
    }

    public function getAllUsersActive($state = 0){
        $this->db->query("SELECT `user_id`, `user_email`, `user_registered`, `user_name`, `user_surname`, `user_level` FROM `users` WHERE `user_deleted` = $state ");
        $results = $this->db->resultSet();
        return $results;
    }

    public function getUser($id){
        $this->db->query("SELECT `user_id`, `user_email`, `user_registered`, `user_name`, `user_surname`, `user_level` FROM `users` WHERE `user_id` = :user_id");
        $this->db->bind(':user_id', $id);
        $result = $this->db->single();
        return $result;
    }

    public function getUserActive($id, $state = 0){
        $this->db->query("SELECT `user_id`, `user_email`, `user_registered`, `user_name`, `user_surname`, `user_level` FROM `users` WHERE `user_deleted` = $state AND `user_id` = :user_id");
        $this->db->bind(':user_id', $id);
        $result = $this->db->single();
        return $result;
    }

    public function getUserMeta($id){
        $this->db->query("SELECT `user_meta_key`,`user_meta_data` FROM `users_meta` WHERE `user_id` = :user_id");
        $this->db->bind(':user_id', $id);
        $results = $this->db->resultSetArray();
        return $results;
    }

    public function getUserId($email){
        $this->db->query("SELECT `user_id` FROM `users` WHERE `user_email` = :user_email");
        $this->db->bind(':user_email', $email);
        $result = $this->db->singleValue();
        return $result;
    }

    public function getUserEmail($id){
        $this->db->query("SELECT `user_email` FROM `users` WHERE `user_id` = :user_id");
        $this->db->bind(':user_id', $id);
        $result = $this->db->singleValue();
        return $result;
    }

    public function getUserLevel($id){
        $this->db->query("SELECT `user_level` FROM `users` WHERE `user_id` = :user_id");
        $this->db->bind(':user_id', $id);
        $result = $this->db->singleValue();
        return $result;
    }
    /**
     *  UPDATE
     */
    public function updateUser($user_id, $user_email, $user_name, $user_surname) : bool
    {
        if(Session::isUserAdmin() || Session::getUserId()){
            if($this->userExist($user_id)){
                if(!$this->emailExist($user_email) || $this->getUserEmail($user_id)==$user_email){
                    $this->db->query("UPDATE
                                                `users`
                                            SET
                                                `user_email` = :user_email,
                                                `user_name` = :user_name,
                                                `user_surname` = :user_surname
                                            WHERE
                                                `user_id` = :user_id");
                    $this->db->bind(':user_email', $user_email);
                    $this->db->bind(':user_name',$user_name);
                    $this->db->bind(':user_surname',$user_surname);

                    $this->db->bind(':user_id',$user_id);

                    return ($this->db->execute()) ? true : false;
                } else throw new Exception(__("EMAIL_EXIST"));
            } else throw new Exception(__("USER_DONT_EXIST"));
        }else throw new Exception(__("INSUFFICIENT_PERMISSIONS"));
    }

    public function updateUserExt($user_id, $user_email, $user_name, $user_surname, $user_level){
        if(isUserAdmin(1) || getUserId()==$user_id){
            if($user_level <= getUserLevel()){
                if($this->userExist($user_id)){
                    if(!$this->emailExist($user_email) || $this->getUserEmail($user_id)==$user_email){
                        $this->db->query("  UPDATE
                                                `users`
                                            SET
                                                `user_email` = :user_email,
                                                `user_name` = :user_name,
                                                `user_surname` = :user_surname,
                                                `user_level` = :user_level
                                            WHERE
                                                `user_id` = :user_id");
                        $this->db->bind(':user_email', $user_email);
                        $this->db->bind(':user_name',$user_name);
                        $this->db->bind(':user_surname',$user_surname);
                        $this->db->bind(':user_level',$user_level);

                        $this->db->bind(':user_id',$user_id);

                        return ($this->db->execute()) ? true : false;
                    }else{
                        throw new Exception("email exist");
                    }
                }else{
                    throw new Exception("user doesn't exist");
                }
            }else{
                throw new Exception("insufficient permissions");
            }
        }else{
            throw new Exception("insufficient permissions");
        }
    }

    public function updateUserPass($user_id, $user_pass){
        if(isUserAdmin(1) || getUserId()==$user_id){
            if($this->userExist($user_id)){
                $this->db->query("UPDATE `users` SET `user_pass` = :user_pass WHERE `user_id` = :user_id");
                $this->db->bind(":user_pass",$user_pass);
                $this->db->bind(":user_id",$user_id);
                return $this->db->execute() ? true : false;
            }else{
                throw new Exception("user doesn't exist");
            }
        }else{
            throw new Exception("insufficient permissions");
        }
    }

    public function updateUserMeta($user_id, $meta_key, $meta_data){
        if(isUserAdmin(1) || getUserId()==$user_id){
            if($this->metaKeyExist($user_id, $meta_key)){
                $this->db->query("  UPDATE
                                        `users_meta`
                                    SET
                                        `user_meta_data` = :meta_data
                                    WHERE
                                        `user_meta_key` = :meta_key
                                    AND
                                        `user_id` = :user_id");
                $this->db->bind(':meta_key', $meta_key);
                $this->db->bind(':meta_data', $meta_data);
                $this->db->bind(':user_id', $user_id);
                return ($this->db->execute()) ? true : false;
            }else{
                try{
                    $this->createUserMeta($user_id, $meta_key, $meta_data);
                }catch(Exception $e){
                    throw $e;
                }
            }
        }else{
            throw new Exception("insufficient permissions");
        }
    }

    public function disableUser($user_id, $state = 1){
        if(isUserAdmin(1)){
            if($this->userExist($user_id)){
                $this->db->query("UPDATE `users` SET `user_deleted` = :state WHERE `user_id` = :user_id");
                $this->db->bind(":user_pass",$state);
                $this->db->bind(":user_id",$user_id);
                return $this->db->execute() ? true : false;
            }else{
                throw new Exception("user doesn't exist");
            }
        }else{
            throw new Exception("insufficient permissions");
        }
    }
    
    /**
     *  DELETE
     */
    public function delUser($id){
        if(isUserAdmin(1)){
            $row = $this->getUser($id);
            if(!empty($row)){
                if($row->user_level < getUserLevel()){
                    if($row->user_id != getUserId()){
                        $this->db->query("DELETE FROM `users` WHERE `user_id` = :user_id");
                        $this->db->bind(':user_id', $id);
                        return ($this->db->execute()) ? true : false;
                    }else
                        throw new Exception('You are not allowed to remove your account');
                }else
                    throw new Exception('insufficient permissions');
            }else
                throw new Exception("user doesn't exist");
        }else
            throw new Exception("insufficient permissions");
    }

    public function delUsers($ids){
        foreach($ids as $id){
            delUser($id);
        }
    }

    public function delUserMeta($id){
        if(isUserAdmin(1) || $id == getUserId()){
            $row = $this->getUser($id);
            if(!empty($row)){
                $meta = $this->getUserMeta($id);
                if(!empty($meta)){
                    if($row->user_level <= getUserLevel()){
                        
                        $this->db->query("DELETE FROM `users_meta` WHERE `user_id` = :user_id");
                        $this->db->bind(':user_id', $id);
                        return ($this->db->execute()) ? true : false;

                    }else
                        throw new Exception('insufficient permissions');
                }else
                    throw new Exception('user meta is empty');
            }else
                throw new Exception("user doesn't exist");
        }else
            throw new Exception("insufficient permissions");
    }

    public function delUsersMeta($ids){
        foreach($ids as $id){
            delUserMeta($id);
        }
    }

    /**
     *  EXTRA
     */
    public function userExist($id){
        $this->db->query('SELECT `user_id` FROM users WHERE `user_id`=:user_id');
        $this->db->bind(':user_id', $id);
        $this->db->execute();
        return ($this->db->rowCount() > 0) ? true : false;
    }

    public function emailExist($email){
        $this->db->query('SELECT `user_email` FROM users WHERE `user_email`=:user_email');
        $this->db->bind(':user_email', $email);
        $this->db->execute();
        return ($this->db->rowCount() > 0) ? true : false;
    }
    
    public function metaKeyExist($user_id, $key){
        $this->db->query('SELECT `user_meta_key` FROM users_meta WHERE `user_id`=:user_id AND `user_meta_key`=:meta_key');
        $this->db->bind(':user_id', $user_id);
        $this->db->bind(':meta_key', $key);
        $this->db->execute();
        return ($this->db->rowCount() > 0) ? true : false;
    }

    /**
     *  EMPLOYEE TO
     */
    public function getEmployeeToCabinets($employee_id)
    {
        $this->db->query("SELECT `id`, `user_id`, `cabinet_id` FROM `employee_to_cabinet` WHERE `user_id` = :user_id ");
        $this->db->bind(':user_id', $employee_id);
        return $this->db->resultSet();
    }

    public function getEmployeesToCabinets()
    {
        $this->db->query("SELECT `id`, `user_id`, `cabinet_id` FROM `employee_to_cabinet`");
        return $this->db->resultSet();
    }

    public function getEmployeeToServices($employee_id)
    {
        $this->db->query("SELECT `id`, `user_id`, `service_id` FROM `employee_to_service` WHERE `user_id` = :user_id ");
        $this->db->bind(':user_id', $employee_id);
        return $this->db->resultSet();
    }

    public function getEmployeesToServices()
    {
        $this->db->query("SELECT `id`, `user_id`, `service_id` FROM `employee_to_service`");
        return $this->db->resultSet();
    }
}