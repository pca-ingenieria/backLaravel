## Instalación

Clona el repositorio

	git clone https://github.com/pca-ingenieria/backLaravel.git
	
Ingresa a la carpeta

	cd backLaravel
	
Instala las depencias

	composer install

Se debe de crear la base de datos

	'prueba_pca' esta por defecto en el archivo .env
	
Se corre las migraciones de la base de datos

	php artisan migrate
	
Se inicia el servidor

	php artisan serve