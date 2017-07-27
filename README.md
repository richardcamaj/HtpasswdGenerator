# HtpasswdGenerator version 1.0.1
Htpasswd allows an easy and effective way to lock folders under the Apache web server, HtpasswordGenerator helps you set up.

![version: 1.0.1](https://img.shields.io/badge/flat-1.0.1-brightgreen.svg?label=version)
![status: stable](https://img.shields.io/badge/flat-stable-brightgreen.svg?label=status)
![licence: mit](https://img.shields.io/badge/flat-mit-brightgreen.svg?label=license)

- easy-to-use
- ready-to-use
- user-friendly license: MIT


### Example 1
```sh
// Username
$username = 'johnDoe';

// User password
$password = 'mypassword0123';


$htpasswdGenerator0 = new HtpasswdGenerator();

/* 
 * Generate htpasswd content: johnDoe:$apr1$f2lygs5q$1HQpCaLF.5kkYZqQo4DXD0
 * You must add this string to the new line in the .htpasswd file
 */
$htpasswdContent = $htpasswdGenerator0->generateHtpasswd($username, $password);


```

### Example 2


```sh
// Username
$username = 'johnDoe';

// User password
$password = 'mypassword0123';


$htpasswdGenerator0 = new HtpasswdGenerator();

/* 
 * You must add this content to end of the .htaccess file
 * and content form Example 1 to the new line in the .htpasswd file
 */
$htaccessPart = $htpasswdGenerator0->getHtaccessPart("/var/www/html","My Protected Area");

```

### Example 3
```sh
// Username
$username = 'johnDoe';

// User password
$password = 'mypassword0123';


$htpasswdGenerator0 = new HtpasswdGenerator();

/* 
 * Htaccess add-on to use, for example, 
 * to show up on a web page (e.g., in the htpasswd website generators service, etc.)
 */
$htaccessPartInHTML = $htpasswdGenerator0->getHtaccessPartHtml("/var/www/html","My Protected Area");

```
License
----

MIT

