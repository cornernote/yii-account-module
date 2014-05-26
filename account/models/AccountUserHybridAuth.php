<?php

/**
 * AccountUserHybridAuth
 *
 * --- BEGIN ModelDoc ---
 *
 * Table user_hybrid_auth
 * @property integer $id
 * @property integer $user_id
 * @property string $provider
 * @property string $identifier
 * @property string $email
 *
 * @see \CActiveRecord
 * @method \AccountUserHybridAuth find($condition = '', array $params = array())
 * @method \AccountUserHybridAuth findByPk($pk, $condition = '', array $params = array())
 * @method \AccountUserHybridAuth findByAttributes(array $attributes, $condition = '', array $params = array())
 * @method \AccountUserHybridAuth findBySql($sql, array $params = array())
 * @method \AccountUserHybridAuth[] findAll($condition = '', array $params = array())
 * @method \AccountUserHybridAuth[] findAllByPk($pk, $condition = '', array $params = array())
 * @method \AccountUserHybridAuth[] findAllByAttributes(array $attributes, $condition = '', array $params = array())
 * @method \AccountUserHybridAuth[] findAllBySql($sql, array $params = array())
 * @method \AccountUserHybridAuth with()
 * @method \AccountUserHybridAuth together()
 * @method \AccountUserHybridAuth cache($duration, $dependency = null, $queryCount = 1)
 * @method \AccountUserHybridAuth resetScope($resetDefault = true)
 * @method \AccountUserHybridAuth populateRecord($attributes, $callAfterFind = true)
 * @method \AccountUserHybridAuth[] populateRecords($data, $callAfterFind = true, $index = null)
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
class AccountUserHybridAuth extends AccountActiveRecord
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

}