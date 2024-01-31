# **Magento 2.0 Request a Callback Extension** #

The extension allows customers to request a callback with a simple form.

## Description ##

The extension displays a block on the frontend where customers can apply for a callback from the shop owner. The module provides a widget for inserting the block anywhere in the frontend quickly. The administrator is also able to customize the block title, subtitle and success feedback message. The form displays the customer name and telephone as mandatory fields.

The client can choose the requested callback date, and also predefined times from a dropdown, and country list selection. In the widget’s configuration panel the administrator can easily customize the predefined time intervals and the date settings. The extension can be set to send an email notification to the shop owner if a new request arrives automatically. All submits will be saved and displayed the in administration grid, also delete or change statuses functionalities supported as well.

## Features ##

- The widget(s) can be placed anywhere easily on the store frontend in Magento 2.0.
- Using Ajax for fast submitting 
- Module enable / disable
- Customize widget title, subtitle and success message
- Country dropdown list for easily detect timezone 
- Customize date and predefined times
- Save requests and show in the administration grid, delete or change statuses as well
- Setup automatic administrator email notification
- Honeypot defense against bots
- Multistore support
- Supported languages: English
 
It is a separate module that does not change the default Magento 2.0 files. 
 
Support: 
Magento Community Edition  2.2.x

## Installation ##

** Important! Always install and test the extension in your development enviroment, and not on your live or production server. **
 
1. Backup Your Data 
Backup your store database and web directory. 
 
2. Clear Cache and cookies 
Clear the store cache under var/cache and all cookies for your store domain. 
 
3. Disable Compilation 
Disable Compilation, if it’s enabled.

4. Upload Files 
Unzip extension contents on your computer and navigate inside the extracted folder. Create folder app / code on your webserver if you don't have it already. Using your FTP client upload content of the directory to your store root / app / code folder.

5. Enable extension
Please use the following commands in the /bin directory of your Magento 2.0 instance:

    php magento module:enable Me_Cmb

    php magento setup:upgrade 

One more time clear the cache under var/cache and var/page_cache login to Magento backend (admin panel).

## Configuration ##
 
Login to Magento backend (admin panel). You can find the module configuration here: Stores / Configuration, in the left menu Magevolve Extensions / Request a Callback.

## Change Log ##

Version 1.0.1 - March 25, 2018
- Compatibility with Magento 2.2.x
- Configuration fixes

Version 1.0.0 - March 31, 2017
- Compatibility with Magento 2.1.x
- Compatibility with Magento 2.0.x

## Troubleshooting ##
 
1. After the extension installation I receive a 404 error in Stores / Configuration / Magevolve Extensions / Request a Callback. 
Clear the store cache, browser cookies, logout from backend and login back. 
 
2. My configuration changes do not appear on the store.
Clear the store cache, clear your browser cache and domain cookies and refresh the page. 
 
## Extension license ##
 
The module license description included in the Terms and Conditions:
http://magevolve.com/terms-and-conditions  
 
## Support ##
 
If you have any questions about the extension, please contact us.

## License ##

See COPYING.txt for license details.

Copyright © 2018 Magevolve Ltd. All rights reserved.