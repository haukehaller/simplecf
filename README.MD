Simple Contact Form
===================

This extension provides a very basic contact form for your TYPO3 site. Fields included are 'name', 'street', 'city',
'phone', 'email', 'message' and a 'contact by' field to let the user choose between 'phone' and 'email'.

Mandatory fields can be defined in TS and default to 'name', 'message' and either 'email' or 'phone' depending on the
user's selection. Unwanted fields can simply be removed from both form and email templates without breaking stuff.

The extension depends on ```EXT:sr_freecap``` to provide some spam protection.

Example TS configuration
------------------------

```
plugin.tx_simplecf {
	settings {
		subject = A new contactform submission
		fromEmail = contactform@mysite.tld
		fromName = Contactform
		toEmail = contactform@mysite.tld
		toName = Contactform
		targetPageUid = 123
		mandatoryFields = name,message,street,city
	}
}
```
