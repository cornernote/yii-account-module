<?php

/**
 * AccountUser
 *
 * @property string $name
 *
 * --- BEGIN ModelDoc ---
 *
 * Table account_user
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 *
 * @see CActiveRecord
 * @method User find() find($condition = '', array $params = array())
 * @method User findByPk() findByPk($pk, $condition = '', array $params = array())
 * @method User findByAttributes() findByAttributes(array $attributes, $condition = '', array $params = array())
 * @method User findBySql() findBySql($sql, array $params = array())
 * @method User[] findAll() findAll($condition = '', array $params = array())
 * @method User[] findAllByPk() findAllByPk($pk, $condition = '', array $params = array())
 * @method User[] findAllByAttributes() findAllByAttributes(array $attributes, $condition = '', array $params = array())
 * @method User[] findAllBySql() findAllBySql($sql, array $params = array())
 * @method User with() with()
 *
 * --- END ModelDoc ---
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-account-module
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-account-module/master/LICENSE
 *
 * @package yii-account-module
 */
class AccountUser extends AccountActiveRecord
{

    /**
     * Returns the static model of the specified AR class.
     * @param string $className
     * @return AccountUser the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }

}