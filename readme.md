# Simple Podcast Blog
Simple podcast blog running using Docker.

## What you'll need
- git 
- Docker
- Yarn (or NPM)
- Composer
- SASS
- Port 8080 free

### Running this project

#### Clone the repository
```sh
$ git clone https://github.com/regular-alves/podcast-blog.git
```

#### Install theme and plugin dependencies (yarn and composer)
```sh
# cd mu-plugin/simple-importer-podcasts
$ yarn install
$ composer install
# cd themes/simple-theme
$ yarn install
$ composer install
```

#### Compile theme assets
Theme assets were written using SASS and must be compiled to CSS.
```sh
# cd themes/simple-theme
$ yarn build

# if you would like to SASS watch file changes
$ yarn dev
```

#### Build and run docker containers
This application has already WordPress core files and a database attached.

```sh
$ docker-compose build
$ docker-compose up
```

After finishing these steps, your application will be available at http://localhost:8080/.

#### Preparing WordPress
##### Database
In your browser, follow the WordPress wizard to install your application database.


##### Logging into the WP panel 
After setup the application database, you must log in to the [WordPress admin panel](http://localhost:8080/wp-admin/) using the user you've just created. 


##### Themes
Active `Podcast - Simple Theme` theme in [WordPress panel > Appearance > Themes](http://localhost:8080/wp-admin/themes.php).

##### Plugins
All plugins you need are inside the `mu-plugins` folder, so you don't need to activate them.

##### Injecting posts
Access the [Simple Importer page](http://localhost:8080/wp-admin/admin.php?page=simple-importer) to inject posts.
This feature will create posts, download featured images, create necessary categories, and everything else.

After all these steps, the front-end will have content and will be accessable:

- http://localhost:8080/genres/web-design/
- http://localhost:8080/genres/technology/