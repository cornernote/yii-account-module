# Yii Account Module

Allows users to create and manage their account.


## Features

- Provides actions that can be used with current defaults, or easily extended to allow fully customisable account management.
- Included action classes: 
    - AccountLoginAction - Login to an account, optional ReCaptcha after 3 login attempts.
    - AccountLogoutAction - Logout from an account.
    - AccountSignUpAction - Sign up for a new account, can optionally send an account activation email, or can allow direct activation.
    - AccountActivateAction - Activate a new account once the secure email link is clicked.
    - AccountResendActivationAction - Resends the activation email incase it did not arrive.
    - AccountLostPassword - Request an email to be sent which will contain a secure link to allow a password reset, with optional ReCaptcha.
    - AccountResetPasswordAction - Checks for valid link and allows resetting the account password.
    - AccountUpdateAction - Update own account details.
    - AccountChangePasswordAction - Change own password details after verifying current password.
    - AccountViewAction - View own account details.
- Automatically detect the users timezone on signup.
- Does not impose a data structure, you can use your existing User table with your existing fields.
- Module uses [YiiEmailModule](http://cornernote.github.io/yii-email-module/), allows emails with templates and email queueing.
- Module uses [YiiStrap](http://getyiistrap.com/), the ultimate Twitter Bootstrap extension for Yii.


## Resources

- **[Documentation](http://cornernote.github.io/yii-account-module)**
- **[GitHub Project](https://github.com/cornernote/yii-account-module)**
- **[Yii Extension](http://www.yiiframework.com/extension/yii-account-module)**


## Support

- Does this README need improvement?  Go ahead and [suggest a change](https://github.com/cornernote/yii-account-module/edit/master/README.md).
- Found a bug, or need help using this project?  Check the [open issues](https://github.com/cornernote/yii-account-module/issues) or [create an issue](https://github.com/cornernote/yii-account-module/issues/new).


## License

[BSD-3-Clause](https://raw.github.com/cornernote/yii-account-module/master/LICENSE), Copyright © 2013-2014 [Mr PHP](mailto:info@mrphp.com.au)


[![Mr PHP](https://raw.github.com/cornernote/mrphp-assets/master/img/code-banner.png)](http://mrphp.com.au) [![Project Stats](https://www.ohloh.net/p/yii-account-module/widgets/project_thin_badge.gif)](https://www.ohloh.net/p/yii-account-module)

[![Latest Stable Version](https://poser.pugx.org/cornernote/yii-account-module/v/stable.png)](https://github.com/cornernote/yii-account-module/releases/latest) [![Total Downloads](https://poser.pugx.org/cornernote/yii-account-module/downloads.png)](https://packagist.org/packages/cornernote/yii-account-module) [![Monthly Downloads](https://poser.pugx.org/cornernote/yii-account-module/d/monthly.png)](https://packagist.org/packages/cornernote/yii-account-module) [![Latest Unstable Version](https://poser.pugx.org/cornernote/yii-account-module/v/unstable.png)](https://github.com/cornernote/yii-account-module) [![Build Status](https://travis-ci.org/cornernote/yii-account-module.png?branch=master)](https://travis-ci.org/cornernote/yii-account-module) [![License](https://poser.pugx.org/cornernote/yii-account-module/license.png)](https://raw.github.com/cornernote/yii-account-module/master/LICENSE)
