# LOLSCOUT

A platform for **League of Legends** players to find a team: verify your Riot account, show your rank and champion mastery, and search, join or manage amateur teams.

Built in 2023 as my first full PHP project.

## Features

- **Accounts** – sign up with an email confirmation code, log in, reset a forgotten password by email (PHPMailer) and manage account settings.
- **Riot account verification** – players prove they own a summoner account by setting a code in the game client, checked through the Riot API's third-party code endpoint.
- **Player profiles** – rank (League-V4) and champion mastery pulled from the Riot API, plus role and social links.
- **Teams** – create and edit teams, search teams by rank, apply to a team, invite players, save favourites and get notifications.

## Stack

PHP · MySQL (mysqli) · JavaScript · HTML/CSS · PHPMailer · Riot Games API

## Running locally

1. Import the database into MySQL and set the connection details in `includes/dbh.inc.php`.
2. Add a Riot API key to the files in `scripts/` and SMTP details to `send-email.php`.
3. Serve the folder with PHP (for example `php -S localhost:8000`).

## Looking back

This was a learning project. Today I'd keep credentials in environment variables, use PDO with prepared statements for every query, and build it on a framework such as Laravel.
