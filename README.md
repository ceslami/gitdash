# gitdash

gitdash is a tool for teams who use Github.

#### Getting Started

gitdash is a Backbone/Marionette application with a featherlight PHP backend
powered by SlimPHP.

To start using this application:

1. Download and open MAMP
    * Click on Preferences
    * Go the Apache menu, change the Document Root to the location where
      you cloned this repo
2. Log into Github
    * [Create a new Github application](https://github.com/settings/applications/new)
    * Set your Hompage URL to ``http://localhost:8888``
    * Set your Authorization Callback URL to ``http://localhost:8888/oauth_login``
3. Update your config.php
    * Find the ``example.config.php`` file in ``/app/src``
    * Replace ``client_id`` and ``client_secret`` with the values given to you
      upon successfully creating your Github app
    * Leave the values for ``app_url`` and ``callback_url`` in place
4. Navigate to [http://locahost:8888](http://locahost:8888) and click login. Give
   yourself permissions and you're off to the races!

:100:
