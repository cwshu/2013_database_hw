Facenote
========
a simple facebook-like web application, written by pure php.
NCTU database course homework.

Support user, friend, post article, reponse article, and like article functionality.
User can upload it's icon.

database schema
---------------
6 table, please see ``mysql_init_table.sql``.

deployment
----------
We should install Apache, php5 and MySQL first.

database connection info at ``db_connect.php``, the default ``(user, database) = (facenote, facenote)``

initial table schema: ``mysql -u facenote -p facenote < mysql_init_table.sql``.
