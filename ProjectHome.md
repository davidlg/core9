# About #
Core9 is a simple PHP framework designed to make easy creating quick applications with PHP5.

## What does it have? ##
Core9 is designed to handle the sections of your application (called "modules"), each of them residing in a Controller class with one or more functions (called "actions"). Those actions can render a view, return a JSON object, execute an action like inserting or updating a row in the database, etc.

Along with that I try to add some libraries that make the coder's life easier and happier:
  * The Mootools Javascript Library - Updated to the latest version
  * The MDB2 PEAR library for database abstraction and portability (removed in latest commit; will be back ASAP)
  * The Smarty template rendering engine
  * New in [r10](https://code.google.com/p/core9/source/detail?r=10): nuSOAP has been integrated into the Core to make it easier to create webservices with SOAP
  * New in [r12](https://code.google.com/p/core9/source/detail?r=12): The Bootstrap CSS Library for UI greatness

## How does it work? ##
Latest changes to the framework have got it closer to the MVC architecture and that may be a good thing to start with, but you may want something more flexible (or don't like MVC at all, why not). If that's your case Core9 does not force you to use the MVC architecture at all: just take what you need and modify the rest. As easy as that.

Core9 is more a library of tools than a tool itself, giving you the power to write your code the way you want. Fancy modifying it to fit your way of working? Go with it. Do you think that you can improve it with your changes? Great! Get in touch with me and I'll be more than happy to check out your ideas.

**Caution:** This framework is still quite experimental, thought it had a major rewrite in some parts and got closer to the MVC architecture. It's still as flexible as before, nevertheless, but now is more stable and organized. As always, be careful to use it for production and be ready to do heavy modifications.