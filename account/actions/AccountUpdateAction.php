<?php

/**
 * AccountUpdateAction
 *
 * @property AccountUserController $controller
 * @property array|string $returnUrl
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-account-module
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-account-module/master/LICENSE
 *
 * @package yii-account-module
 */
class AccountUpdateAction extends CAction
{

    /**
     * @var string
     */
    public $view = 'account.views.account.update';

    /**
     * @var string
     */
    public $formClass = 'AccountUpdate';

    /**
     * @var string
     */
    public $returnUrl = array('/account/index');

    /**
     * Update own account details.
     */
    public function run()
    {
        /** @var AccountUpdate $accountUpdate */
        $accountUpdate = new $this->formClass();
        $accountUpdate->userClass = $this->controller->userClass;
        $accountUpdate->firstNameField = $this->controller->firstNameField;
        $accountUpdate->lastNameField = $this->controller->lastNameField;
        $accountUpdate->emailField = $this->controller->emailField;
        $accountUpdate->usernameField = $this->controller->usernameField;

        // collect user input
        if (isset($_POST[$this->formClass])) {
            $accountUpdate->attributes = $_POST[$this->formClass];
            if ($accountUpdate->save()) {
                Yii::app()->user->addFlash(Yii::t('account', 'Your account has been updated.'), 'success');
                $this->controller->redirect(Yii::app()->returnUrl->getUrl($this->returnUrl));
            }
        }

        // display the update account form
        $this->render($this->view, array(
            'accountUpdate' => $accountUpdate,
        ));
    }

    /**
     * @return string
     */
    public function getReturnUrl()
    {
        if (!$this->_returnUrl)
            $this->_returnUrl = Yii::app()->user->returnUrl;
        return $this->_returnUrl;
    }

    /**
     * @param string $returnUrl
     */
    public function setReturnUrl($returnUrl)
    {
        $this->_returnUrl = $returnUrl;
    }

}
