# Synth Notification Bundle [![Build Status](https://secure.travis-ci.org/synthmedia/SynthNotificationBundle.png)](http://travis-ci.org/synthmedia/SynthNotificationBundle)

The concept of this bundle is to provide a notification system, much like that of Facebook (but a basic version at
present).

Very much a work in progress! Feel free to fork and fix as you see fit =)

PLEASE NOTE: There are a lot of bundle assumptions here, as it's mostly been tailored for a single use case.

## Continuous Integration

Builds are run using the awesome [Travis CI](http://travis-ci.org/), testing against PHP 5.3 with:

* Symfony 2.0.0
* Symfony 2.0.1
* Symfony 2.0.3
* Symfony 2.0.4
* Symfony 2.0.5 (current stable)
* Symfony origin/master (development)

## Installation

Update your `deps` file, and add the following lines:

    [SynthNotificationBundle]
        git=http://github.com/synthmedia/SynthNotificationBundle.git
        target=/bundles/Synth/NotificationBundle

After that, just install the new dependencies:

    $ ./bin/vendor install

Register the bundle namespace in the autoloader (if you haven't already):

    // app/autoloader.php
    $autoloader->registerNamespaces(array(
        // ...
        'Synth'       => __DIR__.'/../vendor/bundles',
    ));

Finally, make sure that the `SynthNotificationBundle` is registered in the application kernel:

    // app/AppKernel.php
    public function registerBundles()
    {
        return array(
            // ...
            new Synth\NotificationBundle\SynthNotificationBundle(),
        );
    }

At present, the bundle only supports `orm`, sorry! If anyone is interested in helping out with an `odm` adaptation, give
us a shout.

## Basic Usage

Out of the box, the bundle assumes you're using the FOSUserBundle for your user authentication. If you're not, just make
sure you implement the abstract Notification class in the Model directory.

## Types

These allow separation between notifications, giving developers the choice of displaying everything (a la Facebook), or
individual notifications for a specific section.

## Future Development

Areas we'd like to work on and perfect, but aren't 'mission critical', if you will:

* Multiple from users - being able to group notifications from more than one person (Joe, Mark and Chris liked your
link)

## Credits

[Dom Udall](https://github.com/dmno/)

## Licence
Licenced under the [New BSD License](http://opensource.org/licenses/bsd-license.php)
