<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# Configuration

## Multiple features
By default, all features are enabled, except email verification and password reset.

### Update email verification
If you want to use email verification or password reset feature, you need to set up the mail configuration in the .env file
```
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=your_email
MAIL_FROM_NAME="${APP_NAME}"
```
In addition to this, you need to set up the mail verification in the app/Models/User.php file.
```
... your other code
 
class User extends Authenticatable implements MustVerifyEmail

... your other code

```

and enable feature in .env file. Make sure you have the following lines in your `.env` file:

 
```
FEATURE_UPDATE_EMAIL_VERIFICATION=true
FEATURE_UPDATE_RESET_PASSWORD=true
```

### Update profile photo
### Update password
### Update 2 factor authentication
### Update reset password
### Update account deactivation


