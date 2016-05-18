My Lil Ponies
===
The initial task: 

1. Create a database schema that supports storing the following information: pony name, fur color, eye color, height, weight, and pony friends (each pony can have multiple friends).

1. Populate the database with 5 ponies, with each pony having 1-3 friends each.

1. Build a UI that can list all the ponies using an HTML table, delete a selected pony, and change the name of a selected pony.

Setup
---
1. DB/Host set up:
	* Point vhost to mylilponies/web/
	* In /resources/config edit config.yml and update db settings to match your local mysql db

1. Need to have composer installed for next steps, learn more @ https://getcomposer.org/doc/00-intro.md

1. Command line (from repo root)
	* ```composer install```
	* ```./console doctrine:database:create```
	* ```./console doctrine:schema:load```
	* ```./console doctrine:schema:fill```

1. In browser, go to site
