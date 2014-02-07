<?php

/**
 * AccountUser
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-account
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-account/master/LICENSE
 *
 * @package yii-account-module
 *
 * --- BEGIN ModelDoc ---
 *
 * Table user
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
 */
class AccountUser extends CActiveRecord
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
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'user';
    }

    /**
     * @param array $rules
     * @return array validation rules for model attributes.
     */
    public function rules($rules = array())
    {
        $rules = array();

        // search fields
        if ($this->scenario == 'search') {
            $rules[] = array('id, username, first_name, last_name, email', 'safe');
        }

        // create/update
        if (in_array($this->scenario, array('create', 'update'))) {
            $rules[] = array('email, username, first_name', 'required');
            $rules[] = array('email, username', 'length', 'max' => 255);
            $rules[] = array('first_name, last_name', 'length', 'max' => 32);
            $rules[] = array('email', 'email');
        }

        return $rules;
    }

    /**
     * @param array $options
     * @return CActiveDataProvider
     */
    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.username', $this->lastname, true);
        $criteria->compare('t.first_name', $this->first_name, true);
        $criteria->compare('t.last_name', $this->last_name, true);
        $criteria->compare('t.email', $this->email, true);

        return new CActiveDataProvider(get_class($this), array(
            'criteria' => $criteria,
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }

}