# BackEnd Laravel

Este es un proyecto basado en Laravel 5.5, como parte de una prueba tecnica

## Instalación

### Clona el repositorio

	git clone https://github.com/pca-ingenieria/backLaravel.git
	
### Ingresa a la carpeta

	cd backLaravel
	
### Instala las dependencias

	composer install

### Se debe de crear la base de datos

Por defecto esta parametrizado con el nombre "prueba_pca" en el archivo .env si se desea cambiar el nombre de la base de datos se debe de cambiar en el archivo .env
	
### Se corre las migraciones de la base de datos

	php artisan migrate
	
### Se inicia el servidor

	php artisan serve