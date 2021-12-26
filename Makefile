# Prepare for production
production: ensure-composer ensure-permissions enable-cache build-assets

ensure-composer:
	composer update --ignore-platform-req=php --optimize-autoloader

ensure-permissions:
	#chmod -R o+w storage

enable-cache:
	php artisan optimize

build-assets:
	npm update
	npm run dev --demo1 --rtl --dark-mode
	npm run dev --demo2 --rtl --dark-mode
	npm run dev --demo3 --rtl --dark-mode
	npm run dev --demo4 --rtl
	npm run dev --demo7 --rtl
