My Lil Ponies
---

1. DB/Host set up:
	* Point vhost to web/
	* In /resources/config edit config.yml and update db settings to match your local mysql db

2. Command line (from repo root)
	* ```composer install```
	* ```./console doctrine:schema:load```
	* ```./console doctrine:schema:fill```

3. In browser, go to site