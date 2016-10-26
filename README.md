
# Blacklight — Magento Code Coverage Like Never Before

Blacklight allows you to view the code coverage of your Magento extensions while bringing you visibility into the usage of your code. Blacklight is based on the PHPUnit's awesome code coverage library and supports the same features and backends as PHPUnit's code coverage.

<img width="1144" alt="screen shot 2016-10-26 at 21 01 49" src="https://cloud.githubusercontent.com/assets/327432/19738281/7c492b08-9bbf-11e6-9be6-9f252d8d51a6.png">

Requirements
------------

Blacklight requires PHP version 5.6 or greater and Magento 1.x


Installation
------------

There are two ways to install Blacklight. For a simple no-brainer way, use the TARs from the Releases page and install it like any other Magento extension using Magento Connect Manager.

The extension package archive can be obtained from the project's [releases](https://github.com/mridang/blacklight/releases) page on GitHub.

### Modman

The extension can be installed directly from the GitHub repository by cloning the project and using Modman. For the extension to work, it's dependencies also need to be installed by running `composer install` in the extension's root directory. Also make sure the symlinks are allowed in your Magento installation and [Modman](https://github.com/colinmollenhour/modman) is installed.

Here are the steps to install Blacklight via Modman:

1. Execute `modman init` to initialize Modman in your Magento installation root directory
2. To clone the this repo execute `modman clone git@github.com:mridang/blacklist.git`, again in your Magento installation's root directory. You will see some errors about dependencies. Those dependencies will be fixed in the next two steps.
3. To install the dependencies required by the extension navigate to `.modman/blacklight` and run `composer install`
4. The final step is to fix the Modman symlinks. Navigate back your Magento installation root directory and run `modman repair`.

That's it. You should now have the extension installed into your Magento installation. The sources and the repo are located under `.modman/blacklight` and you can use it as any other git repository. In order to uninstall Blacklight, run `modman undeploy blacklight`.  


Configuration
-----

Blacklight can be found under Magento's "System" menu. Navigate to "Configuration" and find "Code Coverage" under the "Services" section of the page.


<img width="1143" alt="screen shot 2016-10-26 at 20 10 27" src="https://cloud.githubusercontent.com/assets/327432/19736522/4dd214da-9bb8-11e6-9879-6df22ae55f05.png">



Blacklight doesn't require much configuration and is designed to work out of the box. In the configuration section, you must configure a few options:

###Coverage Mode

The coverage mode selected is dependant upon how you are testing your extension. 

* **Always On**: In this mode, every request is audited. This is handy for generating code coverage for manual operations.
* **Headers**: In this mode, code coverage will be generated for every request containing a `X-Run-Coverage` header. This is often used when doing acceptance testing using a framework such as Robot Framework. The header's value is discarded.
* **Off**: In this mode, code coverage is disabled entirely.



###Coverage Driver

The coverage driver used for generating the code coverage is dependant upon your runtime. For most scenarios, leaving the option as "**Auto**" chooses the driver correctly depending upon the runtime.

* **PHP 5** [Xdebug](http://xdebug.org/) is the only source of raw code coverage data supported for PHP 5. Version 2.2.1 of Xdebug is required but using the latest version is highly recommended.
* **PHP 7**: Version 2.4.0 (or later) of [Xdebug](http://xdebug.org/) as well as [phpdbg](http://phpdbg.com/docs) are supported sources of raw code coverage data for PHP 7.
* **HHVM**:  A version of HHVM that implements the Xdebug API for code coverage (`xdebug_*_code_coverage()`) is required.


### Extension Name

This option lists all the installed extensions from the `community` channel. Selecting an extension here runs code coverage on the path `app/code/community/<Namespace>/<Extension>/*`  by recursively adding all files to the whitelist.

### Output Path

The output path by default is `var/coverage/`. Ensure that this directory exists and is writeable by the Magento user. Magento adds a `.htaccess` file to the `var` directory denying access. In order to conveniently view generated code coverage reports, create a `.htaccess` file in the `var/coverage/` directory with the line:

```
Allow from all
```

## Usage

Once enabled, Blacklight creates one coverage file for every request using's PHP Code Coverage's COV format. (Why .COV and not XML or HTML directly you may ask? Simply because it offers a simpler way to unserialize and merge multiple coverage files.)

When you would like to view your coverage report, invoke the merging by visiting the following path:

```
http://<magento>/blacklight/report/view
```

Merging the reports is a slow process and depends on the number of COV files to process. If the merging was successful, you will be presented empty screen. You coverage report is now ready.

Code coverage should only be used during development and in development environments. Blacklight is horribly slow and you often see your life pass by.


Authors
-------

* Mridang Agarwalla
* Hannu Pölönen


License
-------

Blacklight is licensed under the MIT License - see the LICENSE file for details