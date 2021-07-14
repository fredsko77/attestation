# Attestation App

Installation du projet 

1. Clôner le projet
```
git clone https://github.com/fredsko77/attestation.git <répertoire>
```

2. Installer les dépendances 
```
composer install
``` 

3. Configurer votre accès à la base de données en mofiant la ligne ci-dessous dans le fichier .env
```
DATABASE_URL=
```

4. Créer la base de données 
``` 
php bin/console doctrine:database:create
```

5. Générer les fichiers de migrations 
```
php bin/console make:migration
``` 
En cas d'erreur, executer la commande **`mkdir migrations`** (ou créer un repertoire **migrations** à la racine du projet) puis relancer la commande **`php bin/console make:migration`**

6. Executer les fichiers de migrations 
``` 
php bin/console doctrine:migrations:migrate
```

7. Executer les fixtures (jeu de données initiales)
``` 
php bin/console doctrine:fixtures:load
```