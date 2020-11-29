# Blacklisting Emails in the Divi Contact Form

The Divi Theme's contact form module offers several features to help reduce the volume of spam comments you receive. This include a math-based captcha, and support for Google's ReCaptcha v3. 

Despite these, you may still find some spam emails getting through. Another option, which complements these, is to ban particular email addresses or domains from being submitted as the user email. 

Examples uses for this are:

1. Ban the specific email addresses of persistent spammers
2. Ban email addresses from a free email provider from which you are seeing lots of spam, and no legitimate emails
3. Ban email addresses from your own domain - useful if you don't send yourself contact form messages and are seeing spammers fake email addresses from your own domain.
4. Ban the use of particular words in email addresses (e.g. "viagra")


## Blacklisting Emails using Divi Booster

Divi Booster adds an option to the Divi contact form to allow easy blacklisting of email addresses.

With Divi Booster enabled, you'll see a new option in the contact form settings at:

Contact Form Settings > Content > Spam Protection > Use Email Blacklist

Enable this option, and the following option should appear below it:

Contact Form Settings > Content > Spam Protection > Email Blacklist

In this option, you can add a list of email addresses or partial email addresses to be blocked.

![](file://dbdb-contactform-emailblacklist.png)

The example above shows an email blacklist with with three items. 

The first line blocks all emails from my own domain - useful since I don't contact myself by my contact form, so any use of my domain is presumably a spam message.

The second line blocks any message where the email address is an aol.com address - this would be useful if I was seeing lots of spam emails from aol.com addresses and was confident I wasn't going to be getting legitimate emails from aol.com addresses. (I'm just using AOL as an example here - I'm not advocating blocking them specifically).

The third line blocks a specific email address - this is useful if you keep seeing emails from the same spam email address.

You can also enter individual words (e.g. "viagra") and if it matches any part of the email address entered by the user, the email address will be blocked.

When the contact form is submitted with a blacklisted email address, the user will receive an "Invalid Email" message, the same as if the supplied email was malformed.

![](file://dbdb-contactform-emailblacklist-invalid-email.png)

This feature is available as of Divi Booster 3.1.4.