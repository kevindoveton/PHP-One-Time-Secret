# PHP One Time Secret
Responsive website to share passwords with others. Originally built to combat the problem of sharing passwords through email. Once the link is clicked or the timeout expires, the link becomes invalid. 

## Security
This project makes use of OpenSSL in order to encrypt the passwords prior to storing them in the database, the 
encrytion key is stored outside of the webroot, and not in any source files. It also uses a seperate SQL account 
to write data, and another to read the data. By doing this we decrease our attack radius. 

## The Future
I hope to add the ability for the user to choose their own encryption key if they desire, this would then require
the receiving user to enter that encryption key to get their password. I'm consious that by allowing the user to
set the encryption key, they will most likely use a short phrase - drastically decreasing the time to brute force.

Currently the password is automatically cleared after 1 hour and after 1 view, I would like to have the user be 
able to define that timout themselves. As above, i'm afraid that by handing control to the user, they will 
inevitably decrease the security of the system by setting unreasonably large timouts. 

## Challenges
- When sending a link, messaging clients will automatically generate a preview of the message. This was combatted
by generating a generic page if the user-agent was detected as being a bot.
- Creating a fantastic user experience that makes people want to go to the extra effort of creating a link to
the password, rather than just sending the password. Creating something that doesn't feel like a chore.

## Install
- Tested on PHP 7.0
- Requires composer
- Requires apache for htaccess

```
composer install
```
