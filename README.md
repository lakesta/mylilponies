My Lil Ponies
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