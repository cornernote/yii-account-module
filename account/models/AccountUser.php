<?php

/**
 * AccountUser
 *
 * @property string $name
 *
 * --- BEGIN ModelDoc ---
 *
 * Table account_user
 * @property string $id
 * @property string $email
 * @property string $username
 * @property string $password
 * @property string $first_name
 * @property string $last_name
 * @property string $timezone
 * @property integer $activated
 * @property integer $disabled
 *
 * @see \CActiveRecord
 * @method \AccountUser find($condition = '', array $params = array())
 * @method \AccountUser findByPk($pk, $condition = '', array $params = array())
 * @method \AccountUser findByAttributes(array $attributes, $condition = '', array $params = array())
 * @method \AccountUser findBySql($sql, array $params = array())
 * @method \AccountUser[] findAll($condition = '', array $params = array())
 * @method \AccountUser[] findAllByPk($pk, $condition = '', array $params = array())
 * @method \AccountUser[] findAllByAttributes(array $attributes, $condition = '', array $params = array())
 * @method \AccountUser[] findAllBySql($sql, array $params = array())
 * @method \AccountUser with()
 * @method \AccountUser together()
 * @method \AccountUser cache($duration, $dependency = null, $queryCount = 1)
 * @method \AccountUser resetScope($resetDefault = true)
 * @method \AccountUser populateRecord($attributes, $callAfterFind = true)
 * @method \AccountUser[] populateRecords($data, $callAfterFind = true, $index = null)
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