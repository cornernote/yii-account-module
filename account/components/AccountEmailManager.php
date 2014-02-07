<?php

/**
 * AccountEmailManager
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-account-module
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-account-module/master/LICENSE
 *
 * @package yii-account-module
 */
class AccountEmailManager
{

    /**
     * @param $user AccountUser
     * @return bool
     */
    public static function sendAccountLostPassword($user)
    {
        /** @var AccountModule $account */
        $account = Yii::app()->getModule('account');
        $emailManager = Yii::app()->emailManager;

        // get lost password link
        $token = Yii::app()->tokenManager->createToken(strtotime('+1day'), 'AccountLostPassword', $user->primaryKey, 1);
        $url = Yii::app()->createAbsoluteUrl('/account/resetPassword', array('user_id' => $user->primaryKey, 'token' => $token));

        // build the templates
        $template = 'account_lost_password';
        $message = $emailManager->buildTemplateMessage($template, array(
            'user' => $user,
            'url' => $url,
        ));

        // get the message
        $swiftMessage = Swift_Message::newInstance($message['subject']);
        $swiftMessage->setBody($message['message'], 'text/html');
        //$swiftMessage->addPart($message['text'], 'text/plain');
        $swiftMessage->setFrom($emailManager->fromEmail, $emailManager->fromName);
        $swiftMessage->setTo($user->{$account->emailField}, $user->name);

        // spool the email
        $emailSpool = $emailManager->getEmailSpool($swiftMessage, $user);
        $emailSpool->priority = 1; // highest priority
        $emailSpool->template = $template;
        return $emailSpool->save(false);

        // or send the email
        //return Swift_Mailer::newInstance(Swift_MailTransport::newInstance())->send($swiftMessage);
    }

    /**
     * @param $user AccountUser
     * @return bool
     */
    public static function sendAccountActivate($user)
    {
        /** @var AccountModule $account */
        $account = Yii::app()->getModule('account');
        $emailManager = Yii::app()->emailManager;

        // get lost password link
        $token = Yii::app()->tokenManager->createToken(strtotime('+1day'), 'AccountActivate', $user->primaryKey, 1);
        $url = Yii::app()->createAbsoluteUrl('/account/activate', array('user_id' => $user->primaryKey, 'token' => $token));

        // build the templates
        $template = 'account_activate';
        $message = $emailManager->buildTemplateMessage($template, array(
            'user' => $user,
            'url' => $url,
        ));

        // get the message
        $swiftMessage = Swift_Message::newInstance($message['subject']);
        $swiftMessage->setBody($message['message'], 'text/html');
        //$swiftMessage->addPart($message['text'], 'text/plain');
        $swiftMessage->setFrom($emailManager->fromEmail, $emailManager->fromName);
        $swiftMessage->setTo($user->{$account->emailField}, $user->name);

        // spool the email
        $emailSpool = $emailManager->getEmailSpool($swiftMessage, $user);
        $emailSpool->priority = 1; // highest priority
        $emailSpool->template = $template;
        return $emailSpool->save(false);

        // or send the email
        //return Swift_Mailer::newInstance(Swift_MailTransport::newInstance())->send($swiftMessage);
    }

    /**
     * @param $user AccountUser
     * @return bool
     */
    public static function sendAccountWelcome($user)
    {
        /** @var AccountModule $account */
        $account = Yii::app()->getModule('account');
        $emailManager = Yii::app()->emailManager;

        // build the templates
        $template = 'account_welcome';
        $message = $emailManager->buildTemplateMessage($template, array(
            'user' => $user,
        ));

        // get the message
        $swiftMessage = Swift_Message::newInstance($message['subject']);
        $swiftMessage->setBody($message['message'], 'text/html');
        //$swiftMessage->addPart($message['text'], 'text/plain');
        $swiftMessage->setFrom($emailManager->fromEmail, $emailManager->fromName);
        $swiftMessage->setTo($user->{$account->emailField}, $user->name);

        // spool the email
        $emailSpool = $emailManager->getEmailSpool($swiftMessage, $user);
        $emailSpool->priority = 1; // highest priority
        $emailSpool->template = $template;
        return $emailSpool->save(false);

        // or send the email
        //return Swift_Mailer::newInstance(Swift_MailTransport::newInstance())->send($swiftMessage);
    }

}
